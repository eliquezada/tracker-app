<?php

namespace App\Repositories;

use App\Models\Task;
use App\Services\TaskCreate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskRepository
{

    /**
     * Get all task by user
     *
     * @return array
     */
    public function getAll()
    {
        $data = Task::mine()->idDescending()->get()->toArray();
        $tasks = array();
        if ($data == null) {
            $today = Carbon::now();
            $tasks[$today->format('Y-m-d')][] = '';
        } else {
            foreach ($data as $element) {
                $tasks[$element['created_at']][] = $element;
            }
        }
        return $tasks;
    }

    /**
     * Create & store a task
     *
     * @param $request
     *
     * @return array
     */
    public function create(Request $request)
    {
        $data = $request->validate(['name' => 'required|between:3,25']);

        $data = array_merge($data, ['user_id' => auth()->user()->id,'started_at' => new Carbon,'created_at' => new Carbon]);

        $task = Task::create($data);

        return  $task->toArray();
    }

    /**
     * Update a task
     *
     * @param $id
     *
     * @return array
     */
    public function stop($id)
    {
        $task = Task::find($id);
        $task->stopped_at = new Carbon;
        $task->save();

        return $task;
    }

    /**
     * Find a task by id
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return Task::find($id);
    }

    /**
     * Find user active task
     *
     * @return mixed
     */
    public function running()
    {
        return Task::mine()->running()->first();
    }
}
