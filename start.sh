#!/bin/bash
# start.sh - Script de démarrage Render

# Attendre que la base de données soit prête
echo "Attente de la base de données..."
sleep 10

# Importer le schéma SQL si première exécution
if [ -f /var/www/html/database/schema.sql ]; then
    echo "Importation du schéma SQL..."
    mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME < /var/www/html/database/schema.sql 2>/dev/null
    echo "Importation terminée."
fi

# Démarrer Apache
apache2-foreground
