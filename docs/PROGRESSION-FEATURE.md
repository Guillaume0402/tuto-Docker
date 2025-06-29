# Fonctionnalité de Progression des Chapitres

## Vue d'ensemble

Cette fonctionnalité permet aux utilisateurs de marquer des chapitres comme terminés et de suivre leur progression dans les cours.

## Fonctionnalités

### 1. Barre de Progression

-   Affichage en temps réel du pourcentage de progression
-   Indication du nombre de chapitres terminés
-   Mise à jour automatique après marquage d'un chapitre

### 2. Bouton "Marquer comme terminé"

-   Bouton interactif dans chaque chapitre
-   Appel AJAX pour éviter le rechargement de page
-   Feedback visuel (spinner, animation, notification)

### 3. Persistance des Données

-   Stockage en base de données via la table `chapter_progress`
-   Mise à jour automatique de la progression générale
-   Gestion des doublons (un chapitre ne peut être marqué qu'une fois)

## Structure Technique

### Routes AJAX

```
POST /api/cours/{id}/chapitre/{chapter}/complete
POST /api/course/{id}/chapter/{chapter}/complete
```

### Méthode du Contrôleur

```php
CourseController::markChapterComplete($id, $chapterNumber)
```

### Modèle Enrollment

-   `markChapterComplete($userId, $courseId, $chapterNumber)`
-   `getCompletedChapters($userId, $courseId)`
-   `getCourseProgress($userId, $courseId, $totalChapters)`
-   `updateProgress($userId, $courseId, $progress)`

### Base de Données

```sql
CREATE TABLE chapter_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    chapter_number INT NOT NULL,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_progress (user_id, course_id, chapter_number),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);
```

## Utilisation

### Pour l'Utilisateur

1. Naviguer vers un chapitre de cours
2. Lire le contenu du chapitre
3. Cliquer sur "Marquer comme terminé"
4. Voir la progression se mettre à jour automatiquement

### Pour le Développeur

1. La progression est automatiquement calculée
2. Les données sont persistées en base
3. L'interface se met à jour sans rechargement
4. Gestion d'erreurs intégrée

## Tests

### Scripts de Test Disponibles

-   `public/test-progress.php` : Test des méthodes du modèle
-   `public/test-ajax.html` : Test de l'API AJAX

### Comment Tester

1. Démarrer l'application Docker
2. Se connecter avec un utilisateur
3. Naviguer vers un chapitre
4. Cliquer sur "Marquer comme terminé"
5. Vérifier la mise à jour de la progression

## Sécurité

-   Vérification de l'authentification utilisateur
-   Vérification de l'inscription au cours
-   Protection contre les doublons
-   Validation des paramètres

## Extensions Possibles

-   Ajout de badges pour les chapitres terminés
-   Système de récompenses
-   Export de la progression
-   Statistiques détaillées
-   Synchronisation multi-appareils
