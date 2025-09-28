<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    
        .heading-1
        {
            font-size:18px;
            border-bottom:2.5px solid white;
        }
        .btn-attendence
        {
            margin-bottom:10px;
        }
        .box-1
        {
            background-color:#ffffff;
        }
        .box-2
        {
            max-height: 210px; 
            overflow-y: auto;
            
        }
        .notice-date
        {
            font-size:12px;
        }
         .notice-list {
            padding:10px;
          background-color:#ffffff;
          max-height: 150px;  
          overflow-y: auto;   
          padding: 0;
          margin-top: 10px;
          list-style-type: none;
          border-bottom:1px solid black;
        }
        .notice-boxes
        {
            border:1px solid black;
            margin-top:5px;
            padding:10px;
            border-radius:10px;
        }
        .data
        {
            margin-top:10px;
            border:1px solid black;
            border-radius:5px;
            box-shadow:0 0 10px;
            height:210px;
            padding:10px;
            
        }
        .data-2
        {
            margin-top:10px;
            border:1px solid black;
            border-radius:5px;
            box-shadow: -2px -1px 7px 1px;
            min-height:100px;
            height:auto;
            
        }
        .data-1
        {
            margin-top:10px;
            margin-left:10px;
            border:1px solid black;
            border-radius:5px;
            box-shadow: -2px -1px 7px 1px;
            min-height:300px;
             height:auto;
            
        }
        .box-test
        {
          max-height: 400px;  
          overflow-y: auto;   
          padding: 0;
          margin-top: 10px;
          list-style-type: none;  
        }
        .progress
        {
            float:right;
            width:100px;
        }
        .text
        {
            display: flex;
            justify-content: space-around;
            font-size:17px;
            border-bottom:1px solid black;
            
        }
        .left-side
        {
            background-color:#1f2a40 ;
            color:white;
            min-height:130vh;
            height:auto;
        }
        .heading
        {
            text-align:center;
            margin:10px auto;
        }
        .image img
        {
            border-radius:60px;
            margin-top:10px;
        }
        .text-box-1
        {
            margin-top:20px;
        }
        .left-btn
        {
            color:white;
            transition: background-color 0.3s ease;
            margin-top:20px;
        }
        .left-btn:hover
        {
            background-color:#495057 !important ;
        }
        .right-side
        {
            background-color:#f0f4f8;
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
            font-size: 16px;
            font-weight: 400;
        }
        .student-quote
        {
            color:#28A745;
            font-size:15px;
        }
        .tbl-subject
        {
            margin-top:10px;
        }
    </style>
  </head>
  <body>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-2  left-side">
                <div class="heading">
                    <p class="heading-1"><strong>STUDENT DASHBOARD</strong></p> 
                </div>
                <div class="buttons">
                    <a href="student-dashboard.php" class="btn left-btn w-100 nav-link">
                        Dashboard
                    </a> 
                    <a href="student-profile.php?studentId=<?php echo $result["studentId"] ?>" class="btn left-btn w-100 nav-link">
                        Profile
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                    </a>
                    <a href="fees-student.php" class="btn left-btn w-100 nav-link">
                        Fees Tracker
                    </a>
                    <a href="attendence-student.php" class="btn left-btn w-100 nav-link">
                        Attendance
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-backpack" viewBox="0 0 16 16">
                          <path d="M4.04 7.43a4 4 0 0 1 7.92 0 .5.5 0 1 1-.99.14 3 3 0 0 0-5.94 0 .5.5 0 1 1-.99-.14M4 9.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm1 .5v3h6v-3h-1v.5a.5.5 0 0 1-1 0V10z"/>
                          <path d="M6 2.341V2a2 2 0 1 1 4 0v.341c2.33.824 4 3.047 4 5.659v5.5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5V8a6 6 0 0 1 4-5.659M7 2v.083a6 6 0 0 1 2 0V2a1 1 0 0 0-2 0m1 1a5 5 0 0 0-5 5v5.5A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5V8a5 5 0 0 0-5-5"/>
                        </svg>
                    </a>
                    <a href="test-student.php" class="btn left-btn w-100 nav-link">
                       Test Details
                    </a>
                    <a href="logout-student.php" class="btn left-btn w-100 nav-link">
                        Log Out
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg>
                    </a> 
                </div>
            </div>
            <div class="col-md-10 col-sm-10 right-side">
                  
           
 