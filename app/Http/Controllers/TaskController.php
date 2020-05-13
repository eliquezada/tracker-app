<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskCreate;
use App\Services\TaskList;
use App\Services\TaskStop;
use App\Services\TaskActive;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(TaskList $taskList)
    {
        return $taskList->__invoke();
    }

    public function store(TaskCreate $taskCreate, Request $request)
    {
        return $taskCreate->__invoke($request);
    }

    public function active(TaskActive $taskActive)
    {
        return $taskActive->__invoke();
    }

    public function stopRunning(TaskStop $taskStop, $id)
    {
        return $taskStop->__invoke($id);
    }
}
