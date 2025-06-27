#!/bin/bash
# Script de test des routes de l'application Docker

echo "🧪 Test des routes de l'application Docker"
echo "=========================================="

BASE_URL="http://localhost:8000"

# Fonction pour tester une URL
test_url() {
    local url=$1
    local expected_status=${2:-200}
    
    echo -n "Testing $url ... "
    
    status=$(curl -s -o /dev/null -w "%{http_code}" "$url")
    
    if [ "$status" = "$expected_status" ]; then
        echo "✅ OK ($status)"
        return 0
    else
        echo "❌ FAIL ($status, expected $expected_status)"
        return 1
    fi
}

# Tests des routes principales
echo -e "\n📋 Tests des routes principales:"
test_url "$BASE_URL/"
test_url "$BASE_URL/cours"
test_url "$BASE_URL/contact"

# Tests des modules
echo -e "\n📚 Tests des modules de cours:"
for i in {1..5}; do
    test_url "$BASE_URL/cours/$i"
done

# Tests des routes inexistantes (doivent retourner 404)
echo -e "\n🚫 Tests des routes inexistantes (404 attendu):"
test_url "$BASE_URL/inexistant" 404
test_url "$BASE_URL/cours/999" 404

echo -e "\n🎉 Tests terminés !"
