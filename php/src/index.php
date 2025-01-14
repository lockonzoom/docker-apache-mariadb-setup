<?php

// Autoload Controllers
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/controllers/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load Routes
$routes = require __DIR__ . '/routes.php';
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Routing Logic
foreach ($routes as $route => $action) {
    // รองรับเส้นทางแบบไดนามิก (เช่น /content/id/{id}/page/{page})
    $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_]+)', $route);
    $pattern = '#^' . $pattern . '$#';

    if (preg_match($pattern, $requestUri, $matches)) {
        array_shift($matches); // ลบ match แรกที่เป็นเส้นทางทั้งหมด

        list($controllerName, $method) = explode('@', $action);

        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $matches);
                exit;
            } else {
                http_response_code(500);
                echo "Method $method not found in $controllerName";
                exit;
            }
        } else {
            http_response_code(500);
            echo "Controller $controllerName not found";
            exit;
        }
    }
}

// เส้นทางไม่พบ
http_response_code(404);
echo "404 Not Found";