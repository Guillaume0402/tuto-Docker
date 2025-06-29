<?php

// Définition des routes de l'application

// Routes pour la page d'accueil
$router->get('/', 'HomeController', 'index');
$router->get('/home', 'HomeController', 'index');
$router->get('/accueil', 'HomeController', 'index');

// Routes d'authentification
$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'register');
$router->get('/logout', 'AuthController', 'logout');
$router->post('/logout', 'AuthController', 'logout');

// Routes pour le dashboard
$router->get('/dashboard', 'AuthController', 'dashboard');
$router->get('/profil', 'AuthController', 'dashboard');

// Routes pour les cours
$router->get('/cours', 'CourseController', 'index');
$router->get('/courses', 'CourseController', 'index');
$router->get('/cours/{id}', 'CourseController', 'show');
$router->get('/course/{id}', 'CourseController', 'show');
$router->post('/cours/{id}/enroll', 'CourseController', 'enroll');
$router->post('/course/{id}/enroll', 'CourseController', 'enroll');

// Routes pour les chapitres
$router->get('/cours/{id}/chapitre/{chapter}', 'CourseController', 'chapter');
$router->get('/course/{id}/chapter/{chapter}', 'CourseController', 'chapter');

// Routes pour le contact
$router->get('/contact', 'ContactController', 'index');
$router->post('/contact', 'ContactController', 'index');

// Routes pour les pages statiques
$router->get('/about', 'HomeController', 'about');
$router->get('/a-propos', 'HomeController', 'about');

// =========================
// ROUTES API (AJAX uniquement)
// =========================
$router->get('/api/courses', 'ApiController', 'courses');
$router->get('/api/course/{id}', 'ApiController', 'course');
$router->post('/api/contact', 'ApiController', 'contact');
$router->post('/api/cours/{id}/chapitre/{chapter}/complete', 'CourseController', 'markChapterComplete');
$router->post('/api/course/{id}/chapter/{chapter}/complete', 'CourseController', 'markChapterComplete');

// Route catch-all pour les erreurs 404 (doit être en dernier)
// $router->get('.*', 'ErrorController', 'notFound');
