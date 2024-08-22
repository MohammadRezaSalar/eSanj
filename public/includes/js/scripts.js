$(document).ready(()=>{
    ajax_header();

    $('#task-end-date').bootstrapMaterialDatePicker({
        format: 'jYYYY/jMM/jDD',
        nowButton: true,
        time:false,
    });

    $('#btn-open-new-task-modal').click(()=>{
        $('#task-form')[0].reset();
        $('#task-end-date').val(get_just_current_date())
        $('#btn-submit-task').attr('status','add').removeAttr('task-id')
        $('#single-task-modal').modal('show')
    })

    $('#btn-submit-task').click(function (e){
        e.preventDefault();
        $('#error-box').html('')
        let submit_button=$(this);
        makeButtonLoading(submit_button)
        let data=$('#task-form').serialize();
        if (submit_button.attr('status')==='add'){
            $.ajax({
                type:'POST',
                url:'/api/v1/admin/tasks',
                data:data,
                dataType:'JSON',
                success:function (response){
                    success_toastr('ثبت با موفقیت انجام شد.')
                    $('#single-task-modal').modal('hide')
                    Livewire.dispatch('refresh');
                }
            }).error(function (e){
                let res=e.responseJSON.errors
                const errors = Object.values(res);
                let messages='';
                console.log(errors)
                for (const error of errors){
                    messages+=`
                    <div class="alert alert-danger alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg><strong>ارور!</strong>
                        ${error[0]}
                        <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                         </button>
                    </div>

                    `;
                    console.log(messages)
                    $('#error-box').append(messages);
                }
                removeLoadingFromButton(submit_button)
            })
        }else {
            $.ajax({
                type:'PUT',
                url:'/api/v1/admin/tasks/'+submit_button.attr('task-id'),
                data:data,
                dataType:'JSON',
                success:function (response){
                    info_toastr('ویرایش با موفقیت انجام شد.')
                    $('#single-task-modal').modal('hide')
                    Livewire.dispatch('refresh');
                }
            }).error(function (e){
                removeLoadingFromButton(submit_button)
                console.log(e.responseJSON.errors)
            })
        }

    })




    $(document).on('click','.edit-task',function (){

        //we can read this data from table row, but for api testing response...
        let taskId=$(this).attr('task-id');
        $.ajax({
            type:'GET',
            url:'/api/v1/admin/tasks/'+taskId,
            dataType:'JSON',
            success:function (response){
                $('#task-title').val(response.data.title)
                $('#task-explain').val(response.data.explain)
                $('#task-end-date').val(response.data.end_date)
                $('#task-priority').find(`option[value="${response.data.priority}"]`).prop('selected',true)
                $('#task-status').find(`option[value="${response.data.status}"]`).prop('selected',true)
                $('#btn-submit-task').attr('status','edit').attr('task-id',taskId)
                $('#single-task-modal').modal('show')
            }
        })
    })

    $(document).on('click','.delete-task',function (){
        let taskId=$(this).attr('task-id');
        let taskTitle=$(this).attr('task-title');
        Swal.fire({
            title: 'حذف وظیفه',
            text: `آیا از حذف وظیفه (${taskTitle}) با شناسه (${taskId}) اطمینان دارید؟`,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر',
            allowOutsideClick: false,
        }).then((result) => {
            if (result['value']==true) {
                $.ajax({
                    type:'DELETE',
                    url:'/api/v1/admin/tasks/'+taskId,
                    dataType:'JSON',
                    success:function (response){
                        info_toastr('حذف با موفقیت انجام شد.')
                        Livewire.dispatch('refresh');
                    }
                })
            }
        })
    })







})
