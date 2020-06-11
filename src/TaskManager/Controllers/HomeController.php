<?php

declare(strict_types=1);

namespace TaskManager\Controllers;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;
use TaskManager\Models\Task;
use TaskManager\Request\Request;

class HomeController extends Controller
{
    public const TASK_PER_PAGE = 3;

    public function __invoke(Request $request, int $page = 1, string $sort = null): Response
    {
        if ($sort !== null) {
            $request->getSession()->set('sort', $sort);
        } else {
            $sort = $request->getSession()->get('sort', 'asc');
        }

        $query = db()->getRepository(Task::class)
            ->sortByName($sort);

        $paginator = new Paginator($query);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / self::TASK_PER_PAGE);

        $paginator
            ->getQuery()
            ->setFirstResult(self::TASK_PER_PAGE * ($page - 1))
            ->setMaxResults(self::TASK_PER_PAGE);

        return twig('home.twig', [
            'tasks' => $paginator,
            'page' => $page,
            'totalPages' => $pagesCount,
            'sort' => $sort === 'asc' ? 'desc' : 'asc'
        ]);
    }
}
