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
        $month = $_GET['month'];
        $sql= "SELECT * FROM report WHERE sid='$sid' AND psent='0' AND scstatus IN ('Completed', 'Partially Completed') AND scdate LIKE '%$month%' ORDER BY scdate ASC";
        $result = mysqli_query($conn, $sql);
        $flag = true;
        $sql2= "SELECT sname, course, spno, tzone FROM std_info WHERE sid = '$sid'";
        $result2 = mysqli_query($conn, $sql2);
        $stdprof = mysqli_fetch_assoc($result2);
        $mname = date("F Y", strtotime($month));
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>  
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
                    <h4>PROGRESS REPORTS</h4>
                </div>
                <div class="content-card">
                    <div class="btn-holder">
                            <button onclick="location.href='session.php'" type="button" id="bt-back"><i class='bx bx-left-arrow-alt' ></i> Back</button>
                        </div>
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
                                        <label for="month">Month: </label>
                                        <input type="month" name="month" id="month">
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
                        echo '
                    <div class="progress-details">
                        <center><h3>Acadameic details of '. $mname .' </h3></center>
                        <br>
                        <div class="stud-info">
                        <span><b>Name:</b> '. $stdprof["sname"] .'</span>
                        <span><b>Course:</b> '. $stdprof["course"] .'</span>
                        <span><b>Phone:</b> '. $stdprof["spno"] .'</span>
                        <span><b>Timezone:</b> ';
                        foreach($timezones as $val => $disp)  {    if($val == $stdprof['tzone']){ echo $disp;  } }  
                        echo '</span>
                        </div>
                        <table class="progress-table">
                            <thead></thead>
                            <tbody>
                            <form action="" method="post" class="send-report">
                                <tr style="background-color :#98DED9;">
                                    <td colspan="2"><b>Session details</b></td>
                                    <input type="hidden" name="sid" value="'.   $sid   .'">
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td style="width: 5%;">Sl.No</td>
                                                    <td style="width: 35%;">Topic taken</td>
                                                    <td style="width: 20%;">Date</td>
                                                    <td style="width: 15%;">WB test score</td>
                                                    <td style="width: 15%;">School test score</td>
                                                </tr>
                                            </thead>
                                            <tbody>';

                        if(mysqli_num_rows($result) > 0){
                            $j=1;
                            while($result_sess = mysqli_fetch_assoc($result)){
                                echo '<tr>
                                        <td>'. $j .'</td>
                                        <input type="hidden" name="scid[]" id="scid" value="'. $result_sess["scid"]  .'">
                                        <td><input type="text" name="takenTopic[]" id="takenTopic" value="'. $result_sess["takenTopic"]  .'" required></td>
                                        <td><input type="date" name="scdate[]" id="scdate" value="'. $result_sess["scdate"]  .'" required></td>
                                        <td><input type="text" name="wbMark[]" id="wbMark" value="'. $result_sess["wbMark"]  .'"></td>
                                        <td><input type="text" name="schMark[]" id="schMark" value="'. $result_sess["schMark"]  .'"></td>
                                    </tr>';
                                    $j++;
                            }
                            echo '
                                            </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#b13935;" colspan="2"><b>Enter the progress report details</b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%";>Strengths</td>
                                        <td><textarea name="strength" id="strength"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Should focus on</td>
                                        <td><textarea name="focus" id="focus"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Remarks</td>
                                        <td><textarea name="measure" id="measure"></textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                                    <div class="formsub">
                                        <div class="btn-holder">
                                            <button type="submit" id="bt-sub2" class="bt-report"  style="color: #fff;">Send Progress Report<i class="bx bx-mail-send"></i></button>                                    </div>
                                    </div>
                                </form>
                        </div>';
                        }else{
                                        echo '
                                        </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                <td><h3>Progress report sent already or no classes!</h3></td>
                                </tr>
                            </tbody>
                        </table>
                            </form>
                    </div>';
                        }                                        
                        
                }
                    
                ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.send-report').submit(function (e) { 
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize() + '&send-report=true';
                var submitButton = form.find('#bt-sub2');
                
                submitButton.prop('disabled', true);
                
                $.ajax({
                type: "POST",
                url: "../db/message.php",
                data: formData,
                success: function (response) {
                    if (response === "1") {

                    submitButton.replaceWith('Sent 📩');
                    
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Progress report has been sent to email!',
                        showConfirmButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Refresh the page
                        }
                    });
                    } else if (response === "00" || response === "01" || response === "x") {
                    submitButton.prop('disabled', true);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: 'Error code: ' + response
                    });
                    }
                }
                });
            });
        }); 
    </script>
</body>
</html>