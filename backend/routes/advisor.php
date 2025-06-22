<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AdvisorController;

$app->group('/api/advisor', function (RouteCollectorProxy $group) {
    $group->get('/students', [AdvisorController::class, 'getAdvisees']);
    $group->get('/student/{id}', [AdvisorController::class, 'getStudentDetails']);
    $group->post('/student/{id}/notes', [AdvisorController::class, 'addNote']);
    $group->get('/student/{id}/notes', [AdvisorController::class, 'getNotes']);
});
