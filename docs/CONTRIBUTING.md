# 🤝 Guide de Contribution

Merci de votre intérêt pour contribuer à cette formation Docker gratuite ! Ce document vous guidera à travers le processus de contribution.

## 🎯 Philosophie du Projet

Cette formation est **100% gratuite** et conçue pour rester accessible à tous. Nous privilégions :

-   ✅ **Simplicité** : Code clair et bien documenté
-   ✅ **Pédagogie** : Explications détaillées dans les modules
-   ✅ **Qualité** : Tests et validation avant merge
-   ✅ **Ouverture** : Accueil bienveillant des contributions

## 🚀 Comment Contribuer

### 1. Types de Contributions Bienvenues

#### 📚 **Documentation et Formation**

-   Amélioration des modules existants
-   Ajout de nouveaux exercices pratiques
-   Correction des fautes de frappe
-   Traduction en d'autres langues

#### 💻 **Code et Fonctionnalités**

-   Corrections de bugs
-   Nouvelles fonctionnalités pour la plateforme
-   Optimisations de performance
-   Amélioration de l'interface utilisateur

#### 🧪 **Tests et Qualité**

-   Ajout de tests unitaires
-   Tests d'intégration
-   Validation des modules de formation
-   Retours d'expérience utilisateur

### 2. Processus de Contribution

#### **Étape 1 : Fork et Clone**

```bash
# Fork le projet sur GitHub puis clone votre fork
git clone https://github.com/VOTRE-USERNAME/tuto-Docker.git
cd tuto-Docker
```

#### **Étape 2 : Créer une Branche**

```bash
# Pour une nouvelle fonctionnalité
git checkout -b feature/nom-de-la-fonctionnalité

# Pour une correction de bug
git checkout -b fix/description-du-bug

# Pour de la documentation
git checkout -b docs/amélioration-doc
```

#### **Étape 3 : Développer**

-   Suivez les conventions de code existantes
-   Ajoutez des commentaires explicatifs
-   Testez vos modifications localement
-   Documentez les nouvelles fonctionnalités

#### **Étape 4 : Commit et Push**

```bash
# Ajoutez vos modifications
git add .

# Commit avec un message descriptif
git commit -m "feat: ajout du module Kubernetes

- Nouveau module avec 10 exercices pratiques
- Documentation complète avec exemples
- Tests unitaires inclus"

# Push vers votre fork
git push origin feature/nom-de-la-fonctionnalité
```

#### **Étape 5 : Pull Request**

1. Créez une Pull Request depuis votre fork
2. Décrivez clairement vos modifications
3. Référencez les issues concernées si applicables
4. Attendez la review et les éventuels ajustements

## 📝 Standards de Code

### **PHP**

```php
<?php
// Utilisation de PSR-12 pour le style de code
class ExempleClass
{
    private string $property;

    public function exempleMethod(): string
    {
        // Code clair et commenté
        return $this->property;
    }
}
```

### **JavaScript**

```javascript
// Utilisation d'ES6+ et commentaires JSDoc
/**
 * Description de la fonction
 * @param {string} param - Description du paramètre
 * @returns {boolean} Description du retour
 */
function exempleFunction(param) {
    // Code lisible avec des noms explicites
    return param.length > 0;
}
```

### **CSS/SCSS**

```scss
// Utilisation de la méthodologie BEM et commentaires
.module {
    // Variables SCSS pour la maintenance
    $module-padding: 1rem;

    &__element {
        padding: $module-padding;
    }

    &--modifier {
        background-color: var(--primary-color);
    }
}
```

## 🧪 Tests

### **Lancer les Tests**

```bash
# Tests PHP (si disponibles)
./scripts/test-routes.sh

# Tests d'intégration
./scripts/test-statistics.sh

# Test Docker
docker-compose up -d
```

### **Ajouter des Tests**

-   Créez des tests pour toute nouvelle fonctionnalité
-   Placez les tests dans le dossier approprié
-   Documentez comment lancer vos tests

## 📋 Checklist Avant PR

Avant de soumettre votre Pull Request, vérifiez :

-   [ ] ✅ Le code suit les standards du projet
-   [ ] ✅ Les tests passent (si applicables)
-   [ ] ✅ La documentation est mise à jour
-   [ ] ✅ Les commits ont des messages clairs
-   [ ] ✅ Pas de conflits avec la branche main
-   [ ] ✅ Les nouvelles fonctionnalités sont testées

## 💬 Communication

### **Issues GitHub**

-   🐛 **Bugs** : Décrivez le problème avec des étapes de reproduction
-   💡 **Features** : Proposez de nouvelles fonctionnalités avec des use cases
-   ❓ **Questions** : Utilisez les Discussions pour les questions générales

### **Template d'Issue Bug**

```markdown
## 🐛 Description du Bug

Brève description du problème

## 🔄 Étapes de Reproduction

1. Aller à '...'
2. Cliquer sur '....'
3. Faire défiler vers le bas jusqu'à '....'
4. Voir l'erreur

## 💭 Comportement Attendu

Description du comportement attendu

## 📱 Environnement

-   OS: [ex: Windows 10]
-   Browser: [ex: Chrome 91]
-   Docker: [ex: 20.10.7]
```

## 🏆 Reconnaissance

Tous les contributeurs seront reconnus dans :

-   Le fichier CONTRIBUTORS.md (à créer)
-   Les release notes
-   La documentation du projet

## 📞 Contact

-   💬 **Discussions GitHub** pour les questions générales
-   🐛 **Issues GitHub** pour les bugs et suggestions
-   📧 **Email** : Voir le profil GitHub du maintainer

---

**Merci de contribuer à cette formation gratuite ! Ensemble, rendons Docker accessible à tous ! 🐳❤️**
