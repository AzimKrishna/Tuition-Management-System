<?php
$i=1;
if(isset($_POST["bid"])){
    include '../db/config.php';
    $bid = mysqli_real_escape_string($conn, $_POST["bid"]);
    $sql = "SELECT * FROM bill WHERE bid= '$bid'";
    $result = mysqli_query($conn, $sql);
    
    $sid = mysqli_real_escape_string($conn, $_POST["sid"]);
}else{
    header("Location: viewbill.php");
}
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
                    <h4>COMPLETE PAYMENT</h4>
                </div>
                <div class="content-card">
                    <div class="btn-holder">
                        <button onclick="location.href='history.php'" type="button" id="bt-back"><i class='bx bx-left-arrow-alt' ></i> Back</button>
                    </div>
                    <?php
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
                                            <td style="color:#b13935;" colspan="2"><b>Billed sessions</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table class="inner">
                                                    <tbody>
                                                        <tr style="font-weight: bold;";>
                                                            <td>Sl.No</td>
                                                            <td>Session date</td>
                                                            <td>Topic Taken</td>
                                                            <td>Session status</td>
                                                        </tr>
                                                        ';
                                                     if(mysqli_num_rows($result) > 0){
                                                         while($tresult = mysqli_fetch_assoc($result)){
                                                            $scid = $tresult["scid"];
                                                            $pamt = $tresult["pamt"];
                                                            $sql3 = "SELECT scstatus, takenTopic, scdate FROM report WHERE scid='$scid' AND billed='1' ORDER BY scdate";
                                                            $result3 = mysqli_query($conn, $sql3);
                                                            if(mysqli_num_rows($result3) > 0){
                                                                while($result_sess = mysqli_fetch_assoc($result3)){
                                                                    echo '                                                        
                                                                        <tr>
                                                                            <td>'. $i  .'</td>
                                                                            <td>'. $result_sess["scdate"]  .'</td>
                                                                            <td>'. $result_sess["takenTopic"]  .'</td>
                                                                            <td>'. $result_sess["scstatus"]  .'</td>
                                                                        </tr>
                                                                    ';
                                                                    $i++;
                                                                }
                                                            }else{
                                                                
                                                                echo '
                                                                    <tr>
                                                                        <td>Error</td>
                                                                    </tr>
                                                                ';
                                                            }
                                                            
                                                         }
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
                                            <td><input type="text" name="pamt" id="pamt" disabled value='. $pamt .'></td>
                                         </tr>
                                        <tr>
                                            <td>Payment Recieved: </td>
                                            <td><input type="text" name="ramt" id="ramt" required></td>
                                        </tr>
                                        <tr>
                                            <td>Payment source: </td>
                                            <td>
                                                <select name="psrc" id="psrc" required>
                                                    <option value="" selected="selected">Select payment method</option>
                                                    ';
                                                    foreach($payment as $val => $disp){
                                                        echo '<option value="'. $val .'">'. $disp .'</option>';
                                                    }
                                                    echo '
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payment txn ID: </td>
                                            <td><input type="text" name="ptxnid" id="ptxnid"  required></td>
                                        </tr>
                                        <tr>
                                            <td>Payment date: </td>
                                            <td><input type="date" name="pdate" id="pdate" required></td>
                                        </tr>
                                </tbody>
                            </table>
                                <div class="formsub">
                                        <div class="btn-holder">
                                            <input type="hidden" name="bid" id="bid" value="'. $bid .'">
                                            <button type="submit" id="bt-sub" name="addpay" style="color: #fff;">Add Payment <i class="bx bx-list-plus"></i></button>
                                            <!-- <button type="submit" id="bt-sub" name="addpay-w-send">Send reciept <i class="bx bxs-send"></i></button> -->
                                        </div>
                                    </div>
                                </form>';
                    
                    
                    
                    ?>
                
                </div>
            </div>
        </div>
    </div>
</body>
</html>