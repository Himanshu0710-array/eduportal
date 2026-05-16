#!/bin/bash
# Start MariaDB service using init.d for better Docker compatibility
/etc/init.d/mariadb start

# Wait for MariaDB to start
sleep 3

# Configure MariaDB user permissions so PHP (www-data) can connect
mysql -u root -e "CREATE USER IF NOT EXISTS 'dbuser'@'%' IDENTIFIED BY 'dbpass';"
mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'dbuser'@'%' WITH GRANT OPTION;"
mysql -u root -e "FLUSH PRIVILEGES;"

# Create database and import the clean SQL dump
mysql -u root -e "CREATE DATABASE IF NOT EXISTS \`himanshu_4604\`;"
mysql -u root himanshu_4604 < /var/www/html/database.sql

# Start Apache in the foreground so the container stays running
apache2-foreground
