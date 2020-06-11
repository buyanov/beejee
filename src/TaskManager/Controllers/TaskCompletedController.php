<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\Response;
use TaskManager\Models\Task;
use TaskManager\Request\Request;

class TaskCompletedController extends Controller
{
    public function __invoke(Request $request, int $id): Response
    {
        $isCompleted = $request->get('isCompleted');

        /** @var Task $task */
        $task = Task::find($id);
        if ($isCompleted !== null && $task !== null) {
            $task->setCompleted($isCompleted === 'true' ?: false);
            $task->save();
        }

        return new Response('1');
    }
}
