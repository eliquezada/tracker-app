<?php
namespace App\Services;

use App\Repositories\TaskRepository;


final class TaskActive
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
     * Get active task
     *
     * @return array
     */
    public function __invoke()
    {
        return $this->repository->running() ?? [];
    }
}
