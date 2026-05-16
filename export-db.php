<?php
include 'database-connect.php';
try {
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sql = "CREATE DATABASE IF NOT EXISTS `himanshu_4604`;\nUSE `himanshu_4604`;\n\n";
    foreach($tables as $table) {
        $stmt = $conn->query("SHOW CREATE TABLE `$table`");
        $create = $stmt->fetch(PDO::FETCH_ASSOC);
        $sql .= $create['Create Table'] . ";\n\n";
        
        if (in_array($table, ['tblcourse', 'tblsession', 'tblacademicyear', 'tblsubject', 'tblstudent', 'tbladmin'])) {
            $data = $conn->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $row) {
                // Escape values
                $escaped_vals = array_map(function($val) use ($conn) {
                    return substr($conn->quote($val), 1, -1);
                }, array_values($row));
                
                $cols = implode("`, `", array_keys($row));
                $vals = implode("', '", $escaped_vals);
                $sql .= "INSERT IGNORE INTO `$table` (`$cols`) VALUES ('$vals');\n";
            }
            $sql .= "\n";
        }
    }
    
    // Insert a dummy student if none exists
    $sql .= "INSERT IGNORE INTO `tblstudent` (`studentName`, `studentEmail`, `studentPassword`) VALUES ('Dummy Student', 'dummy@example.com', 'password123');\n";

    file_put_contents('db_dump.sql', $sql);
    echo "Dumped " . count($tables) . " tables successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
