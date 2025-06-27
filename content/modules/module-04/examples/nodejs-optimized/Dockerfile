# Dockerfile multi-stage optimisé pour Node.js
# Exemple du Module 4 - Formation Docker

# =============================================================================
# Stage 1: Base configuration
# =============================================================================
FROM node:18-alpine AS base

# Métadonnées de l'image
LABEL org.opencontainers.image.title="Node.js Optimized App"
LABEL org.opencontainers.image.description="Exemple d'application Node.js optimisée"
LABEL org.opencontainers.image.version="1.0.0"
LABEL maintainer="Formation Docker <docker@formation.fr>"

# Variables d'environnement communes
ENV NODE_ENV=production
ENV NPM_CONFIG_CACHE=/tmp/.npm
ENV HOME=/app

# Répertoire de travail
WORKDIR /app

# Créer un utilisateur non-root pour la sécurité
RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodeuser -u 1001 -G nodejs

# Installer les dépendances système de base
RUN apk add --no-cache \
    tini \
    && rm -rf /var/cache/apk/*

# =============================================================================
# Stage 2: Dependencies
# =============================================================================
FROM base AS deps

# Copier les fichiers de dépendances
COPY package*.json ./

# Installer les dépendances de production seulement
# npm ci est plus rapide et plus fiable pour la production
RUN npm ci --only=production --no-audit --no-fund && \
    npm cache clean --force

# =============================================================================
# Stage 3: Development dependencies (pour le build si nécessaire)
# =============================================================================
FROM base AS build-deps

# Copier les fichiers de dépendances
COPY package*.json ./

# Installer toutes les dépendances (dev + prod) pour le build
RUN npm ci --no-audit --no-fund

# Copier le code source
COPY . .

# Exécuter les scripts de build (si nécessaire)
# RUN npm run build

# =============================================================================
# Stage 4: Runtime final
# =============================================================================
FROM base AS runtime

# Copier les dépendances de production depuis le stage deps
COPY --from=deps --chown=nodeuser:nodejs /app/node_modules ./node_modules

# Copier le code de l'application
COPY --chown=nodeuser:nodejs . .

# Supprimer les fichiers de développement
RUN rm -rf \
    Dockerfile* \
    docker-compose* \
    .dockerignore \
    .git* \
    README.md \
    *.log

# Basculer vers l'utilisateur non-root
USER nodeuser

# Port exposé (documentation uniquement)
EXPOSE 3000

# Health check pour vérifier que l'application fonctionne
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD node healthcheck.js || exit 1

# Utiliser tini comme init process (PID 1)
ENTRYPOINT ["/sbin/tini", "--"]

# Commande par défaut
CMD ["node", "server.js"]
