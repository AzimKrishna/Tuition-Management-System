<?php
include '../db/config.php';
$i=1;
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
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
                    <li class="sch-menu">
                        <a href="../report/session.php"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../report/session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="../report/progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu" id="active" >
                        <a href="daily.php"><i class='bx bx-calendar'></i> Schedule <i class='bx bx-chevron-right' ></i></a>
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
                    <h4>DAILY SCHEDULE</h4>
                </div>
                <div class="content-card">
                    <div class="select-date-sch">
                        <div class="search-holder">
                            <h3>Select date</h3><br>
                            <?php
                            // $url = $_SERVER['REQUEST_URI'];  
                            // $parts = parse_url($url);
                            // parse_str($parts['query'], $scdate);
                            // $scdate = $scdate['scdate'];
                            $scdate = $_GET['scdate'];
                            $sql_show = "SELECT scid, sid, scdate, sctime, scstatus FROM schedule WHERE scdate = '$scdate' ORDER BY sctime";
                            $sch_data = mysqli_query($conn, $sql_show);
                            ?>
                            <form action="#">
                                <label for="scdate">View schedule on: </label>
                                <input type="date" name="scdate" id="scdate" value="<?php  echo $scdate;   ?>">
                                    <button type="submit" id="bt-sub">Get schedule</button>
                                <br>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="daily-sched-table">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:5%;">Sl.no</th>
                                    <th style="width:30%;">Student name</th>
                                    <th style="width:20%;">Time (IST)</th>
                                    <th style="width:30%;">Course</th>
                                    <th style="width:15%;">Status</th>
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
                                            }else if($schdetail['scstatus']=='Partially completed'){
                                                echo 'style="border-bottom: 1px solid #d7d7d7; background-color: #a7ffb3;"';
                                            }else if($schdetail['scstatus']=='Cancelled'){
                                                echo 'style="border-bottom: 1px solid #d7d7d7; background-color: rgb(255, 208, 208);"';
                                            }      ?>            >

                                    <td><?php  echo $i; ?> <span class="s" style="opacity: 0;"><?php echo $schdetail['sid']; $sid = $schdetail['sid']; ?></span></td>
                                    <td>
                                        <?php
                                            $sql = "SELECT sname, course FROM std_info WHERE sid ='$sid'";
                                            $sql_q = mysqli_query($conn, $sql);
                                            $sqldata = mysqli_fetch_assoc($sql_q);
                                            echo $sqldata['sname'];
                                        ?>
                                    </td>
                                    <td><?php echo date("H:i", strtotime($schdetail['sctime']));?></td>
                                    <td><?php echo $sqldata['course'];?></td>
                                    <td>
                                        <?php
                                            if($schdetail['scstatus']=='Assigned'){
                                                echo '<a href="../report/form.php?scid='. $schdetail['scid'] .'">Assigned</a>';
                                            }else 
                                                echo $schdetail['scstatus'];
                                        ?>
                                    </td>
                                    <?php
                                            $i++;
                                            }
                                            
                                        }
                                    ?>
                                </tr>
                
                            </tbody>
                        </table>
                        <div class="daily-add-table">
                            <div class="add-sched-form">
                                <div class="title">
                                    <h4>Add schedule</h4>
                                </div>
                                <div class="adder">
                                    <form action="../db/action.php" method="post">
                                        <input type="hidden" name="scdate" value="<?php  echo $scdate;   ?>">
                                        <label for="sid">Student name</label><br>
                                        <?php
                                            $sql_n = "SELECT sid, sname FROM std_info";
                                            $std_data = mysqli_query($conn, $sql_n);
                                        ?>
                                        <select name="sid" id="sid">
                                            <option selected="selected">Select</option>
                                        <?php
                                            if(mysqli_num_rows($std_data) > 0){
                                                while($sname = mysqli_fetch_assoc($std_data)){
                                                    echo '<option value="'. $sname["sid"] .'">'. $sname["sname"] .'</option>';
                                                }
                                            }
                                        ?>
                                        </select><br><br>
                                        <label for="sctime">Time</label><br>
                                        <input type="time" name="sctime" id="sctime" required><br><br><br>
                                        <button type="submit" name="schedule_btn">Schedule</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>