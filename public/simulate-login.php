<?php
// Simuler une connexion utilisateur pour tester
require_once '../app/config/config.php';
require_once '../app/core/Session.php';

Session::start();
Session::set('user_id', 1);
Session::set('username', 'test_user');
Session::set('first_name', 'Test');
Session::set('last_name', 'User');

echo "<h1>Connexion simulée réussie !</h1>";
echo "<p>Vous pouvez maintenant accéder aux cours :</p>";
echo "<ul>";
echo "<li><a href='/cours/1'>Module 1 - Introduction à Docker</a></li>";
echo "<li><a href='/cours/2'>Module 2 - Installation et Configuration</a></li>";
echo "<li><a href='/cours/3'>Module 3 - Premiers Conteneurs</a></li>";
echo "</ul>";
