<?php

require 'vendor/autoload.php';

include_once('connection.php');
$name = $_POST['client'];
$start = $_POST['start'];
$end = $_POST['end'];

$sql1 = "SELECT * FROM person WHERE person_name = '$name'";
$res1 =  mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);

$sql2 = "SELECT * FROM contract WHERE person_id = '" . $row1['person_id'] . "' AND (start_date BETWEEN '$start' AND '$end')";
$res2 = mysqli_query($con, $sql2);

$total_price=0;
$total_acc=0;
$total_daf3at = 0;
$html = "<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<center> <h2> تقارير $name بين $start و $end </h2></center>

        <h3> العقود </h3>
        <table border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <th>رقم العقد</th>
            <th>نوع العقد</th>
            <th>العميل</th>
            <th>الشركة</th>
            <th>سعر العقد</th>
            <th>تاريخ الإبتداء</th>
            <th>تاريخ الإنتهاء</th>
        </tr>";
for ($i = 0; $i < mysqli_num_rows($res2); $i++) {
    $row2 = mysqli_fetch_array($res2);
    // echo $row2['contract_type_id'];
    $total_price += $row2['price'];
    $sql3 = "SELECT * FROM contract_type WHERE contract_type_id = '" . $row2['contract_type_id'] . "'";
    $res3 = mysqli_query($con, $sql3);
    $row3 = mysqli_fetch_array($res3);
    // var_dump($res3);
    $sql4 = "SELECT* FROM company WHERE company_id = '" . $row2['company_id'] . "'";
    $res4 = mysqli_query($con, $sql4);
    $row4 = mysqli_fetch_array($res4);
    $sql5 = "SELECT* FROM person WHERE person_id = '" . $row2['agent'] . "'";
    $res5 = mysqli_query($con, $sql5);
    $row5 = mysqli_fetch_array($res5);
    $html .= "<tr>
            <td>" . $row2['contract_number'] . "</td>
            <td>" . $row3['type'] . "</td>
            <td>" . $row5['person_name'] . "</td>
            <td>" . $row4['company_name'] . "</td>
            <td>" . $row2['price'] . "</td>
            <td>" . $row2['start_date'] . "</td>
            <td>" . $row2['end_date'] . "</td>
        </tr>";
}
$html .= "</table>";

$html .="<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >".$total_price." </th></tr></table>";
$sql6 = "SELECT * FROM accident WHERE person_id = '" . $row1['person_id'] . "' AND (date BETWEEN '$start' AND '$end')";
$res6 = mysqli_query($con, $sql6);

$html .="<h3> الحوادث </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>رقم الحادث</th>
    <th>تاريخ الحادث</th>
    <th>تكلفة الحادث</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res6); $i++) {
$row6 = mysqli_fetch_array($res6);
$total = 0;
$sql7 = "SELECT* FROM accident_cost WHERE accident_id = '" . $row6['accident_id'] . "'";
$res7 = mysqli_query($con, $sql7);
for($j=0;$j<mysqli_num_rows($res7);$j++){
    $row7=mysqli_fetch_array($res7);
    $total += $row7['cost'];
}
$total_acc += $total;
// $sql8 = "SELECT* FROM contract WHERE contract_id = '" . $row6['contract_id'] . "'";
// $res8 = mysqli_query($con, $sql8);
// $row8 = mysqli_fetch_array($res8);
$html .= "<tr>
    <td>" . $row6['accident_id'] . "</td>
    <td>" . $row6['date'] . "</td>
    <td>" . $total . "</td>
</tr>";
}
$html .= "</table>";

$html .="<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >".$total_acc." </th></tr></table>";
$sql8 = "SELECT * FROM client_expenses WHERE client_id = '".$row1['person_id']."' AND (payday BETWEEN '$start' AND '$end')";
$res8 = mysqli_query($con, $sql8);

$html .="<h3> الدفعات </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>تاريخ الدفعة</th>
    <th>قيمة الدفعة بالدولار</th>
    <th>قيمة الدفعة باللبناني</th>
    <th>رقم الشيك</th>
    <th>العقد</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res8); $i++) {
$row8 = mysqli_fetch_array($res8);
$sql9 = "SELECT* FROM contract WHERE contract_id = '" . $row8['contract_id'] . "'";
$res9 = mysqli_query($con, $sql9);
$row9=mysqli_fetch_array($res9);
$total_daf3at += $row8['required_amount'];
// $sql8 = "SELECT* FROM contract WHERE contract_id = '" . $row6['contract_id'] . "'";
// $res8 = mysqli_query($con, $sql8);
// $row8 = mysqli_fetch_array($res8);
$html .= "<tr>
    <td>" . $row8['payday'] . "</td>
    <td>" . $row8['required_amount'] . "</td>
    <td>" . $row8['lebanese_amount'] . "</td>
    <td>" . $row8['check_number'] . "</td>
    <td>" . $row9['contract_number'] . "</td>
</tr>";
}
$html .= "</table>";

$html .="<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >".$total_daf3at." </th></tr></table>"; 

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
