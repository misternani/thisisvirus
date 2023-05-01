<?php include_once 'dbConnection.php';

    session_start();
    ob_start();
    $_SESSION['visit']='0';
    $c=$_GET['cat'];
    $username=$_GET['user'];
    if (!(isset($_SESSION['username']))) 
    {
        $result = mysqli_query($con, "SELECT username FROM user WHERE username = '$username' and password = '$username'") or die('Error');
        $count = mysqli_num_rows($result);
        if ($count == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $name = $row['username'];
        }

        $_SESSION["username"] = $username;
          $_SESSION["name"]     = $username;
        }

        else{
       $q3 = mysqli_query($con, "INSERT INTO user(name,username,password) VALUES  ('$username','$username','$username')");
        if ($q3) {
      
        $_SESSION["username"] = $username;
             $_SESSION["name"]     = $username;
    }
    }
    } else {

        $result = mysqli_query($con, "SELECT username FROM user WHERE username = '$username' and password = '$username'") or die('Error');
        $count = mysqli_num_rows($result);
        if ($count == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $name = $row['username'];
        }

        $_SESSION["username"] = $username;
          $_SESSION["name"]     = $username;
        }

        else{
       $q3 = mysqli_query($con, "INSERT INTO user(name,username,password) VALUES  ('$username','$username','$username')");
        if ($q3) {
      
        $_SESSION["username"] = $username;
             $_SESSION["name"]     = $username;
         }
     }

        $name     = $username;
        $username = $username;
        
     
        
    }?>
    <!DOCTYPE html>
    <html>
    <head>
        
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
       <link  rel="stylesheet" href="css/bootstrap.min.css"/>
       <link rel="icon" href="favicon.ico" type="image/icon" sizes="16x16">
     <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
     <link rel="stylesheet" href="css/main.css">
     <link  rel="stylesheet" href="css/font.css">
     <script src="js/jquery.js" type="text/javascript"></script>
     <script src="js/bootstrap.min.js"  type="text/javascript"></script>
    </head>
    <body>
  
    <?php $result = mysqli_query($con, "SELECT * FROM quiz WHERE status = 'enabled' and category = '$c' ORDER BY date DESC") or die('Error');
        echo '<div class="panel"><table class="table table-striped title1"  style="vertical-align:middle">';
        $c = 1;
        while ($row = mysqli_fetch_array($result)) {
            $title   = $row['title'];
            $total   = $row['total'];
            $correct = $row['correct'];
            $wrong   = $row['wrong'];
            $time    = $row['time'];
            $eid     = $row['eid'];
            $q12 = mysqli_query($con, "SELECT score FROM history WHERE eid='$eid' AND username='$username'") or die('Error98');
            $rowcount = mysqli_num_rows($q12);
            if ($rowcount == 0) {
                echo '<tr><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle;color:gray;font-weight:bold;">' . $title . '</td>
      <td style="vertical-align:middle"><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&start=start" class="btn" style="color:white;background:#009900;font-size:12px;padding:7px;padding-left:10px;padding-right:10px"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span><b>Start</b></span></a></b></td></tr>';
            } else {
                $q = mysqli_query($con, "SELECT * FROM history WHERE username='$_SESSION[username]' AND eid='$eid' ") or die('Error197');
                while ($row = mysqli_fetch_array($q)) {
                    $timec  = $row['timestamp'];
                    $status = $row['status'];
                }
                $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' ") or die('Error197');
                while ($row = mysqli_fetch_array($q)) {
                    $ttimec  = $row['time'];
                    $qstatus = $row['status'];
                }
                $remaining = (($ttimec * 60) - ((time() - $timec)));
                if ($remaining > 0 && $qstatus == "enabled" && $status == "ongoing") {
                    echo '<tr style="color:#ff6600"><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle;font-weight:bold;">' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
      <td style="vertical-align:middle"><b><a href="account.php?q=quiz&step=2&eid=' . $eid . '&n=1&t=' . $total . '&start=start" class="btn" style="margin:0px;background:darkorange;color:white">&nbsp;<span class="title1"><b>Continue</b></span></a></b></td></tr>';
                } else {
                    echo '<tr style="color:#33cc33"><td style="vertical-align:middle">' . $c++ . '</td><td style="vertical-align:middle;font-weight:bold;">' . $title . '&nbsp;<span title="This quiz is already solve by you" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
      <td style="vertical-align:middle"><b><a href="result.php?eid=' . $eid . '" class="btn" style="margin:0px;background:#ffcc00;color:white">&nbsp;<span class="title1"><b>View Result</b></span></a></b>

           <b><a href="retaker.php?eid=' . $eid . '&total='.$total.'&c='.$c.'" class="btn" style="margin:0px;background:#ff0000;color:white">&nbsp;<span class="title1"><b>Clear</b></span></a></b>

      </td></tr>';



     
                }
            }
        }
?>
</body>
    </html>
