<?php
  include "admin-dashboard-top.php";
  include "admin-dashboard-content.php";
  include "../database-connect.php";
  $sessionId  = $_REQUEST["sessionId"];
  $stmt=$conn->prepare("SELECT * FROM tblsession where sessionId=:sessionId");
  $stmt->bindParam(":sessionId",$sessionId);
  $stmt->execute();
  $result=$stmt->fetch();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .fees-content
        {
            margin-top:20px;
        }
        .form-section
        {
             background: #fff;
             margin:40px auto;
             box-shadow:0 0 10px;
             border-radius:10px;
             padding:10px;
        }
        .heading-fees
        {
            text-align:center;
            border-bottom:2px solid black;
        }
        .submit
        {
            width: 98%;
            margin:10px 10px 10px 10px;
        }
    </style>
  </head>
    <div class="col-md-10 form-section">
        <body>
            <form class="fees-content" action="update-session-process.php" method="POST">
                <?php if (isset($_REQUEST["err"]) && $_REQUEST["err"] == 1): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Session Name not filled
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="heading-fees">
                    <h3>ADD SESSION</h3>
                </div>
                <input type="hidden" name="sessionId" value="<?php echo $result["sessionId"]; ?>">
                <div class="mb-3">
                    <label class="form-label"><b>Session Name</b></label>
                    <input class="form-control" type="text" name="sessionName" value="<?php echo htmlspecialchars($result["sessionName"]); ?>">
                </div>
                <?php
                    if($result["status"]==1)
                    {
                       ?> 
                    <div class="form-check">
                          <input class="form-check-input" type="radio" name="status" value="1"  checked>
                          <label class="form-check-label" for="flexRadioDefault1">
                            Active
                          </label>
                        </div>
                        <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" value="0"  >
                  <label class="form-check-label" for="flexRadioDefault2">
                    Inactive
                  </label>
                </div>
                    <?php
                    }
                    else
                    {
                    ?>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="1"  >
                      <label class="form-check-label" for="flexRadioDefault1">
                        Active
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="0"  checked>
                      <label class="form-check-label" for="flexRadioDefault2">
                        Inactive
                      </label>
                    </div>
                <?php
                    }
                ?>
                <button type="submit" class="btn btn-primary submit">Submit</button>
            </form>
        </body>
    </div>
    </div>
    </div>
<?php
    include "admin-dashboard-footer.php";
?>