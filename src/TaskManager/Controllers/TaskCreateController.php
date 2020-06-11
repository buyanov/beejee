<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Symfony\Component\HttpFoundation\Response;
use TaskManager\Models\Task;
use TaskManager\Request\FormRequest;

class TaskCreateController extends Controller
{
    public function __invoke(FormRequest $request): Response
    {
        $formData = $request->validate();

        if (isset($formData['errors'])) {
            return twig('form.twig', [
                'form' => $formData,
                'action' => '/task/create'
            ]);
        }

        $taskData = $formData['data'];

        $task = new Task();
        $task->setEmail($taskData['email']);
        $task->setUsername($taskData['username']);
        $task->setDescription($taskData['description']);
        $task->setCreated(new \DateTime('now'));
        $task->setStatus($taskData['status']);

        $task->save();

        success('Task successfully created');

        return $this->redirect();
    }
}
