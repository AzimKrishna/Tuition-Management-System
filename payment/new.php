<?php
    error_reporting(0);
    include '../db/config.php';
    $sql_q = "SELECT sid,sname,pname FROM std_info";
    $std_data = mysqli_query($conn, $sql_q);
    $i=1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/style.css">
    <script type="text/javascript" src="../js/script.js"></script>  
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
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
                    <li class="sch-menu">
                        <a href="../report/session.php"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../report/session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="../report/progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="../schedule/daily.php"><i class='bx bx-calendar'></i> Schedule  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../schedule/daily.php"> Daily</a> </li>
                            <li><a style="font-size: 18px;" href="../schedule/weekly.php"> Weekly</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu" id="active">
                        <a href="history.php"><i class='bx bx-money'></i> Billing  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="new.php"> Add new</a> </li>
                            <li><a style="font-size: 18px;" href="history.php"> History</a> </li>
                        </ul>
                    </li>
                    <li><a href="https://app.ziteboard.com/" target="_blank"><i class='bx bx-chalkboard' ></i> Ziteboard</a></li>
                    <li><a href="https://google.com" target="_blank"><i class='bx bxl-google' ></i>oogle</a></li>
                </ul>
            </div>
            <div class="main-content">
                <div class="header">
                    <h4>CREATE BILL</h4>
                </div>
                <div class="content-card">
                    <div class="select-date-rep">
                        <div class="search-holder">
                            <h3>Select student</h3><br>
                            <form action="#">
                                <div>
                                    <label for="sname">Student:</label>
                                    <select name="sname" id="sname" required onchange="this.form.submit()">
                                        <option value = "">select a student</option>
                                        
                                        <?php 
                                            if(mysqli_num_rows($std_data) > 0){
                                                    while($stdetail = mysqli_fetch_assoc($std_data)){
                                                        echo '<option ';
                                                        if($stdetail['sid'] == $_GET["sname"]) {echo 'selected="selected"'; }
                                                        echo 'value="'. $stdetail['sid'] .'">'. $stdetail['sname'] .' - '. $stdetail['pname'] .' </option>';
                                                    
                                                    }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <br><br>
                            </form>
                        </div>
                        
                    </div>

                    <?php
                    if($_GET["sname"] !== "" && isset($_GET["sname"])){
                            $sid = $_GET["sname"];
                            $sql = "SELECT sid,sname,pname,course,skype,fee FROM std_info WHERE sid='$sid'";
                            $result2 = mysqli_query($conn, $sql);
                            $result2 = mysqli_fetch_assoc($result2);

                        echo '<table class ="payment-table">
                                <thead>
                                </thead>
                                <tbody>
                                    <form action="../db/action.php" method="post">
                                        <input type="hidden" name="sid" value="'.   $result2["sid"]   .'">
                                        <tr style="background-color :#98DED9;">
                                            <td colspan="2"><b>Student details</b></td>
                                        </tr>
                                        <tr>
                                            <td style="width:40%;">Name: </td>
                                            <td style="width:60%;" class="fbox">
                                            '.   $result2["sname"]   .'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Course: </td>
                                            <td>'.   $result2["course"]   .'</td>
                                        </tr>
                                        <tr>
                                            <td>Skype ID: </td>
                                            <td>'.   $result2["skype"]   .'</td>
                                        </tr>
                                        <tr>
                                            <td>Parent name: </td>
                                            <td>'.   $result2["pname"]   .'</td>
                                        </tr>
                                        <tr>
                                            <td>Fee: </td>
                                            <td id="fee">'.   $result2["fee"]   .' $</td>
                                        </tr>
                                        <tr >
                                            <td style="color:#b13935;" colspan="2"><b>Unpaid sessions</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table class="inner">
                                                    <tbody>
                                                        ';
                                                    $stdid = $result2["sid"];
                                                
                                                    $sql3 = "SELECT rid, sid, scid, scstatus, billed, takenTopic, scdate FROM report WHERE sid='$stdid' AND billed='0' AND scstatus IN ('Completed', 'Partially Completed') ORDER BY scdate";
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    if(mysqli_num_rows($result3) > 0){
                                                        while($result_sess = mysqli_fetch_assoc($result3)){
                                                            echo '                                                        
                                                                <tr>
                                                                    <td><input type="checkbox" name="check_list[]" id="session'.  $i  .'" value="'.   $result_sess["scid"]   .'" onclick="CalcTotal()"></td>
                                                                    <td><label for="session'.  $i  .'">'. $result_sess["scdate"]  .'</label> </td>
                                                                    <td><label for="session'.  $i  .'">'. $result_sess["takenTopic"]  .'</label></td>
                                                                    <td><label for="session'.  $i  .'">'. $result_sess["scstatus"]  .'</label></td>
                                                                </tr>
                                                            ';
                                                            $i++;
                                                        }
                                                    }else{
                                                        
                                                        echo '
                                                            <tr>
                                                                <td>No sessions</td>
                                                            </tr>
                                                        ';
                                                    }
                                                    echo '
                                                    </tbody>
                                                </table>
                                            </td>   
                                        </tr>
                                        <tr >
                                            <td colspan="2"><b>Payment details</b></td>
                                        </tr>
                                        <tr>
                                            <td>Expected payment amount: </td>
                                            <td><input type="text" name="pamt" id="pamt" required></td>
                                        </tr>
                                        <tr>
                                            <td>Payment due date: </td>
                                            <td><input type="date" name="due" id="due" required></td>
                                        </tr>
                                        <tr>
                                            <td>Note (optional): </td>
                                            <td><textarea name="note" id="note"></textarea></td>
                                        </tr>
                                </tbody>
                            </table>
                                <div class="formsub">
                                        <div class="btn-holder">
                                            <button type="submit" id="bt-sub" name="addbill" style="color: #fff;">Create Bill<i class="bx bx-list-plus"></i></button>
                                            <!-- <button type="submit" id="bt-sub" name="addpay-w-send">Send reciept <i class="bx bxs-send"></i></button> -->
                                        </div>
                                    </div>
                                </form>';
                    }
                    
                    
                    
                    ?>                
                </div>
            </div>
        </div>
    </div>
</body>
</html>