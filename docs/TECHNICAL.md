# 📚 Documentation Technique

## 🎯 Architecture et Choix Techniques

### Approche Classique Simplifiée

Le site utilise maintenant une **approche classique** et **maintenable** :

#### ✅ Contenu statique dans le code PHP

-   Chapitres définis comme des tableaux simples
-   Contenu spécifique selon l'ID du cours
-   Affichage avec `htmlspecialchars()` standard
-   Code lisible et maintenable

#### ❌ Anciennes complexités supprimées

-   Chargement des fichiers README.md depuis le système
-   Parsing automatique du Markdown
-   Extraction des chapitres via regex
-   Méthodes complexes de conversion Markdown vers HTML

**Résultat** : Code plus simple, plus rapide, plus sécurisé.

---

## 🎨 Architecture CSS (Sass 7-1)

### Structure organisée

```
scss/
├── abstracts/     # Variables, mixins, fonctions
├── base/          # Reset, typographie
├── components/    # Boutons, cards, etc.
├── layout/        # Header, footer, navigation
├── pages/         # Styles spécifiques aux pages
├── vendors/       # Bootstrap et frameworks
└── app.scss       # Fichier principal
```

### Scripts de compilation

-   `npm run build-css` → Compile la nouvelle architecture
-   `npm run watch-css` → Mode développement avec watch
-   `npm run dev` → Mode développement complet

**Avantages** : Organisation professionnelle, scalabilité, maintenabilité optimale.

---

## 🌈 Système de Dégradés par Niveau

### Organisation visuelle par progression

#### 🔵 **Niveau Débutant** (Modules 1-4)

Palette : Bleus et Cyans

-   Module 1 : Bleu océan (`#4facfe` → `#00f2fe`)
-   Module 2 : Bleu ciel (`#43e97b` → `#38f9d7`)
-   Module 3 : Bleu électrique (`#667eea` → `#764ba2`)
-   Module 4 : Bleu profond (`#f093fb` → `#f5576c`)

#### 🟠 **Niveau Intermédiaire** (Modules 5-10)

Palette : Oranges et Violets

-   Module 5 : Orange sunset (`#ffecd2` → `#fcb69f`)
-   Module 6 : Violet rose (`#a8edea` → `#fed6e3`)
-   Module 7 : Orange électrique (`#ff9a9e` → `#fecfef`)
-   Module 8 : Violet profond (`#667eea` → `#764ba2`)
-   Module 9 : Orange moderne (`#f6d365` → `#fda085`)
-   Module 10 : Violet doux (`#fbc2eb` → `#a6c1ee`)

#### 🟣 **Niveau Avancé** (Modules 11+)

Palette : Sophistiqués et Premium

-   Module 11+ : Dégradés professionnels variés

### Implémentation technique

```scss
// Classe appliquée dynamiquement
.module-gradient-beginner.module-1 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
```

### Effets visuels

-   ✨ Particules subtiles sur les dégradés
-   🎯 Animation hover sur les icônes Docker
-   📱 Responsive design adaptatif
-   ⚡ Transitions fluides optimisées

**Résultat** : Progression visuelle claire et interface moderne.

---

## 🛠️ Configuration Bootstrap Locale

### Installation autonome

-   Bootstrap 5.3 compilé localement
-   Personnalisation via variables Sass
-   Pas de dépendance CDN externe
-   Performance optimisée

### Fichiers clés

-   `scss/vendors/_bootstrap.scss` - Import principal
-   `scss/bootstrap/_bootstrap-local.scss` - Configuration locale
-   `scss/abstracts/_variables.scss` - Variables personnalisées

**Avantage** : Autonomie complète et personnalisation maximale.
