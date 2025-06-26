<?php

class CourseController extends Controller
{
    public function index()
    {
        $courseModel = new Course();
        $courses = $courseModel->findAll();

        $data = [
            'title' => 'Nos Cours - Tuto Docker',
            'courses' => $courses
        ];

        $this->view('cours', $data);
    }

    public function show($id)
    {
        $courseModel = new Course();
        $course = $courseModel->find($id);

        if (!$course) {
            header('Location: /cours');
            exit;
        }

        $data = [
            'title' => $course['title'] . ' - Tuto Docker',
            'course' => $course
        ];

        $this->view('course-detail', $data);
    }

    public function enroll($id)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Session::get('user_id')) {
            Session::setFlash('error', 'Vous devez être connecté pour vous inscrire à un cours');
            header('Location: /login');
            exit;
        }

        $userId = Session::get('user_id');
        $courseModel = new Course();
        $course = $courseModel->find($id);

        if (!$course) {
            Session::setFlash('error', 'Cours introuvable');
            header('Location: /cours');
            exit;
        }

        // Vérifier si l'utilisateur n'est pas déjà inscrit
        if ($courseModel->isUserEnrolled($userId, $id)) {
            Session::setFlash('info', 'Vous êtes déjà inscrit à ce cours');
        } else {
            if ($courseModel->enrollUser($userId, $id)) {
                Session::setFlash('success', 'Inscription réussie au cours : ' . $course['title']);
            } else {
                Session::setFlash('error', 'Erreur lors de l\'inscription');
            }
        }

        header('Location: /cours/' . $id);
        exit;
    }
}
