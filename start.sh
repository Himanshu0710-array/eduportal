#!/bin/bash
# Start MariaDB service using init.d for better Docker compatibility
/etc/init.d/mariadb start

# Wait for MariaDB to start
sleep 3

# Import the database schema
mysql -u root < /var/www/html/database.sql

# Start Apache in the foreground so the container stays running
apache2-foreground
