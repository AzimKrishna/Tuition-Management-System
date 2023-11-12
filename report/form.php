<?php
include '../db/config.php';
// error_reporting(0);
if(!isset($_GET['scid'])){
    header("Location: ../index.php");
}
$scid = $_GET['scid'];
$sql = "SELECT scid, sctime, scstatus, scdate, sid FROM schedule WHERE scid='$scid'";
$result = mysqli_query($conn, $sql);
$result = mysqli_fetch_assoc($result);
$status = $result['scstatus'];
if($status != 'Assigned'){
    header("Location: ../schedule/daily.php");
}
$sid = $result['sid'];
$sql2 = "SELECT sname, course FROM std_info WHERE sid='$sid'";
$result2 = mysqli_query($conn, $sql2);
$result2 = mysqli_fetch_assoc($result2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script type="text/javascript" src="../js/script.js"></script>  
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
                    <li><a href="index.php"><i class='bx bx-home' ></i> Home</a></li>
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
                            <li><a style="font-size: 18px;" href="../payment/history."> History</a> </li>
                        </ul>
                    </li>
                    <li><a href="https://app.ziteboard.com/" target="_blank"><i class='bx bx-chalkboard' ></i> Ziteboard</a></li>
                    <li><a href="https://google.com" target="_blank"><i class='bx bxl-google' ></i>oogle</a></li>
                </ul>
            </div>
            <div class="main-content">
                <div class="header">
                    <h4>REPORT: SESSION TAKEN/CANCELLED</h4>
                </div>
                <div class="content-card">
                    <div class="btn-holder">
                        <button onclick="window.history.go(-1); return false;" type="submit" id="bt-back"><i class='bx bx-left-arrow-alt' ></i> Back</button>
                    </div>
                    <div class="report-form-conatiner">
                        <div class="info">
                            <div class="brief">
                                <span><b>Student name:</b> <?php echo $result2['sname'];?></span>
                                <span><b>Class date:</b> <?php echo $result['scdate'];?></span>
                                <span><b>Scheduled time:</b> <?php echo date("H:i", strtotime($result['sctime']));?></span>
                                <span><b>Course:</b> <?php echo $result2['course'];?></span>
                            </div>
                        </div>
                        <div class="class-details">
                            <div class="heading">
                                <h4 style="color:#b13935;">Class details</h4>
                            </div>
                        </div>
                        <table>
                            <thead>
                            </thead>
                            <tbody>
                                <form action="../db/action.php" method="post">
                                    <input type="hidden" name="scid" value="<?php echo $scid;?>">
                                    <input type="hidden" name="sid" value="<?php echo $sid;?>">
                                    <input type="hidden" name="scdate" value="<?php echo $result['scdate'];?>">
                                    <tr>
                                        <td style="width:40%;">Status of the session:</td>
                                        <td style="width:60%;" class="fbox">
                                            <div>
                                                <input type="radio" name="scstatus" id="completed" value="Completed" onclick="EnableDisableRest()" required>
                                                <label for="completed">Completed</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="scstatus" id="pcompleted" value="Partially completed" onclick="EnableDisableRest()">
                                                <label for="pcompleted">Partially Completed</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="scstatus" id="cancelled" value="Cancelled" onclick="EnableDisableRest()">
                                                <label for="cancelled">Cancelled</label>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>If cancelled, by:</td>
                                        <td style="width:60%;" class="fbox">
                                            <div>
                                                <input type="radio" name="cancby" id="tr" value="Teacher">
                                                <label for="tr">Teacher</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="cancby" id="std" value="Student">
                                                <label for="std">Student</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>If cancelled, enter the reason:</td>
                                        <td>
                                            <textarea class="big" name="cReason" id="cReason"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#b13935;"><b>If the class occured, fill the rest of the form and then submit</b></td>
                                    </tr>
                                    <tr>
                                        <td>Class start time: (IST)</td>
                                        <td><input type="time" name="AcSTime" id="AcSTime" value="<?php echo $result['sctime'];?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Class end time: (IST)</td>
                                        <td><input type="time" name="AcFtime" id="AcFTime"></td>
                                    </tr>
                                    <tr>
                                        <td>Time lost during session: (min)</td>
                                        <td><input type="number" name="lDuration" id="lDuration"></td>
                                    </tr>
                                    <tr>
                                        <td>If time was lost, mention why:</td>
                                        <td><textarea class="big" name="lDurReason" id="lDurReason"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="color:#b13935;"><b>Academic details</b></td>
                                    </tr>
                                    <tr>
                                        <td>Topen taken in the class:</td>
                                        <td><textarea class="big" name="takentopic" id="takentopic" required></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Topic for next class:</td>
                                        <td><textarea class="big" name="nexttopic" id="nexttopic"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Status of last class's homework:</td>
                                        <td>
                                            <div>
                                                Scored <input type="number" name="gmark" id="gmark"> out of <input type="number" name="tmark" id="tmark">
                                            </div>
                                            <br>
                                            <div>
                                                OR
                                            </div>
                                            <br>
                                            <div>
                                                <input type="radio" name="HWork" id="notdo" value="notdo">
                                                <label for="notdo">Student didn't do the homework</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="HWork" id="notgiven" value="notgiven">
                                                <label for="notgiven">Homework was not assigned</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="HWork" id="notcorrected" value="notcorrected">
                                                <label for="notcorrected">Not corrected the homework</label>
                                            </div>
                                            <br>
                                            <div>
                                                <label for="hwnote">Notes:</label>
                                                <textarea name="hwnote" id="hwnote" style="width: 395px;height: 100px;" ></textarea>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>School test marks:</td>
                                        <td><input type="text" name="schmark" id="schmark"></td>
                                    </tr>
                                    <tr>
                                        <td>White board test marks:</td>
                                        <td><input type="text" name="wbmark" id="wbmark"></td>
                                    </tr>
                                    <tr>
                                        <td>Private academic comments:</td>
                                        <td><textarea class="big" name="pvtcomment" id="pvtcomment"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Details if you spoke with parent:</td>
                                        <td><textarea class="big" name="parentcomm" id="parentcomm"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Academic comments for parents to view:</td>
                                        <td><textarea class="big" name="pubcomment" id="pubcomment"></textarea></td>
                                    </tr>

                            </tbody>
                        </table>
                            <div class="formsub">
                                <div class="btn-holder">
                                    <button type="submit" id="bt-sub" name="subreport" style="color: #fff;">Submit</button>
                                </div>
                            </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>