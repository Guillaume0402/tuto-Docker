<?php

abstract class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    protected function view($viewName, $data = [])
    {
        $this->view->render($viewName, $data);
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function getInput($key, $default = null)
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function validate($rules, $data)
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleValue = $ruleParts[1] ?? null;

                switch ($ruleName) {
                    case 'required':
                        if (empty($value) && $value !== '0') {
                            $errors[$field][] = "Le champ {$field} est requis";
                        }
                        break;

                    case 'email':
                        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "Le champ {$field} doit être un email valide";
                        }
                        break;

                    case 'min':
                        if ($value && strlen($value) < $ruleValue) {
                            $errors[$field][] = "Le champ {$field} doit contenir au moins {$ruleValue} caractères";
                        }
                        break;

                    case 'max':
                        if ($value && strlen($value) > $ruleValue) {
                            $errors[$field][] = "Le champ {$field} ne peut pas dépasser {$ruleValue} caractères";
                        }
                        break;

                    case 'numeric':
                        if ($value && !is_numeric($value)) {
                            $errors[$field][] = "Le champ {$field} doit être numérique";
                        }
                        break;

                    case 'url':
                        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
                            $errors[$field][] = "Le champ {$field} doit être une URL valide";
                        }
                        break;
                }
            }
        }

        return $errors;
    }

    protected function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }

        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    protected function isAuthenticated()
    {
        return Session::get('user_id') !== null;
    }

    protected function requireAuth()
    {
        if (!$this->isAuthenticated()) {
            Session::setFlash('error', 'Vous devez être connecté pour accéder à cette page');
            $this->redirect('/login');
        }
    }

    protected function getCurrentUser()
    {
        if ($this->isAuthenticated()) {
            $userModel = new User();
            return $userModel->find(Session::get('user_id'));
        }

        return null;
    }
}
