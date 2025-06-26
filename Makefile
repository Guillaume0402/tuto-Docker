# Makefile pour faciliter l'utilisation de Docker

# Variables
DOCKER_COMPOSE = docker-compose
PROJECT_NAME = tuto-docker

# Commandes par défaut
.PHONY: help
help: ## Affiche l'aide
	@echo "Commandes disponibles:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

.PHONY: build
build: ## Construit les images Docker
	$(DOCKER_COMPOSE) build --no-cache

.PHONY: up
up: ## Démarre les conteneurs
	$(DOCKER_COMPOSE) up -d

.PHONY: down
down: ## Arrête les conteneurs
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: down up ## Redémarre les conteneurs

.PHONY: logs
logs: ## Affiche les logs
	$(DOCKER_COMPOSE) logs -f

.PHONY: logs-web
logs-web: ## Affiche les logs du serveur web
	$(DOCKER_COMPOSE) logs -f web

.PHONY: logs-db
logs-db: ## Affiche les logs de la base de données
	$(DOCKER_COMPOSE) logs -f db

.PHONY: shell-web
shell-web: ## Ouvre un shell dans le conteneur web
	$(DOCKER_COMPOSE) exec web bash

.PHONY: shell-db
shell-db: ## Ouvre un shell dans le conteneur de base de données
	$(DOCKER_COMPOSE) exec db mysql -u root -p

.PHONY: install
install: ## Installation complète du projet
	@echo "🚀 Installation du projet $(PROJECT_NAME)"
	@if [ ! -f .env ]; then \
		echo "📋 Copie du fichier .env"; \
		cp .env.example .env; \
	fi
	@echo "🏗️  Construction des images Docker"
	$(DOCKER_COMPOSE) build
	@echo "🚀 Démarrage des conteneurs"
	$(DOCKER_COMPOSE) up -d
	@echo "⏳ Attente du démarrage des services (30s)"
	@sleep 30
	@echo "✅ Installation terminée!"
	@echo "🌐 Application disponible sur: http://localhost:8080"
	@echo "🗄️  PhpMyAdmin disponible sur: http://localhost:8081"

.PHONY: clean
clean: ## Nettoie les conteneurs et volumes
	$(DOCKER_COMPOSE) down -v --remove-orphans
	docker system prune -f

.PHONY: reset
reset: clean install ## Réinitialise complètement le projet

.PHONY: status
status: ## Affiche le statut des conteneurs
	$(DOCKER_COMPOSE) ps

.PHONY: composer
composer: ## Installe les dépendances Composer
	$(DOCKER_COMPOSE) exec web composer install

.PHONY: test
test: ## Lance les tests (si configurés)
	$(DOCKER_COMPOSE) exec web php -v
	@echo "✅ PHP fonctionne correctement"

.PHONY: backup-db
backup-db: ## Sauvegarde la base de données
	@echo "💾 Sauvegarde de la base de données"
	$(DOCKER_COMPOSE) exec -T db mysqldump -u root -p$(shell grep DB_ROOT_PASSWORD .env | cut -d '=' -f2) $(shell grep DB_NAME .env | cut -d '=' -f2) > backup_$(shell date +%Y%m%d_%H%M%S).sql
	@echo "✅ Sauvegarde terminée"

.PHONY: restore-db
restore-db: ## Restaure la base de données (fichier à spécifier avec FILE=backup.sql)
	@if [ -z "$(FILE)" ]; then \
		echo "❌ Veuillez spécifier le fichier: make restore-db FILE=backup.sql"; \
		exit 1; \
	fi
	@echo "📥 Restauration de la base de données depuis $(FILE)"
	$(DOCKER_COMPOSE) exec -T db mysql -u root -p$(shell grep DB_ROOT_PASSWORD .env | cut -d '=' -f2) $(shell grep DB_NAME .env | cut -d '=' -f2) < $(FILE)
	@echo "✅ Restauration terminée"
