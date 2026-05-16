<?php
try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=himanshu_4604;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(", ", $tables);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
