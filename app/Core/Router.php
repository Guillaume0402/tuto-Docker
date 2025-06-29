<?php

class Router
{
    private $routes = [];
    private $basePath = '';

    public function __construct($basePath = '')
    {
        $this->basePath = rtrim($basePath, '/');
    }

    public function addRoute($method, $pattern, $controller, $action)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function get($pattern, $controller, $action)
    {
        $this->addRoute('GET', $pattern, $controller, $action);
    }

    public function post($pattern, $controller, $action)
    {
        $this->addRoute('POST', $pattern, $controller, $action);
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->cleanUri($uri);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                $params = $this->matchRoute($route['pattern'], $uri);

                if ($params !== false) {
                    $this->callController($route['controller'], $route['action'], $params);
                    return;
                }
            }
        }
    
        // Aucune route trouvée
        throw new Exception("Route non trouvée : {$method} {$uri}");
    }

    private function cleanUri($uri)
    {
        // Supprime le chemin de base si présent
        if ($this->basePath && strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }

        // Assure qu'on commence par /
        $uri = '/' . ltrim($uri, '/');

        // Supprime le slash final sauf pour la racine
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        return $uri;
    }

    private function matchRoute($pattern, $uri)
    {
        // D'abord remplacer les paramètres par des regex
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([a-zA-Z0-9-_]+)', $pattern);

        // Puis échapper les caractères spéciaux pour regex
        $pattern = str_replace('/', '\/', $pattern);

        // Créer la regex complète
        $regex = '/^' . $pattern . '$/';

        if (preg_match($regex, $uri, $matches)) {
            // Supprimer le match complet
            array_shift($matches);
            return $matches;
        }

        return false;
    }

    private function callController($controllerName, $action, $params = [])
    {
        // Inclure le fichier du contrôleur
        $controllerFile = "../app/Controllers/{$controllerName}.php";

        if (!file_exists($controllerFile)) {
            throw new Exception("Contrôleur non trouvé : {$controllerName}");
        }

        require_once $controllerFile;

        // Vérifier que la classe existe
        if (!class_exists($controllerName)) {
            throw new Exception("Classe de contrôleur non trouvée : {$controllerName}");
        }

        // Instancier le contrôleur
        $controller = new $controllerName();

        // Vérifier que la méthode existe
        if (!method_exists($controller, $action)) {
            throw new Exception("Action non trouvée : {$controllerName}::{$action}");
        }

        // Appeler l'action avec les paramètres
        call_user_func_array([$controller, $action], $params);
    }

    public function url($pattern, $params = [])
    {
        $url = $this->basePath . $pattern;

        // Remplacer les paramètres dans l'URL
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }

        return $url;
    }
}
