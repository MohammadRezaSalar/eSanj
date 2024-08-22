@extends('admin.layouts.master')
@section('pageTitle','مدیریت وظایف')
@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-2 pr-4 pl-4">
                        <h4 class="card-title">مدیریت وظایف</h4>
                        <button type="button" id="btn-open-new-task-modal" class="btn btn-rounded btn-primary m-0" data-toggle="modal" >
                            <span class="btn-icon-left text-info"><i class="fa fa-plus color-info mt-1"></i></span>افزودن وظیفه جدید
                        </button>
                    </div>
                    <div class="card-body">
                        <livewire:admin.tasks.tasks-table />
                    </div>
                </div>
            </div>
        </div>








        <div class="modal fade " id="single-task-modal" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form id="task-form" action="#" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> وظیفه</h5>
                            <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                        </div>
                        <div class="modal-body" >
                            <div id="error-box">

                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input id="task-title" name="title" class="form-control input-with-float-label" placeholder=" "></input>
                                    <label for="task-title" class="float-label">عنوان</label>
                                </div>


                                <div class="form-group col-4">
                                    <label for="task-priority" class="selectbox-float-label">اولویت</label>
                                    <select name="priority" id="task-priority" class="form-control">
                                        <option value="low" >پایین</option>
                                        <option value="medium" selected>متوسط</option>
                                        <option value="high">بالا</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="task-status" class="selectbox-float-label">وضعیت</label>
                                    <select name="status" id="task-status" class="form-control">
                                        <option value="running" selected>در حال انجام</option>
                                        <option value="postponed" >به تعویق افتاده</option>
                                        <option value="done">کامل شده</option>
                                    </select>
                                </div>

                                <div class="form-group col-4">
                                    <input type="text" name="end_date" id="task-end-date" class="form-control input-with-float-label">
                                    <label for="task-end-date" class="float-label">تاریخ پایان:</label>

                                </div>


                                <div class="form-group col-12">
                                    <textarea name="explain" id="task-explain" class="form-control input-with-float-label" placeholder=" "></textarea>
                                    <label for="task-explain" class="float-label">توضیحات</label>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success light" id="btn-submit-task">تایید</button>
                            <button type="button" class="btn btn-warning light" data-dismiss="modal" data-bs-dismiss="modal">انصراف</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>





    </div>
@endsection
