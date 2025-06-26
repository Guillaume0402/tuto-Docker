<?php

class View
{
    private $viewsPath;
    private $layoutsPath;
    private $data = [];

    public function __construct()
    {
        $this->viewsPath = '../app/Views/';
        $this->layoutsPath = '../app/Views/layouts/';
    }

    public function render($viewName, $data = [])
    {
        $this->data = $data;

        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);

        // Capturer le contenu de la vue
        ob_start();

        $viewFile = $this->viewsPath . $viewName . '.php';

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("Vue non trouvée : {$viewName}");
        }

        $content = ob_get_clean();

        // Si on a un layout, l'inclure avec le contenu
        if (isset($data['layout']) && $data['layout'] !== false) {
            $this->renderWithLayout($data['layout'], $content, $data);
        } else {
            // Layout par défaut
            $this->renderWithLayout('default', $content, $data);
        }
    }

    private function renderWithLayout($layoutName, $content, $data = [])
    {
        // Extraire les données pour le layout
        extract($data);

        // Le contenu est disponible dans la variable $content
        $layoutFile = $this->layoutsPath . $layoutName . '.php';

        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            // Si pas de layout, afficher juste le contenu
            echo $content;
        }
    }

    public function partial($partialName, $data = [])
    {
        extract($data);

        $partialFile = $this->viewsPath . 'partials/' . $partialName . '.php';

        if (file_exists($partialFile)) {
            include $partialFile;
        } else {
            throw new Exception("Partial non trouvé : {$partialName}");
        }
    }

    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public function url($path)
    {
        return BASE_URL . ltrim($path, '/');
    }

    public function asset($path)
    {
        return BASE_URL . 'assets/' . ltrim($path, '/');
    }

    public function formatDate($date, $format = 'd/m/Y')
    {
        if ($date instanceof DateTime) {
            return $date->format($format);
        }

        return date($format, strtotime($date));
    }

    public function formatDateTime($date, $format = 'd/m/Y H:i')
    {
        return $this->formatDate($date, $format);
    }

    public function truncate($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . $suffix;
    }

    public function pluralize($count, $singular, $plural = null)
    {
        if ($plural === null) {
            $plural = $singular . 's';
        }

        return $count > 1 ? $plural : $singular;
    }

    public function isActive($currentPath, $targetPath)
    {
        return $currentPath === $targetPath ? 'active' : '';
    }

    public function flash($type = null)
    {
        if ($type) {
            return Session::getFlash($type);
        }

        return Session::getAllFlash();
    }

    public function oldInput($key, $default = '')
    {
        return Session::getOldInput($key, $default);
    }

    public function csrfToken()
    {
        return Session::getCsrfToken();
    }

    public function csrfField()
    {
        return '<input type="hidden" name="_token" value="' . $this->csrfToken() . '">';
    }
}
