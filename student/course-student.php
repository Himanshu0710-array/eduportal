<?php
include "../database-connect.php";
session_start();
include "../splitting-student/top-student.php";
include "../splitting-student/content-student.php";

$$studentId = $_REQUEST["studentId"];
$stmt = $conn->prepare("SELECT * FROM tblstudent WHERE studentId = :studentId");
$stmt->bindParam(":studentId", $studentId);
$stmt->execute();
$student = $stmt->fetch();

$courseId = $student["courseId"];
?>
<title>Student Dashboard</title>
<style>
#student-dashboard {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 20px;
    min-height: 100vh;
}

#student-dashboard h1 {
    font-size: 32px;
    font-weight: bold;
    color: #2d3748;
    margin-bottom: 25px;
    text-align: center;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

#student-dashboard .stats-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
}

#student-dashboard .stat-card {
    flex: 1 1 240px;
    color: #fff;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

#student-dashboard .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

#student-dashboard .stat-card:hover::before {
    transform: translateX(100%);
}

#student-dashboard .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

#student-dashboard .stat-card h3 {
    margin: 15px 0 10px 0;
    font-size: 16px;
    font-weight: 600;
    opacity: 0.9;
}

#student-dashboard .stat-card .number {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 5px;
}

#student-dashboard .progress-bar {
    background-color: rgba(255,255,255,0.2);
    border-radius: 12px;
    height: 6px;
    margin: 12px 0;
    width: 100%;
    overflow: hidden;
}

#student-dashboard .progress-bar-inner {
    background-color: rgba(255,255,255,0.8);
    height: 6px;
    border-radius: 12px;
    transition: width 0.3s ease;
}

#student-dashboard .card {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
}

#student-dashboard .card h2 {
    font-size: 24px;
    color: #2d3748;
    margin-bottom: 20px;
    font-weight: 600;
}

#student-dashboard table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
}

#student-dashboard th, #student-dashboard td {
    padding: 12px 15px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    text-align: left;
}

#student-dashboard th {
    background: #3b82f6;
    color: white;
    font-weight: 600;
}

#student-dashboard tr:nth-child(even) {
    background-color: rgba(59, 130, 246, 0.05);
}

#student-dashboard tr:hover {
    background-color: rgba(59, 130, 246, 0.1);
    transform: scale(1.01);
    transition: all 0.2s ease;
}

#student-dashboard .btn {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    margin-top: 10px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

#student-dashboard .btn-blue {
    background: #3b82f6;
    color: #fff;
}

#student-dashboard .btn-blue:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
}

#student-dashboard .btn-red {
    background: #ef4444;
    color: #fff;
}

#student-dashboard .btn-red:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
}

#student-dashboard ul {
    list-style: none;
    padding: 0;
}

#student-dashboard ul li {
    padding: 10px 0;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    color: #4a5568;
    position: relative;
    padding-left: 20px;
}

#student-dashboard ul li::before {
    content: '•';
    color: #3b82f6;
    font-size: 16px;
    position: absolute;
    left: 0;
    top: 10px;
}

#student-dashboard ul li:last-child {
    border-bottom: none;
}
</style>
</head>
<body>
<div id="student-dashboard">
    <h1>Welcome, <?php echo $student["studentName"]; ?></h1>
    <?php
    $cstmt = $conn->prepare("SELECT * FROM tblspecialcourse WHERE courseId=:courseId");
    $cstmt->bindParam(":courseId", $courseId);
    $cstmt->execute();

    $tCourse = $cstmt->rowCount();

    ?>
    <div class="stats-grid">
        <!-- Total Courses - Blue -->
        <div class="stat-card" style="background: #3b82f6;">
            <div class="number"><?php echo $tCourse ?></div>
            <h3>Total Courses</h3>
            <div class="progress-bar"><div class="progress-bar-inner" style="width:75%;"></div></div>
            <a href="#" class="btn btn-blue">Know More</a>
        </div>
    
        <!-- Completed Modules - Green -->
        <div class="stat-card" style="background: #10b981;">
            <div class="number">12</div>
            <h3>Completed Modules</h3>
            <div class="progress-bar"><div class="progress-bar-inner" style="width:80%;"></div></div>
            <a href="#" class="btn btn-blue">Know More</a>
        </div>
    
        <!-- Pending Modules - Yellow -->
        <div class="stat-card" style="background: #f59e0b;">
            <div class="number">8</div>
            <h3>Pending Modules</h3>
            <div class="progress-bar"><div class="progress-bar-inner" style="width:50%;"></div></div>
            <a href="#" class="btn btn-blue">Know More</a>
        </div>
    
        <!-- Overall Progress - Purple -->
        <div class="stat-card" style="background: #8b5cf6;">
            <div class="number">60%</div>
            <h3>Overall Progress</h3>
            <div class="progress-bar"><div class="progress-bar-inner" style="width:60%;"></div></div>
            <a href="#" class="btn btn-blue">Know More</a>
        </div>
    </div>

    <div class="card">
        <h2>Your Courses</h2>
        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Modules Completed</th>
                    <th>Progress</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($specialCourse=$cstmt->fetch())
            {
            ?>
            
                <tr>
                    <td><?php echo $specialCourse["specialCourseName"]; ?></td>
                    <?php
                    $specialCourseId = $specialCourse["specialCourseId"];
                    $mstmt=$conn->prepare("SELECT * FROM tblmodule WHERE specialCourseId = :specialCourseId");
                    $mstmt->bindParam(":specialCourseId",$specialCourseId);
                    $mstmt->execute();
                    $mcount = $mstmt->rowCount();
                    $module = $mstmt->fetch();
                    ?>
                    <td>3/<?php echo $mcount; ?></td>
                    <td>
                        <div class="progress-bar" style="background-color: rgba(59, 130, 246, 0.2);">
                            <div class="progress-bar-inner" style="background: #3b82f6; width:60%;"></div>
                        </div>
                    </td>
                    <td><a href="#" class="btn btn-blue">Know More</a></td>
                </tr>
                
            
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Alerts</h2>
        <ul>
            <li>Complete the pending Python module.</li>
            <li>Submit your Data Structures assignment.</li>
            <li>Improve your quiz performance in Algorithms.</li>
        </ul>
        <a href="#" class="btn btn-red">Know More</a>
    </div>
</div>

<?php
include "../splitting-student/footer.php";
?>
</body>
</html>