<?php
if(isset($_POST["view_id"])){
    include '../db/config.php';
    $sid = mysqli_real_escape_string($conn, $_POST["view_id"]);
    $sql_q = "SELECT * FROM std_info WHERE sid='$sid'";
    $std_data = mysqli_query($conn, $sql_q);
    $stdetail = mysqli_fetch_assoc($std_data);
}else{
    header("Location: student.php");
}

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div class="home">
        <div class="wrapper">
            <div class="menu">
                <h2><i class='bx bxs-dashboard'></i> DASHBOARD</h2>
                <ul class="menu-adjust">
                    <li ><a href="../index.php"><i class='bx bx-home' ></i> Home</a></li>
                    <li class="active"><a href="student.php"><i class='bx bxs-group' ></i> Students</a></li>
                    <li class="sch-menu">
                        <a href="../report/session.php"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../report/session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="../report/progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="../schedule/daily.php"><i class='bx bx-calendar'></i> Schedule <i class='bx bx-chevron-right' ></i></a>
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
                    <h4>STUDENT DETAILS</h4>
                </div>
                <div class="content-card">
                    <div class="btn-holder">
                        <button onclick="location.href='student.php'" type="button" id="bt-back"><i class='bx bx-left-arrow-alt' ></i> Back</button>
                    </div>
                    <div class="profile-card">
                        <div class="profile-title">
                            <h2>Student details</h2>
                        </div><br>
                        <div class="profile-details">
                        <img src="https://www.kindpng.com/picc/m/171-1712282_profile-icon-png-profile-icon-vector-png-transparent.png" alt="profile-icon" style=" display: block; margin-left: auto; margin-right: auto; width:30%; max-width:150px; border-radius: 50%;">
                                    <br>
                                    <form action="../db/action.php" method="post">
                                    <input type="hidden" name="stdID" value="<?php echo $sid; ?>">
                                        <label for="sname">Student name</label><br>
                                        <input type="text" name="sname" id="sname" value="<?php  echo $stdetail['sname'];   ?>"><br><br>
                                        <label for="course">Course</label><br>
                                        <select name="course" id="course">                                            
                                            <?php
                                                
                                                foreach($courses as $cval => $cdisp){
                                                    echo '<option '; 
                                                    if($cval == $stdetail['course']){  
                                                        echo 'selected="selected"';   
                                                    }
                                                    echo ' value="'. $cval .'">'. $cdisp .'</option>';
                                                }
                                            
                                            ?>
                                        </select><br><br>
                                        <label for="smail">Student email</label><br>
                                        <input type="email" name="smail" id="smail" value="<?php  echo $stdetail['smail'];   ?>"><br><br>
                                        <label for="spno">Student phone</label><br>
                                        <input type="tel" name="spno" id="spno " value="<?php  echo $stdetail['spno'];   ?>"><br><br>
                                        <label for="skype">Skype ID</label><br>
                                        <input type="text" name="skype" id="skype" value="<?php  echo $stdetail['skype'];   ?>"><br><br>
                                        <label for="pname">Parent name</label><br>
                                        <input type="text" name="pname" id="pname" value="<?php  echo $stdetail['pname'];   ?>"><br><br>
                                        <label for="pmail">Parent email</label><br>
                                        <input type="email" name="pmail" id="pmail" value="<?php  echo $stdetail['pmail'];   ?>"><br><br>
                                        <label for="ppno">Parent phone</label><br>
                                        <input type="tel" name="ppno" id="ppno" value="<?php  echo $stdetail['ppno'];   ?>"><br><br>
                                        <label for="tzone">Timezone</label><br>
                                        <select name="tzone" id="tzone">

                                            <?php
                                            
                                                foreach($timezones as $val => $disp){
                                                    echo '<option '; 
                                                    if($val == $stdetail['tzone']){  
                                                        echo 'selected="selected"';   
                                                    }
                                                    echo ' value="'. $val .'">'. $disp .'</option>';
                                                }
                                            
                                            ?>
                                        </select><br><br>
                                        <label for="ctry">Country</label><br>
                                        <input type="text" name="ctry" id="ctry" value="<?php  echo $stdetail['ctry'];   ?>" ><br><br>
                                        <label for="fee">Fee ($)</label><br>
                                        <input type="number" name="fee" id="fee" value="<?php  echo $stdetail['fee'];   ?>" ><br><br>
                                        <label for="doj">Date of joining</label><br>
                                        <input type="date" name="doj" id="doj" value="<?php  echo $stdetail['doj'];   ?>"><br><br>
                                        <label for="note">Note (optional)</label><br>
                                        <textarea name="note" id="note" value="<?php  echo $stdetail['note'];   ?>"></textarea><br><br>
                                        <table style="width: 100%">
                                            <th style="width: 50%"></th>
                                            <th style="width: 50%"></th>
                                            <tr>
                                                <td><label for="tot">Total sessions:</label></td>
                                                <td><?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE sid='$sid'";
                                                                            $result = mysqli_query($conn, $sqlc);
                                                                            $count = mysqli_fetch_assoc($result);
                                                                            echo $count['total'];
                                                                        ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="tot">Pending sessions:</label></td>
                                                <td><?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE sid='$sid' AND scstatus='Assigned'";
                                                                            $result = mysqli_query($conn, $sqlc);
                                                                            $count = mysqli_fetch_assoc($result);
                                                                            echo $count['total'];
                                                                        ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="tot">Completed sessions:</label></td>
                                                <td><?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE sid='$sid' AND scstatus='Completed'";
                                                                            $result = mysqli_query($conn, $sqlc);
                                                                            $count = mysqli_fetch_assoc($result);
                                                                            echo $count['total'];
                                                                        ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="tot">Cancelled sessions:</label></td>
                                                <td><?php  $sqlc = "SELECT COUNT(*) as total FROM schedule WHERE sid='$sid' AND scstatus='Cancelled'";
                                                                            $result = mysqli_query($conn, $sqlc);
                                                                            $count = mysqli_fetch_assoc($result);
                                                                            echo $count['total'];
                                                                        ?>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                        <br><br>
                                        <div class="btn-holder">
                                            <form action="../db/action.php" method="post">
                                                <input type="hidden" name="stdID" value="<?php echo $sid; ?>">
                                                <button type="submit" id="bt-res" name="delstud">Delete student</button>
                                            </form>
                                            <button type="submit" id="bt-sub" name="updstud">Update</button>
                                        </div>
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>