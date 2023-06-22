<?php
require 'vendor/autoload.php';

include_once('connection.php');
$name = $_POST['garage'];
$start = $_POST['start'];
$end = $_POST['end'];
$sql1 = "SELECT * FROM garage WHERE garage_name = '$name'";
$res1 =  mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);

$sql2 = "SELECT * FROM garage_expenses WHERE garage_id = '" . $row1['garage_id'] . "' AND (date BETWEEN '$start' AND '$end')";
$res2 = mysqli_query($con, $sql2);

$total = 0;
$daf3at = 0;
$html = "<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<center> <h2> تقارير $name بين $start و $end </h2></center>
<h3> دفعات الشركة</h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>تاريخ الدفعة</th>
    <th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>رقم الشيك</th>
    <th>الحادث</th>
    <th> تفصيل الحادث </th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res2); $i++) {
    $row2 = mysqli_fetch_array($res2);
    $daf3at += $row2['required_amount'];
    $html .= "<tr>
    <td>" . $row2['date'] . "</td>
    <td>" . $row2['required_amount'] . "</td>
    <td>" . $row2['lebanese_amount'] . "</td>
    <td>" . $row2['check_number'] . "</td>
    <td>" . $row2['accident_id'] . "</td>
    <td>" . $row2['accident_cost_id'] . "</td>
</tr>";
}
$html .= "</table>";

$html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $daf3at . " </th></tr></table>";


$sql6 = "SELECT * FROM accident_cost JOIN accident ON accident_cost.accident_id=accident.accident_id AND accident_cost.garage_id= '" . $row1['garage_id'] . "' AND (accident.date BETWEEN '$start' AND '$end')";
$res6 = mysqli_query($con, $sql6);

$html .= "<h3> حوادث الزبائن </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
<th>الزبون</th>
    <th>رقم الحادث</th>
    <th>تاريخ الحادث</th>
    <th>التكلفة</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res6); $i++) {
    $row6 = mysqli_fetch_array($res6);
    $total += $row6['cost'];
    $sql7 = "SELECT* FROM person WHERE person_id = '" . $row6['person_id'] . "'";
    $res7 = mysqli_query($con, $sql7);
    $row7 = mysqli_fetch_array($res7);
    $sql11 = "SELECT* FROM accident WHERE accident_id = '" . $row6['accident_id'] . "'";
    $res11 = mysqli_query($con, $sql11);
    $row11 = mysqli_fetch_array($res11);
    $html .= "<tr>
<td>" . $row7['person_name'] . "</td>
    <td>" . $row6['accident_id'] . "</td>

    <td>" . $row11['date'] . "</td>
    <td>" . $row6['cost'] . "</td>
</tr>";
}
$html .= "</table>";

$html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $total . " </th></tr></table>";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
