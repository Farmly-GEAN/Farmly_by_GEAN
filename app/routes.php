<?php
namespace App;

class Router {
    private array $routes = [];

    public function __construct() {
        // Home
        $this->get('/', 'App\\Controllers\\HomeController@index');

        // Buyer
        $this->get('/buyer/products', 'App\\Controllers\\Buyer\\ProductController@index');
        $this->get('/buyer/products/{id}', 'App\\Controllers\\Buyer\\ProductController@show');
        $this->post('/buyer/reviews', 'App\\Controllers\\Buyer\\ReviewController@store');

        // Seller
        $this->get('/seller', 'App\\Controllers\\Seller\\DashboardController@index');
        $this->get('/seller/products/create', 'App\\Controllers\\Seller\\ProductController@create');
        $this->post('/seller/products', 'App\\Controllers\\Seller\\ProductController@store');
    }

    public function get(string $path, string $handler): void { $this->routes["GET $path"] = $handler; }
    public function post(string $path, string $handler): void { $this->routes["POST $path"] = $handler; }

    public function dispatch(string $uri, string $method): void {
        $path = parse_url($uri, PHP_URL_PATH);
        foreach ($this->routes as $key => $handler) {
            [$m, $route] = explode(' ', $key, 2);
            $params = [];
            if ($m !== $method) continue;

            // Simple {id} parameter matching
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches);
                [$class, $action] = explode('@', $handler);
                $controller = new $class();
                return $controller->$action(...$matches);
            }
        }
        http_response_code(404);
        echo 'Not Found';
    }
}
