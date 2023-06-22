<?php
require 'vendor/autoload.php';
include_once('connection.php');
$name = $_POST['agent'];
$start = $_POST['start'];
$end = $_POST['end'];

$sql1 = "SELECT * FROM person WHERE person_name = '$name'";
$res1 =  mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);

$sql2 = "SELECT * FROM contract WHERE agent = '" . $row1['person_id'] . "' AND (start_date BETWEEN '$start' AND '$end')";
$res2 = mysqli_query($con, $sql2);

$total_price = 0;
$daf3at=0;
$total = 0;
$total2=0;
$total3=0;
$total4=0;
$html = "<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<center> <h2> تقارير $name بين $start و $end </h2></center>

        <h3> العقود </h3>
        <table border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <th>الزبون</th>
            <th>رقم العقد</th>
            <th>نوع العقد</th>
            <th>الشركة</th>
            <th>سعر العقد</th>
            <th>حصة العمبل</th>
            <th>الصافي </th>
            <th>تاريخ الإبتداء</th>
            <th>تاريخ الإنتهاء</th>
        </tr>";
for ($i = 0; $i < mysqli_num_rows($res2); $i++) {
    $row2 = mysqli_fetch_array($res2);
    // echo $row2['contract_type_id'];
    $total_price += $row2['agent_portion'];
    $total3 += $row2['price'];
    $sql3 = "SELECT * FROM contract_type WHERE contract_type_id = '" . $row2['contract_type_id'] . "'";
    $res3 = mysqli_query($con, $sql3);
    $row3 = mysqli_fetch_array($res3);
    // var_dump($res3);
    $sql4 = "SELECT* FROM company WHERE company_id = '" . $row2['company_id'] . "'";
    $res4 = mysqli_query($con, $sql4);
    $row4 = mysqli_fetch_array($res4);
    $sql5 = "SELECT* FROM person WHERE person_id = '" . $row2['person_id'] . "'";
    $res5 = mysqli_query($con, $sql5);
    $row5 = mysqli_fetch_array($res5);
    $safi = $row2['price'] - $row2['agent_portion'];
    $total4 += $safi;
    $html .= "<tr>
             <td>" . $row5['person_name'] . "</td>
            <td>" . $row2['contract_number'] . "</td>
            <td>" . $row3['type'] . "</td>
            <td>" . $row4['company_name'] . "</td>
            <td>" . $row2['price'] . "</td>
            <td>" . $row2['agent_portion'] . "</td>
            <td>" . $safi . "</td> 
            <td>" . $row2['start_date'] . "</td>
            <td>" . $row2['end_date'] . "</td>
        </tr>";
}
$html .= "</table>";

$html .="<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>مجموع حصص العميل </th>
<th >".$total_price." </th></tr>
<tr><th width='12.2%'>مجموع العقود </th>
<th >".$total3." </th></tr>
<tr><th width='12.2%'>الصافي </th>
<th >".$total4." </th></tr></table>";

$query = "SELECT * FROM contract WHERE agent = '" . $row1['person_id'] . "' AND (end_date BETWEEN '$start' AND '$end')";
$result = mysqli_query($con, $query);

$html .="<h3> العقود المنتهية</h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>الزبون</th>
            <th>رقم العقد</th>
            <th>نوع العقد</th>
            <th>الشركة</th>
            <th>سعر العقد</th>
            <th>حصة العمبل</th>
            <th>الصافي </th>
            <th>تاريخ الإبتداء</th>
            <th>تاريخ الإنتهاء</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($result); $i++) {
 $roww = mysqli_fetch_array($result);
    // echo $row2['contract_type_id'];
    $p += $roww['agent_portion'];
    $t += $roww['price'];
    $query2 = "SELECT * FROM contract_type WHERE contract_type_id = '" . $roww['contract_type_id'] . "'";
    $result2 = mysqli_query($con, $query2);
    $roww2 = mysqli_fetch_array($result2);
    // var_dump($res3);
    $query3 = "SELECT* FROM company WHERE company_id = '" . $roww['company_id'] . "'";
    $result3 = mysqli_query($con, $query3);
    $roww3 = mysqli_fetch_array($result3);
    $query4 = "SELECT* FROM person WHERE person_id = '" . $roww['person_id'] . "'";
    $result4 = mysqli_query($con, $query4);
    $roww4 = mysqli_fetch_array($result4);
    $s = $roww['price'] - $roww['agent_portion'];
    $total4 += $safi;
    $html .= "<tr>
             <td>" . $row5['person_name'] . "</td>
            <td>" . $roww['contract_number'] . "</td>
            <td>" . $roww2['type'] . "</td>
            <td>" . $roww3['company_name'] . "</td>
            <td>" . $roww['price'] . "</td>
            <td>" . $roww['agent_portion'] . "</td>
            <td>" . $s . "</td> 
            <td>" . $roww['start_date'] . "</td>
            <td>" . $roww['end_date'] . "</td>
        </tr>";
}
$html .= "</table>";

$sql8 = "SELECT * FROM agent_expenses WHERE agent_id = '".$row1['person_id']."' AND (payday BETWEEN '$start' AND '$end')";
$res8 = mysqli_query($con, $sql8);


$html .="<h3> الدفعات </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>تاريخ الدفعة</th>
    <th> قيمة الدفعة بالدولار</th>
    <th>قيمة الدفعة باللبناني</th>
    <th>رقم الشيك</th>
    <th>العقد</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res8); $i++) {
$row8 = mysqli_fetch_array($res8);
$daf3at += $row8['required_amount'];
$sql9 = "SELECT* FROM contract WHERE contract_id = '" . $row8['contract_id'] . "'";
$res9 = mysqli_query($con, $sql9);
$row9=mysqli_fetch_array($res9);
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
<th >".$daf3at." </th></tr></table>";


$sql6 = "SELECT * FROM accident_cost JOIN accident ON accident_cost.accident_id=accident.accident_id JOIN contract ON accident_cost.contract_id = contract.contract_id AND contract.agent= '" . $row1['person_id'] . "' AND (accident.date BETWEEN '$start' AND '$end')";
$res6 = mysqli_query($con, $sql6);

$html .="<h3> حوادث الزبائن </h3>
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
$row7=mysqli_fetch_array($res7);
// for($j=0;$j<mysqli_num_rows($res7);$j++){
//     $row7=mysqli_fetch_array($res7);
//     $total += $row7['cost'];
// }
$sql13 = "SELECT* FROM accident WHERE accident_id = '" . $row6['accident_id'] . "'";
$res13 = mysqli_query($con, $sql13);
$row13 = mysqli_fetch_array($res13);
$html .= "<tr>
<td>" . $row7['person_name'] . "</td>
    <td>" . $row6['accident_id'] . "</td>

    <td>" . $row13['date'] . "</td>
    <td>" . $row6['cost'] . "</td>
</tr>";
}
$html .= "</table>";

$html .="<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >".$total." </th></tr></table>";


$sql10 = "SELECT * FROM client_expenses JOIN contract ON client_expenses.contract_id = contract.contract_id AND contract.agent= '" . $row1['person_id'] . "' AND (client_expenses.payday BETWEEN '$start' AND '$end')";
$res10 = mysqli_query($con, $sql10);

$html .="<h3> دفعات الزبائن عن عقود العميل </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
<th>الزبون</th>
<th> تاريخ الدفعة </th>
<th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
<th>رقم الشيك</th>
<th>العقد</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res10); $i++) {
$row10 = mysqli_fetch_array($res10);
$total2 += $row10['required_amount'];
$sql11 = "SELECT* FROM person WHERE person_id = '" . $row10['client_id'] . "'";
$res11 = mysqli_query($con, $sql11);
$row11=mysqli_fetch_array($res11);
// for($j=0;$j<mysqli_num_rows($res7);$j++){
//     $row7=mysqli_fetch_array($res7);
//     $total += $row7['cost'];
// }
$sql12 = "SELECT* FROM contract WHERE contract_id = '" . $row10['contract_id'] . "'";
$res12 = mysqli_query($con, $sql12);
$row12 = mysqli_fetch_array($res12);
$html .= "<tr>
<td>" . $row11['person_name'] . "</td>
    <td>" . $row10['payday'] . "</td>
    <td>" . $row10['required_amount'] . "</td>
    <td>" . $row10['lebanese_amount'] . "</td>
    <td>" . $row10['check_number'] . "</td>
    <td>" . $row12['contract_number'] . "</td>
</tr>";
}
$html .= "</table>";

$html .="<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >".$total2." </th></tr></table>";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
