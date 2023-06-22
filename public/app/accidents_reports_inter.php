<?php

require 'vendor/autoload.php';
include_once('connection.php');

$start = $_POST['start'];
$end = $_POST['end'];

$sql1 = "SELECT * FROM accident WHERE (date BETWEEN '$start' AND '$end')";
$res1 = mysqli_query($con, $sql1);

$total1 = 0;
$daf3at = 0;
$html = "<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<center> <h2> تقارير الحوادث بين $start و $end </h2></center>
<h3> الحوادث </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>رقم الحادث</th>
    <th>تاريخ الحادث</th>
    <th>الزبون</th>
    <th>التكلفة</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res1); $i++) {
    $row1 = mysqli_fetch_array($res1);
    $total = 0;
    // $daf3at += $row1['amount'];
    $sql2 = "SELECT * FROM person WHERE person_id ='" . $row1['person_id'] . "'";
    $res2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($res2);
    if(!isset($row2['person_name'])){
        $person = null;
    }else $person = $row2['person_name'];
    $html .= "<tr>
    <td>" . $row1['accident_id'] . "</td>
    <td>" . $row1['date'] . "</td>
    <td>" . $person . "</td>";
    $sql3 = "SELECT * FROM accident_cost WHERE accident_id ='" . $row1['accident_id'] . "'";
    $res3 = mysqli_query($con, $sql3);
    if (mysqli_num_rows($res3) != 0) {
        for ($j = 0; $j < mysqli_num_rows($res3); $j++) {

            $row3 = mysqli_fetch_array($res3);
            $total += $row3['cost'];
        }
    }
    $daf3at += $total;
    $html .= "<td>" . $total . "</td></tr>";
}
$html .= "</table>";

$html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $daf3at . " </th></tr></table>";

$sql6 = "SELECT * FROM accident_cost JOIN accident ON accident_cost.accident_id=accident.accident_id AND (accident.date BETWEEN '$start' AND '$end')";
$res6 = mysqli_query($con, $sql6) or die(mysqli_error($con));
// echo mysqli_num_rows($res6);
$html .= "<h3>  تفاصيل الحوادث  </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>رقم الحادث</th>
    <th>تفصيل الحادث</th>
    <th>السيارة</th>
    <th>الخبير</th>
    <th>الغراج</th>
    <th>المستشفى</th>
    <th>المتضرر</th>
    <th>التكلفة</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res6); $i++) {
    $row6 = mysqli_fetch_array($res6);
    $total1 += $row6['cost'];
    $html .= "<tr>
     <td>" . $row6['accident_id'] . "</td>
     <td>" . $row6['accident_cost_id'] . "</td>";
    if ($row6['car_id'] != null) {
        $sql4 = "SELECT * FROM car WHERE car_id = '" . $row6['car_id'] . "'";
        $res4 = mysqli_query($con, $sql4);
        $row4 = mysqli_fetch_array($res4);
        $html .=  "<td>" . $row4['car_number'] . "</td>";
    } else $html .= "<td></td>";

    if ($row6['expert_id'] != null) {
        $sql7 = "SELECT* FROM person WHERE person_id = '" . $row6['expert_id'] . "'";
        $res7 = mysqli_query($con, $sql7);
        $row7 = mysqli_fetch_array($res7);
        $html .=  "<td>" . $row7['person_name'] . "</td>";
    } else $html .= "<td></td>";

    if ($row6['garage_id'] != null) {
        $sql8 = "SELECT* FROM garage WHERE garage_id = '" . $row6['garage_id'] . "'";
        $res8 = mysqli_query($con, $sql8);
        $row8 = mysqli_fetch_array($res8);
        $html .=  "<td>" . $row8['garage_name'] . "</td>";
    } else $html .= "<td></td>";
    
    if ($row6['hospital_id'] != null) {
        $sql9 = "SELECT* FROM hospital WHERE hospital_id = '" . $row6['hospital_id'] . "'";
        $res9 = mysqli_query($con, $sql9);
        $row9 = mysqli_fetch_array($res9);
        $html .=  "<td>" . $row9['hospital_name'] . "</td>";
    } else $html .= "<td></td>";
    
    if(!isset($row6['afflicted'])){
        $html .= "<td></td>";
    }else $html .= "<td>".$row6['afflicted']."</td>";
    $html .= "<td>" . $row6['cost'] . "</td>
</tr>";
}
$html .= "</table>";

$html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $total1 . " </th></tr></table>";
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
