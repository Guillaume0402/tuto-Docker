# 🎨 Configuration Bootstrap Local

## ✅ Installation terminée !

Bootstrap 5.3.3 est maintenant installé **localement** dans le projet au lieu d'utiliser les CDN.

### Avantages de cette configuration :

-   🚀 **Performance** : Pas de requête externe, chargement plus rapide
-   🔧 **Personnalisation** : Variables SCSS modifiables
-   🌐 **Autonomie** : Fonctionne sans connexion internet
-   🔒 **Sécurité** : Pas de dépendance CDN externe
-   📦 **Contrôle des versions** : Version fixe, pas de breaking changes

## 📁 Structure des fichiers

```
public/assets/scss/
├── bootstrap/
│   ├── _bootstrap-local.scss     ← Import Bootstrap depuis node_modules
│   └── _custom-variables.scss    ← Variables personnalisées Docker
├── style.scss                    ← Fichier principal
├── _variables.scss               ← Variables globales du projet
└── _custom.scss                  ← Styles personnalisés
```

## 🎨 Personnalisation

### Variables Docker personnalisées

Le fichier `_custom-variables.scss` contient :

```scss
// Couleurs de la formation Docker
$primary: #2496ed; // Bleu Docker officiel
$docker-blue: #2496ed;
$free-green: #059669; // Vert pour badges "GRATUIT"
$free-green-light: #ecfdf5; // Fond vert clair

// Typographie
$font-family-sans-serif: "Inter", "Segoe UI", system-ui;

// Et bien plus...
```

### Comment personnaliser

1. **Modifier les couleurs** : Éditez `_custom-variables.scss`
2. **Ajouter des styles** : Éditez `_custom.scss`
3. **Recompiler** : `npm run build-css`

## 🛠️ Scripts npm disponibles

```bash
# Compilation une fois (production)
npm run build-css

# Surveillance et recompilation automatique (développement)
npm run watch-css
# ou
npm run dev

# Build complet
npm run build
```

## 🚀 Utilisation en développement

```bash
# 1. Installer les dépendances (déjà fait)
npm install

# 2. Lancer la surveillance des fichiers SCSS
npm run dev

# 3. Modifier les fichiers SCSS
# Les changements sont automatiquement compilés !
```

## 📦 Dépendances installées

-   **bootstrap@5.3.3** : Framework CSS
-   **sass** : Compilateur SCSS vers CSS

## 🔄 Migration depuis CDN

L'ancien fichier utilisait :

```scss
@import url("https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css");
```

Maintenant nous utilisons :

```scss
@import "custom-variables";
@import "../../../../node_modules/bootstrap/scss/bootstrap";
```

## ⚠️ Notes importantes

1. **Warnings de dépréciation** : Normaux avec Bootstrap 5 et Sass récent
2. **Chemin relatif** : Le chemin `../../../../node_modules/` est correct
3. **CSS généré** : Le fichier final est dans `public/assets/css/style.css`
4. **Commit** : N'oubliez pas de commiter `node_modules/` ou utilisez `.gitignore`

## 🎯 Prochaines étapes

1. Tester l'interface avec la nouvelle configuration
2. Personnaliser les couleurs Docker si nécessaire
3. Ajouter des composants Bootstrap personnalisés
4. Optimiser la compilation pour la production

---

**Formation Docker 100% Gratuite** 🐳  
Bootstrap maintenant installé localement pour une meilleure autonomie !
