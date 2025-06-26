<?php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validation des données
            if (empty($email) || empty($password)) {
                Session::setFlash('error', 'Veuillez remplir tous les champs');
                return $this->view('login');
            }

            // Vérification des identifiants
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::setFlash('success', 'Connexion réussie');

                header('Location: /dashboard');
                exit;
            } else {
                Session::setFlash('error', 'Identifiants incorrects');
            }
        }

        $data = [
            'title' => 'Connexion - Tuto Docker'
        ];

        $this->view('login', $data);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';

            // Validation
            $errors = [];

            if (empty($username)) $errors[] = 'Le nom d\'utilisateur est requis';
            if (empty($email)) $errors[] = 'L\'email est requis';
            if (empty($password)) $errors[] = 'Le mot de passe est requis';
            if ($password !== $confirmPassword) $errors[] = 'Les mots de passe ne correspondent pas';
            if (strlen($password) < 6) $errors[] = 'Le mot de passe doit contenir au moins 6 caractères';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Format d\'email invalide';
            }

            if (empty($errors)) {
                $userModel = new User();

                // Vérifier si l'utilisateur existe déjà
                if ($userModel->findByEmail($email)) {
                    $errors[] = 'Cet email est déjà utilisé';
                } elseif ($userModel->findByUsername($username)) {
                    $errors[] = 'Ce nom d\'utilisateur est déjà pris';
                } else {
                    // Créer l'utilisateur
                    $userData = [
                        'username' => $username,
                        'email' => $email,
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'first_name' => $firstName,
                        'last_name' => $lastName
                    ];

                    if ($userModel->create($userData)) {
                        Session::setFlash('success', 'Compte créé avec succès. Vous pouvez maintenant vous connecter.');
                        header('Location: /login');
                        exit;
                    } else {
                        $errors[] = 'Erreur lors de la création du compte';
                    }
                }
            }

            if (!empty($errors)) {
                Session::setFlash('error', implode('<br>', $errors));
            }
        }

        $data = [
            'title' => 'Inscription - Tuto Docker'
        ];

        $this->view('register', $data);
    }

    public function logout()
    {
        Session::destroy();
        Session::setFlash('success', 'Vous avez été déconnecté');
        header('Location: /');
        exit;
    }

    public function dashboard()
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::get('user_id')) {
            header('Location: /login');
            exit;
        }

        $userId = Session::get('user_id');
        $userModel = new User();
        $user = $userModel->find($userId);

        $data = [
            'title' => 'Dashboard - Tuto Docker',
            'user' => $user
        ];

        $this->view('dashboard', $data);
    }
}
