<?php

declare(strict_types=1);

namespace App\Core;

/** Routeur minimal : associe méthode HTTP + URL à une action de contrôleur. */
final class Router
{
    /** @var array<string, array<string, array{0: class-string, 1: string}>> */
    private array $routes = [];

    /** @param array{0: class-string, 1: string} $handler */
    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    /** @param array{0: class-string, 1: string} $handler */
    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    /** Appelle l'action correspondant à l'URL, ou affiche une 404. */
    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim((string) parse_url($uri, PHP_URL_PATH), '/');
        $path = $path === '' ? '/' : $path;

        foreach ($this->routes[$method] ?? [] as $pattern => [$class, $action]) {
            $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
            if (preg_match($regex, $path, $matches) === 1) {
                $params = array_values(array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY));
                (new $class())->$action(...$params);

                return;
            }
        }

        http_response_code(404);
        View::render('erreur', ['code' => 404, 'message' => "La page que vous recherchez n'existe pas."]);
    }
}
