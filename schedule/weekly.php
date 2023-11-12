<?php
include '../db/config.php';
$i=1;
// error_reporting(0);

//function to find current week's start and end dates

function x_week_range($scdate) {
    $ts = strtotime($scdate);
    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    return array(date('Y-m-d', $start),
                 date('Y-m-d', strtotime('next saturday', $start)));
}

$date = date('Y-m-d');
list($start_date, $end_date) = x_week_range($date);
$sql_show = "SELECT sid, scdate, sctime, scstatus FROM schedule WHERE scdate BETWEEN '$start_date' AND '$end_date' ORDER BY scdate";
$sch_data = mysqli_query($conn, $sql_show);
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
                    <li ><a href="../index.php"><i class='bx bx-home' ></i> Home</a></li>
                    <li><a href="../students/student.php"><i class='bx bxs-group' ></i> Students</a></li>
                    <li class="sch-menu">
                        <a href="../report/session.php"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../report/session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="../report/progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu" id="active">
                        <a href="daily.php"><i class='bx bx-calendar'></i> Schedule     <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="daily.php"> Daily</a> </li>
                            <li><a style="font-size: 18px;" href="weekly.php"> Weekly</a> </li>
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
                    <h4>WEEKLY SCHEDULE</h4>
                </div>
                <div class="content-card">
                    <div class="weekly-sched-stats">
                            <div class="holder" style="width: 100%;">
                                <div class="tot">
                                    Total sessions: <?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE scdate BETWEEN '$start_date' AND '$end_date'";
                                                           $result = mysqli_query($conn, $sqlc);
                                                           $count = mysqli_fetch_assoc($result);
                                                           echo $count['total'];
                                                    ?>
                                </div>
                                <div class="tot-pen">
                                    Pending sessions: <?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE scstatus = 'Assigned' AND scdate BETWEEN '$start_date' AND '$end_date'";
                                                           $result = mysqli_query($conn, $sqlc);
                                                           $count = mysqli_fetch_assoc($result);
                                                           echo $count['total'];
                                                        ?>
                                </div>
                                <div class="tot-com">
                                    Completed sessions: <?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE scstatus = 'Completed' AND scdate BETWEEN '$start_date' AND '$end_date'";
                                                           $result = mysqli_query($conn, $sqlc);
                                                           $count = mysqli_fetch_assoc($result);
                                                           echo $count['total'];
                                                        ?>
                                </div>
                                <div class="tot-can">
                                    Cancelled sessions:  <?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE scstatus = 'Cancelled' AND scdate BETWEEN '$start_date' AND '$end_date'";
                                                           $result = mysqli_query($conn, $sqlc);
                                                           $count = mysqli_fetch_assoc($result);
                                                           echo $count['total'];
                                                        ?>
                                </div>
                            </div>
                    </div>
                    <br>
                    <div class="weekly-sched-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Sl.no</th>
                                        <th style="width: 8%">Date</th>
                                        <th style="width: 8%">Day</th>
                                        <th style="width: 7%">Time</th>
                                        <th style="width: 13%;">Student name</th>
                                        <th style="width: 13%">Course</th>
                                        <th style="width: 13%;">Timezone</th>
                                        <th style="width: 10%;">Student end</th>
                                        <th style="width: 8%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(mysqli_num_rows($sch_data) > 0){
                                    while($schdetail = mysqli_fetch_assoc($sch_data)){                                                             

                                ?>
                                    <tr <?php   if($schdetail['scstatus']=='Assigned'){
                                                    echo 'style="border-bottom: 1px solid #d7d7d7;"';
                                                }else if($schdetail['scstatus']=='Completed'){
                                                    echo 'style="border-bottom: 1px solid #d7d7d7; background-color: #a7ffb3;"';
                                                }else if($schdetail['scstatus']=='Cancelled'){
                                                    echo 'style="border-bottom: 1px solid #d7d7d7; background-color: rgb(255, 208, 208);"';
                                                }      ?>            >
                                        <td><?php  echo $i; ?> <span class="s" style="opacity: 0;"><?php $sid = $schdetail['sid']; ?></span></td>
                                        <td><?php  echo $schdetail['scdate']; ?></td>
                                        <td><?php  
                                                $timestamp = strtotime($schdetail["scdate"]);
                                                $day = date('l', $timestamp);
                                                echo $day;
                                            ?>
                                        </td>
                                        <td><?php echo date("H:i", strtotime($schdetail['sctime']));?></td>
                                        <td>
                                            <?php
                                                $sql = "SELECT sname, course, tzone FROM std_info WHERE sid ='$sid'";
                                                $sql_q = mysqli_query($conn, $sql);
                                                $sqldata = mysqli_fetch_assoc($sql_q);
                                                echo $sqldata['sname'];
                                            ?>
                                        </td>
                                        <td><?php echo $sqldata['course'];  ?></td>
                                        <td><?php
                                                
                                                foreach($timezones as $val => $disp){
                                                    if($val == $sqldata['tzone']){  
                                                        echo $disp;   
                                                    }
                                                }
                                            
                                            ?>
                                        </td>
                                        <td><?php 
                                                $concatdate = $schdetail["scdate"] . ' ' . $schdetail['sctime'];
                                                $cdate = new DateTime($concatdate, new DateTimeZone('Asia/Calcutta'));                                            
                                                $cdate->setTimezone(new DateTimeZone($sqldata['tzone']));
                                                $cdate1 = $cdate->format('Y-m-d');
                                                $timestamp = strtotime($cdate1);
                                                $day = date('l', $timestamp);
                                                echo $day . ', ';
                                                $cdate = $cdate->format('H:i');
                                                echo $cdate;

                                            ?>
                                        </td>
                                        <td><?php  echo $schdetail['scstatus']; ?></td>
                                        <?php
                                                $i++;
                                                }
                                            }
                                        
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>