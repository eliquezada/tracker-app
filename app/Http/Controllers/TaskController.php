<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{

    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function index()
    {
        return $this->tasks->getAll();
    }

    public function store(Request $request)
    {
        return $this->tasks->create($request);

    }

    public function active()
    {
        return $this->tasks->running() ?? [];
    }

    public function stopRunning($id)
    {
        return $this->tasks->update($id);
    }
}
