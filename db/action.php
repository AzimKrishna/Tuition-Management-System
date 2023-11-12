<?php
include 'config.php';

// Adding student to db

if(isset($_POST["addstud"])){
    $sname = mysqli_real_escape_string($conn, $_POST["sname"]);
    $course = mysqli_real_escape_string($conn, $_POST["course"]);
    $smail = mysqli_real_escape_string($conn, $_POST["smail"]);
    $spno = mysqli_real_escape_string($conn, $_POST["spno"]);
    $skype = mysqli_real_escape_string($conn, $_POST["skype"]);
    $pname = mysqli_real_escape_string($conn, $_POST["pname"]);
    $pmail = mysqli_real_escape_string($conn, $_POST["pmail"]);
    $ppno = mysqli_real_escape_string($conn, $_POST["ppno"]);
    $tzone = mysqli_real_escape_string($conn, $_POST["tzone"]);
    $ctry = mysqli_real_escape_string($conn, $_POST["ctry"]);
    $fee = mysqli_real_escape_string($conn, $_POST["fee"]);
    $doj = mysqli_real_escape_string($conn, $_POST["doj"]);
    $note = mysqli_real_escape_string($conn, $_POST["note"]);


    $sql = "INSERT INTO std_info (sname, course, smail, spno, skype, pname, pmail, ppno, tzone, ctry, fee, doj, note)
    VALUES ('$sname', '$course', '$smail', '$spno', '$skype', '$pname', '$pmail', '$ppno', '$tzone', '$ctry', '$fee', '$doj', '$note')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../students/student.php");
    } else {
    echo "<script>alert('Error.');</script>";
    }

}

// Update student details in db

if(isset($_POST["updstud"])){
    $sid = mysqli_real_escape_string($conn, $_POST["stdID"]);
    $sname = mysqli_real_escape_string($conn, $_POST["sname"]);
    $course = mysqli_real_escape_string($conn, $_POST["course"]);
    $smail = mysqli_real_escape_string($conn, $_POST["smail"]);
    $spno = mysqli_real_escape_string($conn, $_POST["spno"]);
    $skype = mysqli_real_escape_string($conn, $_POST["skype"]);
    $pname = mysqli_real_escape_string($conn, $_POST["pname"]);
    $pmail = mysqli_real_escape_string($conn, $_POST["pmail"]);
    $ppno = mysqli_real_escape_string($conn, $_POST["ppno"]);
    $tzone = mysqli_real_escape_string($conn, $_POST["tzone"]);
    $ctry = mysqli_real_escape_string($conn, $_POST["ctry"]);
    $fee = mysqli_real_escape_string($conn, $_POST["fee"]);
    $doj = mysqli_real_escape_string($conn, $_POST["doj"]);
    $note = mysqli_real_escape_string($conn, $_POST["note"]);

    $sql = "UPDATE std_info SET sname='$sname', course='$course', smail='$smail', spno='$spno', skype='$skype', pname='$pname', pmail='$pmail', 
    ppno='$ppno', tzone='$tzone', ctry='$ctry', fee='$fee', doj='$doj', note='$note' WHERE sid='$sid'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ../students/student.php");
    } else {
    echo "<script>alert('Error.');</script>";
    }

}


// Deleting student from db
if(isset($_POST["delstud"])){
    $sid = mysqli_real_escape_string($conn, $_POST["stdID"]);
    $sql = "DELETE FROM std_info WHERE sid='$sid'";
    $result = mysqli_query($conn, $sql);
    $sql = "DELETE FROM schedule WHERE sid='$sid'";
    $result = mysqli_query($conn, $sql);
    $sql = "DELETE FROM report WHERE sid='$sid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ../students/student.php");
    } else {
    echo "<script>alert('Error.');</script>";
    }

}

//Add daily schedule
if(isset($_POST["schedule_btn"])){

    $sid = mysqli_real_escape_string($conn, $_POST["sid"]);
    $sctime = mysqli_real_escape_string($conn, $_POST["sctime"]);
    $scdate = mysqli_real_escape_string($conn, $_POST["scdate"]);

    $sql = "INSERT INTO schedule (sid, scdate, sctime, scstatus) VALUES ('$sid', '$scdate', '$sctime', 'Assigned')";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: ../schedule/daily.php?scdate=$scdate");
    } else {
        echo "<script>alert('Error.');</script>";
    }
}

//Add report from daily schedule
if(isset($_POST['subreport'])){
    $scdate = mysqli_real_escape_string($conn, $_POST["scdate"]);
    $sid = mysqli_real_escape_string($conn, $_POST["sid"]);
    $scid = mysqli_real_escape_string($conn, $_POST["scid"]);
    $scstatus = mysqli_real_escape_string($conn, $_POST["scstatus"]);
    $cancby = isset($_POST["cancby"]) ? mysqli_real_escape_string($conn, $_POST["cancby"]) : '';
    $cReason = isset($_POST["cReason"]) ? mysqli_real_escape_string($conn, $_POST["cReason"]) : '';
    $AcSTime = mysqli_real_escape_string($conn, $_POST["AcSTime"]);
    $AcFtime = mysqli_real_escape_string($conn, $_POST["AcFtime"]);
    if((!empty($_POST["gmark"])) && (!empty($_POST["tmark"]))){
        $hwmark = mysqli_real_escape_string($conn, $_POST["gmark"]) . '/' . mysqli_real_escape_string($conn, $_POST["tmark"]);   //homework mark instead of three option in hwork (OR option)
    }
    $lDuration = mysqli_real_escape_string($conn, $_POST["lDuration"]);
    $lDurReason = mysqli_real_escape_string($conn, $_POST["lDurReason"]);
    $takentopic = mysqli_real_escape_string($conn, $_POST["takentopic"]);
    $nexttopic = mysqli_real_escape_string($conn, $_POST["nexttopic"]);
    $HWork = isset($_POST["HWork"]) ? mysqli_real_escape_string($conn, $_POST["HWork"]) : '';
    $hwnote = mysqli_real_escape_string($conn, $_POST["hwnote"]);
    $schmark = mysqli_real_escape_string($conn, $_POST["schmark"]);
    $wbmark = mysqli_real_escape_string($conn, $_POST["wbmark"]);
    $pvtcomment = mysqli_real_escape_string($conn, $_POST["pvtcomment"]);
    $parentcomm = mysqli_real_escape_string($conn, $_POST["parentcomm"]);
    $pubcomment = mysqli_real_escape_string($conn, $_POST["pubcomment"]);

    $sql = "SELECT * FROM report WHERE scid = '$scid'";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_num_rows($result);
    if($result == 0){
        if($scstatus == 'Cancelled' || $scstatus == 'Completed' || $scstatus == 'Partially completed'){
            $sql = "UPDATE schedule SET scstatus='$scstatus' WHERE scid='$scid'";
            $result1 = mysqli_query($conn, $sql);
        }     
        if($result1){
    
            if($scstatus == 'Cancelled'){
                $sql = "INSERT INTO report (scid, sid, scstatus, cancby, cReason, scdate) VALUES ('$scid', '$sid', '$scstatus', '$cancby', '$cReason', '$scdate')";
                $result = mysqli_query($conn, $sql);
            }else if($scstatus == 'Completed' || $scstatus == 'Partially completed'){
                //if homework mark set rather than three options
                if(isset($hwmark)){
                    $sql = "INSERT INTO report (scid, sid, scstatus, AcSTime, AcFTime, LDuration, lDurReason, 
                    takenTopic, nextTopic, HWork, hwNote, schMark, wbMark, pvtComment, parentComm, pubComment, scdate) 
                    VALUES ('$scid', '$sid', '$scstatus', '$AcSTime', '$AcFtime', '$lDuration', '$lDurReason', 
                    '$takentopic', '$nexttopic', '$hwmark', '$hwnote', '$schmark', '$wbmark', '$pvtcomment', '$parentcomm', '$pubcomment', '$scdate')";
    
                    $result = mysqli_query($conn, $sql);
                } else if(null == $hwmark){
                    //if homwork options set rather than marks
                    $sql = "INSERT INTO report (scid, sid, scstatus, AcSTime, AcFTime, LDuration, lDurReason, 
                    takenTopic, nextTopic, HWork, hwNote, schMark, wbMark, pvtComment, parentComm, pubComment, scdate) 
                    VALUES ('$scid', '$sid', '$scstatus', '$AcSTime', '$AcFtime', '$lDuration', '$lDurReason', 
                    '$takentopic', '$nexttopic', '$HWork', '$hwnote', '$schmark', '$wbmark', '$pvtcomment', '$parentcomm', '$pubcomment', '$scdate')";
    
                    $result = mysqli_query($conn, $sql);
                }
            }
            if($result){
                header("Location: ../schedule/daily.php?scdate=$scdate");
            } else {
                echo "<script>alert('Error.');</script>";
            }
    
        } else {
            echo "<script>alert('Error in updating status.');</script>";
        }
    }else{
        echo "<script>alert('Alread submitted report for this, contact support for help. Click back to go to previous page!!.');</script>";
    }



}


//Add payment to db

if(isset($_POST['addpay'])){
    $bid = $_POST['bid'];
    $pdate = $_POST['pdate'];
    $ptxnid = $_POST['ptxnid'];
    $psrc = $_POST['psrc'];
    $ramt = $_POST['ramt'];
 
    if(!empty($_POST['bid'])) {
        $sql = "UPDATE bill SET complete='1', pdate='$pdate', ptxnid='$ptxnid', psrc='$psrc', ramt='$ramt' WHERE bid='$bid'";
        $result1 = mysqli_query($conn, $sql);
        if($result1){
            header("Location: ../payment/history.php");
        } else {
            echo "<script>alert('Error.');</script>";
        }
    }
}


//Add bill to db

if(isset($_POST['addbill'])){
    $ran = time();
    $ran = md5($ran);
    $ran = substr($ran, 0, 5);
    $bid = "CC" . $ran;
    $sid = $_POST['sid'];
    $note = $_POST['note'];
    $complete = '0';
    $due = $_POST['due'];
    $pamt = $_POST['pamt'];
    
    if(!empty($_POST['check_list'])) {
        foreach($_POST['check_list'] as $check) {
            $scid = $check;
            $sql = "INSERT INTO bill (bid, sid, note, complete, due, pamt, scid) VALUES ('$bid', '$sid', '$note', '$complete', '$due', '$pamt', '$scid')";
            $result = mysqli_query($conn, $sql);
            $sql = "UPDATE report SET billed='1' WHERE scid='$scid' and sid='$sid'";
            $result1 = mysqli_query($conn, $sql);
            if($result1){
                header("Location: ../payment/history.php");
            } else {
                echo "<script>alert('Error.');</script>";
            }


        }
    }
}


//View payment details swal

if(isset($_POST['view-history'])){
    $complete = $_POST['complete'];
    $sid = $_POST['sid'];
    $sql = "SELECT sid,sname,pname,course,skype,fee FROM std_info WHERE sid='$sid'";
    $result2 = mysqli_query($conn, $sql);
    $result2 = mysqli_fetch_assoc($result2);
    $j=1;
    $sdateArr = array(); 
    $topicArr = array(); 
    $bid = $_POST['billid'];
    $sql = "SELECT * FROM bill WHERE bid = '$bid' "; 
    $result = mysqli_query($conn, $sql);


    $output = '  
             <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Bill details</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
             <div class="mp_viewing_data">
             <div class="table-responsive">  
             <table class="table table-bordered" style="font-size: 18px;">
                             <tr>  
                                  <td width="30%"><label><b>Student Name</b></label></td>  
                                  <td width="70%">'.$result2["sname"].'</td>  
                             </tr>  
                             <tr>  
                                  <td width="30%"><label><b>Course</b></label></td>  
                                  <td width="70%">'.$result2["course"].'</td>  
                             </tr>  
                             <tr>  
                                  <td width="30%"><label><b>Skype ID</b></label></td>  
                                  <td width="70%">'.$result2["skype"].'</td>  
                             </tr>  
                             <tr>  
                                  <td width="30%"><label><b>Parent name</b></label></td>  
                                  <td width="70%">'.$result2["pname"].'</td>  
                             </tr>  
                             <tr>  
                                  <td width="30%"><label><b>Fee</b></label></td>  
                                  <td width="70%">'.$result2["fee"].'</td>  
                             </tr>  
                             <tr>
                             <td colspan="2">
                                 <table class="inner" style="width:100%;";>
                                     <tbody style="border-width:2px;";>
                                         <tr style="font-weight: bold; border-width:2px;";>
                                             <td style="border-width:2px;";>Sl.No</td>
                                             <td style="border-width:2px;";>Session date</td>
                                             <td style="border-width:2px;";>Topic Taken</td>
                                             <td style="border-width:2px;";>Session status</td>
                                         </tr>
                             ';
    if(mysqli_num_rows($result) > 0){
        while($tresult = mysqli_fetch_assoc($result)){
            $scid = $tresult["scid"];
            $pamt = $tresult["pamt"];
            $due = $tresult["due"];
            if(isset($tresult["ramt"])){$ramt = $tresult["ramt"];}
            $sql3 = "SELECT scstatus, takenTopic, scdate FROM report WHERE scid='$scid' AND billed='1' ORDER BY scdate";
            $result3 = mysqli_query($conn, $sql3);
            if(mysqli_num_rows($result3) > 0){
                while($result_sess = mysqli_fetch_assoc($result3)){
                    array_push($sdateArr, $result_sess["scdate"]);
                    array_push($topicArr, $result_sess["takenTopic"]);
                    $output .= '                             
                                <tr style="border-width:2px;";>  
                                    <td style="border-width:2px;";>'. $j  .'</td>
                                    <td style="border-width:2px;";>'. $result_sess["scdate"]  .'</td>
                                    <td style="border-width:2px;";>'. $result_sess["takenTopic"]  .'</td>
                                    <td style="border-width:2px;";>'. $result_sess["scstatus"]  .'</td>
                                </tr> 
                                ';
                    $j++;
                }
            }
        }
    }  
    $output .= '</tbody>
            </table>
        </td>   
        </tr>';                      
    if($complete=='1'){ $status= 'Completed ✅';  }else{ $status=  'Pending ⚠️'; }                          
    $output .=                '
                             <tr>  
                                  <td width="30%"><label><b>Total Fee</b></label></td>  
                                  <td width="70%">'.$pamt.'</td>  
                             </tr>';
    if($complete=='1'){ 
        $output .= '<tr>  
                        <td width="30%"><label><b>Recieved Fee</b></label></td>  
                        <td width="70%">'. $ramt .'</td>  
                    </tr> ';
    }
    $output .=                 '  
                             <tr>  
                                  <td width="30%"><label><b>Status</b></label></td>  
                                  <td width="70%">'. $status .'</td>  
                             </tr> 
                             <tr>  
                                  <td width="30%"><label><b>Whatsapp Message</b></label></td>  
                                  <td width="70%" style="font-size: 11px;">
                                   *📢 Invoice Alert! 📢*<br>
                                    Dear '. $result2["pname"] .',<br>
                                    <br>
                                    Thank you for choosing Celesta Campus for online tutoring! 🌟 We have attached the detailed invoice for your tutoring sessions. 📝💻 Please review the sessions conducted, their dates, and the charges.<br>
                                    <br>
                                    💰 *Amount Due:* '. $pamt .'<br>
                                    ⏳ *Due By:* '. $due .'<br>
                                    🆔 *Invoice ID:* '. $bid .'<br>
                                    <br>
                                    *Sessions:*<br>';      

if (!empty($sdateArr) && !empty($topicArr)) {
    $sdateArrLength = count($sdateArr);
    $topicArrLength = count($topicArr);

    for ($i = 0; $i < $sdateArrLength && $i < $topicArrLength; $i++) {
        $sdate = $sdateArr[$i];
        $topic = $topicArr[$i];
        $output .=  '📅 '. $sdate .': '. $topic .' - '.$result2["fee"].'<br>';
    }
}


    $output .=                                 '
                                    <br>
                                    📌 *Total:* '. $pamt .'<br>
                                    <br>
                                    If you have any questions, feel free to reply to this message.<br>
                                    <br>       
                                    Thank you for choosing Celesta Campus! We strive to deliver the best classes always! 🌟<br>
                                    <br>
                                    Best regards,<br>
                                    Celesta Campus Team<br>
                                  
                                  </td>  
                             </tr> 
                             
                             </table></div>
             </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
                                                  
                  ';     
        echo $output;
}


?>