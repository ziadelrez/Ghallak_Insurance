
<?php

use Mpdf\Tag\Dd;
require 'vendor/autoload.php';

include_once('connection.php');
$somme = $_GET['somme'];
$person = $_GET['client'];
$date = date('d/m/y');
$contract = $_GET['contracts'];
$lebanese = $_GET['lebanese'];
$html = "
<style>
img{  
    height: 150px;  
    width: 150px;  
    }  
   #left {    
    text-align: left;  
    }  
    </style>
<html lang='en' dir='rtl'>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<h2>  مؤسسة غسان حلاق لوساطة التأمين</h2>
<table width ='900px'>
<tr><td><h3>كافة أنواع التأمين </h3></td>
<div id='left'><td padding-left='600px' width='20%'> <img src='logo (1).png'></td></div>
</tr></table>
<table width='500px'>
<tr>
<td width = '40%'>رقم الترخيص 113 </td>
<th> قيمة الإيصال: $somme $ </th></tr> </table>
<br>
</p>وصلنا من السيد/ة: $person<p>
</p>مبلغاً وقدره: $somme دولار أمريكي فقط لا غير<p>
</p>ما يساوي $lebanese ليرة لبنانية فقط لا غير<p>
<p>نقداً بتاريخ: $date </p> 
<p>و ذلك عن العقود : $contract</p>

<p style='text-align:center'> شارع الثقافة - سنتر عبس٫ طابق أرضي.
 هاتف: ٠٦/٤٢٧٧٧٧ - ٠٦/٤٤٨٢٦٦ - ٠٣/٧٢٢٢٦٦</p></center>";

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
$mpdf->allow_charset_conversion = true;
$mpdf->SetDirectionality('rtl');
$mpdf->autoScriptToLang = true;
$mpdf->autoLangToFont = true;
$mpdf->WriteHTML($html);
$mpdf->Output();
?>