<?php
require 'vendor/autoload.php';

include_once('connection.php');
$start = $_POST['start'];
$end = $_POST['end'];

$sql2 = "SELECT * FROM other_expenses WHERE (payday BETWEEN '$start' AND '$end')";
$res2 = mysqli_query($con, $sql2);

$daf3at = 0;
$html = "<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<center> <h2> تقارير أخرى بين $start و $end </h2></center>
<h3> الدفعات </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>سبب الدفعة</th>
    <th>تاريخ الدفعة</th>
    <th>قيمة الدفعة</th>
    <th>رقم الشيك</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res2); $i++) {
    $row2 = mysqli_fetch_array($res2);
    $daf3at += $row2['amount'];
    $html .= "<tr>
    <td>" . $row2['description'] . "</td>
    <td>" . $row2['payday'] . "</td>
    <td>" . $row2['amount'] . "</td>
    <td>" . $row2['check_number'] . "</td>
</tr>";
}
$html .= "</table>";

$html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $daf3at . " </th></tr></table>";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
