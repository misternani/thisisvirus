<?php session_start();?>
<html>
<head>
        <link rel="icon" href="favicon.ico" type="image/icon" sizes="16x16">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1.0,user-scalable=no"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
       <link  rel="stylesheet" href="css/bootstrap.min.css"/>
     <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
     <link rel="stylesheet" href="css/main.css">
     <link  rel="stylesheet" href="css/font.css">
     <script src="js/jquery.js" type="text/javascript"></script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6335432508397861"
     crossorigin="anonymous"></script>
      <script src="js/bootstrap.min.js"  type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'> 
    <style type="text/css">
        img{
            width:100%;
        }
    </style>

   
   
    </head>
<body>
<?php
 include_once 'dbConnection.php';
 
 ob_start();
     $_SESSION['visit']='1';
    $username=$_SESSION['username'];
    $eid=$_GET['eid'];
    $_SESSION['revert']=$eid;
    $r = mysqli_query($con, "SELECT category from quiz WHERE  eid = '$eid'") or die('Error');
    while ($rol = mysqli_fetch_row($r)) {$pat=$rol[0];}
    $c=$pat;
    $q = mysqli_query($con, "SELECT * FROM quiz WHERE eid='$eid' ") or die('Error157');
    while ($row = mysqli_fetch_array($q)) {
        $total = $row['total'];
    }
    $q = mysqli_query($con, "SELECT * FROM history WHERE eid='$eid' AND username='$username' ") or die('Error157');
    
    while ($row = mysqli_fetch_array($q)) {
        $s      = $row['score'];
        $w      = $row['wrong'];
        $r      = $row['correct'];
        $status = $row['status'];
    }
    if (isset($status)&&$status == "finished") {
        echo '<div class="panel">
<center><h1 class="title" style="color:#660033">Result</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';
        echo '<tr style="color:darkblue"><td style="vertical-align:middle">Total Questions</td><td style="vertical-align:middle">' . $total . '</td></tr>
      <tr style="color:darkgreen"><td style="vertical-align:middle">Correct Answer&nbsp;<span class="glyphicon glyphicon-ok-arrow" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $r . '</td></tr> 
    <tr style="color:red"><td style="vertical-align:middle">Wrong Answer&nbsp;<span class="glyphicon glyphicon-remove-arrow" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $w . '</td></tr>
    <tr style="color:orange"><td style="vertical-align:middle">Unattempted&nbsp;<span class="glyphicon glyphicon-ban-arrow" aria-hidden="true"></span></td><td style="vertical-align:middle">' . ($total - $r - $w) . '</td></tr>
    <tr style="color:darkblue"><td style="vertical-align:middle">Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td style="vertical-align:middle">' . $s . '</td></tr>';
       echo '<tr></tr></table></div><div class="panel"><br /><h3 align="center" style="font-family:calibri">:: Detailed Analysis ::</h3><br /><ol style="font-size:20px;font-weight:bold;font-family:calibri;margin-top:20px">';
        $q = mysqli_query($con, "SELECT * FROM questions WHERE eid='$_GET[eid]'") or die('Error197');
        while ($row = mysqli_fetch_array($q)) {
            $question = $row['qns'];
            $qid      = $row['qid'];
            $q2 = mysqli_query($con, "SELECT * FROM user_answer WHERE eid='$_GET[eid]' AND qid='$qid' AND username='$_SESSION[username]'") or die('Error197');
            if (mysqli_num_rows($q2) > 0) {
                $row1         = mysqli_fetch_array($q2);
                $ansid        = $row1['ans'];
                $correctansid = $row1['correctans'];
                $q3 = mysqli_query($con, "SELECT * FROM options WHERE optionid='$ansid'") or die('Error197');
                $q4 = mysqli_query($con, "SELECT * FROM options WHERE optionid='$correctansid'") or die('Error197');
                $row2       = mysqli_fetch_array($q3);
                $row3       = mysqli_fetch_array($q4);
                $ans        = $row2['option'];
                $correctans = $row3['option'];
            } else {
                $q3 = mysqli_query($con, "SELECT * FROM answer WHERE qid='$qid'") or die('Error197');
                $row1         = mysqli_fetch_array($q3);
                $correctansid = $row1['ansid'];
                $q4 = mysqli_query($con, "SELECT * FROM options WHERE optionid='$correctansid'") or die('Error197');
                $row2       = mysqli_fetch_array($q4);
                $correctans = $row2['option'];
                $ans        = "Unanswered";
            }
            if ($correctans == $ans && $ans != "Unanswered") {
                 $c='uploads/'.$question;
                $r     = mysqli_query($con, "SELECT image FROM questions WHERE eid='$_GET[eid]'");
                while ($rol = mysqli_fetch_row($r)) {$pat=$rol[0];}
                if($pat)
                {
                    echo '<li><div style="font-size:16px;font-weight:bold;font-family:calibri;margin-top:20px;padding:10px;word-wrap:break-word;border:2px solid darkgreen;border-radius:10px;"><img src="'.$c.'"/><span class="glyphicon glyphicon-ok" style="color:darkgreen"></span></div><br />';
                }
                else{ echo '<li><div style="font-size:16px;font-weight:bold;font-family:calibri;margin-top:20px;background-color:lightgreen;padding:10px;word-wrap:break-word;border:2px solid darkgreen;border-radius:10px;">' . $question . ' <span class="glyphicon glyphicon-ok" style="color:darkgreen"></span></div><br />';
                }
               
                echo '<font style="font-size:14px;color:darkgreen"><b>Your Answer: </b></font><font style="font-size:14px;">' . $ans . '</font><br />';
                echo '<font style="font-size:14px;color:darkgreen"><b>Correct Answer: </b></font><font style="font-size:14px;">' . $correctans . '</font><br />';
            } 
            else if ($ans == "Unanswered") {
                 $c='uploads/'.$question;
                $r     = mysqli_query($con, "SELECT image FROM questions WHERE eid='$_GET[eid]'");
                while ($rol = mysqli_fetch_row($r)) {$pat=$rol[0];}
                if($pat)
                {
                    echo '<li><div style="font-size:16px;font-weight:bold;font-family:calibri;margin-top:20px;padding:10px;word-wrap:break-word;border:2px solid #b75a0e;border-radius:10px;"><img src="'.$c.'"/></span></div><br />';
                }
                else{
                echo '<li><div style="font-size:16px;font-weight:bold;font-family:calibri;margin-top:20px;background-color:#f7f576;padding:10px;word-wrap:break-word;border:2px solid #b75a0e;border-radius:10px;">' . $question . ' </div><br />';}
                echo '<font style="font-size:14px;color:darkgreen"><b>Correct Answer: </b></font><font style="font-size:14px;">' . $correctans . '</font><br />';
            } 
            else {
                 $c='uploads/'.$question;
                $r     = mysqli_query($con, "SELECT image FROM questions WHERE eid='$_GET[eid]'");
                while ($rol = mysqli_fetch_row($r)) {$pat=$rol[0];}
                if($pat)
                {
                    echo '<li><div style="font-size:16px;font-weight:bold;font-family:calibri;margin-top:20px;padding:10px;word-wrap:break-word;border:2px solid red;border-radius:10px;"><img src="'.$c.'"/><span class="glyphicon glyphicon-remove" style="color:red"></span></div><br />';
                }else{
                echo '<li><div style="font-size:16px;font-weight:bold;font-family:calibri;margin-top:20px;background-color:#f99595;padding:10px;word-wrap:break-word;border:2px solid darkred;border-radius:10px;">' . $question . ' <span class="glyphicon glyphicon-remove" style="color:red"></span></div><br />';}
                echo '<font style="font-size:14px;color:red"><b>Your Answer: </b></font><font style="font-size:14px;">' . $ans . '</font><br />';
                echo '<font style="font-size:14px;color:green"><b>Correct Answer: </b></font><font style="font-size:14px;">' . $correctans . '</font><br />';
                
            }
            echo "<br /></li>";
        }
        echo '</ol>';
        echo "</div>";
    } else {
        die("You must submit any opened tests before attempting new test, so go and submit any continue or opened quizzes.");
    }?>


</body>
</html>

