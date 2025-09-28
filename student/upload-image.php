<?php
include "../database-connect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = $_POST["studentId"];

    
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {

        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = $_FILES['profileImage']['name'];
        $fileSize = $_FILES['profileImage']['size'];
        $fileType = $_FILES['profileImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                
                $stmt = $conn->prepare("UPDATE tblstudent SET studentImage = :studentImage WHERE studentId = :studentId");
                $stmt->bindParam(":studentImage", $newFileName);
                $stmt->bindParam(":studentId", $studentId);
                $stmt->execute();

                
                header("Location: student-dashboard.php?studentId=$studentId");
                exit();
            } else {
                echo "Error moving the uploaded file!";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "No file uploaded or upload error!";
    }
} else {
    echo "Invalid Request!";
}
?>
