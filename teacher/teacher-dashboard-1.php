<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../database-connect.php";

$students = $conn->query("SELECT * FROM tblstudent")->fetchAll(PDO::FETCH_ASSOC);
$tests = $conn->query("
    SELECT t.*, COALESCE(s.subjectName, CONCAT('Subject ', t.subjectId)) as subjectName 
    FROM tbltest t 
    LEFT JOIN tblsubject s ON t.subjectId = s.subjectId
")->fetchAll(PDO::FETCH_ASSOC);
$marks = $conn->query("SELECT * FROM tblresult")->fetchAll(PDO::FETCH_ASSOC);
$attendance = $conn->query("SELECT * FROM tblattendence")->fetchAll(PDO::FETCH_ASSOC);

$totalStudents = count($students);
$totalTests = count($tests);

$attendanceCount = 0;
foreach ($attendance as $a) if (!empty($a['attendence'])) $attendanceCount++;
$avgAttendance = ($totalTests && $totalStudents) ? round(($attendanceCount / ($totalStudents * $totalTests)) * 100, 1) : 0;

$lowPerformers = [];
$performanceDist = ['Excellent'=>0,'Good'=>0,'Average'=>0,'Needs Improvement'=>0];

foreach ($students as $student) {
    $studentMarks = [];
    foreach ($marks as $m) if ($m['studentId']==$student['studentId']) $studentMarks[] = $m;
    $total=0; $count=0;
    foreach ($studentMarks as $m) if (isset($m['marksObtained'])) {$total+=$m['marksObtained']; $count++;}
    $avg = ($count>0)?($total/$count):0;
    if($avg<50) $lowPerformers[]=['studentName'=>$student['studentName'],'avg_percentage'=>$avg];
    if($avg>=90) $performanceDist['Excellent']++;
    elseif($avg>=75) $performanceDist['Good']++;
    elseif($avg>=50) $performanceDist['Average']++;
    else $performanceDist['Needs Improvement']++;
}

$testAverages = [];
foreach($tests as $t) {
    $testMarks = [];
    foreach($marks as $m) if(isset($m['testId']) && $m['testId']==$t['testId']) $testMarks[]=$m;
    $sum=0;$count=0;
    foreach($testMarks as $tm) if(isset($tm['marksObtained'])){$sum+=$tm['marksObtained']; $count++;}
    $average = ($count>0)?round($sum/$count,1):0;
    $testAverages[]=['testName'=>$t['subjectName'],'average'=>$average];
}
?>

<title>Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body{
    font-family:Arial,sans-serif;
    background:#f0f2f5;
    margin:0;
    padding:15px;
    color:#333;
    height:100vh;
    overflow:hidden;
}
h1,h2{
    color:#667eea;
    margin:10px 0;
    font-size:1.3rem;
}
.container{
    max-width:100%;
    height:100vh;
    display:flex;
    flex-direction:column;
}
.stats-grid{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-bottom:20px;
}
.stat-card{
    flex:1 1 200px;
    background:#667eea;
    color:#fff;
    padding:15px;
    border-radius:8px;
    text-align:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}
.stat-number{
    font-size:1.8rem;
    font-weight:bold;
}
.stat-label{
    font-size:0.9rem;
    opacity:0.9;
}
.charts-grid{
    display:flex;
    gap:15px;
    flex:1;
    min-height:0;
}
.chart-card{
    flex:1;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    display:flex;
    flex-direction:column;
}
.chart-container{
    position:relative;
    flex:1;
    min-height:350px;
}
.btn{
    display:inline-block;
    padding:6px 12px;
    margin-top:8px;
    background:#fff;
    color:#667eea;
    border-radius:6px;
    text-decoration:none;
    font-size:0.8rem;
    font-weight:500;
    transition:all 0.3s ease;
}
.btn:hover{
    background:#f8f9fa;
    transform:translateY(-1px);
}
</style>
</head>
<body>
<div class="container">

<div class="stats-grid">
<div class="stat-card">
    <div class="stat-number"><?php echo $totalStudents;?></div>
    <div class="stat-label">Total Students</div>
    <a href="students.php" class="btn">View Details</a>
</div>
<div class="stat-card">
    <div class="stat-number"><?php echo $totalTests;?></div>
    <div class="stat-label">Total Tests</div>
    <a href="tests.php" class="btn">View Details</a>
</div>
<div class="stat-card">
    <div class="stat-number"><?php echo $avgAttendance;?>%</div>
    <div class="stat-label">Avg Attendance</div>
    <a href="attendance.php" class="btn">View Details</a>
</div>
<div class="stat-card">
    <div class="stat-number"><?php echo count($lowPerformers);?></div>
    <div class="stat-label">Low Performers</div>
    <a href="low-performers.php" class="btn">View Details</a>
</div>
</div>

<div class="charts-grid">
<div class="chart-card">
    <h2>Average Marks by Test</h2>
    <div class="chart-container">
        <canvas id="marksChart"></canvas>
    </div>
</div>
<div class="chart-card">
    <h2>Performance Distribution</h2>
    <div class="chart-container">
        <canvas id="perfChart"></canvas>
    </div>
</div>
<div class="chart-card">
    <h2>Low Performers (%)</h2>
    <div class="chart-container">
        <?php if(count($lowPerformers)==0): ?>
        <p style="font-size:0.9rem;text-align:center;margin-top:100px;color:#666;">No low performers found</p>
        <?php else: ?>
        <canvas id="lowPerformersChart"></canvas>
        <?php endif;?>
    </div>
</div>
</div>

<script>
// Average Marks Chart
const marksCtx = document.getElementById('marksChart').getContext('2d');
new Chart(marksCtx,{
    type:'bar',
    data:{
        labels:<?php echo json_encode(array_column($testAverages,'testName'));?>,
        datasets:[{
            label:'Average Marks',
            data:<?php echo json_encode(array_column($testAverages,'average'));?>,
            backgroundColor:'#667eea',
            borderRadius:4,
            borderSkipped:false,
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{display:false},
            tooltip:{
                backgroundColor:'rgba(102, 126, 234, 0.9)',
                titleColor:'#fff',
                bodyColor:'#fff'
            }
        },
        scales:{
            y:{
                beginAtZero:true,
                max:100,
                grid:{color:'rgba(0,0,0,0.1)'},
                ticks:{font:{size:12}}
            },
            x:{
                grid:{display:false},
                ticks:{
                    font:{size:12},
                    maxRotation:45
                }
            }
        }
    }
});

// Performance Distribution Chart
const perfCtx = document.getElementById('perfChart').getContext('2d');
new Chart(perfCtx,{
    type:'doughnut',
    data:{
        labels:<?php echo json_encode(array_keys($performanceDist));?>,
        datasets:[{
            data:<?php echo json_encode(array_values($performanceDist));?>,
            backgroundColor:['#28a745','#17a2b8','#ffc107','#dc3545'],
            borderWidth:0,
            cutout:'50%'
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                position:'bottom',
                labels:{
                    font:{size:12},
                    padding:20,
                    usePointStyle:true
                }
            },
            tooltip:{
                backgroundColor:'rgba(0,0,0,0.8)',
                titleColor:'#fff',
                bodyColor:'#fff'
            }
        }
    }
});

// Low Performers Chart
<?php if(count($lowPerformers) > 0): ?>
const lowPerfCtx = document.getElementById('lowPerformersChart').getContext('2d');
new Chart(lowPerfCtx,{
    type:'bar',
    data:{
        labels:<?php echo json_encode(array_column($lowPerformers, 'studentName'));?>,
        datasets:[{
            label:'Percentage',
            data:<?php echo json_encode(array_column($lowPerformers, 'avg_percentage'));?>,
            backgroundColor:'#dc3545',
            borderRadius:4,
            borderSkipped:false,
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{display:false},
            tooltip:{
                backgroundColor:'rgba(220, 53, 69, 0.9)',
                titleColor:'#fff',
                bodyColor:'#fff'
            }
        },
        scales:{
            y:{
                beginAtZero:true,
                max:50,
                grid:{color:'rgba(0,0,0,0.1)'},
                ticks:{font:{size:12}}
            },
            x:{
                grid:{display:false},
                ticks:{
                    font:{size:10},
                    maxRotation:45
                }
            }
        }
    }
});
<?php endif; ?>
</script>
</div>
</body>
</html>