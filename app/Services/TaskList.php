<?php
namespace App\Services;

use App\Repositories\TaskRepository;

final class TaskList
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
     * Get all tasks from db
     *
     * @return array
     */
    public function __invoke()
    {
        return $this->repository->getAll();
    }
}
