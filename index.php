<?php
// error_reporting(0);
include 'db/config.php';

function x_week_range($scdate) {
    $ts = strtotime($scdate);
    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    return array(date('Y-m-d', $start),
                 date('Y-m-d', strtotime('next saturday', $start)));
}
function sumRamtValues($values) {
    $sum = 0;

    foreach ($values as $value) {
        // Remove unwanted characters from the value
        $cleanedValue = preg_replace("/[^0-9.]/", "", $value);

        // Convert the cleaned value to a float and add it to the sum
        $sum += floatval($cleanedValue);
    }

    return $sum;
}

$date = date('Y-m-d');
list($start_date, $end_date) = x_week_range($date);

$query = "SELECT tzone, COUNT(*) AS count FROM std_info GROUP BY tzone";
$result1 = mysqli_query($conn, $query);

$countSum = 0;

// Calculate the sum of count values
while ($row = mysqli_fetch_assoc($result1)) {
    $count = $row['count'];
    $countSum += $count;
}

$percentageComposition = array();

$query = "SELECT tzone, COUNT(*) AS count FROM std_info GROUP BY tzone";
$result1 = mysqli_query($conn, $query);

// Calculate the percentage composition
while ($row = mysqli_fetch_assoc($result1)) {
    $tzone = $row['tzone'];
    $count = $row['count'];
    $percentage = ($count / $countSum ) * 100;
    $dataPoints[] = array("label" => $tzone, "y" => $percentage);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.png">
    <title>Dashboard</title>
    <script>
    window.onload = function() {
    
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
            text: "Number of students timezone wise"
        },
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
    
    }
    </script>
</head>
<body>
    <div class="home">
        <div class="wrapper">
            <div class="menu">
                <h2><i class='bx bxs-dashboard'></i> DASHBOARD</h2>
                <ul class="menu-adjust">
                    <li class="active"><a href="index.php"><i class='bx bx-home' ></i> Home</a></li>
                    <li><a href="students/student.php"><i class='bx bxs-group' ></i> Students</a></li>
                    <li class="sch-menu">
                        <a href="report/session.php"><i class='bx bxs-report'></i> Reports  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="report/session.php"> Session</a> </li>
                            <li><a style="font-size: 18px;" href="report/progress.php"> Progress</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="schedule/daily.php"><i class='bx bx-calendar'></i> Schedule  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="schedule/daily.php"> Daily</a> </li>
                            <li><a style="font-size: 18px;" href="schedule/weekly.php"> Weekly</a> </li>
                        </ul>
                    </li>
                    <li class="sch-menu">
                        <a href="payment/history.php"><i class='bx bx-money'></i> Billing  <i class='bx bx-chevron-right' ></i></a>
                        <ul class="sub-sch">
                            <li><a style="font-size: 18px;" href="payment/new.php"> Add new</a> </li>
                            <li><a style="font-size: 18px;" href="payment/history.php"> History</a> </li>
                        </ul>
                    </li>
                    <li><a href="https://app.ziteboard.com/" target="_blank"><i class='bx bx-chalkboard' ></i> Ziteboard</a></li>
                    <li><a href="https://google.com" target="_blank"><i class='bx bxl-google' ></i>oogle</a></li>
                </ul>
            </div>
            <div class="main-content">
                <div class="header">
                    <h4>HOME</h4>
                </div>
                <div class="content-card">
                    <div class="overview-boxes">
                        <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Records</div>
                            <div class="number"><?php  $sql="SELECT COUNT(1) FROM std_info"; $result = mysqli_query($conn, $sql); $row=mysqli_fetch_array($result); echo $row['0']; ?></div>
                            <div class="brief">
                            <span class="text">Total number of students</span>
                            </div>
                        </div>
                        <i class='bx bx-user ico' ></i>
                        </div>
                        <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Today's session</div>
                            <div class="number"><?php  $sql="SELECT COUNT(1) FROM schedule WHERE scdate='$date'"; $result = mysqli_query($conn, $sql); $row=mysqli_fetch_array($result); echo $row['0']; ?></div>
                            <div class="brief">
                            <span class="text">Number of sessions today</span>
                            </div>
                        </div>
                        <i class='bx bxs-book-open ico three' ></i>
                        </div>
                        <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Unpaid bills</div>
                            <div class="number"><?php  $sql = "SELECT COUNT(DISTINCT bid) AS total FROM bill WHERE complete = '0'"; $result = mysqli_query($conn, $sql); $row=mysqli_fetch_array($result); echo $row['0']; ?></div>
                            <div class="brief">
                            <span class="text">Number of pending bills</span>
                            </div>
                        </div>
                        <i class='bx bx-error ico five'></i>
                        </div>
                        <div class="box">
                        <div class="right-side">
                            <div class="box-topic">Income</div>
                            <div class="number"><?php  
                                $sql="SELECT bid, ramt FROM bill GROUP BY bid;";
                                $result = mysqli_query($conn, $sql); 
                                if ($result){
                                    $ramtValues = array();
                                        while ($row = mysqli_fetch_array($result)) {
                                            $ramtValues[] = $row['ramt'];
                                        }
                                }
                                echo sumRamtValues($ramtValues). " $";
                            
                            ?></div>
                            <div class="brief">
                            <span class="text">Total amount of money earned</span>
                            </div>
                        </div>
                        <i class='bx bx-wallet-alt ico four' ></i>
                        </div>
                    </div>

                    <!-- <div id="chartContainer" style="height: 370px; width: 100%;"></div> -->
                    <!-- uncomment if you need the chart for statics -->

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>