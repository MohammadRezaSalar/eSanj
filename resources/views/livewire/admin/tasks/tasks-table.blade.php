<div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-row">
                <div>
                    <div class="form-group mr-2">
                        <label class="selectbox-float-label" for="paginate">نمایش :</label>
                        <select wire:model.live="paginate" id="paginate" name="paginate"
                                class="form-control">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div style="min-width: 400px">
                    <div class="form-group">
                        <input wire:model.live="searchKey" placeholder=" "
                               name="search" id="searchKey" type="text"
                               class="form-control input-with-float-label" autocomplete="off">
                        <label for="searchKey" class="float-label">جستجو در عنوان و توضیحات
                            :</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex flex-row">
                <div class="flex-fill"></div>
                <div class="d-flex  flex-column-reverse">
                    <div class="">
                        نمایش {{ $tasks->firstItem() }} به {{ $tasks->lastItem() }} از
                        مجموع {{ $tasks->total()}} وظیفه
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover ">
            <thead>
            <tr>
                <th>شناسه</th>
                <th>عنوان</th>
                <th>اولویت</th>
                <th>وضعیت</th>
                <th>توضیحات</th>
                <th>کاربر ایجاد کننده</th>
                <th>تاریخ پایان</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->title}}</td>
                    <td>
                        <span @class([
                                'badge badge-rounded light  border-dashed',
                                'badge-muted'=>$task->priority->isLow(),
                                'badge-info'=>$task->priority->isMedium(),
                                'badge-danger'=>$task->priority->isHigh(),
                            ])>
                            {{$task->priority->getLabelText()}}
                        </span>
                    </td>
                    <td>
                        <span @class([
                            'badge badge-rounded light badge-success border-dashed',
                            'badge-info'=> $task->status->isRunning(),
                            'badge-warning'=> $task->status->isPostponed(),
                            'badge-muted'=> $task->status->isDone(),
                        ])>
                            {{$task->status->getLabelText()}}
                        </span>
                    </td>

                    <td>{{$task->explain}}</td>
                    <td>{{$task->user->full_name}}</td>
                    <td>{{$task->end_date}}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <i task-id="{{$task->id}}" class="edit-task btn text-primary btn-xs sharp mr-1 fa fa-pencil c-pointer operation-icon" title="ویرایش"></i>
                            <i task-id="{{$task->id}}" task-title="{{$task->title}}" class="delete-task btn text-danger btn-xs sharp mr-1 fa fa-trash c-pointer operation-icon" title="حذف"></i>
                        </div>
                    </td>
                </tr>
            @endforeach

            @if($tasks->isEmpty())
                <td colspan="8">فیلدی جهت نمایش وجود ندارد.</td>
            @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <div class="">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
