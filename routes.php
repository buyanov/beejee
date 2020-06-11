<?php
/* @var \FastRoute\RouteCollector $r */

$r->get('/[page-{page:[0-9]+}[/sort-{sort:(?:asc|desc)}]]', 'TaskManager\Controllers\HomeController');

$r->addGroup('/task', static function (\FastRoute\RouteCollector $r) {
    $r->get('/new', static function() { return twig('form.twig', ['action' => '/task/create']); });
    $r->post('/create', 'TaskManager\Controllers\TaskCreateController');
    $r->get('/{id:[0-9]+}', 'TaskManager\Controllers\TaskEditController');
    $r->post('/{id:[0-9]+}', 'TaskManager\Controllers\TaskSaveController');
    $r->post('/{id:[0-9]+}/complete', 'TaskManager\Controllers\TaskCompletedController');
});

$r->get('/login', static function () { return twig('login.twig'); });
$r->get('/logout', 'TaskManager\Controllers\LogoutController');
$r->post('/login', 'TaskManager\Controllers\LoginController');