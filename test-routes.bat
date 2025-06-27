@echo off
REM Script de test des routes de l'application Docker (Windows)

echo 🧪 Test des routes de l'application Docker
echo ==========================================

set BASE_URL=http://localhost:8000

echo.
echo 📋 Tests des routes principales:
curl -s -o nul -w "Status: %%{http_code}" %BASE_URL%/ && echo  - Page d'accueil
curl -s -o nul -w "Status: %%{http_code}" %BASE_URL%/cours && echo  - Liste des cours
curl -s -o nul -w "Status: %%{http_code}" %BASE_URL%/contact && echo  - Contact

echo.
echo 📚 Tests des modules de cours:
for /L %%i in (1,1,5) do (
    curl -s -o nul -w "Status: %%{http_code}" %BASE_URL%/cours/%%i && echo  - Module %%i
)

echo.
echo 🎉 Tests terminés ! Vérifiez que tous les statuts sont 200.
