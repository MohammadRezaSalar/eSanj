<?php

namespace App\Livewire\Admin\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TasksTable extends Component
{
    use WithPagination;
    protected $paginationTheme='bootstrap';
    public $paginate=10;
    public $searchKey;
    #[On('refresh')]
    #[On('echo:tasks-channel,Admin\Tasks\AddNewTask')]
    #[On('echo:tasks-channel,Admin\Tasks\UpdateTask')]
    #[On('echo:tasks-channel,Admin\Tasks\DeleteTask')]
    public function reload()
    {

    }
    public function render()
    {
        $tasks=Task::orderBy('id','desc')
            ->where('title','LIKE','%'.$this->searchKey.'%')
            ->orWhere('explain','LIKE','%'.$this->searchKey.'%')
            ->paginate($this->paginate);
        return view('livewire.admin.tasks.tasks-table',compact('tasks'));
    }
}
