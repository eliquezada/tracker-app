<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Task::mine()->get()->toArray();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|between:3,25']);

        $data = array_merge($data, ['user_id' => auth()->user()->id,'started_at' => new Carbon]);

        $task = Task::create($data);

        return  $task->toArray();
    }
}
