<?php
include_once "connection.php";
if (session_status() == PHP_SESSION_NONE) {
    //session has not started
    session_start();
    if (empty($_SESSION["wp20admin"])) {
        header('Location: index.php');
    }
}
?>
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

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">

</head>

<body>

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
                        <li class="sidebar-item active">
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
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>تعديل عقد</h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <?php
                            $contract_number = $_GET['contract_number'];
                            $sql = "SELECT * FROM contract WHERE contract_number = '$contract_number'";
                            $result = mysqli_query($con, $sql) or die(mysqli_error($con));
                            $row = mysqli_fetch_array($result);

                            $sql1 = "SELECT * FROM person WHERE person_id = '" . $row['person_id'] . "'";
                            $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
                            $row1 = mysqli_fetch_array($result1);
                            // echo "person_id".$row['person_id'];
                            // echo "person_name".$row1['person_name'];
                            ?>
                            <form action="edit_contract_inter.php?contract_number=<?php echo $contract_number; ?>" method="post" id="myform">
                                <div class="form-group">
                                    <label for="search2">الزبون* </label>
                                    <input type="text" class="form-control" id="search2" name="search2" value="<?php echo $row1['person_name']; ?>" required>
                                </div>

                                <div class="list-group list-group-item-action" id="content2"></div>
                                <script>
                                    function func(e) {

                                        document.getElementById("search2").value = e.target.innerHTML;
                                        $('#content2').html('');
                                    }
                                </script>

                                <div class="form-group">
                                    <label for="num">رقم العقد* </label>
                                    <input type="text" class="form-control" id="num" name="num" value="<?php echo $contract_number; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="type">نوع العقد* :</label>
                                    <select name="type" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="type" required>

                                        <?php
                                        $query = "SELECT * FROM contract_type";
                                        $resultat = mysqli_query($con, $query);

                                        for ($i = 0; $i < mysqli_num_rows($resultat); $i++) {
                                            $roww = mysqli_fetch_array($resultat);
                                            if($row['contract_type_id'] == $roww['contract_type_id']){
                                                echo "<option class='dropdown-item' value=" . $roww['contract_type_id'] . " selected>" . $roww['type'] . "</option>";
                                            }
                                            else echo "<option class='dropdown-item' value=" . $roww['contract_type_id'] . ">" . $roww['type'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="com">شركة التأمين* :</label>
                                    <select name="com" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="com" required>

                                        <?php
                                        $query2 = "SELECT * FROM company";
                                        $resultat2 = mysqli_query($con, $query2);

                                        for ($i = 0; $i < mysqli_num_rows($resultat2); $i++) {
                                            $roww2 = mysqli_fetch_array($resultat2);
                                            if($row['company_id'] == $roww2['company_id']){
                                                echo "<option class='dropdown-item' value=" . $roww2['company_id'] . " selected>" . $roww2['company_name'] . "</option>";
                                            }
                                            else echo "<option class='dropdown-item' value=" . $roww2['company_id'] . ">" . $roww2['company_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="agent">الوسيط* :</label>
                                    <select name="agent" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="agent" required>

                                        <?php
                                        $query3 = "SELECT * FROM person JOIN types ON person.person_id = types.person_id AND types.person_type_id = '2'";
                                        $resultat3 = mysqli_query($con, $query3);
                                        // var_dump($resultat3);

                                        for ($i = 0; $i < mysqli_num_rows($resultat3); $i++) {
                                            $roww3 = mysqli_fetch_array($resultat3);
                                            if($row['agent'] == $roww3['person_id']){
                                                echo "<option class='dropdown-item' value=" . $roww3['person_id'] . " selected>" . $roww3['person_name'] . "</option>";
                                            }
                                            else echo "<option class='dropdown-item' value=" . $roww3['person_id'] . ">" . $roww3['person_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="begin">تاريخ إبتداء العقد* </label>
                                    <input type="date" class="form-control" id="begin" name="begin" value="<?php echo $row['start_date']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="end">تاريخ إنتهاء العقد* </label>
                                    <input type="date" class="form-control" id="end" name="end" value="<?php echo $row['end_date']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">سعر العقد* </label>
                                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="office"> حصة المكتب*</label>
                                    <input type="text" class="form-control" id="office" name="office" value="<?php echo $row['office_portion']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="agent_potion"> حصة الوسيط*</label>
                                    <input type="text" class="form-control" id="agent_potion" name="agent_potion" value="<?php echo $row['agent_portion']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description"> تعريف العقد </label>
                                    <input type="text" class="form-control" id="description" name="description" value="<?php echo $row['description']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="info">البوليصة </label>
                                    <input type="text" class="form-control" id="info" name="info" value="<?php echo $row['info']; ?>">
                                </div>
                                <div class="form-group">
                                    <!-- <div id="content3"></div> -->

                                    <label for="car"> السيارة :</label>
                                    <select name="car" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="car">

                                        <?php
                                        // echo "<script> document.writeln(person); </script>";

                                        $query5 = "SELECT * FROM car WHERE person_id = '" . $row1['person_id'] . "'";
                                        $resultat5 = mysqli_query($con, $query5);
                                        echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                        for ($i = 0; $i < mysqli_num_rows($resultat5); $i++) {
                                            $row5 = mysqli_fetch_array($resultat5);
                                            $query6 = "SELECT * FROM car_name WHERE car_name_id = '" . $row5['car_name_id'] . "'";
                                            $result6 = mysqli_query($con, $query6);
                                            $row6 = mysqli_fetch_array($result6);
                                            if($row['car_id'] == $row5['car_id']){
                                                echo "<option class='dropdown-item' value=" . $row5['car_id'] . " selected>" . $row6['name'] . " || ".$row5['car_number']."</option>";
                                            }
                                            else echo "<option class='dropdown-item' value=" . $row5['car_id'] . ">" . $row6['name'] . " || ".$row5['car_number']."</option>";

                                        }

                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="estate"> رقم العقار </label>
                                    <input type="text" class="form-control" id="estate" name="estate" value="<?php echo $row['real_estate_number']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="workers"> عدد العمال </label>
                                    <input type="text" class="form-control" id="workers" name="workers" value="<?php echo $row['workers_number']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="worker_salary">معاش العامل</label>
                                    <input type="text" class="form-control" id="worker_salary" name="worker_salary" value="<?php echo $row['worker_salary']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="emp_salary"> معاش المعلم </label>
                                    <input type="text" class="form-control" id="emp_salary" name="emp_salary" value="<?php echo $row['employer_salary']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="degree"> درجات الإصابة </label>
                                    <input type="text" class="form-control" id="degree" name="degree" value="<?php echo $row['injury_degree']; ?>" </div>
                                    <div class="form-group">
                                        <label for="value"> قيمة الغرض </label>
                                        <input type="text" class="form-control" id="value" name="value" value="<?php echo $row['value']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="maid"> معلومات الخادم/ة</label>
                                        <input type="text" class="form-control" id="maid" name="maid" value="<?php echo $row['housemaid_info']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <label for="finished">منتهي</label>
                                            <?php
                                            $check = $row['isFinished'];
                                            if ($check == "0") {
                                                echo "<input class='form-check-input' type='checkbox' id='finished' name='finished'>";
                                            } else if ($check == "1") {
                                                echo "<input class='form-check-input' type='checkbox' id='finished' name='finished' checked>";
                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <br>
                    <div class="buttons">
                        <button type="submit" name="submit" class="btn btn-primary"> تعديل العقد</button>
                        <a href="contracts.php" class="btn btn-danger"> رجوع</a>
                        <?php
                        $sql5 = "SELECT * FROM client_expenses WHERE contract_id = '" . $row['contract_id'] . "'";
                        $res5 = mysqli_query($con, $sql5) or die(mysqli_error($con));
                        $sql6 = "SELECT * FROM accident_cost WHERE contract_id = '" . $row['contract_id'] . "'";
                        $res6 = mysqli_query($con, $sql6)  or die(mysqli_error($con));
                        $sql7 = "SELECT * FROM companies_expenses WHERE contract_id = '" . $row['contract_id'] . "'";
                        $res7 = mysqli_query($con, $sql7) or die(mysqli_error($con));
                        $sql8 = "SELECT * FROM agent_expenses WHERE contract_id = '" . $row['contract_id'] . "'";
                        $res8 = mysqli_query($con, $sql8) or die(mysqli_error($con));
                        if (mysqli_num_rows($res5) != 0 || mysqli_num_rows($res6) != 0 || mysqli_num_rows($res7) != 0 || mysqli_num_rows($res8) != 0) { ?>
                            <a class="btn btn-danger" onclick="mssg()" id="delete_btn">حذف العقد </a>
                            <script>
                                function mssg() {
                                    alert("لا يمكنك حذف هذا العقد");
                                }
                            </script>

                        <?php
                        } else { ?>
                            <a href="delete_contract.php?contract_number=<?php echo $contract_number; ?>" id="delete_btn" class="btn btn-danger" onclick="return confirm('هل أنت متأكد ؟');">حذف العقد </a>
                        <?php }
                        ?>

                    </div>
                    </form>
                </div>
            </div>

            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> الحوادث</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> رقم الحادث</th>
                                    <th class="cell"> التكلفة</th>
                                    <th class="cell"> تاريخ التكلفة</th>
                                    <th class="cell"> المتضرر</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($res6); $i++) {
                                    $row6 = mysqli_fetch_array($res6);

                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $row6['accident_id'] . "</td>";
                                    echo "<td class='cell'>" . $row6['cost'] . "</td>";
                                    echo "<td class='cell'>" . $row6['date'] . "</td>";
                                    echo "<td class='cell'>" . $row6['afflicted'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> دفعات الزبون</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> الزبون</th>
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell"> التاريخ </th>
                                    <th class="cell"> رقم الشيك</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($res5); $i++) {
                                    $row51 = mysqli_fetch_array($res5);
                                    $sql9 = "SELECT * FROM person WHERE person_id = '" . $row51['client_id'] . "'";
                                    $res9 = mysqli_query($con, $sql9);
                                    $row9 = mysqli_fetch_array($res9);
                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $row9['person_name'] . "</td>";
                                    echo "<td class='cell'>" . $row51['required_amount'] . "</td>";
                                    echo "<td class='cell'>" . $row51['payday'] . "</td>";
                                    echo "<td class='cell'>" . $row51['check_number'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> دفعات الشركات</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> الشركة</th>
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell"> التاريخ </th>
                                    <th class="cell"> رقم الشيك</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($res7); $i++) {
                                    $row7 = mysqli_fetch_array($res7);
                                    $sql10 = "SELECT * FROM company WHERE company_id = '" . $row7['company_id'] . "'";
                                    $res10 = mysqli_query($con, $sql10);
                                    $row10 = mysqli_fetch_array($res10);
                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $row10['company_name'] . "</td>";
                                    echo "<td class='cell'>" . $row7['required_amount'] . "</td>";
                                    echo "<td class='cell'>" . $row7['date'] . "</td>";
                                    echo "<td class='cell'>" . $row7['check_number'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> دفعات العميل</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> العميل</th>
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell"> التاريخ </th>
                                    <th class="cell"> رقم الشيك</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($res8); $i++) {
                                    $row8 = mysqli_fetch_array($res8);
                                    $sql11 = "SELECT * FROM person WHERE person_id = '" . $row8['agent_id'] . "'";
                                    $res11 = mysqli_query($con, $sql11);
                                    $row11 = mysqli_fetch_array($res11);
                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $row11['person_name'] . "</td>";
                                    echo "<td class='cell'>" . $row8['required_amount'] . "</td>";
                                    echo "<td class='cell'>" . $row8['payday'] . "</td>";
                                    echo "<td class='cell'>" . $row8['check_number'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/search2.js"></script>
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