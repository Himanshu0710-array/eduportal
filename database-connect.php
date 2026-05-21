<?php

$servername = getenv("DB_HOST") ?: "127.0.0.1";    
if (PHP_OS_FAMILY === 'Windows') {
    $username   = getenv("DB_USER") ?: "root";         
    $password   = getenv("DB_PASS") !== false ? getenv("DB_PASS") : "";             
} else {
    $username   = getenv("DB_USER") ?: "dbuser";         
    $password   = getenv("DB_PASS") !== false ? getenv("DB_PASS") : "dbpass";             
}
$dbname     = getenv("DB_NAME") ?: "himanshu_4604"; 

try {
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    
    // TiDB requires SSL. Use Render's default certificate path on Linux.
    if (strpos($servername, 'tidbcloud') !== false) {
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }
    if (PHP_OS_FAMILY !== 'Windows') {
        $options[PDO::MYSQL_ATTR_SSL_CA] = '/etc/ssl/certs/ca-certificates.crt';
    }

    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password, $options);

} catch (PDOException $e) {
 
    die("Connection failed: " . $e->getMessage());
}
?>
