#!/bin/bash
# Start MariaDB service using init.d for better Docker compatibility
/etc/init.d/mariadb start

# Wait for MariaDB to start
sleep 3

# Configure MariaDB user permissions so PHP (www-data) can connect
mysql -u root -e "CREATE USER IF NOT EXISTS 'root'@'127.0.0.1' IDENTIFIED BY '';"
mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;"
mysql -u root -e "FLUSH PRIVILEGES;"

# Import the database schema
mysql -u root < /var/www/html/database.sql

# Start Apache in the foreground so the container stays running
apache2-foreground
