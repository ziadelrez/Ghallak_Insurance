<?php
require 'vendor/autoload.php';

include_once('connection.php');
$date = $_POST['date'];

$sql1 = "SELECT * FROM contract WHERE start_date = '$date'";
$res1 = mysqli_query($con, $sql1);

$cont_total = 0;
$acc_total = 0;
$client_total = 0;
$agent_total = 0;
$expert_total = 0;
$comp_total = 0;
$comp_acc_total = 0;
$garage_total = 0;
$other_total = 0;
$html = "<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<center> <h2> تقارير يوم $date </h2></center>
<h3> العقود </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>رقم العقد</th>
    <th>الزبون</th>
    <th>الشركة</th>
    <th>تاريخ الإنتهاء</th>
    <th>السعر</th>
    <th>نوع العقد</th>
    <th>العميل</th>
</tr>";
for ($i = 0; $i < mysqli_num_rows($res1); $i++) {
    $row1 = mysqli_fetch_array($res1);
    $cont_total += $row1['price'];
    $sql2 = "SELECT * FROM person WHERE person_id ='" . $row1['person_id'] . "'";
    $res2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($res2);

    $sql3 = "SELECT * FROM person WHERE person_id ='" . $row1['agent'] . "'";
    $res3 = mysqli_query($con, $sql3);
    $row3 = mysqli_fetch_array($res3);

    $sql4 = "SELECT * FROM company WHERE company_id ='" . $row1['company_id'] . "'";
    $res4 = mysqli_query($con, $sql4);
    $row4 = mysqli_fetch_array($res4);

    $sql5 = "SELECT * FROM contract_type WHERE contract_type_id ='" . $row1['contract_type_id'] . "'";
    $res5 = mysqli_query($con, $sql5);
    $row5 = mysqli_fetch_array($res5);
    $html .= "<tr>
    <td>" . $row1['contract_number'] . "</td>
    <td>" . $row2['person_name'] . "</td>
    <td>" . $row4['company_name'] . "</td>
    <td>" . $row1['end_date'] . "</td>
    <td>" . $row1['price'] . "</td>
    <td>" . $row5['type'] . "</td>
    <td>" . $row3['person_name'] . "</td>
    </tr>";
}
$html .= "</table>";

$html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $cont_total . " </th></tr></table>";

$sql6 = "SELECT * FROM accident WHERE date = '$date'";
$res6 = mysqli_query($con, $sql6);
if (mysqli_num_rows($res6) != 0) {
    $html .= "<h3> الحوادث </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>رقم الحادث</th>
    <th>تاريخ الحادث</th>
    <th>الزبون</th>
    <th>التكلفة</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res6); $i++) {
        $row6 = mysqli_fetch_array($res6);
        $total = 0;
        $sql7 = "SELECT * FROM person WHERE person_id ='" . $row6['person_id'] . "'";
        $res7 = mysqli_query($con, $sql7);
        $row7 = mysqli_fetch_array($res7);

        $html .= "<tr>
    <td>" . $row6['accident_id'] . "</td>
    <td>" . $row6['date'] . "</td>
    <td>" . $row7['person_name'] . "</td>";
        $sql8 = "SELECT * FROM accident_cost WHERE accident_id ='" . $row6['accident_id'] . "'";
        $res8 = mysqli_query($con, $sql8);
        if (mysqli_num_rows($res8) != 0) {
            for ($j = 0; $j < mysqli_num_rows($res8); $j++) {

                $row8 = mysqli_fetch_array($res8);
                $total += $row8['cost'];
            }
        }
        $acc_total += $total;
        $html .= "<td>" . $total . "</td></tr>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $acc_total . " </th></tr></table>";
}
$sql9 = "SELECT * FROM client_expenses WHERE payday = '$date'";
$res9 = mysqli_query($con, $sql9);
if (mysqli_num_rows($res9) != 0) {
    $html .= "<h3> دفعات الزبائن </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>الزبون</th>
    <th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>العقد</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res9); $i++) {
        $row9 = mysqli_fetch_array($res9);
        $client_total += $row9['required_amount'];
        $sql10 = "SELECT * FROM person WHERE person_id ='" . $row9['client_id'] . "'";
        $res10 = mysqli_query($con, $sql10);
        $row10 = mysqli_fetch_array($res10);

        $sql11 = "SELECT * FROM contract WHERE contract_id ='" . $row9['contract_id'] . "'";
        $res11 = mysqli_query($con, $sql11);
        $row11 = mysqli_fetch_array($res11);
        $html .= "<tr>
    <td>" . $row10['person_name'] . "</td>
    <td>" . $row9['required_amount'] . "</td>
    <td>" . $row9['lebanese_amount'] . "</td>
    <td>" . $row11['contract_number'] . "</td>
    <td>" . $row9['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $client_total . " </th></tr></table>";
}
$sql12 = "SELECT * FROM agent_expenses WHERE payday = '$date'";
$res12 = mysqli_query($con, $sql12);
if (mysqli_num_rows($res12) != 0) {
    $html .= "<h3> دفعات العملاء </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>العميل</th>
    <th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>العقد</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res12); $i++) {
        $row12 = mysqli_fetch_array($res12);
        $agent_total += $row12['required_amount'];
        $sql13 = "SELECT * FROM person WHERE person_id ='" . $row12['agent_id'] . "'";
        $res13 = mysqli_query($con, $sql13);
        $row13 = mysqli_fetch_array($res13);

        $sql14 = "SELECT * FROM contract WHERE contract_id ='" . $row12['contract_id'] . "'";
        $res14 = mysqli_query($con, $sql14);
        $row14 = mysqli_fetch_array($res14);
        $html .= "<tr>
    <td>" . $row13['person_name'] . "</td>
    <td>" . $row12['required_amount'] . "</td>
    <td>" . $row12['lebanese_amount'] . "</td>
    <td>" . $row14['contract_number'] . "</td>
    <td>" . $row12['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $agent_total . " </th></tr></table>";
}

$sql15 = "SELECT * FROM expert_expenses WHERE date = '$date'";
$res15 = mysqli_query($con, $sql15);
if (mysqli_num_rows($res15) != 0) {
    $html .= "<h3> دفعات الخبراء </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>الخبير</th>
<th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>الحادث</th>
    <th> تفصيل الحادث</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res15); $i++) {
        $row15 = mysqli_fetch_array($res15);
        $expert_total += $row15['required_amount'];
        $sql16 = "SELECT * FROM person WHERE person_id ='" . $row15['expert_id'] . "'";
        $res16 = mysqli_query($con, $sql16);
        $row16 = mysqli_fetch_array($res16);

        $html .= "<tr>
    <td>" . $row16['person_name'] . "</td>
    <td>" . $row15['required_amount'] . "</td>
    <td>" . $row15['lebanese_amount'] . "</td>
    <td>" . $row15['accident_id'] . "</td>
    <td>" . $row15['accident_cost_id'] . "</td>
    <td>" . $row15['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $expert_total . " </th></tr></table>";
}

$sql17 = "SELECT * FROM companies_expenses WHERE date = '$date'";
$res17 = mysqli_query($con, $sql17);
if (mysqli_num_rows($res17) != 0) {
    $html .= "<h3> دفعات الشركة </h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>الشركة</th>
    <th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>العقد</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res17); $i++) {
        $row17 = mysqli_fetch_array($res17);
        $comp_total += $row17['required_amount'];
        $sql18 = "SELECT * FROM company WHERE company_id ='" . $row17['company_id'] . "'";
        $res18 = mysqli_query($con, $sql18);
        $row18 = mysqli_fetch_array($res18);

        $html .= "<tr>
    <td>" . $row18['company_name'] . "</td>
    <td>" . $row17['required_amount'] . "</td>
    <td>" . $row17['lebanese_amount'] . "</td>
    <td>" . $row17['contract_id'] . "</td>
    <td>" . $row17['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $comp_total . " </th></tr></table>";
}

$sql19 = "SELECT * FROM companies_accident_expenses WHERE date = '$date'";
$res19 = mysqli_query($con, $sql19);
if (mysqli_num_rows($res19) != 0) {
    $html .= "<h3>  دفعات الشركة بدل حوادث</h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>الشركة</th>
    <th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>الحادث</th>
    <th> تفصيل الحادث</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res19); $i++) {
        $row19 = mysqli_fetch_array($res19);
        $comp_acc_total += $row19['required_amount'];
        $sql20 = "SELECT * FROM company WHERE company_id ='" . $row19['company_id'] . "'";
        $res20 = mysqli_query($con, $sql20);
        $row20 = mysqli_fetch_array($res20);

        $html .= "<tr>
    <td>" . $row20['company_name'] . "</td>
    <td>" . $row19['required_amount'] . "</td>
    <td>" . $row19['lebanese_amount'] . "</td>
    <td>" . $row19['accident_id'] . "</td>
    <td>" . $row19['accident_cost_id'] . "</td>
    <td>" . $row19['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $comp_acc_total . " </th></tr></table>";
}

$sql21 = "SELECT * FROM garage_expenses WHERE date = '$date'";
$res21 = mysqli_query($con, $sql21);
if (mysqli_num_rows($res21) != 0) {
    $html .= "<h3>  دفعات الغراجات</h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>الغراج</th>
    <th> قيمة الدفعة بالدولار</th>
<th>قيمة الدفعة باللبناني</th>
    <th>الحادث</th>
    <th> تفصيل الحادث</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res21); $i++) {
        $row21 = mysqli_fetch_array($res21);
        $garage_total += $row21['required_amount'];
        $sql22 = "SELECT * FROM garage WHERE garage_id ='" . $row21['garage_id'] . "'";
        $res22 = mysqli_query($con, $sql22);
        $row22 = mysqli_fetch_array($res22);

        $html .= "<tr>
    <td>" . $row22['garage_name'] . "</td>
    <td>" . $row21['required_amount'] . "</td>
    <td>" . $row21['lebanese_amount'] . "</td>
    <td>" . $row21['accident_id'] . "</td>
    <td>" . $row21['accident_cost_id'] . "</td>
    <td>" . $row21['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $garage_total . " </th></tr></table>";
}

$sql23 = "SELECT * FROM other_expenses WHERE payday = '$date'";
$res23 = mysqli_query($con, $sql23);
if (mysqli_num_rows($res23) != 0) {
    $html .= "<h3>  دفعات أخرى</h3>
<table border='1' width='100%' style='border-collapse: collapse;'>
<tr>
    <th>سبب الدفعة</th>
    <th>قيمة الدفعة</th>
    <th>رقم الشيك</th>
</tr>";
    for ($i = 0; $i < mysqli_num_rows($res23); $i++) {
        $row23 = mysqli_fetch_array($res23);
        $other_total += $row23['amount'];
        $html .= "<tr>
    <td>" . $row23['description'] . "</td>
    <td>" . $row23['amount'] . "</td>
    <td>" . $row23['check_number'] . "</td>";
    }
    $html .= "</table>";

    $html .= "<table border='1' bgcolor='#D3D3D3' width='100%' style='border-collapse: collapse;'>
<tr><th width='12.2%'>المجموع </th>
<th >" . $other_total . " </th></tr></table>";
}
$total = $client_total+$comp_acc_total-$agent_total-$expert_total-$comp_total-$garage_total-$other_total;
$html.="<br><b> المجموع : ".$total ."$<b>";


$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
