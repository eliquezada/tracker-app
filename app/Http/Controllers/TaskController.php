<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use App\Services\TaskCreate;
use App\Services\TaskList;
use App\Services\TaskStop;

class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function index(TaskList $taskList)
    {
        return $taskList->__invoke();
    }

    public function store(TaskCreate $taskCreate, Request $request)
    {
        return $taskCreate->__invoke($request);
    }

    public function active()
    {
        return $this->tasks->running() ?? [];
    }

    public function stopRunning(TaskStop $taskStop, $id)
    {
        return $taskStop->__invoke($id);
    }
}
