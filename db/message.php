<?php
include 'config.php';
require_once '../convertor/autoload.inc.php';
use Dompdf\Dompdf;
// sending bill email

if(isset($_POST['send-mail'])){
    $bid = $_POST['bid'];
    $sql = "SELECT * FROM bill WHERE bid= '$bid'";
    $result = mysqli_query($conn, $sql);
    $result_temp = mysqli_query($conn, $sql);
    
    $t_result = mysqli_fetch_assoc($result_temp); //temp
    
    $sid = $_POST['sid'];
    $sql2 = "SELECT sname,pname,smail,pmail,fee FROM std_info WHERE sid='$sid'";
    $result2 = mysqli_query($conn, $sql2);
    $result2 = mysqli_fetch_assoc($result2);

    $pmail = $result2["pmail"];
    $smail = $result2["smail"];

    $subject = "Invoice for ". $result2["sname"] ."'s Session(s) - [". $bid ."]";
    $body = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="color-scheme" content="light dark" />
        <meta name="supported-color-schemes" content="light dark" />
        <title></title>
        <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        
        @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
        body {
        width: 100% !important;
        height: 100%;
        margin: 0;
        -webkit-text-size-adjust: none;
        }
        
        a {
        color: #3869D4;
        }
        
        a img {
        border: none;
        }
        
        td {
        word-break: break-word;
        }
        
        .preheader {
        display: none !important;
        visibility: hidden;
        mso-hide: all;
        font-size: 1px;
        line-height: 1px;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        }
        /* Type ------------------------------ */
        
        body,
        td,
        th {
        font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
        }
        
        h1 {
        margin-top: 0;
        color: #333333;
        font-size: 22px;
        font-weight: bold;
        text-align: left;
        }
        
        h2 {
        margin-top: 0;
        color: #333333;
        font-size: 16px;
        font-weight: bold;
        text-align: left;
        }
        
        h3 {
        margin-top: 0;
        color: #333333;
        font-size: 14px;
        font-weight: bold;
        text-align: left;
        }
        
        td,
        th {
        font-size: 14px;
        }
        
        p,
        ul,
        ol,
        blockquote {
        margin: .4em 0 1.1875em;
        font-size: 16px;
        line-height: 1.625;
        }
        
        p.sub {
        font-size: 13px;
        }
        /* Utilities ------------------------------ */
        
        .align-right {
        text-align: right;
        }
        
        .align-left {
        text-align: left;
        }
        
        .align-center {
        text-align: center;
        }
        
        .u-margin-bottom-none {
        margin-bottom: 0;
        }
        /* Buttons ------------------------------ */
        
        .button {
        background-color: #3869D4;
        border-top: 10px solid #3869D4;
        border-right: 18px solid #3869D4;
        border-bottom: 10px solid #3869D4;
        border-left: 18px solid #3869D4;
        display: inline-block;
        color: #FFF;
        text-decoration: none;
        border-radius: 3px;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
        -webkit-text-size-adjust: none;
        box-sizing: border-box;
        }
        
        .button--green {
        background-color: #22BC66;
        border-top: 10px solid #22BC66;
        border-right: 18px solid #22BC66;
        border-bottom: 10px solid #22BC66;
        border-left: 18px solid #22BC66;
        }
        
        .button--red {
        background-color: #FF6136;
        border-top: 10px solid #FF6136;
        border-right: 18px solid #FF6136;
        border-bottom: 10px solid #FF6136;
        border-left: 18px solid #FF6136;
        }
        
        @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
            text-align: center !important;
        }
        }
        /* Attribute list ------------------------------ */
        
        .attributes {
        margin: 0 0 21px;
        }
        
        .attributes_content {
        background-color: #F4F4F7;
        padding: 16px;
        }
        
        .attributes_item {
        padding: 0;
        }
        /* Related Items ------------------------------ */
        
        .related {
        width: 100%;
        margin: 0;
        padding: 25px 0 0 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        }
        
        .related_item {
        padding: 10px 0;
        color: #CBCCCF;
        font-size: 15px;
        line-height: 18px;
        }
        
        .related_item-title {
        display: block;
        margin: .5em 0 0;
        }
        
        .related_item-thumb {
        display: block;
        padding-bottom: 10px;
        }
        
        .related_heading {
        border-top: 1px solid #CBCCCF;
        text-align: center;
        padding: 25px 0 10px;
        }
        /* Discount Code ------------------------------ */
        
        .discount {
        width: 100%;
        margin: 0;
        padding: 24px;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        background-color: #F4F4F7;
        border: 2px dashed #CBCCCF;
        }
        
        .discount_heading {
        text-align: center;
        }
        
        .discount_body {
        text-align: center;
        font-size: 15px;
        }
        /* Social Icons ------------------------------ */
        
        .social {
        width: auto;
        }
        
        .social td {
        padding: 0;
        width: auto;
        }
        
        .social_icon {
        height: 20px;
        margin: 0 8px 10px 8px;
        padding: 0;
        }
        /* Data table ------------------------------ */
        
        .purchase {
        width: 100%;
        margin: 0;
        padding: 35px 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        }
        
        .purchase_content {
        width: 100%;
        margin: 0;
        padding: 25px 0 0 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        }
        
        .purchase_item {
        padding: 10px 0;
        color: #51545E;
        font-size: 15px;
        line-height: 18px;
        }
        
        .purchase_heading {
        padding-bottom: 8px;
        border-bottom: 1px solid #EAEAEC;
        }
        
        .purchase_heading p {
        margin: 0;
        color: #85878E;
        font-size: 14px;
        }
        
        .purchase_footer {
        padding-top: 15px;
        border-top: 1px solid #EAEAEC;
        }
        
        .purchase_total {
        margin: 0;
        text-align: right;
        font-weight: bold;
        color: #333333;
        }
        
        .purchase_total--label {
        padding: 0 15px 0 0;
        }
        
        body {
        background-color: #F2F4F6;
        color: #51545E;
        }
        
        p {
        color: #51545E;
        }
        
        .email-wrapper {
        width: 100%;
        margin: 0;
        padding: 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        background-color: #F2F4F6;
        }
        
        .email-content {
        width: 100%;
        margin: 0;
        padding: 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        }
        /* Masthead ----------------------- */
        
        .email-masthead {
        padding: 25px 0;
        text-align: center;
        }
        
        .email-masthead_logo {
        width: 94px;
        }
        
        .email-masthead_name {
        font-size: 16px;
        font-weight: bold;
        color: #A8AAAF;
        text-decoration: none;
        text-shadow: 0 1px 0 white;
        }
        /* Body ------------------------------ */
        
        .email-body {
        width: 100%;
        margin: 0;
        padding: 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        }
        
        .email-body_inner {
        width: 570px;
        margin: 0 auto;
        padding: 0;
        -premailer-width: 570px;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        background-color: #FFFFFF;
        }
        
        .email-footer {
        width: 570px;
        margin: 0 auto;
        padding: 0;
        -premailer-width: 570px;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        text-align: center;
        }
        
        .email-footer p {
        color: #A8AAAF;
        }
        
        .body-action {
        width: 100%;
        margin: 30px auto;
        padding: 0;
        -premailer-width: 100%;
        -premailer-cellpadding: 0;
        -premailer-cellspacing: 0;
        text-align: center;
        }
        .borderless-table {
        border-collapse: collapse;
        }

        .borderless-table td, .borderless-table th {
        border: none;
        }
        .body-sub {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #EAEAEC;
        }
        
        .content-cell {
        padding: 45px;
        }
        /*Media Queries ------------------------------ */
        
        @media only screen and (max-width: 600px) {
        .email-body_inner,
        .email-footer {
            width: 100% !important;
        }
        }
        
        @media (prefers-color-scheme: dark) {
        body,
        .email-body,
        .email-body_inner,
        .email-content,
        .email-wrapper,
        .email-masthead,
        .email-footer {
            background-color: #333333 !important;
            color: #FFF !important;
        }
        p,
        ul,
        ol,
        blockquote,
        h1,
        h2,
        h3,
        span,
        .purchase_item {
            color: #FFF !important;
        }
        .attributes_content,
        .discount {
            background-color: #222 !important;
        }
        .email-masthead_name {
            text-shadow: none !important;
        }
        }
        
        :root {
        color-scheme: light dark;
        supported-color-schemes: light dark;
        }
        </style>
    <![endif]-->
    </head>
    <body>
        <span class="preheader">This is an invoice for the sessions conducted at Celesta Campus. Please submit payment by '. $t_result["due"] .'</span>
        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td text-align="center">
            <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                <td class="email-masthead">
                    <a href="#" class="f-fallback email-masthead_name">
                    <img src="https://drive.google.com/uc?export=view&id=1sAj_-F29d9XMIm557ka3Langl_TOejiD" style="width:220px;" alt="CELESTA CAMPUS">                </a>
                </td>
                </tr>
                <!-- Email Body -->
                <tr>
                <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                    <table class="email-body_inner" text-align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Body content -->
                    <tr>
                        <td class="content-cell">
                        <div class="f-fallback">
                            <h1>Dear '. $result2["pname"] .',</h1>
                            <p>We sincerely appreciate your trust in our online tutoring services. This email serves as an invoice for the tutoring 
                            sessions that has been conducted.<br>Please find the attached detailed invoice outlining the sessions conducted, their 
                            respective dates, and the corresponding charges. We kindly request your prompt attention to the payment process.</p><br>
                            <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="attributes_content">
                                <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                    <td class="attributes_item">
                                        <span class="f-fallback">
                <strong>Amount Due:</strong> '. $t_result["pamt"] .'
                </span>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="attributes_item">
                                        <span class="f-fallback">
                <strong>Due By:</strong> '. $t_result["due"] .'
                </span>
                                    </td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            </table>
                            <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                <h3>Invoice ID: '. $bid .'</h3>
                                </td>
                                <td>
                                <h3 class="align-right">'. date("Y-m-d") .'</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                    <th class="purchase_heading" text-align="left">
                                        <p class="f-fallback" style="text-align:left;">Topic Taken</p>
                                    </th>
                                    <th class="purchase_heading">
                                        <p class="f-fallback" style="text-align:left;">Date</p>
                                    </th>
                                    <th class="purchase_heading" text-align="right">
                                        <p class="f-fallback" style="text-align:right;">Amount</p>
                                    </th>
                                    </tr>
';
if(mysqli_num_rows($result) > 0){
    while($tresult = mysqli_fetch_assoc($result)){
        $scid = $tresult["scid"];
        $pamt = $tresult["pamt"];
        $sql3 = "SELECT scdate, takenTopic FROM report WHERE scid='$scid'";
        $result3 = mysqli_query($conn, $sql3);
        if(mysqli_num_rows($result3) > 0){
            while($result_sess = mysqli_fetch_assoc($result3)){
                $body .= '<tr>
                            <td width="50%" class="purchase_item"><span class="f-fallback">'. $result_sess["takenTopic"] .'</span></td>
                            <td width="30%" class="purchase_item"><span class="f-fallback">'. $result_sess["scdate"] .'</span></td>
                            <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'. $result2["fee"] .'</span></td>
                          </tr>';
            }
        }

    }
}

$body .='
                                    <tr>
                                    <td width="50%" class="purchase_footer" valign="middle">
                                    </td>
                                    <td width="30%" class="purchase_footer" valign="middle">
                                        <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                    </td>
                                    <td width="20%" class="purchase_footer" valign="middle">
                                        <p class="f-fallback purchase_total">'. $t_result["pamt"] .'</p>
                                    </td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                            </table>
                            <p>If you have any questions about this invoice, simply reply to this email or reach out through our whatsapp for help.</p>
                            ';
if(isset($t_result["note"])){
    $body .= '<p>Note: '. $t_result["note"] .'</p>';
}                           
$body .=                            '
                            <p>Thank you for your continued support and choosing Celesta Campus as your preferred tutoring service. Delivering the best classes, always!</p><br>
                            <p>Cheers,
                            <br>Celesta Campus Team</p>
                            <!-- Sub copy -->
                        </div>
                        </td>
                    </tr>
                    </table>
                </td>
                </tr>
                <tr>
                <td>
                    <table class="email-footer" text-align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="content-cell" text-align="center">
                        <p class="f-fallback sub align-center">
                            Celesta Campus
                            <br>India.
                        </p>
                        </td>
                    </tr>
                    </table>
                </td>
                </tr>
            </table>
            </td>
        </tr>
        </table>
    </body>
    </html>';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $headers .= 'From: CelestaCampus Billing <celestacampus.team@gmail.com>' . "\r\n";

    if(!isset($pmail)){
        $pmail = "conronald13@gmail.com";
    } 
    if(!isset($smail)){
        $smail = "conronald13@gmail.com";
    }
    if (mail($pmail, $subject, $body, $headers)) {
        $result2["pname"] = $result2["sname"];
        if (mail($smail, $subject, $body, $headers)){
            $sql = "UPDATE bill SET bsent='1' WHERE bid='$bid'";
            $result = mysqli_query($conn, $sql);
            echo "1";
        }else {
            echo "01";
        }
        
    } else {
        echo "00";
    }
}



// sending progreses email

if(isset($_POST['send-report'])){

    $sid = $_POST['sid'];
    $scid = $_POST['scid'];
    $takenTopic = $_POST['takenTopic'];
    $scdate = $_POST['scdate'];
    $wbMark = $_POST['wbMark'];
    $schMark = $_POST['schMark'];

    $strength = $_POST['strength'];
    $focus = $_POST['focus'];
    $measure = $_POST['measure'];

    $sql = "SELECT * FROM std_info WHERE sid='$sid'";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($result);

    $pmail = $result['pmail'];
    $subject = " [". $result['sname']  ."] Progress Report - [". $result['course']  ."]";
    $body = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml'>
      <head>
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <meta name='x-apple-disable-message-reformatting' />
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta name='color-scheme' content='light dark' />
        <meta name='supported-color-schemes' content='light dark' />
        <title></title>
        <style type='text/css' rel='stylesheet' media='all'>
        /* Base ------------------------------ */
        
        @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap');
        body {
          width: 100% !important;
          height: 100%;
          margin: 0;
          -webkit-text-size-adjust: none;
        }
        
        a {
          color: #3869D4;
        }
        
        a img {
          border: none;
        }
        
        td {
          word-break: break-word;
        }
        
        .preheader {
          display: none !important;
          visibility: hidden;
          mso-hide: all;
          font-size: 1px;
          line-height: 1px;
          max-height: 0;
          max-width: 0;
          opacity: 0;
          overflow: hidden;
        }
        /* Type ------------------------------ */
        
        body,
        td,
        th {
          font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
        }
        
        h1 {
          margin-top: 0;
          color: #333333;
          font-size: 22px;
          font-weight: bold;
          text-align: left;
        }
        
        h2 {
          margin-top: 0;
          color: #333333;
          font-size: 16px;
          font-weight: bold;
          text-align: left;
        }
        
        h3 {
          margin-top: 0;
          color: #333333;
          font-size: 14px;
          font-weight: bold;
          text-align: left;
        }
        
        td,
        th {
          font-size: 14px;
        }
        
        p,
        ul,
        ol,
        blockquote {
          margin: .4em 0 1.1875em;
          font-size: 16px;
          line-height: 1.625;
        }
        
        p.sub {
          font-size: 13px;
        }
        /* Utilities ------------------------------ */
        
        .align-right {
          text-align: right;
        }
        
        .align-left {
          text-align: left;
        }
        
        .align-center {
          text-align: center;
        }
        
        .u-margin-bottom-none {
          margin-bottom: 0;
        }
        /* Buttons ------------------------------ */
        
        .button {
          background-color: #3869D4;
          border-top: 10px solid #3869D4;
          border-right: 18px solid #3869D4;
          border-bottom: 10px solid #3869D4;
          border-left: 18px solid #3869D4;
          display: inline-block;
          color: #FFF;
          text-decoration: none;
          border-radius: 3px;
          box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
          -webkit-text-size-adjust: none;
          box-sizing: border-box;
        }
        
        .button--green {
          background-color: #22BC66;
          border-top: 10px solid #22BC66;
          border-right: 18px solid #22BC66;
          border-bottom: 10px solid #22BC66;
          border-left: 18px solid #22BC66;
        }
        
        .button--red {
          background-color: #FF6136;
          border-top: 10px solid #FF6136;
          border-right: 18px solid #FF6136;
          border-bottom: 10px solid #FF6136;
          border-left: 18px solid #FF6136;
        }
        
        @media only screen and (max-width: 500px) {
          .button {
            width: 100% !important;
            text-align: center !important;
          }
        }
        /* Attribute list ------------------------------ */
        
        .attributes {
          margin: 0 0 21px;
        }
        
        .attributes_content {
          background-color: #F4F4F7;
          padding: 16px;
        }
        
        .attributes_item {
          padding: 0;
        }
        /* Related Items ------------------------------ */
        
        .related {
          width: 100%;
          margin: 0;
          padding: 25px 0 0 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .related_item {
          padding: 10px 0;
          color: #CBCCCF;
          font-size: 15px;
          line-height: 18px;
        }
        
        .related_item-title {
          display: block;
          margin: .5em 0 0;
        }
        
        .related_item-thumb {
          display: block;
          padding-bottom: 10px;
        }
        
        .related_heading {
          border-top: 1px solid #CBCCCF;
          text-align: center;
          padding: 25px 0 10px;
        }
        /* Discount Code ------------------------------ */
        
        .discount {
          width: 100%;
          margin: 0;
          padding: 24px;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #F4F4F7;
          border: 2px dashed #CBCCCF;
        }
        
        .discount_heading {
          text-align: center;
        }
        
        .discount_body {
          text-align: center;
          font-size: 15px;
        }
        /* Social Icons ------------------------------ */
        
        .social {
          width: auto;
        }
        
        .social td {
          padding: 0;
          width: auto;
        }
        
        .social_icon {
          height: 20px;
          margin: 0 8px 10px 8px;
          padding: 0;
        }
        /* Data table ------------------------------ */
        
        .purchase {
          width: 100%;
          margin: 0;
          padding: 35px 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .purchase_content {
          width: 100%;
          margin: 0;
          padding: 25px 0 0 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .purchase_item {
          padding: 10px 0;
          color: #51545E;
          font-size: 15px;
          line-height: 18px;
        }
        
        .purchase_heading {
          padding-bottom: 8px;
          border-bottom: 1px solid #EAEAEC;
        }
        
        .purchase_heading p {
          margin: 0;
          color: #85878E;
          font-size: 14px;
        }
        
        .purchase_footer {
          padding-top: 15px;
          border-top: 1px solid #EAEAEC;
        }
        
        .purchase_total {
          margin: 0;
          text-align: right;
          font-weight: bold;
          color: #333333;
        }
        
        .purchase_total--label {
          padding: 0 15px 0 0;
        }
        
        body {
          background-color: #F2F4F6;
          color: #51545E;
        }
        
        p {
          color: #51545E;
        }
        
        .email-wrapper {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #F2F4F6;
        }
        
        .email-content {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        /* Masthead ----------------------- */
        
        .email-masthead {
          padding: 25px 0;
          text-align: center;
        }
        
        .email-masthead_logo {
          width: 94px;
        }
        
        .email-masthead_name {
          font-size: 16px;
          font-weight: bold;
          color: #A8AAAF;
          text-decoration: none;
          text-shadow: 0 1px 0 white;
        }
        /* Body ------------------------------ */
        
        .email-body {
          width: 100%;
          margin: 0;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
        }
        
        .email-body_inner {
          width: 570px;
          margin: 0 auto;
          padding: 0;
          -premailer-width: 570px;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          background-color: #FFFFFF;
        }
        
        .email-footer {
          width: 570px;
          margin: 0 auto;
          padding: 0;
          -premailer-width: 570px;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          text-align: center;
        }
        
        .email-footer p {
          color: #A8AAAF;
        }
        
        .body-action {
          width: 100%;
          margin: 30px auto;
          padding: 0;
          -premailer-width: 100%;
          -premailer-cellpadding: 0;
          -premailer-cellspacing: 0;
          text-align: center;
        }
        .borderless-table {
          border-collapse: collapse;
        }
    
        .borderless-table td, .borderless-table th {
          border: none;
        }
        .body-sub {
          margin-top: 25px;
          padding-top: 25px;
          border-top: 1px solid #EAEAEC;
        }
        
        .content-cell {
          padding: 45px;
        }
        /*Media Queries ------------------------------ */
        
        @media only screen and (max-width: 600px) {
          .email-body_inner,
          .email-footer {
            width: 100% !important;
          }
        }
        
        @media (prefers-color-scheme: dark) {
          body,
          .email-body,
          .email-body_inner,
          .email-content,
          .email-wrapper,
          .email-masthead,
          .email-footer {
            background-color: #333333 !important;
            color: #FFF !important;
          }
          p,
          ul,
          ol,
          blockquote,
          h1,
          h2,
          h3,
          span,
          .purchase_item {
            color: #FFF !important;
          }
          .attributes_content,
          .discount {
            background-color: #222 !important;
          }
          .email-masthead_name {
            text-shadow: none !important;
          }
        }
        
        :root {
          color-scheme: light dark;
          supported-color-schemes: light dark;
        }
                .myTable{
                border-collapse: collapse;
            }
            .myTable thead td, .myTable span{
                background-color: #161D6F;
                color: #fff;
            }
            .myTable tr td:nth-child(even){
                padding: 10px 20px;
            }
            .myTable tr td{
                padding: 10px 20px 10px 13px;
                font-size: 14px;
    
                border: 1px solid black;
            }
        </style>
        <!--[if mso]>
        <style type='text/css'>
          .f-fallback  {
            font-family: Arial, sans-serif;
          }
        </style>
      <![endif]-->
      </head>
      <body>
        <span class='preheader'>Progress Update on [". $result['sname']  ."]'s [". $result['course']  ."] Journey</span>
        <table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
          <tr>
            <td text-align='center'>
              <table class='email-content' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                  <td class='email-masthead'>
                    <a href='https://example.com' class='f-fallback email-masthead_name'>
                    <img src='https://drive.google.com/uc?export=view&id=1sAj_-F29d9XMIm557ka3Langl_TOejiD' style='width:220px;' alt='CELESTA CAMPUS'>
                  </a>
                  </td>
                </tr>
                <!-- Email Body -->
                <tr>
                  <td class='email-body' width='570' cellpadding='0' cellspacing='0'>
                    <table class='email-body_inner' text-align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                      <!-- Body content -->
                      <tr>
                        <td class='content-cell'>
                          <div class='f-fallback'>
                            <h1>Dear ". $result['pname']  .",</h1>
                            <p>Attached is the progress report for ". $result['sname']  ." in ". $result['course']  .". It provides valuable insights into their performance and achievements.</p>
                            
                            <p>Please review the report with your child to celebrate their successes and identify areas for improvement. Feel free to reach out if you have any questions at celestacampus.team@gmail.com .</p>
                            <p>Thank you for your continued trust in us to nurture your child's academic development. We appreciate your support.</p>
                            <p>Best Regards,
                              <br>Celesta Campus Team</p>
                            <!-- Sub copy -->
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table class='email-footer' text-align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                      <tr>
                        <td class='content-cell' text-align='center'>
                          <p class='f-fallback sub align-center'>
                            Celesta Campus
                            <br>India
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </body>
    </html>";

    // pdf generation part
    

    $tmp = sys_get_temp_dir();
    $dompdf = new Dompdf([
        'logOutputFile' => '',
        // authorize DomPdf to download fonts and other Internet assets
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true, 
        'isFontSubsettingEnabled' => true,
        'defaultMediaType' => 'all',
        // all directories must exist and not end with /
        'fontDir' => $tmp,
        'fontCache' => $tmp,
        'tempDir' => $tmp,
        'chroot' => $tmp,
    ]);

    
    $mname = date("F", strtotime($scdate[0]));

    $html = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link href='https://fonts.googleapis.com/css2?family=Harmattan:wght@400;500;600;700&family=Hubballi&display=swap' rel='stylesheet'>
                <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap' rel='stylesheet'>
                <title>Progress Report</title>
                <style>
                    @font-face {
                            font-family: 'ErasBoldITC';
                            font-weight: normal;
                            font-style: normal;
                            font-variant: normal;
                            src: url('convertor/vendor/dompdf/dompdf/lib/fonts/ErasBoldITC.ttf') format('truetype');
                    }
                    *{
                        padding: 0;
                        margin: 0;
                    }
                    body{
                        height: 842pt;
                        width: 595pt;
                    }
                    .header{
                        position: absolute;
                        width: 595pt;
                        height: 116pt;
                        left: 0pt;
                        top: 0pt;
                        background: #7F62C3;
                    }
                    .title{
                        position: absolute;
                        width: 219pt;
                        height: 60pt;
                        left: 30pt;
                        top: 28pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 700;
                        font-size: 36pt;
                        line-height: 15pt;
                        color: #FFFFFF;
                    }
                    .logo-holder{
                        position: absolute;
                        width: 86pt;
                        height: 41pt;
                        left: 448pt;
                        top: 28pt;
                    }
                    .logo-holder img{
                        width: 86pt;
                    }
                    .logo-t-1{
                        position: absolute;
                        width: 117pt;
                        height: 6pt;
                        left: 448pt;
                        top: 75pt;
                        font-family: 'Roboto';
                        font-style: normal;
                        font-weight: 700;
                        font-size: 7pt;
                        line-height: 6pt;
                        color: #FFFFFF;
                    }
                    .logo-t-2 a{
                        position: absolute;
                        width: 106pt;
                        height: 6pt;
                        left: 459pt;
                        top: 83pt;
                        font-family: 'Roboto';
                        font-style: normal;
                        font-weight: 700;
                        font-size: 7pt;
                        line-height: 6pt;
                        color: #FACA2B;
                        text-decoration: none;
                    }
                    .centre{
                        height: 661pt;
                    }
                    .centre .rec1{
                        position: absolute;
                        width: 82pt;
                        height: 22pt;
                        left: 32pt;
                        top: 152pt;
                        background: #8871c959;
                    }
                    .centre .pmark{
                        position: absolute;
                        width: 18pt;
                        height: 0pt;
                        left: 22pt;
                        top: 161pt;
                        border: 2pt solid #8870C9;
                        transform: rotate(90deg);
                    }
                    .centre .rec1-t{
                        position: absolute;
                        width: 75pt;
                        height: 12pt;
                        left: 38pt;
                        top: 148pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 400;
                        font-size: 14pt;
                        line-height: 12pt;
                        color: #000000;
                    }
            
                    .centre .rec2{
                        position: absolute;
                        width: 82pt;
                        height: 22pt;
                        left: 296pt;
                        top: 152pt;
                        background: #8871c959;
                    }
                    .centre .pmark2{
                        position: absolute;
                        width: 18pt;
                        height: 0pt;
                        left: 287pt;
                        top: 161pt;
                        border: 2pt solid #8870C9;
                        transform: rotate(90deg);
                    }
                    .centre .rec2-t{
                        position: absolute;
                        width: 75pt;
                        height: 12pt;
                        left: 303pt;
                        top: 148pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 400;
                        font-size: 14pt;
                        line-height: 12pt;
                        color: #000000;
                    }
            
                    .centre .rec3{
                        position: absolute;
                        width: 82pt;
                        height: 22pt;
                        left: 483pt;
                        top: 152pt;
                        background: #8871c959;
                    }
                    .centre .pmark3{
                        position: absolute;
                        width: 18pt;
                        height: 0pt;
                        left: 473pt;
                        top: 161pt;
                        border: 2pt solid #8870C9;
                        transform: rotate(90deg);
                    }
                    .centre .rec3-t{
                        position: absolute;
                        width: 75pt;
                        height: 12pt;
                        left: 489pt;
                        top: 148pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 400;
                        font-size: 14pt;
                        line-height: 12pt;
                        color: #000000;
                    }
                    .centre .stud-details{
                        position: absolute;
                        height: 62pt;
                        left: 32pt;
                        top: 180pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-size: 12pt;
                        line-height: 7pt;
                    }
                    .centre .course-details{
                        position: absolute;
                        height: 62pt;
                        left: 298pt;
                        top: 180pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-size: 12pt;
                        line-height: 7pt;
                    }
                    .centre .report-details{
                        position: absolute;
                        height: 62pt;
                        left: 484pt;
                        top: 180pt;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-size: 12pt;
                        line-height: 7pt;
                    }
                    .centre table{
                        padding: 274pt 29pt 0pt 30pt;
                        font-style: normal;
                        font-weight: 400;
                        font-size: 14pt;
                        font-family: 'Harmattan';
                        border-width: 1pt;
                        border-style: solid;
                        border-color: #7E5FC3;
                        border-collapse: collapse;
                        width: 100%;
                        border-spacing: 0pt;
                    }
                    .centre table thead{
                        background-color: #7E5FC4;
                        color: #FFFFFF;
                    }
                    .centre table td, th{
                        border-collapse: collapse;
                        text-align: left;
                        vertical-align: middle;
                        padding-left: 3.5pt;
                    }
                    .centre table tbody tr:nth-child(odd){
                        background-color: #DCD5F0;
                    }
                    .centre .report-row .sub{
                        padding: 0pt 32pt 0pt 32pt;
                    }
                    .centre .report-row .sub span{
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 700;
                        font-size: 14pt;
                    }
                    .centre .report-row .sub p{
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 400;
                        font-size: 14pt;
                        line-height: 7pt;
                    }
            
            
                    .centre .quote{
                        position: absolute;
                        width: 535pt;
                        height: 30pt;
                        left: 30pt;
                        bottom: 77pt;
                        text-align: center;
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 700;
                        font-size: 12pt;
                        line-height: 5.3pt;
            
                        color: #767676;
                    }
                    .footer{
                        position: absolute;
                        width: 595pt;
                        height: 65pt;
                        left: 0pt;
                        bottom: 0;
                        background: #DCD5F0;
                    }
                    .footer .footer-logo{
                        position: absolute;
                        width: 97pt;
                        height: 26pt;
                        left: 261pt;
                        top: 14pt;
                        font-family: 'ErasBoldITC';
                        font-style: normal;
                        font-weight: 400;
                        font-size: 16pt;
                        line-height: 10pt;
                        color: #8B8B8B;
            
                    }
                    .footer .footer-text{
                        position: absolute;
                        width: 28pt;
                        height: 12pt;
                        left: 283pt;
                        top: 33pt;
            
                        font-family: 'Harmattan';
                        font-style: normal;
                        font-weight: 700;
                        font-size: 14pt;
                        line-height: 12pt;
                        color: #8B8B8B;
                    }
                    #first{
                        padding-top: 6pt;
                    }
                </style>
            </head>
            <body>
                <div class='header'>
                    <div class='title'>
                        <b>Progress</b>
                        <br> 
                        <b>Report</b>
                    </div>
                    <div class='logo-holder'>
                        <img src='http://localhost/PROJECT/img/logo.png' alt=''>
                    </div>
                    <div class='logo-t-1'>
                        If you have any queries, contact us at
                    </div>
                    <div class='logo-t-2'>
                        <a href='mailto:celestacampus.team@gmail.com? subject=Query regarding progress report'>  
                            celestacampus.team@gmail.com
                        </a>  
                    </div>
                </div>
                <div class='centre'>
                    <div class='rec1'>
                    </div>
                    <div class='rec1-t'>
                        Student details
                    </div>
                    <div class='pmark'></div>
            
                    <div class='stud-details'>
                        <b>Name:</b> ". $result['sname'] ." <br>
                        <b>Student email:</b> ". $result['smail'] ." <br>
                        <b>Student phone:</b> ". $result['spno'] ." <br>
                        <b>Skye ID:</b> ". $result['skype'] ." <br>
                        <b>Country:</b> ". $result['ctry'] ." <br>
                    </div>
            
            
                    <div class='rec2'>
                    </div>
                    <div class='rec2-t'>
                        Course details
                    </div>
                    <div class='pmark2'></div>
                    <div class='course-details'>
                        <b>Course:</b> ". $result['course'] ." <br>
                        <b>Fee:</b> ". $result['fee'] ." <br>
                        <b>Total number of sessions:</b> ". count($scdate) ." <br>
                    </div>
            
            
                    <div class='rec3'>
                    </div>
                    <div class='rec3-t'>
                        Report details
                    </div>
                    <div class='pmark3'></div>
                    <div class='report-details'>
                        <b>Month:</b> ". $mname ." <br>
                        <b>Tutor:</b> Celesta <br>
                    </div>
            
            
                    <!-- table -->
                    <table>
                        <thead>
                            <tr>
                                <td style='width: 10%;'>Sl.No</td>
                                <td style='width: 36%;'>Topic Taken</td>
                                <td style='width: 17%;'>Date of session</td>
                                <td style='width: 19%;'>Whiteboard marks</td>
                                <td style='width: 17%;'>School marks</td>
                            </tr>
                        </thead>
                        <tbody>
                        ";
        $scdateArrLength = count($scdate);
        $j = 1;
        for ($i = 0; $i < $scdateArrLength; $i++) {

            $html .= "
                            <tr>
                                <td>". $j ."</td>
                                <td>". $takenTopic[$i] ."</td>
                                <td>". $scdate[$i] ."</td>
                                <td>". $wbMark[$i] ."</td>
                                <td>". $schMark[$i] ."</td>
                            </tr>
            ";
            $j++;
        }
        
        $html .="
                        
                        </tbody>
                    </table>
                    ";

        if(!$strength =='' && !$strength == null){
            $html .="<div class='report-row' id='first'>
                        <div class='sub' id='first'>
                            <span>Strengths</span><br>
                            <p>". $strength ."</p>

                        </div>
                    </div>";
        } 
        if(!$focus =='' && !$focus == null){
            $html .="    <div class='report-row'>
                            <div class='sub'>
                                <span>Should focus more on</span><br>
                                <p>". $focus ."</p>

                            </div>
                        </div>";
        }      
        if(!$measure =='' && !$measure == null){
            $html .="<div class='report-row'>
                        <div class='sub'>
                            <span>Remarks</span><br>
                            <p>". $measure ."</p>
                        </div>
                    </div>";
        }                 

        $html .="

                    
                    <div class='quote'>
                        We encourage you to review this progress report with your child and discuss their achievements and areas for <br>improvement. <br>Thank you for entrusting us with your child's academic growth.
                    </div>
                </div>
                <div class='footer'>
                    <div class='footer-logo'>
                        CELESTA <br>
                        CAMPUS
                    </div>
                    <div class='footer-text'>
                        India
                    </div>
                </div>
            </body>
            </html>";

    $dompdf->loadHtml($html);
    $name = $result['sname']. "_" .$mname ."_". "Progress_Report";
    $filename = 'C:/xampp/htdocs/PROJECT/saved/'. $name .'.pdf';
    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    file_put_contents($filename, $dompdf->output());

    $content = file_get_contents($filename);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $file_name = basename($filename);

    // header
    $header = "From: CelestaCampus Team <celestacampus.team@gmail.com>" . "\r\n";
    $header .= "Reply-To: celestacampus.team@gmail.com" . "\r\n";
    $header .= "MIME-Version: 1.0" . "\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

    // message & attachment
    $nmessage = "--".$uid."\r\n";
    $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
    $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $nmessage .= $body."\r\n\r\n";
    $nmessage .= "--".$uid."\r\n";
    $nmessage .= "Content-Type: application/octet-stream; name=\"".$name.".pdf\"\r\n";
    $nmessage .= "Content-Transfer-Encoding: base64\r\n";
    $nmessage .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n\r\n";
    $nmessage .= $content."\r\n\r\n";
    $nmessage .= "--".$uid."--";

    if (mail($pmail, $subject, $nmessage, $header)) {
        if (mail('youremailhere@gmail.com', $subject, $nmessage, $header)){
                foreach($_POST['scid'] as $tget){
                  $sql = "UPDATE report SET psent='1' WHERE sid='$sid' AND scid='$tget'";
                  $resultt = mysqli_query($conn, $sql);
                }
                if($resultt){
                  echo "1";
                }else{
                  echo "x";
                }
        }else {
            echo "01";
        }
        
    } else {
        echo "00";
    }

}


?>