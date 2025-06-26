#!/bin/bash

echo "🧪 Test des statistiques dynamiques"
echo "==================================="
echo ""

# Vérifier que Docker est démarré
if ! docker-compose ps | grep -q "Up"; then
    echo "⚠️  Les conteneurs Docker ne sont pas démarrés."
    echo "   Lancez d'abord: docker-compose up -d"
    exit 1
fi

echo "✅ Conteneurs Docker actifs"
echo ""

# Test de la base de données
echo "🔍 Test de la connexion à la base de données..."
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as total_users FROM users;" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✅ Connexion à la base de données OK"
else
    echo "❌ Erreur de connexion à la base de données"
    exit 1
fi

echo ""
echo "📊 Statistiques actuelles:"
echo "------------------------"

# Récupérer les statistiques depuis la base
echo "👥 Utilisateurs:"
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as 'Total utilisateurs' FROM users;" 2>/dev/null

echo ""
echo "📚 Cours:"
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as 'Total cours', SUM(duration_hours) as 'Total heures' FROM courses WHERE is_active = 1;" 2>/dev/null

echo ""
echo "🎓 Inscriptions:"
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as 'Total inscriptions', COUNT(DISTINCT user_id) as 'Étudiants uniques' FROM enrollments;" 2>/dev/null

echo ""
echo "📈 Progression:"
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT ROUND(AVG(progress), 1) as 'Progression moyenne %', COUNT(CASE WHEN progress = 100 THEN 1 END) as 'Cours terminés' FROM enrollments;" 2>/dev/null

echo ""
echo "🌐 Accédez à la formation sur: http://localhost:8080"
echo "   Les statistiques s'affichent maintenant dynamiquement !"
