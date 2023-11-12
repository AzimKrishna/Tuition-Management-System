<?php
include '../db/config.php';
$i=1;

$sql_show = "SELECT * FROM bill GROUP BY bid ORDER BY due DESC";
$bdet = mysqli_query($conn, $sql_show);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>  

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <!-- Modal -->
    <div class="modal fade" id="fp_viewingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
    </div>
    <!-- modal -->
    <div class="home">
        <div class="wrapper">
            <div class="menu">
                <h2><i class='bx bxs-dashboard'></i> DASHBOARD</h2>
                <ul class="menu-adjust" style="padding-left: 0px;">
                    <li ><a href="../index.php"><i class='bx bx-home' ></i> Home</a></li>
                    <li><a href="../students/student.php"><i class='bx bxs-group' ></i> Students</a></li>
                    <li class="sch-menu">
                        <a href="../report/session.php"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="../report/session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="../report/progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="../schedule/daily.php"><i class='bx bx-calendar'></i> Schedule     <i class='bx bx-chevron-right' ></i></a>
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
                    <h4 style="font-weight: 700;">VIEW BILLS</h4>
                </div>
                <div class="content-card">
                    <div class="weekly-sched-stats">
                            <div class="holder" style="width: 100%; justify-content: space-between;">
                                <div class="tot">
                                    Unpaid Bills: <?php  $sqlc = "SELECT COUNT(DISTINCT bid) AS total FROM bill WHERE complete = '0'";
                                                           $result = mysqli_query($conn, $sqlc);
                                                           $count = mysqli_fetch_assoc($result);
                                                           echo $count['total'];
                                                    ?>
                                </div>
                                <div class="tot-pen">
                                    Paid Bills: <?php  $sqlc = "SELECT COUNT(DISTINCT bid) AS total FROM bill WHERE complete = '1'";
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
                                        <th style="width: 12%;">Bill ID</th>
                                        <th style="width: 10%;">Due Date</th>
                                        <th style="width: 10%;">Amount</th>
                                        <th style="width: 17%;">Student Name</th>
                                        <th style="width: 14%;">Note</th>
                                        <th style="width: 11%">View Bill</th>
                                        <th style="width: 11%;">Send  Email</th>
                                        <th style="width: 12%;">Payment</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(mysqli_num_rows($bdet) > 0){
                                    while($b_detail = mysqli_fetch_assoc($bdet)){                                                             

                                ?>
                                    <tr <?php if($b_detail['complete']=='1'){ echo 'style="border-bottom: 1px solid #d7d7d7; background-color: #a7ffb3;"'; } ?> >
                                        <td><?php  echo $b_detail['bid']; ?></td>
                                        <td><?php  echo $b_detail['due']; ?></td>
                                        <td><?php  echo $b_detail['pamt']; ?></td>
                                        <td>
                                            <?php
                                                    $sid = $b_detail['sid'];
                                                    $sql = "SELECT sname FROM std_info WHERE sid='$sid'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $result = mysqli_fetch_assoc($result);
                                                    echo $result['sname'];
                                            ?>
                                        </td>
                                        <td><?php  echo $b_detail['note']; ?></td>
                                        <td>
                                            <form action="#" method="post" id="view-fm" class="view-fm">
                                                <input type="hidden" class="billid" name="billid" id="billid" value="<?php echo $b_detail['bid'];?>"> 
                                                <input type="hidden" class="sid" name="sid" id="sid" value="<?php echo $b_detail['sid'];?>"> 
                                                <input type="hidden" class="complete" name="complete" id="complete" value="<?php echo $b_detail['complete'];?>"> 
                                                <div class="btn-holder" style="margin-bottom: 0px;">
                                                    <button type="submit" id="bt-view" class="bt-view" name="view-history" style="color: #fff;">View</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="#" method="post" class="send-mail" >
                                                <input type="hidden" name="bid" id="bid" value="<?php echo $b_detail['bid'];?>"> 
                                                <input type="hidden" name="sid" id="sid" value="<?php echo $b_detail['sid'];?>">
                                                <div class="btn-holder" style="margin-bottom: 0px;">

                                                    <?php  
                                                    
                                                    if($b_detail["bsent"]==0){
                                                        echo '<button type="submit" id="bt-sub" class="bt-sub" name="send-mail" style="color: #fff;">Send</button>';
                                                    }else if($b_detail["bsent"]==1){
                                                        echo "Sent 📩";
                                                    }
                                                    
                                                    ?>
                                                    
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                        <?php   
                                            if($b_detail['complete']=='0'){
                                                echo '                                            
                                                <form action="complete.php" method="post">
                                                <input type="hidden" name="bid" id="bid" value="'. $b_detail['bid'] .'"> 
                                                <input type="hidden" name="sid" id="sid" value="'. $b_detail['sid'] .'?>"> 
                                                <div class="btn-holder" style="margin-bottom: 0px;">
                                                    <button type="submit" id="bt-finish" name="view-history" style="color: #fff;">Finish</button>
                                                    </div>
                                                </form>';
                                            }else{
                                               echo 'Completed ✅';
                                            }
                                            ?>
                                        </td>
                                        <?php
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</body>
</html>