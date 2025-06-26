<?php

class ContactController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            // Validation
            $errors = [];

            if (empty($name)) $errors[] = 'Le nom est requis';
            if (empty($email)) $errors[] = 'L\'email est requis';
            if (empty($message)) $errors[] = 'Le message est requis';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Format d\'email invalide';
            }

            if (empty($errors)) {
                $messageModel = new Message();
                $messageData = [
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                ];

                if ($messageModel->create($messageData)) {
                    // Log du message (optionnel)
                    $this->logMessage($messageData);

                    Session::setFlash('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');

                    // Redirection pour éviter la resoumission
                    header('Location: /contact');
                    exit;
                } else {
                    Session::setFlash('error', 'Erreur lors de l\'envoi du message. Veuillez réessayer.');
                }
            } else {
                Session::setFlash('error', implode('<br>', $errors));
            }
        }

        $data = [
            'title' => 'Contact - Tuto Docker'
        ];

        $this->view('contact', $data);
    }

    private function logMessage($messageData)
    {
        $logDir = '../mail/contact_logs/';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . date('Y-m-d') . '.log';
        $logEntry = date('Y-m-d H:i:s') . ' - ' .
            $messageData['name'] . ' (' . $messageData['email'] . ') - ' .
            $messageData['subject'] . ' - ' . $messageData['message'] . PHP_EOL;

        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}
