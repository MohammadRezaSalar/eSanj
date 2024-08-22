<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Events\Admin\Tasks\AddNewTask;
use App\Events\Admin\Tasks\DeleteTask;
use App\Events\Admin\Tasks\UpdateTask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Jobs\ProcessTaskJob;
use App\Models\Task;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/tasks",
     *     description="Get tasks list",
     *     summary="Get tasks list",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="searchKey",
     *         in="query",
     *         description="parameter for search in title and explain",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                property="data",
     *                type="array",
     *                @OA\Items(
     *                   @OA\Property(
     *                       property="id",
     *                       type="integer",
     *                       nullable=false,
     *                       example=10,
     *                   ),
     *                   @OA\Property(
     *                        property="user_id",
     *                        type="integer",
     *                        nullable=false,
     *                        example=1,
     *                    ),
     *                   @OA\Property(
     *                        property="title",
     *                        type="string",
     *                        nullable=false,
     *                        example="عنوان ",
     *                    ),
     *                   @OA\Property(
     *                         property="explain",
     *                         type="string",
     *                         nullable=true,
     *                         example="توضیح نمونه برای وظیفه",
     *                     ),
     *                   @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         enum={"running","postponed", "done"},
     *                         nullable=false,
     *                         example="running",
     *                     ),
     *                   @OA\Property(
     *                         property="priority",
     *                         type="string",
     *                         enum={"low", "medium", "high"},
     *                         nullable=false,
     *                         example="medium",
     *                     ),
     *                   @OA\Property(
     *                         property="end_date",
     *                         type="string",
     *                         format="date",
     *                         nullable=false,
     *                         example="1403/06/01",
     *                     ),
     *                   @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         nullable=false,
     *                         example="2024-08-22T15:03:17.000000Z",
     *                     ),
     *                   @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         nullable=false,
     *                         example="2024-08-22T15:03:17.000000Z",
     *                     ),
     *                )
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(property="first", type="string", example="http://localhost:8000/api/v1/admin/tasks?page=1"),
     *                 @OA\Property(property="last", type="string", example="http://localhost:8000/api/v1/admin/tasks?page=1"),
     *                 @OA\Property(property="prev", type="string", nullable=true, example=null),
     *                 @OA\Property(property="next", type="string", nullable=true, example=null),
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=1),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="to", type="integer", example=3),
     *                 @OA\Property(property="total", type="integer", example=3),
     *                 @OA\Property(
     *                     property="links",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="url", type="string", nullable=true, example=null),
     *                         @OA\Property(property="label", type="string", example="1"),
     *                         @OA\Property(property="active", type="boolean", example=true)
     *                     )
     *                 )
     *             )
     *         )
     *     )
     *)
     */

    public function index(Request $request)
    {
        $searchKey=$request->get('searchKey');
        $paginate=$request->get('paginate');

        try {
            $tasks=Task::where('title','LIKE',"%$searchKey%")
                ->orWhere('explain','LIKE',"%$searchKey%")
                ->orderBy('id','desc')
                ->paginate($paginate);
        }catch (\Throwable $e){
            return ApiResponse::withMessage('Something is wrong')->withStatus(500)->build()->response();
        }


        return new TaskCollection($tasks);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            //api route controller use guard api
            Auth::loginUsingId(1);
            \auth()->user()->tasks()->create(
                $request->all()
            );
            broadcast(new AddNewTask())->toOthers();
            ProcessTaskJob::dispatch($request->priority);
        }catch (\Throwable $e){
            return ApiResponse::withMessage('Something is wrong')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Task Successfully Added')->build()->response();
    }
    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $task->update($request->all());
            broadcast(new UpdateTask())->toOthers();
            ProcessTaskJob::dispatch($request->priority);
        }catch (\Throwable $e){
            return ApiResponse::withMessage('Something is wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withMessage('Task Successfully Updated')->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            broadcast(new DeleteTask())->toOthers();
            ProcessTaskJob::dispatch($task->priority);
        }catch (\Throwable $e){
            return ApiResponse::withMessage('Something is wrong')->withStatus(500)->build()->response();
        }
        return ApiResponse::withMessage('Task Successfully Deleted')->build()->response();
    }
}
