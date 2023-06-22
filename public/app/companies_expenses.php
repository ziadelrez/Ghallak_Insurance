<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallak Insurance</title>
    <link rel = "icon" href ="logo (1).png" type = "image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">

</head>

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
                        <li class="sidebar-item">
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
                            <ul class="submenu active">
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
                                <li class="submenu-item active">
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

            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>بحث عن شركة</h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="company_search" name="company_search" placeholder="بحث">
                                </div>
                                <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->
                            </form>
                            <div class="list-group list-group-item-action" id="company_content"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>إضافة دفعة</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="add_comp_exp_inter.php" method="post">
                                <div class="form-group">
                                    <label for="comp">الشركة*</label>
                                    <input type="text" class="form-control" id="comp" name="comp" required>
                                    <div class="list-group list-group-item-action" id="comp_content"></div>
                                </div>
                                <script>
                                    function search_comp(e) {

                                        document.getElementById("comp").value = e.target.innerHTML;
                                        $('#comp_content').html('');
                                        var someVarName4 = document.getElementById("comp").value;
                                        localStorage.setItem("someVarKey4", someVarName4);
                                        var comp = document.getElementById("comp").value;
                                        location.href = "companies_expenses.php?company=" + comp;
                                    }

                                    var s4 = localStorage.getItem("someVarKey4");

                                    document.getElementById("comp").value = s4;
                                    //console.log(sss);
                                    //localStorage.removeItem("someVarKey");
                                </script>
                                <?php
                                $total = 0;
                                if (!isset($_GET['company'])) {
                                    $total = 0;
                                    $company = NULL;
                                } else {
                                    $company = $_GET['company'];
                                    $query3 = "SELECT * FROM company WHERE company_name = '$company'";
                                    $resultat3 = mysqli_query($con, $query3);
                                    $row3 = mysqli_fetch_array($resultat3);
                                    $sql4 = "SELECT * FROM contract WHERE company_id = '" . $row3['company_id'] . "'";
                                    $resultat4 = mysqli_query($con, $sql4);
                                    $req2 = 0;
                                    for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {
                                        $row4 = mysqli_fetch_array($resultat4);
                                        $total += $row4['price'] - $row4['office_portion'];
                                    }
                                    $sql5 = "SELECT * FROM companies_expenses WHERE company_id = '" . $row3['company_id'] . "'";
                                    $resultat5 = mysqli_query($con, $sql5);
                                    if (mysqli_num_rows($resultat5) != 0) {
                                        // echo "hey";
                                        for ($i = 0; $i < mysqli_num_rows($resultat5); $i++) {
                                            $rowww = mysqli_fetch_array($resultat5);
                                            $req2 += $rowww['required_amount'];
                                        }
                                        $total = $total - $req2;
                                    }
                                }

                                ?>

                                <div class="form-group">
                                    <label for="total">المبلغ المتوجب دفعه بالدولار</label>
                                    <input type="text" class="form-control" id="total" name="total" value="<?php echo $total; ?>" readonly>
                                </div>
                                <?php
                                if (!isset($_GET['contract'])) {
                                    $contract = NULL;
                                } else {
                                    $contract = $_GET['contract'];
                                } ?>
                                <div class="form-group">
                                    <label for="contract"> العقد* </label>
                                    <input type="text" class="form-control" id="contract_search" name="contract_search" onkeyup="myFunction()" placeholder="بحث">

                                    <div class="container-table100" style="margin-top: 20px;">
                                        <div class="wrap-table100">
                                            <table class="table table-striped table-hover" id="table3">
                                                <thead>
                                                    <tr class="row2 header">
                                                        <th class="cell"> رقم العقد</th>
                                                        <th class="cell"> السعر </th>
                                                        <th class="cell"> الزبون</th>
                                                        <th class="cell"> العميل</th>
                                                        <th class="cell"> تاريخ الإبتداء</th>
                                                        <th class="cell"> تاريخ الإنتهاء</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="contract_table">
                                                    <?php
                                                    if ($company != null && $contract == null) {
                                                        $sql8 = "SELECT * FROM contract WHERE company_id = '" . $row3['company_id'] . "'";
                                                        $resultat8 = mysqli_query($con, $sql4);
                                                        for ($i = 0; $i < mysqli_num_rows($resultat8); $i++) {
                                                            $row8 = mysqli_fetch_array($resultat8);
                                                            $sql9 = "SELECT * FROM person WHERE person_id = '" . $row8['person_id'] . "'";
                                                            $res9 = mysqli_query($con, $sql9);
                                                            $row9 = mysqli_fetch_array($res9);
                                                            $sql10 = "SELECT * FROM person WHERE person_id = '" . $row8['agent'] . "'";
                                                            $res10 = mysqli_query($con, $sql10);
                                                            $row10 = mysqli_fetch_array($res10);
                                                            // if (isset($row2['person_name']) == null) {
                                                            //     $name = null;
                                                            // } else $name = $row2['person_name'];
                                                            echo "<tr class='row2' onClick='search_contract(\"".$row8['contract_number']."\")'>";
                                                            echo "<td>" . $row8['contract_number'] . "</td>";
                                                            echo "<td>" . $row8['price'] . "</td>";
                                                            echo "<td>" . $row9['person_name'] . "</td>";
                                                            echo "<td >" . $row10['person_name'] . "</td>";
                                                            echo "<td >" . $row8['start_date'] . "</td>";
                                                            echo "<td>" . $row8['end_date'] . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                    
                                <script>
                                    function refresh5() {
                                        var person = document.getElementById("comp").value;
                                        var acc = document.getElementById("contract_search");
                                        var select = acc.value;
                                        location.href = "companies_expenses.php?company=" + person + "&contract=" + select;
                                    }

                                    function search_contract(id) {
                                        document.getElementById("contract_search").value = id;
                                        $('#contract_content').html('');
                                        refresh5();
                                        console.log($('#contract_search').val());

                                    }
                                    var con = "<?php echo $contract ?>";
                                    document.getElementById('contract_search').value = con;
                                    function myFunction() {
                                        var filter = event.target.value.toUpperCase();
                                        var rows = document.querySelector("#table3").rows;

                                        for (var i = 0; i < rows.length; i++) {
                                            var firstCol = rows[i].cells[0].textContent.toUpperCase();
                                            var secondCol = rows[i].cells[1].textContent.toUpperCase();
                                            var thirdCol = rows[i].cells[2].textContent.toUpperCase();
                                            var fourthCol = rows[i].cells[3].textContent.toUpperCase();
                                            var fifthCol = rows[i].cells[4].textContent.toUpperCase();
                                            var sixthCol = rows[i].cells[5].textContent.toUpperCase();
                                            if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1 ||
                                                fifthCol.indexOf(filter) > -1 || sixthCol.indexOf(filter) > -1) {
                                                rows[i].style.display = "";
                                            } else {
                                                rows[i].style.display = "none";
                                            }
                                        }
                                    }
                                    document.querySelector('#contract_search').addEventListener('keyup', filterTable, false);

                                    function func(e) {

                                        document.getElementById("contract_search").value = e.target.innerHTML;
                                        // $('#content2').html('');
                                    }
                                </script>
                                <?php
                                if ($contract != NULL) {
                                     $req = 0;
                                     $query3 = "SELECT * FROM company WHERE company_name = '$company'";
                                        $resultat3 = mysqli_query($con, $query3);
                                        $row3 = mysqli_fetch_array($resultat3);

                                $qq = "SELECT * FROM contract WHERE contract_number = '$contract'";
                                $rr = mysqli_query($con, $qq);
                                $roww = mysqli_fetch_array($rr);
                                $sql = " SELECT * FROM companies_expenses WHERE contract_id='".$roww['contract_id']."'";
                                $res = mysqli_query($con, $sql) or die(mysqli_error($con));
                                if (mysqli_num_rows($res) != 0) {
                                    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                                        $row5 = mysqli_fetch_array($res);
                                        $req += $row5['required_amount'];
                                    }
                                    $rest = $roww['price'] - $req - $roww['office_portion'];
                                } else $rest = $roww['price'] - $roww['office_portion'];
                                } else {
                                  $rest = 0;
                                }
                               
                                ?>
                                <div class="form-group">
                                    <label for="rest_amount">المبلغ المتبقي دفعه بالدولار</label>
                                    <input type="text" class="form-control" id="rest_amount" name="rest_amount" value="<?php echo $rest; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="required_amount">قيمة الدفعة الإلزامي بالدولار*</label>
                                    <input type="text" class="form-control" id="required_amount" name="required_amount" required>
                                </div>
                                <div class="form-group">
                                    <label for="LL">قيمة الدفعة باللبناني</label>
                                    <input type="text" class="form-control" id="LL" name="LL">
                                </div>
                                <div class="form-group">
                                    <label for="payday">تاريخ الدفعة*</label>
                                    <input type="date" class="form-control" id="payday" name="payday" required>
                                </div>

                                <div class="form-group">
                                    <label for="check_number">رقم الحوالة المصرفية</label>
                                    <input type="text" class="form-control" id="check_number" name="check_number">
                                </div>
                                <div class="form-group">
                                    <label for="check">تاريخ تسديد الشيك</label>
                                    <input type="date" class="form-control" id="check" name="check">
                                </div>
                                <div class="form-group">
                                    <label for="bank">البنك :</label>
                                    <select name="bank" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="bank" required>

                                        <?php
                                        $query = "SELECT * FROM bank";
                                        $resultat = mysqli_query($con, $query);
                                        echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                        for ($i = 0; $i < mysqli_num_rows($resultat); $i++) {
                                            $row = mysqli_fetch_array($resultat);
                                            echo "<option class='dropdown-item' value=" . $row['bank_id'] . ">" . $row['bank_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" onclick="subfunc3()" class="btn btn-primary"> إضافة دفعة</button>
                </div>
                </form>
                <br>

                <h3> إضافة دفعة بدل حادث</h3>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="add_comp_acc_exp_inter.php" method="post">
                                <div class="form-group">
                                    <label for="comp1">الشركة*</label>
                                    <input type="text" class="form-control" id="comp1" name="comp1" required>
                                    <div class="list-group list-group-item-action" id="comp_contents"></div>
                                </div>
                                <script>
                                    function search_comp1(e) {

                                        document.getElementById("comp1").value = e.target.innerHTML;
                                        $('#comp_contents').html('');
                                        var someVarName5 = document.getElementById("comp1").value;
                                        localStorage.setItem("someVarKey5", someVarName5);
                                        var comp = document.getElementById("comp1").value;
                                        location.href = "companies_expenses.php?company_name=" + comp;
                                    }

                                    var s5 = localStorage.getItem("someVarKey5");

                                    document.getElementById("comp1").value = s5;
                                    //console.log(sss);
                                    //localStorage.removeItem("someVarKey");
                                </script>
                                <?php
                                $tot = 0;
                                if (!isset($_GET['company_name'])) {
                                    $company_name = NULL;
                                    $tot = 0;
                                } else {
                                    $company_name = $_GET['company_name'];
                                    $query13 = "SELECT * FROM company WHERE company_name = '$company_name'";
                                    $resultat13 = mysqli_query($con, $query13);
                                    $row13 = mysqli_fetch_array($resultat13);
                                    $sql14 = "SELECT * FROM accident_cost JOIN contract ON accident_cost.contract_id=contract.contract_id AND
                                    contract.company_id = '" . $row13['company_id'] . "'";
                                    $resultat14 = mysqli_query($con, $sql14);
                                    $req11 = 0;
                                    for ($i = 0; $i < mysqli_num_rows($resultat14); $i++) {
                                        $row14 = mysqli_fetch_array($resultat14);
                                        $tot += $row14['cost'];
                                    }
                                    $sql15 = "SELECT * FROM companies_accident_expenses WHERE company_id='" . $row13['company_id'] . "'";
                                    $resultat15 = mysqli_query($con, $sql15);
                                    if (mysqli_num_rows($resultat15) != 0) {
                                        for ($i = 0; $i < mysqli_num_rows($resultat15); $i++) {
                                            $row15 = mysqli_fetch_array($resultat15);
                                            $req11 += $row15['required_amount'];
                                        }
                                        $tot = $tot - $req11;
                                    }
                                }

                                ?>
                                <div class="form-group">
                                    <label for="total">المبلغ المتوجب دفعه بالدولار</label>
                                    <input type="text" class="form-control" id="total" name="total" value="<?php echo $tot; ?>" readonly>
                                </div>
                                <?php 
                                if (!isset($_GET['accident_id'])) {
                                            $accident_id = NULL;
                                        } else {
                                            $accident_id = $_GET['accident_id'];
                                        }
                                        ?>
                                <div class="form-group">
                                <label for="accident">الحادث* </label>
                                    <input type="text" class="form-control" id="accident_search" name="accident_search" onkeyup="myFunction1()" placeholder="بحث">
  
                                    <div class="container-table100" style="margin-top: 20px;">
                                        <div class="wrap-table100">
                                            <table class="table table-striped table-hover" id="table5">
                                                <thead>
                                                    <tr class="row2 header">
                                                        <th class="cell"> رقم الحادث</th>
                                                        <th class="cell"> الزبون </th>
                                                        <th class="cell"> التاريخ</th>
                                                        <th class="cell"> السيارة</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="accident_table">
                                                    <?php
                                                    if ($company_name != null && $accident_id == null) {
                                                        $sql8 = "SELECT * FROM accident JOIN accident_cost ON accident.accident_id = accident_cost.accident_id JOIN contract ON accident_cost.contract_id=contract.contract_id AND
        contract.company_id = '" . $row13['company_id'] . "'";
                                                        $resultat8 = mysqli_query($con, $sql8);
                                                        for ($i = 0; $i < mysqli_num_rows($resultat8); $i++) {
                                                            $row8 = mysqli_fetch_array($resultat8);
                                                            $sql9 = "SELECT * FROM person WHERE person_id = '" . $row8['person_id'] . "'";
                                                            $res9 = mysqli_query($con, $sql9);
                                                            $row9 = mysqli_fetch_array($res9);
                                                            $sql10 = "SELECT * FROM car WHERE car_id = '" . $row8['car_id'] . "'";
                                                            $res10 = mysqli_query($con, $sql10);
                                                            $row10 = mysqli_fetch_array($res10);
                                                            // if (isset($row2['person_name']) == null) {
                                                            //     $name = null;
                                                            // } else $name = $row2['person_name'];
                                                            echo "<tr class='row2' onClick='search_accident(\"".$row8['accident_id']."\")'>";
                                                            echo "<td>" . $row8['accident_id'] . "</td>";
                                                            echo "<td>" . $row9['person_name'] . "</td>";
                                                            echo "<td>" . $row8['date'] . "</td>";
                                                            echo "<td >" . $row10['car_number'] . "</td>";

                                                            echo "</tr>";
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        <?php
                                        
                                        $query13 = "SELECT * FROM company WHERE company_name = '$company_name'";
                                        $resultat13 = mysqli_query($con, $query13);
                                        $row12 = mysqli_fetch_array($resultat13);
                                        
                                        ?>
                                </div>
                                <?php
                                //var_dump($resultat14);
                                ?>
                                <script>
                                    function refresh6() {
                                        var person = document.getElementById("comp1").value;
                                        var acc = document.getElementById("accident_search");
                                        var select = acc.value;
                                        location.href = "companies_expenses.php?company_name=" + person + "&accident_id=" + select;
                                    }
                                    function search_accident(id) {
                                        document.getElementById("accident_search").value = id;
                                        
                                        // $('#contract_content').html('');
                                        refresh6();
                                        console.log(document.getElementById("accident_search").value);

                                    }
                                    var acc = "<?php echo $accident_id ?>";
                                    document.getElementById('accident_search').value = acc;
                                    
                                    function myFunction1() {
                                        var filter = event.target.value.toUpperCase();
                                        var rows = document.querySelector("#table5").rows;

                                        for (var i = 0; i < rows.length; i++) {
                                            var firstCol = rows[i].cells[0].textContent.toUpperCase();
                                            var secondCol = rows[i].cells[1].textContent.toUpperCase();
                                            var thirdCol = rows[i].cells[2].textContent.toUpperCase();
                                            var fourthCol = rows[i].cells[3].textContent.toUpperCase();
                                            if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1) {
                                                rows[i].style.display = "";
                                            } else {
                                                rows[i].style.display = "none";
                                            }
                                        }
                                    }
                                    document.querySelector('#accident_search').addEventListener('keyup', filterTable, false);

                                    function func(e) {

                                        document.getElementById("accident_search").value = e.target.innerHTML;
                                        // $('#content2').html('');
                                    }
                                </script>
                                <div class="form-group">
                                    <label for="accident_cost"> تفصيل الحادث* :</label>
                                    <select name="accident_cost" class="btn btn-light dropdown-toggle dropdown-toggle-split" onchange="refresh7()" id="accident_cost" required>

                                        <?php
                                    
                                        if (isset($_GET['accident_cost'])) {
                                            $accident_cost = $_GET['accident_cost'];
                                        } else $accident_cost = null;
                                        $sql16 = "SELECT * FROM accident_cost JOIN contract ON accident_cost.contract_id=contract.contract_id AND
                                   accident_cost.accident_id = '$accident_id' AND contract.company_id='" . $row12['company_id'] . "'";
                                        $resultat16 = mysqli_query($con, $sql16);
                                        echo "<option class='dropdown-item' value=0>NOT SELECTED</option>";
                                        for ($i = 0; $i < mysqli_num_rows($resultat16); $i++) {
                                            $row16 = mysqli_fetch_array($resultat16);
                                            if ($accident_cost == $row16['accident_cost_id']) {
                                                echo "<option class='dropdown-item' value=" . $row16['accident_cost_id'] . " selected>" . $row16['cost'] . " | " . $row16['date'] . "</option>";
                                            } else echo "<option class='dropdown-item' value=" . $row16['accident_cost_id'] . ">" . $row16['cost'] . " | " . $row16['date'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <script>
                                    function refresh7() {
                                        var person = document.getElementById("comp1").value;
                                        var acc = document.getElementById("accident_search");
                                        var select = acc.value;
                                        var cost = document.getElementById("accident_cost");
                                        var acc_cost = cost.value;
                                        location.href = "companies_expenses.php?company_name=" + person + "&accident_id=" + select + "&accident_cost=" + acc_cost;
                                    }
                                </script>
                                <?php
                               
                                if ($accident_cost != null) {
                                    $req12 = 0;
                                    $sql18 = "SELECT * FROM accident_cost WHERE accident_cost_id='$accident_cost'";
                                    $res18 = mysqli_query($con, $sql18);
                                    $row18 = mysqli_fetch_array($res18);
                                    $sql17 = "SELECT * FROM companies_accident_expenses WHERE accident_cost_id = '$accident_cost'";
                                    $res17 = mysqli_query($con, $sql17);
                                    
                                    if (mysqli_num_rows($res17) != 0) {
                                        for ($i = 0; $i < mysqli_num_rows($res17); $i++) {
                                            $row17 = mysqli_fetch_array($res17);
                                            $req12 += $row17['required_amount'];
                                        }

                                        $rest1 = $row18['cost'] - $req12;
                                    } else $rest1 = $row18['cost'];
                                } else $rest1 = 0;
                                ?>
                                <div class="form-group">
                                    <label for="rest_amount">المبلغ المتبقي دفعه بالدولار</label>
                                    <input type="text" class="form-control" id="rest_amount" name="rest_amount" value="<?php echo $rest1 ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="required_amount">قيمة الدفعة الإلزامي بالدولار*</label>
                                    <input type="text" class="form-control" id="required_amount" name="required_amount" required>
                                </div>
                                <div class="form-group">
                                    <label for="LL">قيمة الدفعة باللبناني</label>
                                    <input type="text" class="form-control" id="LL" name="LL">
                                </div>
                                <div class="form-group">
                                    <label for="payday">تاريخ الدفعة*</label>
                                    <input type="date" class="form-control" id="payday" name="payday" required>
                                </div>

                                <div class="form-group">
                                    <label for="check_number">رقم الحوالة المصرفية</label>
                                    <input type="text" class="form-control" id="check_number" name="check_number">
                                </div>
                                <div class="form-group">
                                    <label for="check">تاريخ تسديد الشيك</label>
                                    <input type="date" class="form-control" id="check" name="check">
                                </div>
                                <div class="form-group">
                                    <label for="bank">البنك :</label>
                                    <select name="bank" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="bank" required>

                                        <?php
                                        $query = "SELECT * FROM bank";
                                        $resultat = mysqli_query($con, $query);
                                        echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                        for ($i = 0; $i < mysqli_num_rows($resultat); $i++) {
                                            $row = mysqli_fetch_array($resultat);
                                            echo "<option class='dropdown-item' value=" . $row['bank_id'] . ">" . $row['bank_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit1" onclick="subfunc4()" class="btn btn-primary"> إضافة دفعة</button>
                </div>
                </form>
                <script>
                    function subfunc3() {
                        localStorage.removeItem("someVarKey4");
                        console.log("remved");
                    }

                    function subfunc4() {
                        localStorage.removeItem("someVarKey5");
                        console.log("remved");
                    }
                </script>
            </div>
        </div>
    </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/search10.js"></script>
        <script src="assets/js/search11.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
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