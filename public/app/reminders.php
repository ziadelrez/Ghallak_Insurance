<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallak Insurance</title>
    <link rel = "icon" href ="logo (1).png" type = "image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel=”stylesheet” href=”assets/css/bootstrap.css”>
    <link rel=”stylesheet” href=”assets/css/bootstrap-responsive.css”>
    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">

</head>
<style>
    .button{
        background-color: #ca0b00;
        color: white;
        width: 70px;
    }
</style>
<body>
    <?php
    include_once "connection.php";
    if (session_status() == PHP_SESSION_NONE) {
        //session has not started
        session_start();
        if(empty($_SESSION["wp20admin"])) {
            header('Location: index.php');
        }
    }  ?>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-wrapper" style="float: right; position: absolute;right: -5px;">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.php">حلاق للتأمين</a>
                        </div>
                        <!-- <div class="toggler">
                            <a href="#" class="sidebar-expanded d-none d-md-block"><i class="bi bi-x bi-middle"></i></a>
                        </div> -->
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">

                        <li class="sidebar-item">
                            <a href="person.php" class='sidebar-link'>
                                <span>الأشخاص</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="contracts.php" class='sidebar-link'>
                                <span>العقود</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="accidents.php" class='sidebar-link'>
                                <span>الحوادث</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a href="reminders.php" class='sidebar-link'>
                                <span>التذكيرات</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="hospitals.php" class='sidebar-link'>

                                <span>التعديلات</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="hospitals.php">المستشفيات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="cars.php">السيارات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="cars_types.php">وجهة إستعمال السيارة</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="regions.php">المناطق</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="banks.php">البنوك</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="garages.php">الغراجات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="companies.php">الشركات</a>
                                </li>

                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub ">
                            <a href="Clients_expenses.php" class='sidebar-link'>

                                <span>المصاريف والمداخيل</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="Clients_expenses.php">مصاريف ومداخيل الزبائن</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="agents_expenses.php">مصاريف ومداخيل العملاء</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="experts_expenses.php">مصاريف ومداخيل الخبراء</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="garages_expenses.php">مصاريف ومداخيل الغراجات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="companies_expenses.php">مصاريف ومداخيل الشركات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="other_expenses.php">مصاريف ومداخيل أخرى</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item  has-sub ">
                            <a href="Clients_expenses.php" class='sidebar-link'>

                                <span>التقارير</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="clients_reports.php">تقارير الزبائن</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="agents_reports.php">تقارير العملاء</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="experts_reports.php">تقارير الخبراء</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="garages_reports.php">تقارير الغراجات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="companies_reports.php">تقارير الشركات</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="accidents_reports.php">تقارير الحوادث</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="daily_reports.php">تقارير يومية</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="other_reports.php">تقارير أخرى</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item " style="background-color: #ca0b00 ;" id="exit">
                            <a href="logout.php" class='sidebar-link' style="color: #528B8B;">
                                <span>تسجيل خروج</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    <!-- </div> -->
    <div id="main">
    <header class="mb-3"  style="right: -200px; margin-right: 300px;" >
        <button class="burger-btn d-block d-xl-none"  id="sidebutton" >
            <i class="bi bi-justify fs-3"></i>
        </button>
    </header>
            <?php
            if(!isset($_GET['agent'])){
                $agent = NULL;
            }else $agent = $_GET['agent'];
            
            if(!isset($_GET['start'])){
                $start = NULL;
            }else $start = $_GET['start'];
            
            if(!isset($_GET['end'])){
                $end = NULL;
            }else $end = $_GET['end'];
            ?>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>بحث عن عميل</h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="reminders_inter.php" method="post">
                                <div class="form-group">
                                    <label for="start">إسم العميل </label>
                                    <input type="text" class="form-control" id="agent1" name="agent1" placeholder="بحث">
                                    <div class="list-group list-group-item-action" id="agent1_content"></div>
                                </div>
                                <div class="form-group">
                                    <label for="start">تاريخ الإبتداء</label>
                                    <input type="date" class="form-control" id="start" name="start" required>
                                </div>
                                <div class="form-group">
                                    <label for="end">تاريخ الإنتهاء</label>
                                    <input type="date" class="form-control" id="end" name="end" required>
                                </div>

                                <br>
                                <div class="buttons">
                                    <button type="submit" name="submit" class="btn btn-primary">بحث </button>
                                </div>
                            </form>
                            <script>
                           
                            function search_agent(e) {
                            
                                document.getElementById("agent1").value = e.target.innerHTML;
                                $('#agent1_content').html('');
                            }
                        
                            </script>

                        </div>
                    </div>
                </div>
            </div>

            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> عقود العميل</h3>
            </div>
            <?php
            
            $sql = "SELECT * FROM person WHERE person_name = '$agent'";
            $res = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($res);

            $q = "SELECT * FROM contract WHERE agent = '".$row['person_id']."' AND end_date >= '$start' AND end_date<='$end' ORDER BY end_date DESC";
            $r = mysqli_query($con, $q);
            ?>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell">الزبون</th>
                                    <th class="cell"> رقم العقد</th>
                                    <th class="cell"> سعر العقد</th>
                                    <th class="cell"> حصة العميل</th>
                                    <th class="cell"> الصافي</th>
                                    <th class="cell"> تاريخ الإنتهاء </th>
                                    <th class="cell"> الدفعات </th>
                                    <th class="cell"> الدفعات الباقية</th>
                                    <th class="cell">رسالة تذكير</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($r); $i++) {
                                    $amount=0;
                                    $roww = mysqli_fetch_array($r);
                                    $qq = "SELECT * FROM person WHERE person_id = '" . $roww['person_id'] . "'";
                                    $rr = mysqli_query($con, $qq);
                                    $roww3 = mysqli_fetch_array($rr);
                                    $rest = $roww['price']-$roww['agent_portion'];
                                    $sql4 = "SELECT * FROM client_expenses WHERE contract_id = '" . $roww['contract_id'] . "'";
                                     $resultat4 = mysqli_query($con, $sql4);
                                     if(mysqli_num_rows($resultat4)!=0){
                                         for($i=0;$i<mysqli_num_rows($resultat4);$i++){
                                            $rowww=mysqli_fetch_array($resultat4);
                                            
                                            $amount += $rowww['required_amount'];
                                         }
                                         $amount2 = $roww['price'] - $amount;
                                     }else $amount2 = $roww['price'];
                                    echo "<tr class='row2' onclick='exx(\"".$roww['contract_number']."\")'>";
                                    echo "<td data-title='الزبون'>" . $roww3['person_name'] . "</td>";
                                    echo "<td data-title='رقم العقد'>" . $roww['contract_number'] . "</td>";
                                    echo "<td data-title='سعر العقد'>" . $roww['price'] . "</td>";
                                    echo "<td data-title='حصة العميل'>" . $roww['agent_portion'] . "</td>";
                                    echo "<td data-title='الصافي'>" .$rest . "</td>";
                                    echo "<td data-title='تاريخ الإنتهاء '>" . $roww['end_date'] . "</td>";
                                    echo "<td data-title='الدفعات '>" .$amount . "</td>";
                                    echo "<td data-title='الدفعات الباقية'>" .$amount2 . "</td>";
                                    echo "<td data-title='رسالة تذكير' style='text-align: center;'><button id='send' class='button' onclick='send(event, \"". $roww3['person_name']."\", \"".$roww3['mobile']."\", \"".$roww['end_date']."\", \"".$roww['contract_number']."\" )'>أرسل</button></td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function exx(id) {
                            location.href = "edit_contract.php?contract_number=" + id;
                        };
                        function send(event, person, mobile, date, contract){
                            event.stopPropagation();

                            let mssg = " حضرة السيد/ة "+person+" نود اعلامكم بان عقد بوليصة التأمين رقم "+contract+" ينتهي بتاريخ "+date;    
                            ( function($) {
                            $(document).ready( function() {
                                $.ajax({
                                    url: 'https://www.bestsmsbulk.com/bestsmsbulkapi/sendSmsAPI.php?username=ghallak&&password=Ghallak@2022&&message='+mssg+'&&senderid=G.ELHALLAK&&destination=+961'+mobile,
                                    type: 'get',
                                    success: function(){
                                        alert("إرسال رسالة SMS ل "+ person);
                                    },
                                    error: function(error){
                                        alert("خطأ في إرسال الرسالة! يرجى التحقق من الرقم")
                                    }
                                })
                            })
                        } ) ( jQuery );
                            

                        }
                    </script>

                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> عقود العميل المنتهية</h3>
            </div>
            <?php

            $sql2 = "SELECT * FROM contract WHERE agent = '".$row['person_id']."' AND end_date < NOW() ORDER BY end_date DESC";
            $res2 = mysqli_query($con, $sql2);
            ?>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell">الزبون</th>
                                    <th class="cell"> رقم العقد</th>
                                    <th class="cell"> سعر العقد</th>
                                    <th class="cell"> حصة العميل</th>
                                    <th class="cell"> الصافي</th>
                                    <th class="cell"> نوع العقد</th>
                                    <th class="cell"> تاريخ الإنتهاء</th>
                                    <th class="cell"> الدفعات </th>
                                    <th class="cell"> الدفعات الباقية</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($res2); $i++) {
                                    $amount3=0;
                                    $row2 = mysqli_fetch_array($res2);
                                    $sql3 = "SELECT * FROM contract_type WHERE contract_type_id = '" . $row2['contract_type_id'] . "'";
                                    $res3 = mysqli_query($con, $sql3);
                                    $row3 = mysqli_fetch_array($res3);
                                    $qq2 = "SELECT * FROM person WHERE person_id = '" . $row2['person_id'] . "'";
                                    $rr2 = mysqli_query($con, $qq2);
                                    $roww22 = mysqli_fetch_array($rr2);
                                    $rest2 = $row2['price']-$row2['agent_portion'];
                                    $sql42 = "SELECT * FROM client_expenses WHERE contract_id = '" . $row2['contract_id'] . "'";
                                     $resultat42 = mysqli_query($con, $sql42);
                                     if(mysqli_num_rows($resultat42)!=0){
                                         for($i=0;$i<mysqli_num_rows($resultat42);$i++){
                                            $rowww2=mysqli_fetch_array($resultat42);
                                            
                                            $amount3 += $rowww2['required_amount'];
                                         }
                                         $amount4 = $row2['price'] - $amount3;
                                     }else $amount4 = $row2['price'];
                                    echo "<tr class='row2' onclick='exxx(\"".$row2['contract_number']."\")'>";
                                    echo "<td data-title='الزبون'>" . $roww22['person_name'] . "</td>";
                                    echo "<td data-title='رقم العقد'>" . $row2['contract_number'] . "</td>";
                                    echo "<td data-title='سعر العقد'>" . $row2['price'] . "</td>";
                                    echo "<td  data-title='حصة العميل'>" . $row2['agent_portion'] . "</td>";
                                    echo "<td data-title='الصافي'>" .$rest2 . "</td>";
                                    echo "<td data-title='نوع العقد'>" . $row3['type'] . "</td>";
                                    echo "<td data-title='تاريخ الإنتهاء'>" . $row2['end_date'] . "</td>";
                                    echo "<td data-title='الدفعات '>" .$amount3 . "</td>";
                                    echo "<td data-title='الدفعات الباقية'>" .$amount4 . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                    <script type="text/javascript">
                         function exxx(id) {
                            location.href = "edit_contract.php?contract_number=" + id;
                        };
                    </script>

                </div>
            </div>
            </div>
        </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/agent_search.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {

$('#sidebutton').on('click', function () {
    console.log("click event");
    console.log($('#sidebar'));
    var bar=$("#sidebar");
    var main=$("#main");
    if(bar && bar.hasClass("active"))
    {bar.removeClass("active");
    main.removeClass("active");
    }
    else 
    {
    main.addClass("active");
    bar.addClass("active");
    }
});

});
    </script>
</body>

</html>