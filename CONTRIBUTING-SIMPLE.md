# 🤝 Guide de Contribution

Merci de contribuer à la **Formation Docker 100% Gratuite** !

## 🎯 Types de contributions

-   🐛 **Bugs** - Signaler ou corriger des problèmes
-   📚 **Documentation** - Améliorer guides et modules
-   📖 **Contenu pédagogique** - Nouveaux modules ou exercices
-   ✨ **Fonctionnalités** - Nouvelles features utiles

## 🚀 Contribution rapide

### 1. Fork et setup

```bash
git clone https://github.com/votre-username/tuto-docker.git
cd tuto-docker
cp .env.example .env
make install
```

### 2. Développer

```bash
git checkout -b feature/votre-contribution
# Faire vos modifications
git commit -m "feat: description de votre contribution"
git push origin feature/votre-contribution
```

### 3. Pull Request

Créez une PR avec une description claire de vos changements.

## 📝 Standards

### Code PHP

-   Indentation : 4 espaces
-   Classes : `PascalCase`
-   Méthodes : `camelCase`

### Commits

Format : `type: description`

-   `feat:` nouvelle fonctionnalité
-   `fix:` correction de bug
-   `docs:` documentation
-   `style:` mise en forme

Exemple : `feat: ajouter module Docker Compose`

### Modules de formation

Structure requise :

```
content/modules/module-XX/
├── README.md      # Contenu théorique
├── TP.md         # Travaux pratiques
├── QUIZ.md       # Quiz d'évaluation
├── RESOURCES.md  # Ressources utiles
└── examples/     # Exemples de code
```

## ✅ Checklist avant PR

-   [ ] Code testé avec `make test`
-   [ ] Documentation mise à jour
-   [ ] Pas de secrets dans le code
-   [ ] Responsive design vérifié

## 💬 Support

-   **Issues GitHub** pour les bugs et suggestions
-   **Discussions** pour les questions générales
-   **Wiki** pour la documentation avancée

---

**Merci de rendre cette formation meilleure pour tous ! 🚀**
