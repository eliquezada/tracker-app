<?php
namespace App\Services;

use App\Repositories\TaskRepository;

final class TaskStop
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
     * @param $id
     *
     * @return array
     */
    public function __invoke($id)
    {
        return $this->repository->stop($id);
    }
}
