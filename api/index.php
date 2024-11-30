<?php

require_once './routes/routes.php';

header("Access-Control-Allow-Origin: *");  
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        http_response_code(500);
        echo json_encode(['error' => "Class $class not found"]);
        exit;
    }
});

$requestUri = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query strings
$requestMethod = $_SERVER['REQUEST_METHOD'];
$routes = include './routes/routes.php';

// Database connection
try {
    $pdo = new PDO('mysql:host=db;dbname=course_catalog', 'test_user', 'test_password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if (isset($routes[$requestMethod])) {
    foreach ($routes[$requestMethod] as $route => $handler) {
        $pattern = preg_replace('/\{[^\}]+\}/', '([^\/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        if (preg_match($pattern, $requestUri, $matches)) {
            array_shift($matches);
            // Extract controller, method, and service
            $controllerClass = $handler[0];
            $method = $handler[1];
            $serviceClass = $handler[2];

            // Map service to repository
            $repositoryClass = '\\repositories\\' . str_replace('Service', '', substr($serviceClass, strrpos($serviceClass, '\\') + 1)) . 'Repository';
            
            if (!class_exists($repositoryClass)) {
                http_response_code(500);
                echo json_encode(['error' => "Repository class $repositoryClass not found"]);
                exit;
            }

            $repository = new $repositoryClass($pdo);

            $service = new $serviceClass($repository);

            $controller = new $controllerClass($service);

            // Call the method on the controller
            call_user_func_array([$controller, $method], $matches);
            exit;
        }
    }
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);
