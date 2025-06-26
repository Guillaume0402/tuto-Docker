@echo off
echo.
echo 🧪 Test des statistiques dynamiques
echo ===================================
echo.

REM Vérifier que Docker est démarré
docker-compose ps | findstr "Up" >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ⚠️  Les conteneurs Docker ne sont pas démarrés.
    echo    Lancez d'abord: docker-compose up -d
    pause
    exit /b 1
)

echo ✅ Conteneurs Docker actifs
echo.

REM Test de la base de données
echo 🔍 Test de la connexion à la base de données...
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as total_users FROM users;" >nul 2>&1

if %ERRORLEVEL% EQU 0 (
    echo ✅ Connexion à la base de données OK
) else (
    echo ❌ Erreur de connexion à la base de données
    pause
    exit /b 1
)

echo.
echo 📊 Statistiques actuelles:
echo ------------------------

REM Récupérer les statistiques depuis la base
echo 👥 Utilisateurs:
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as 'Total utilisateurs' FROM users;" 2>nul

echo.
echo 📚 Cours:
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as 'Total cours', SUM(duration_hours) as 'Total heures' FROM courses WHERE is_active = 1;" 2>nul

echo.
echo 🎓 Inscriptions:
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT COUNT(*) as 'Total inscriptions', COUNT(DISTINCT user_id) as 'Étudiants uniques' FROM enrollments;" 2>nul

echo.
echo 📈 Progression:
docker-compose exec db mysql -u user -ppassword -e "USE tuto_docker; SELECT ROUND(AVG(progress), 1) as 'Progression moyenne %%', COUNT(CASE WHEN progress = 100 THEN 1 END) as 'Cours terminés' FROM enrollments;" 2>nul

echo.
echo 🌐 Accédez à la formation sur: http://localhost:8080
echo    Les statistiques s'affichent maintenant dynamiquement !
echo.
pause
