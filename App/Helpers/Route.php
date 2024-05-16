<?php

namespace App\Helpers;

use App\Enums\RequestMethod;
use ReflectionMethod;

class Route {
    private RequestMethod $method;
    private string $route;
    private $callback;
    private bool $requiresAuthentication = true;

    /**
     * Constructor for the Route class.
     * Registers a new route with the specified method, route, and callback.
     *
     * @param RequestMethod $method The HTTP request method.
     * @param string $route The route path.
     * @param callable $callback The callback function to execute.
     */
    function __construct(
        RequestMethod $method, 
        string $route, 
        callable $callback,
        bool $requiresAuthentication = true
    ) {
        $this->method = $method;
        $this->route = trim($route, '/');
        $this->callback = $callback;
        $this->requiresAuthentication = $requiresAuthentication;

        $this->register();
    }

    /**
     * Get all registered routes.
     *
     * @return array Returns an array of all registered routes.
     */
    public static function all(): array
    {
        global $routes;

        return array_map(function ($route) {
            return (object) $route;
        }, $routes);
    }

    /**
     * Get the current matched route based on the request URI and method.
     *
     * @return null|array Returns the matched route or null if no match is found.
     */
    public static function current(): null|array
    {
        global $routes;

        $uri = trim(Request::uri(), '/');
        $method = Request::method();

        foreach ($routes as $route) {
            $matches = [];
            if (self::matchesRoute($uri, $route, $method, $matches)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Register a GET route.
     *
     * @param string $route The route path.
     * @param callable $callback The callback function to execute.
     * @return Route Returns the created Route object.
     */
    public static function get(string $route, callable $callback, bool $requiresAuthentication = true): self
    {
        return new self(RequestMethod::GET, $route, $callback, $requiresAuthentication);
    }

    /**
     * Register a POST route.
     *
     * @param string $route The route path.
     * @param callable $callback The callback function to execute.
     * @return Route Returns the created Route object.
     */
    public static function post(string $route, callable $callback, bool $requiresAuthentication = true): self
    {
        return new self(RequestMethod::POST, $route, $callback, $requiresAuthentication);
    }

    /**
     * Register a PUT route.
     *
     * @param string $route The route path.
     * @param callable $callback The callback function to execute.
     * @return Route Returns the created Route object.
     */
    public static function put(string $route, callable $callback, bool $requiresAuthentication = true): self
    {
        return new self(RequestMethod::PUT, $route, $callback, $requiresAuthentication);
    }

    /**
     * Register a DELETE route.
     *
     * @param string $route The route path.
     * @param callable $callback The callback function to execute.
     * @return Route Returns the created Route object.
     */
    public static function delete(string $route, callable $callback, bool $requiresAuthentication = true): self
    {
        return new self(RequestMethod::DELETE, $route, $callback, $requiresAuthentication);
    }

    /**
     * Register a PATCH route.
     *
     * @param string $route The route path.
     * @param callable $callback The callback function to execute.
     * @return Route Returns the created Route object.
     */
    public static function patch(string $route, callable $callback, bool $requiresAuthentication = true): self
    {
        return new self(RequestMethod::PATCH, $route, $callback, $requiresAuthentication);
    }

    /**
     * Handle the route matching and execution.
     *
     * @return mixed Returns the response from the callback function.
     */
    public static function handle(): mixed
    {
        global $routes;

        $uri = trim(Request::uri(), '/');
        $method = Request::method();

        foreach ($routes as $route) {
            $matches = [];

            if (self::matchesRoute($uri, $route, $method, $matches)) {
                if($route['requiresAuthentication'] && !Request::isAuthenticated()) {
                    return Response::redirect(Response::LOGIN_ROUTE);
                } 

                $parameters = self::resolveParameters($route, $matches);

                return self::executeCallback($route, $parameters);
            }
        }

        return Response::notFound();
    }

    /**
     * Check if the provided URI matches the route pattern.
     *
     * @param string $uri The request URI.
     * @param array $route The route configuration.
     * @param string $method The request method.
     * @param array &$matches The matched parameters.
     * @return bool Returns true if the URI matches, otherwise false.
     */
    private static function matchesRoute(string $uri, array $route, string $method, array &$matches): bool
    {
        $routePattern = preg_replace('/\/{(\w+)}/', '/(?P<$1>[^/]+)', $route['route']);
        
        if (preg_match("#^{$routePattern}$#", $uri, $matches)) {
            if ($method !== $route['method']->name) {
                return false;
            }

            array_shift($matches);

            foreach($matches as $key => $match) {
                if (is_numeric($key)) {
                    unset($matches[$key]);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Resolve route parameters based on the route configuration and matched parameters.
     *
     * @param array $route The route configuration.
     * @param array $matches The matched parameters.
     * @return array Returns the resolved parameters.
     */
    private static function resolveParameters(array $route, array $matches): array
    {
        $parameters = [];
        $callback = $route['callback'];
        $methodReflection = (new ReflectionMethod($callback[0], $callback[1]))->getParameters();
        $hasRequest = false;
        
        $parameters = array_merge($parameters, $matches);

        foreach ($methodReflection as $reflection) {
            if ($reflection->hasType()) {
                $type = $reflection->getType();
                $className = $type->getName();

                // Skip built-in types, these are the basic data types provided by PHP
                if ($type->isBuiltin()) {
                    continue;
                }

                if ($className === 'App\Helpers\Request') {
                    $hasRequest = [
                        'name' => $reflection->name,
                        'type' => $className
                    ];
      
                    continue;
                }

                // Check if the parameter is missing and is not optional
                if(!in_array($reflection->name, array_keys($parameters)) && !$reflection->isOptional()) {
                    Response::error(400, $reflection->name . ' parameter is missing');
                }

                // Check if the parameter is optional and set the default value if it is missing
                if (strpos($className, 'App\Models\\') === 0) {
                    $parameters[$reflection->name] = new $className();

                    if (!$parameters[$reflection->name]) {
                        Response::error(404, 'Resource not found');
                    }
                } else {
                    $parameters[$reflection->name] = new $className($parameters[$reflection->name]);
                }
            }
        }

        if ($hasRequest) {
            $newRequest = new $hasRequest['type']();

            foreach ($parameters as $key => $value) {
                $newRequest->methodParameters[$key] = $value;
            }

            $parameters[$hasRequest['name']] = $newRequest;
        }

        return $parameters;
    }

    /**
     * Execute the callback function for the matched route with resolved parameters.
     *
     * @param array $route The route configuration.
     * @param array $parameters The resolved parameters.
     */
    private static function executeCallback(array $route, array $parameters): void
    {
        $callback = $route['callback'];
        call_user_func_array($callback, $parameters);
    }

    /**
     * Check if the route already exists in the registered routes.
     *
     * @return bool Returns true if the route already exists, otherwise false.
     */
    private function alreadyExists(): bool
    {
        global $routes;

        if(!isset($routes) || !is_array($routes)) {
            return false;
        }

        foreach ($routes as $existingRoute) {
            if ($existingRoute['method'] === $this->method && $existingRoute['route'] === $this->route) {
                return true; 
            }
        }

        return false; 
    }

    /**
     * Register the route in the global routes array.
     */
    private function register(): void {
        global $routes;

        if ($this->alreadyExists()) {
            echo $this->route . ' already exists';
            exit;
        }

        $routes[] = [
            'method' => $this->method,
            'route' => $this->route,
            'callback' => $this->callback,
            'requiresAuthentication' => $this->requiresAuthentication,
        ];
    }
}