#!/bin/bash
# Start MariaDB service
service mariadb start

# Wait for MariaDB to start
sleep 3

# Import the database schema
mysql -u root < /var/www/html/database.sql

# Start Apache in the foreground so the container stays running
apache2-foreground
