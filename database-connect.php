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

    // Handle DB_HOST containing a port (e.g. host:4000)
    $port = 3306;
    if (strpos($servername, ':') !== false) {
        list($servername, $port) = explode(':', $servername);
    }

    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8", $username, $password, $options);

    $checkColumn = $conn->query("SHOW COLUMNS FROM tblteacher LIKE 'section'");
    if ($checkColumn->rowCount() == 0) {
        $conn->query("ALTER TABLE tblteacher ADD COLUMN section VARCHAR(100) DEFAULT ''");
    }

} catch (PDOException $e) {
 
    die("Connection failed: " . $e->getMessage());
}
?>
