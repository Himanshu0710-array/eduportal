<?php
include "admin-dashboard-top.php";
include "admin-dashboard-content.php";

// Fetch courses to populate the dropdown
$courses = $conn->query("SELECT courseId, courseName FROM tblCourse")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add Learning Module</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.form-section {
    background: #fff;
    margin: 40px auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 10px;
    padding: 20px;
}
.heading {
    text-align: center;
    border-bottom: 2px solid #333;
    margin-bottom: 20px;
}
.submit-btn {
    width: 100%;
    margin-top: 15px;
}
</style>
</head>
<body>
<div class="col-md-8 form-section">
    <form action="add-module-process.php" method="POST">
        <div class="heading">
            <h3>Add Module</h3>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Select Course</b></label>
            <select class="form-select" name="courseId" required>
                <option value="">-- Select Course --</option>
                <?php foreach($courses as $c): ?>
                    <option value="<?php echo $c['courseId']; ?>"><?php echo htmlspecialchars($c['courseName']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Module Name</b></label>
            <input type="text" class="form-control" name="moduleName" placeholder="Module Name" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Module Description</b></label>
            <textarea class="form-control" name="moduleDescription" rows="3" placeholder="Short description" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label"><b>Module Duration (hours)</b></label>
            <input type="number" class="form-control" name="moduleDuration" placeholder="Duration in hours" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary submit-btn">Add Module</button>
    </form>
</div>
</body>
</html>

<?php
include "admin-dashboard-footer.php";
?>
