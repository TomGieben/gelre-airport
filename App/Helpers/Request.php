<?php

namespace App\Helpers;

use App\Enums\RequestMethod;

class Request
{
    private array $requestParameters = [];
    public array $methodParameters = [];

    function __construct()
    {
        $this->requestParameters = $this->parseRequestParameters();
    }

    /**
     * Check if the request is authenticated.
     * @return bool Returns true if the request is authenticated, otherwise false.
     */
    public static function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Get the request URI.
     * @return string Returns the request URI.
     */
    public static function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * Get the request method.
     * @return string Returns the request method (GET, POST, PUT, PATCH, DELETE).
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get the request parameters.
     * @return array Returns the request parameters.
     */
    public function getRequestParameters(): array
    {
        return $this->requestParameters;
    }

    /**
     * Check if the request method is GET.
     * @return bool Returns true if the request method is GET, otherwise false.
     */
    public function isGet(): bool
    {
        return $this->method() === RequestMethod::GET->name;
    }

    /**
     * Check if the request method is POST.
     * @return bool Returns true if the request method is POST, otherwise false.
     */
    public function isPost(): bool
    {
        return $this->method() === RequestMethod::POST->name;
    }

    /**
     * Check if the request method is PUT.
     * @return bool Returns true if the request method is PUT, otherwise false.
     */
    public function isPut(): bool
    {
        return $this->method() === RequestMethod::PUT->name;
    }

    /**
     * Check if the request method is PATCH.
     * @return bool Returns true if the request method is PATCH, otherwise false.
     */
    public function isPatch(): bool
    {
        return $this->method() === RequestMethod::PATCH->name;
    }

    /**
     * Check if the request method is DELETE.
     * @return bool Returns true if the request method is DELETE, otherwise false.
     */
    public function isDelete(): bool
    {
        return $this->method() === RequestMethod::DELETE->name;
    }

    /**
     * Check if a specific request parameter exists.
     * @param string $parameter The parameter to check.
     * @return bool Returns true if the parameter exists, otherwise false.
     */
    public function has(string $parameter): bool
    {
        return array_key_exists($parameter, $this->requestParameters);
    }

    /**
     * Get a specific request parameter.
     * @param string $parameter The parameter to get.
     * @return mixed Returns the parameter value if it exists, otherwise null.
     */
    public function get(string $parameter): mixed
    {
        return $this->requestParameters[$parameter] ?? null;
    }

    /**
     * Check if the request doesn't interact with filters.
     * @return bool Returns true if the request doesn't interact with filters, otherwise false.
     */
    public function doesntInteractWithFilters(): bool
    {
        return $this->validation->getRoute()['interactsWithFilters'] ?? false;
    }

    /**
     * Parse request parameters based on the request method.
     * @return array Returns the parsed request parameters.
     */
    private function parseRequestParameters(): array
    {
        $parameters = [];

        if ($this->isGet()) {
            $parameters = $_GET;

            // Remove the file parameter from the request parameters
            if (!empty($parameters)) {
                unset($parameters['file']);
            }
        }

        if ($this->isPost()) {
            $parameters = $_POST;
        }

        if (empty($parameters)) {
            $input = file_get_contents('php://input');
            $parameters = json_decode($input, true) ?? [];
        }

        return $parameters;
    }
}
