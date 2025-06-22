<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdvisorController
{
    public function getAdvisees(Request $request, Response $response): Response
    {
        // fetch advisees from database (mock data for now)
        $data = [
            ['id' => 1, 'name' => 'Ali', 'gpa' => 2.1],
            ['id' => 2, 'name' => 'Siti', 'gpa' => 1.9],
        ];
        
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getStudentDetails(Request $request, Response $response, $args): Response
    {
        $id = $args['id'];
        // Fetch student data from DB
        $student = ['id' => $id, 'name' => 'Ali', 'gpa' => 2.1];
        
        $response->getBody()->write(json_encode($student));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function addNote(Request $request, Response $response, $args): Response
    {
        $id = $args['id'];
        $body = $request->getParsedBody();
        $note = $body['note'];
        
        // Insert note to DB...
        
        $response->getBody()->write(json_encode(['message' => 'Note saved.']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getNotes(Request $request, Response $response, $args): Response
    {
        $id = $args['id'];
        
        // Fetch notes for student from DB...
        $notes = ['note 1', 'note 2'];
        
        $response->getBody()->write(json_encode($notes));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
