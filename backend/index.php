<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes/advisor.php';


use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Create App
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// JWT Secret Key
$secret = "your_super_secret_key";

// MySQL Connection (Adjust credentials)
$pdo = new PDO("mysql:host=localhost;dbname=course_mark_db", "root", "");

// Login Route
$app->post('/api/login', function (Request $request, Response $response) use ($pdo, $secret) {
    $data = $request->getParsedBody();
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $token = JWT::encode(['id' => $user['id'], 'role' => $user['role']], $secret, 'HS256');
        $response->getBody()->write(json_encode([
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role']
            ]
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    return $response->withStatus(401);
});

$app->run();
