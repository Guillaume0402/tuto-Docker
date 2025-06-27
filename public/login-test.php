<?php
// Page de test pour voir le cours avec utilisateur connecté

// Simuler une connexion utilisateur
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'testuser';

// Redirection vers le cours
header('Location: /cours/1');
exit;
