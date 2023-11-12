<?php
    error_reporting(0);
    include '../db/config.php';
    $sql_q = "SELECT sid,sname FROM std_info";
    $std_data = mysqli_query($conn, $sql_q);
    $i=1;
    if( $_GET['sname'] == "none"){
        $flag = false;
    }
    else if(null!== $_GET["sname"] ){
        $sid = $_GET['sname'];
        $fdate = $_GET['fdate'];
        $tdate = $_GET['tdate'];
        $sql= "SELECT * FROM report WHERE sid='$sid' AND scdate BETWEEN '$fdate' AND '$tdate' ORDER BY scdate";
        $result = mysqli_query($conn, $sql);
        $flag = true;
        $sql2= "SELECT sname, course, spno, tzone FROM std_info WHERE sid = '$sid'";
        $result2 = mysqli_query($conn, $sql2);
        $stdprof = mysqli_fetch_assoc($result2);
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="home">
        <div class="wrapper">
            <div class="menu">
                <h2><i class='bx bxs-dashboard'></i> DASHBOARD</h2>
                <ul class="menu-adjust">
                    <li><a href="../index.php"><i class='bx bx-home' ></i> Home</a></li>
                    <li><a href="../students/student.php"><i class='bx bxs-group' ></i> Students</a></li>
                    <li class="sch-menu" id="active">
                        <a href="#"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="../schedule/daily.php"><i class='bx bx-calendar'></i> Schedule  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../schedule/daily.php"> Daily</a> </li>
                            <li><a style="font-size: 18px;" href="../schedule/weekly.php"> Weekly</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="../payment/history.php"><i class='bx bx-money'></i> Billing  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../payment/new.php"> Add new</a> </li>
                            <li><a style="font-size: 18px;" href="../payment/history.php"> History</a> </li>
                        </ul>
                    </li>
                    <li><a href="https://app.ziteboard.com/" target="_blank"><i class='bx bx-chalkboard' ></i> Ziteboard</a></li>
                    <li><a href="https://google.com" target="_blank"><i class='bx bxl-google' ></i>oogle</a></li>
                </ul>
            </div>
            <div class="main-content">
                <div class="header">
                    <h4>SESSION REPORTS</h4>
                </div>
                <div class="content-card">
                    <div class="select-date-rep">
                        <div class="search-holder">
                            <h3>Select student</h3><br>
                            <form action="#">
                                <div>
                                    <label for="sname">Student:</label>
                                    <select name="sname" id="sname" required>
                                        <option selected="selected" value = "none">select a student</option>
                                        
                                        <?php 
                                            if(mysqli_num_rows($std_data) > 0){
                                                    while($stdetail = mysqli_fetch_assoc($std_data)){
                                                        echo '<option value="'. $stdetail['sid'] .'">'. $stdetail['sname'] .'</option>';
                                                    
                                                    }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <br><br>
                                <div class="unifbox">
                                    <div>
                                        <label for="fdate">From: </label>
                                        <input type="date" name="fdate" id="fdate" >
                                    </div>
                                    <div>
                                        <label for="tdate">To:   </label>
                                        <input type="date" name="tdate" id="tdate" >
                                    </div>
                                    <div class="btn-holder">
                                        <button type="submit" id="bt-sub" name="subreport" style="color: #fff;">Submit</button>
                                    </div>
                                </div>
                                              

                            </form>

                        </div>
                    </div>
                    <?php
                    if($flag){
                        echo '<div class="report-details">
                        <center><h3>Session reports: '. $fdate. ' to '. $tdate .' </h3></center>
                        <br>
                        <div class="stud-info">
                        <span><b>Name:</b> '. $stdprof["sname"] .'</span>
                        <span><b>Course:</b> '. $stdprof["course"] .'</span>
                        <span><b>Phone:</b> '. $stdprof["spno"] .'</span>
                        <span><b>Timezone:</b> ';
                        foreach($timezones as $val => $disp)  {    if($val == $stdprof['tzone']){ echo $disp;  } }  
                        echo '</span>
                        </div>
                        <br>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:5%;">No.</th>
                                    <th style="width:10%;">Class date</th>
                                    <th style="width:18%;">Status</th>
                                    <th style="width:28%;">Topic covered</th>
                                    <th style="width:19%;">Homework</th>
                                    <th style="width:10%;">Score school test/quiz</th>
                                    <th style="width:10%;">WhiteBoard test score</th>
                                </tr>
                            </thead>
                            <tbody>';
                            if(mysqli_num_rows($result) > 0){
                                while($rdetail = mysqli_fetch_assoc($result)){   

                                    if($rdetail['scstatus']=='Completed' || $rdetail['scstatus']=='Partially completed'){

                                        echo "<tr style='background-color: #a7ffb3;'>
                                            <td>". $i ."</td>
                                            <td>". $rdetail['scdate'] ."</td>
                                            <td>". $rdetail['scstatus'] ."</td>
                                            <td>". $rdetail['takenTopic'] ."</td>
                                            <td>". $rdetail['HWork'] ."</td>
                                            <td>". $rdetail['schMark'] ."</td>
                                            <td>". $rdetail['wbMark'] ."</td>
                                        </tr>
                                        ";
                                        $i++;
                                    }else if($rdetail['scstatus']=='Cancelled'){
                                        echo "<tr style='background-color: rgb(255, 208, 208);'>
                                            <td>". $i ."</td>
                                            <td>". $rdetail['scdate'] ."</td>
                                            <td colspan='5'> The session was cancelled by ". $rdetail['cancby'] ." due to ". $rdetail['cReason'] ."</td>
                                        </tr>
                                        ";
                                        $i++;
                                    }   
                                }
                            }
                            echo '</tbody>
                            </table>
                        </div>';

                    }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>