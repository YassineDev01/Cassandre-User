# Symfony Cheat Sheet - Cassandre User

Toutes les commandes utiles pour développement et production Symfony.

```bash
# =========================
# Serveur Symfony
# =========================
symfony serve                                  # Lancer le serveur dev
APP_ENV=prod APP_DEBUG=0 symfony server:start  # Lancer le serveur prod

# =========================
# Cache
# =========================
php bin/console cache:clear                    # Vider le cache dev
rm -rf var/cache/prod                          # Supprimer le cache prod

# =========================
# Routes et services
# =========================
php bin/console debug:router                   # Lister les routes
php bin/console debug:container                # Lister les services

# =========================
# Base de données (Doctrine)
# =========================
php bin/console make:entity                     # Créer une entité
php bin/console doctrine:migrations:diff        # Générer migration
php bin/console doctrine:migrations:migrate     # Appliquer migration

# =========================
# Logs
# ========================= 
tail -f var/log/prod.log                        # Suivre les logs prod en temps réel

# =========================
# Front-end (Tailwind CSS)
# =========================
npm run dev                                     # Compiler les assets dev
npm run build                                   # Compiler les assets prod

# =========================
# Autres commandes utiles
# =========================
php bin/console make:controller NomDuController  # Créer un contrôleur
php bin/console make:form NomDuFormType          # Créer un formulaire
php bin/phpunit                                  # Lancer les tests PHPUnit (si configuré)

# =======================
# Base de données
# =======================

bin/console doctrine:database:create             # Crée la base de données.
bin/console doctrine:database:drop --force       # Supprime la base de données.
bin/console make:migration                       # Crée une migration après modification des entités.
bin/console doctrine:migrations:migrate          # Exécute les migrations pour mettre à jour la base de données.
bin/console doctrine:schema:update --force       # Met à jour le schéma de la base            directement (non recommandé en production).
bin/console doctrine:fixtures:load               # Charge des données de test avec les fixtures.
```
