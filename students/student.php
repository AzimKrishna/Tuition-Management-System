<?php
include '../db/config.php';
$i=1;
$sql_q = "SELECT * FROM std_info ORDER BY course";
$std_data = mysqli_query($conn, $sql_q);
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
    <title>Students</title>
</head>
<body>
    <div class="home">
        <div class="wrapper">
            <div class="menu">
                <h2><i class='bx bxs-dashboard'></i> DASHBOARD</h2>
                <ul class="menu-adjust">
                    <li><a href="../index.php"><i class='bx bx-home' ></i> Home</a></li>
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
                    <h4>STUDENTS</h4>
                </div>
                <div class="content-card">
                    <div class="student-table">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:5%;">Sl.no</th>
                                    <th style="width:22%;">Name</th>
                                    <th style="width:19%;">Course</th>
                                    <th style="width:27%;">Timezone</th>
                                    <th style="width:8%;">Fee</th>
                                    <th style="width:9%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if(mysqli_num_rows($std_data) > 0){
                                    while($stdetail = mysqli_fetch_assoc($std_data)){
                            ?>
                                <tr>
                                <td><?php  echo $i; ?> <span class="s" style="opacity: 0;"><?php echo $stdetail['sid'];?></span></td>
                                <td><?php  echo $stdetail['sname']; ?></td>
                                <td><?php  echo $stdetail['course']; ?></td>
                                <td><?php  
                                            foreach($timezones as $val => $disp){
                                                if($val == $stdetail['tzone'])
                                                    echo $disp;
                                            }
                                    ?>
                                </td>
                                <td><?php  echo $stdetail['fee'] . "$"; ?></td>
                                <td>
                                    <form action="std_profile.php" method="post">
                                        <input type="hidden" name="view_id" value="<?php echo $stdetail['sid']; ?>">
                                        <button type="submit" name="view_btn" class ="rounded-button-updt">VIEW</button>
                                    </form>
                                </td>
                                </tr>
                            <?php
                                $i++;
                                }
                            }
                            ?>
                            
                            </tbody>
                        </table>
                        <div class="add-student">
                            <div class="add-student-form">
                                <div class="title"><h4>Add Student</h4></div>
                                <br>
                                <div class="container">
                                    <img src="https://www.kindpng.com/picc/m/171-1712282_profile-icon-png-profile-icon-vector-png-transparent.png" alt="profile-icon" style=" display: block; margin-left: auto; margin-right: auto; width:30%; max-width:200px; border-radius: 50%;">
                                    <br>
                                    <form action="../db/action.php" method="post">
                                        <label for="sname">Student name</label><br>
                                        <input type="text" name="sname" id="sname" required><br><br>
                                        <label for="course">Course</label><br>
                                        <select name="course" id="course">
                                            <option selected="selected">Select grade</option>
                                            <?php
                                                foreach($courses as $cval => $cdisp){
                                                    echo '<option value="'. $cval .'">'. $cdisp .'</option>';
                                                }
                                            ?>
                                        </select><br><br>
                                        <label for="smail">Student email</label><br>
                                        <input type="email" name="smail" id="smail" required><br><br>
                                        <label for="spno">Student phone</label><br>
                                        <input type="tel" name="spno" id="spno " required><br><br>
                                        <label for="skype">Skype ID</label><br>
                                        <input type="text" name="skype" id="skype" required><br><br>
                                        <label for="pname">Parent name</label><br>
                                        <input type="text" name="pname" id="pname" required><br><br>
                                        <label for="pmail">Parent email</label><br>
                                        <input type="email" name="pmail" id="pmail" required><br><br>
                                        <label for="ppno">Parent phone</label><br>
                                        <input type="tel" name="ppno" id="ppno" required><br><br>
                                        <label for="tzone">Timezone</label><br>
                                        <select name="tzone" id="tzone">
                                            <option selected="selected" >Select timezone</option>

                                            <?php
                                                foreach($timezones as $val => $disp){
                                                    echo '<option value="'. $val .'">'. $disp .'</option>';
                                                }
                                            ?>
                                        </select><br><br>
                                        <label for="ctry">Country</label><br>
                                        <input type="text" name="ctry" id="ctry" required><br><br>
                                        <label for="fee">Fee ($)</label><br>
                                        <input type="number" name="fee" id="fee" required><br><br>
                                        <label for="doj">Date of joining</label><br>
                                        <input type="date" name="doj" id="doj" required><br><br>
                                        <label for="note">Note (optional)</label><br>
                                        <textarea name="note" id="note" ></textarea><br><br>
                                        <div class="btn-holder">
                                            <button type="reset" id="bt-res">Reset</button>
                                            <button type="submit" id="bt-sub" name="addstud">Submit</button>
                                        </div>
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