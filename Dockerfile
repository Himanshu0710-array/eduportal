FROM php:8.2-apache

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install PDO MySQL extension and MariaDB server
RUN apt-get update && apt-get install -y mariadb-server && \
    docker-php-ext-install pdo pdo_mysql mysqli

# Set lower_case_table_names=1 BEFORE MariaDB initializes its data directory.
# This makes table name matching case-insensitive on Linux (same as Windows XAMPP),
# fixing errors like "Table 'tblCourseFees' doesn't exist" caused by case mismatch.
RUN mkdir -p /etc/mysql/mariadb.conf.d && \
    printf '[mysqld]\nlower_case_table_names=1\n' \
    > /etc/mysql/mariadb.conf.d/99-case-insensitive.cnf && \
    mysql_install_db --user=mysql --datadir=/var/lib/mysql

# Copy project files to the web root
COPY . /var/www/html/

# Make the start script executable
RUN chmod +x /var/www/html/start.sh

# Expose port 80
EXPOSE 80

CMD ["/var/www/html/start.sh"]
