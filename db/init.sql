-- Script d'initialisation de la base de données
-- Ce script sera exécuté automatiquement lors du premier démarrage du conteneur MySQL

CREATE DATABASE IF NOT EXISTS tuto_docker;

USE tuto_docker;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des cours
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    content LONGTEXT,
    instructor_id INT,
    price DECIMAL(10, 2) DEFAULT 0.00,
    duration_hours INT DEFAULT 0,
    level ENUM(
        'débutant',
        'intermédiaire',
        'avancé'
    ) DEFAULT 'débutant',
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES users (id) ON DELETE SET NULL
);

-- Table des messages de contact
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des inscriptions aux cours
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    progress DECIMAL(5, 2) DEFAULT 0.00,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses (id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- Insertion de données d'exemple
INSERT INTO
    users (
        username,
        email,
        password,
        first_name,
        last_name
    )
VALUES (
        'admin',
        'admin@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Admin',
        'User'
    ),
    (
        'john_doe',
        'john@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'John',
        'Doe'
    );

INSERT INTO
    courses (
        title,
        description,
        content,
        instructor_id,
        price,
        duration_hours,
        level
    )
VALUES (
        'Introduction à Docker',
        'Apprenez les bases de Docker et de la conteneurisation',
        'Contenu du cours Docker...',
        1,
        49.99,
        8,
        'débutant'
    ),
    (
        'PHP Avancé',
        'Techniques avancées en PHP',
        'Contenu du cours PHP...',
        1,
        79.99,
        12,
        'avancé'
    ),
    (
        'Bootstrap 5',
        'Créez des interfaces modernes avec Bootstrap',
        'Contenu du cours Bootstrap...',
        1,
        39.99,
        6,
        'intermédiaire'
    );

INSERT INTO
    messages (name, email, subject, message)
VALUES (
        'Jane Smith',
        'jane@example.com',
        'Question sur les cours',
        'Bonjour, j\'aimerais avoir plus d\'informations sur vos cours.'
    );