<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .left-side
        {
            background-color:#343a40;
            color:white;
            height:200vh;
        }
        .heading
        {
            text-align:center;
            margin:10px auto;
        }
        .image
        {
            display:flex;
            justify-content:center;
        }
        .image img
        {
            border-radius:60px;
        }
        .left-btn
        {
            color:white;
            transition: background-color 0.3s ease;
            margin-top:20px;
        }
        .left-btn:hover
        {
            background-color:#495057 !important;
        }
        /* .left-btn-1
            transition: background-color 0.3s ease;
            margin-top:20px;
        } */
        .left-btn-1:hover
        {
            background-color:#495057 !important;
        }
        .right-side
        {
            background-color:#F8F9FA;
        }
        .welcome-text
        {
            font-family: 'Poppins', sans-serif;
            font-size: 28px;
            font-weight: 600;
            color: #343a40;
        }
        .admin-name
        {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            font-weight: 400;
            color: #495057;
        }
    </style>
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2  left-side">
                <div class="heading">
                    <h5>ADMIN DASHBOARD</h5> 
                </div>
                <div class="image">
                    <a href="admin-dashboard.php">
                    <?php
                
                        $query = "select * from tbladmin where adminId=:adminId";
                        $stmt=$conn->prepare($query);
                        $stmt->bindParam(":adminId",$adminId);
                        $stmt->execute();
                        $result = $stmt->fetch();
                        
                        if (!empty($result['picture'])) 
                        {
                        	echo '<img src="'.$result['picture'].'" style=" height: 100px;" />';
                        } 
                        else 
                        {
                        	if ($result['adminGender'] == '1') 
                        	{
                        		echo '<img src="images/female-logo.jpg" alt="Male" style="height: 100px; width: 100px;" />';
                        	} 
                        	elseif ($result['adminGender'] == '2')
                        	{
                        		echo '<img src="images/male-logo.jpg" alt="Female" style="height: 100px; width: 100px;" />';
                        	} 
                        }
                    ?>
                    </a>
                </div>
                <div class="buttons">
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Course
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="add-course.php">Add Course</a></li>
                        <li><a class="dropdown-item w-100" href="course-table.php">Course-table</a></li>
                        <li><a class="dropdown-item w-100" href="add-course-fees.php">Add Course Fees</a></li>
                        <li><a class="dropdown-item w-100" href="course-fees-table.php">Course Fees Table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Subject
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="add-subject.php">Add Subject</a></li>
                        <li><a class="dropdown-item w-100" href="subject-table.php">Subject Table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Test
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="test-detail.php">Add Test Detail</a></li>
                        <li><a class="dropdown-item w-100" href="add-test.php">Add Test</a></li>
                        <li><a class="dropdown-item w-100" href="add-result.php">Add Test Result</a></li>
                        <li><a class="dropdown-item w-100" href="test-table.php">Test Table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Fees
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="add-fees.php">Add Fees</a></li>
                        <li><a class="dropdown-item w-100" href="fees-table.php">Fees-table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="add-admin.php">Add Admin</a></li>
                        <li><a class="dropdown-item w-100" href="admin-table.php">Admin Table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Attedence
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="attendence-management.php" class="btn left-btn-1  w-100">Student Attendence</a></li>
                        <li><a href="attendence-table.php" class="btn left-btn-1  w-100">Attendence Table</a></li>
                        <li><a href="notice-student.php" class="btn left-btn-1  w-100">Attendence Notice</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Student
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="student-table.php" class="btn left-btn-1  w-100">Student Table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Session
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="add-session.php">Add Session</a></li>
                        <li><a class="dropdown-item w-100" href="session-table.php">Session-table</a></li>
                      </ul>
                    </div>
                    <div class="dropdown ">
                      <button class="btn dropdown-toggle w-100 nav-link left-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        sahu
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item w-100" href="sahu.php">Sahu</a></li>
                      </ul>
                    </div>
                    <a href="logout-admin.php" class="btn left-btn w-100 nav-link">
                        Log Out
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                    </a> 
                </div>
            </div>
            <div class="col-md-10 col-sm-10 right-side">
                <div>
                    <h3 class="welcome-text">Welcome, <span class="admin-name"><?php echo $result['adminName']; ?></span></h3>
                </div>
   
           
 