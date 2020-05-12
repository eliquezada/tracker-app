<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;

final class TaskCreate
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Save task in db
     *
     * @param $request
     *
     * @return array
     */
    public function __invoke(Request $request)
    {
        return $this->repository->create($request);
    }
}
