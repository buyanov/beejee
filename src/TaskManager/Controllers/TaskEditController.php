<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\Response;
use TaskManager\Models\Task;

class TaskEditController extends Controller
{
    public function __invoke(int $id): Response
    {
        $task = Task::find($id);

        return twig('form.twig', [
            'form' => ['data' => $task->toArray()],
            'action' => '/task/' . $id
        ]);
    }
}
