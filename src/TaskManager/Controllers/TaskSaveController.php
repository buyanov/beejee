<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TaskManager\Models\Task;
use TaskManager\Request\FormRequest;

class TaskSaveController extends Controller
{
    public function __invoke(FormRequest $request): Response
    {
        $formData = $request->validate();

        if (isset($formData['errors'])) {
            return twig('form.twig', [
                'form' => $formData
            ]);
        }

        $taskData = $formData['data'];

        /** @var Task $task */
        $task = Task::find((int) $taskData['id']);

        if ($task) {
            $task->setEmail($taskData['email']);
            $task->setUsername($taskData['username']);
            $task->setDescription($taskData['description']);
            $task->setStatus($taskData['status']);
            $task->setCompleted(isset($taskData['completed']));

            if ($task->isChanged('description') && auth()->user()) {
                $task->setApproved(true);
            }

            db()->flush();
        }

        success('Saved');

        return new RedirectResponse('/task/' . $task->getId());
    }
}
