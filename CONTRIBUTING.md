# 🤝 Guide de Contribution

Merci de votre intérêt pour contribuer à la **Formation Docker Complète** ! Ce guide vous aidera à contribuer efficacement au projet.

## 🎯 Types de contributions

Nous accueillons plusieurs types de contributions :

-   🐛 **Correction de bugs** - Résolution de problèmes identifiés
-   ✨ **Nouvelles fonctionnalités** - Ajout de features utiles
-   📚 **Amélioration de la documentation** - Clarification et ajouts
-   🎨 **Améliorations UI/UX** - Design et expérience utilisateur
-   🧪 **Tests** - Ajout de tests unitaires et d'intégration
-   🌐 **Traductions** - Support multilingue
-   📖 **Contenu pédagogique** - Nouveaux modules ou exercices

## 🚀 Processus de contribution

### 1. Fork et clone

```bash
# Fork le repository sur GitHub, puis :
git clone https://github.com/votre-username/tuto-docker.git
cd tuto-docker
git remote add upstream https://github.com/repo-original/tuto-docker.git
```

### 2. Créer une branche

```bash
# Nommage des branches :
# feature/nom-de-la-feature
# bugfix/description-du-bug
# docs/sujet-documentation
# refactor/zone-refactorisee

git checkout -b feature/nouveau-module-kubernetes
```

### 3. Développement local

```bash
# Installation de l'environnement de développement
cp .env.example .env
docker-compose -f docker-compose.dev.yml up -d

# Vérification que tout fonctionne
make test
```

### 4. Standards de code

#### PHP (PSR-12)

-   Indentation : 4 espaces
-   Accolades : style Allman
-   Noms de classes : PascalCase
-   Noms de méthodes : camelCase
-   Constantes : SNAKE_CASE

```php
<?php

namespace App\Controllers;

class NewModuleController extends Controller
{
    public function showModule(): void
    {
        $data = [
            'title' => 'Nouveau Module',
            'content' => $this->getModuleContent()
        ];

        $this->view('modules/new-module', $data);
    }

    private function getModuleContent(): string
    {
        return 'Contenu du module...';
    }
}
```

#### CSS/SCSS (BEM)

```scss
// Utilisation de la méthodologie BEM
.course-card {
    border: 1px solid $border-color;

    &__header {
        padding: 1rem;
        background-color: $header-bg;
    }

    &__title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    &--featured {
        border-color: $primary-color;
    }
}
```

#### JavaScript (ES6+)

```javascript
// Utilisation des fonctions fléchées et const/let
const CourseManager = {
    init() {
        this.bindEvents();
        this.loadCourses();
    },

    bindEvents() {
        document.addEventListener("DOMContentLoaded", () => {
            this.init();
        });
    },

    async loadCourses() {
        try {
            const response = await fetch("/api/courses");
            const courses = await response.json();
            this.renderCourses(courses);
        } catch (error) {
            console.error("Erreur lors du chargement:", error);
        }
    },
};
```

### 5. Commits conventionnels

Utilisez le format [Conventional Commits](https://www.conventionalcommits.org/) :

```bash
# Format : type(scope): description

# Types principaux :
feat(modules): ajouter module kubernetes avancé
fix(auth): corriger la validation du formulaire de connexion
docs(readme): mettre à jour les instructions d'installation
style(css): améliorer le style des cartes de cours
refactor(controllers): simplifier la logique des contrôleurs
test(courses): ajouter tests pour le CourseController
chore(deps): mettre à jour les dépendances Docker

# Exemples détaillés :
git commit -m "feat(modules): ajouter module Docker Swarm avec exercices pratiques

- Nouveau contrôleur SwarmController
- Vue détaillée avec chapitres interactifs
- Exercices de clustering et load balancing
- Tests unitaires et d'intégration

Closes #42"
```

### 6. Tests et validation

```bash
# Avant de soumettre, vérifiez :

# Tests PHP (à venir)
make test-php

# Validation du code
make lint

# Tests d'intégration Docker
make test-integration

# Vérification de la sécurité
make security-check
```

## 📝 Guidelines spécifiques

### Ajout de nouveaux modules

Si vous ajoutez un module de formation :

1. **Structure requise** :

    ```
    app/Views/modules/
    ├── module-name.php           # Vue principale
    ├── module-name-detail.php    # Vue détaillée
    └── exercises/                # Exercices pratiques
        ├── exercise-1.php
        └── exercise-2.php
    ```

2. **Base de données** :

    ```sql
    -- Ajouter le module dans db/init.sql
    INSERT INTO courses (title, description, content, instructor_id, price, duration_hours, level)
    VALUES ('Nouveau Module', 'Description...', 'Contenu...', 1, 49.99, 8, 'intermédiaire');
    ```

3. **Contrôleur** :
    ```php
    // Méthode dans CourseController.php
    public function showModule($id): void
    {
        $module = $this->courseModel->findById($id);
        $this->view('modules/module-detail', ['module' => $module]);
    }
    ```

### Documentation

-   **README.md** : Gardez-le à jour avec les nouvelles fonctionnalités
-   **Commentaires code** : Expliquez les parties complexes
-   **PHPDoc** : Documentez toutes les méthodes publiques

```php
/**
 * Récupère les modules par niveau de difficulté
 *
 * @param string $level Le niveau : 'débutant', 'intermédiaire', 'avancé'
 * @param int $limit Nombre maximum de résultats (défaut: 10)
 * @return array<Course> Liste des modules trouvés
 * @throws InvalidArgumentException Si le niveau est invalide
 */
public function getModulesByLevel(string $level, int $limit = 10): array
{
    // ...
}
```

## 🔍 Process de review

### Checklist avant soumission

-   [ ] ✅ Code testé localement avec Docker
-   [ ] ✅ Standards de code respectés
-   [ ] ✅ Documentation mise à jour
-   [ ] ✅ Commits conventionnels utilisés
-   [ ] ✅ Aucun secret ou donnée sensible dans le code
-   [ ] ✅ Images Docker optimisées si modifiées
-   [ ] ✅ Responsive design testé sur mobile
-   [ ] ✅ Accessibilité vérifiée (ARIA, contraste)

### Soumission de la Pull Request

```markdown
## 📋 Description

Brève description des changements apportés.

## 🚀 Type de changement

-   [ ] 🐛 Correction de bug
-   [ ] ✨ Nouvelle fonctionnalité
-   [ ] 📚 Mise à jour documentation
-   [ ] 🎨 Changements d'interface
-   [ ] ⚡ Amélioration de performance
-   [ ] 🧪 Ajout de tests

## 🧪 Tests

Décrivez les tests effectués :

-   [ ] Tests locaux avec Docker
-   [ ] Tests sur mobile/tablet
-   [ ] Tests navigateurs multiples
-   [ ] Tests avec/sans authentification

## 📸 Screenshots (si applicable)

Ajoutez des screenshots des changements visuels.

## ✅ Checklist

-   [ ] Auto-review effectuée
-   [ ] Documentation mise à jour
-   [ ] Tests ajoutés/modifiés si nécessaire
-   [ ] Aucun breaking change non documenté
```

## 🐛 Signalement de bugs

Utilisez le template d'issue GitHub :

````markdown
**🐛 Description du bug**
Description claire et concise du problème.

**🔄 Étapes pour reproduire**

1. Aller à '...'
2. Cliquer sur '...'
3. Voir l'erreur

**✅ Comportement attendu**
Description de ce qui devrait se passer.

**📱 Environnement**

-   OS: [Windows 10, macOS Big Sur, Ubuntu 20.04]
-   Navigateur: [Chrome 91, Firefox 89, Safari 14]
-   Docker: [20.10.7]
-   Version du projet: [commit hash ou tag]

**📸 Screenshots**
Ajoutez des screenshots si pertinents.

**📋 Logs supplémentaires**

```bash
# Coller les logs Docker si applicable
docker-compose logs
```
````

## 💡 Propositions de fonctionnalités

Template pour les nouvelles idées :

```markdown
**🚀 Fonctionnalité souhaitée**
Description claire de la fonctionnalité demandée.

**🎯 Problème résolu**
Quel problème cette fonctionnalité résout-elle ?

**💭 Solution proposée**
Description détaillée de votre solution.

**🔄 Alternatives considérées**
Autres approches que vous avez envisagées.

**📋 Contexte supplémentaire**
Tout autre élément pertinent.
```

## 🎓 Ressources utiles

### Documentation technique

-   [Docker Documentation](https://docs.docker.com/)
-   [PHP PSR Standards](https://www.php-fig.org/psr/)
-   [Bootstrap Documentation](https://getbootstrap.com/docs/5.1/)
-   [MDN Web Docs](https://developer.mozilla.org/)

### Outils recommandés

-   **IDE** : VS Code avec extensions Docker, PHP, SCSS
-   **Git GUI** : GitKraken, SourceTree ou GitHub Desktop
-   **Debugging** : Xdebug pour PHP, DevTools pour frontend
-   **Testing** : PHPUnit, Jest, Cypress

## 📞 Contact et support

-   💬 **Discord** : [Communauté Docker Learning](https://discord.gg/tuto-docker)
-   📧 **Email** : contribute@tuto-docker.local
-   🐛 **Issues** : [GitHub Issues](https://github.com/repo/tuto-docker/issues)
-   💭 **Discussions** : [GitHub Discussions](https://github.com/repo/tuto-docker/discussions)

---

**Merci pour votre contribution ! 🙏**

Chaque contribution, qu'elle soit petite ou grande, aide à améliorer l'apprentissage de Docker pour la communauté francophone.
