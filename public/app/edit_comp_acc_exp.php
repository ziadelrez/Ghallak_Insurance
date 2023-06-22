<?php
include_once "connection.php";
if (session_status() == PHP_SESSION_NONE) {
    //session has not started
    session_start();
    if(empty($_SESSION["wp20admin"])) {
        header('Location: index.php');
    }
} 
$id = $_GET['comp_acc_id'];
$sql = "SELECT * FROM companies_accident_expenses WHERE companies_accident_expenses_id = '$id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
$sql1 = "SELECT * FROM company WHERE company_id = '" . $row['company_id'] . "'";
$res1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);
$req2 = 0;
if (!isset($_GET['accident_id'])) {
    $accident = null;
    $sql8 = "SELECT * FROM accident_cost WHERE accident_cost_id='" . $row['accident_cost_id'] . "'";
    $res8 = mysqli_query($con, $sql8);
    $row8 = mysqli_fetch_array($res8);
    $sql7 = "SELECT * FROM companies_accident_expenses WHERE accident_cost_id = '" . $row['accident_cost_id'] . "'";
    $res7 = mysqli_query($con, $sql7);
    for ($i = 0; $i < mysqli_num_rows($res7); $i++) {
        $row7 = mysqli_fetch_array($res7);
        $req2 += $row7['required_amount'];
    }

    $rest = $row8['cost'] - $req2 + $row['required_amount'];
    // echo $rest;
    // echo $req2;
    // var_dump($res8);
    // var_dump($res7);
} else {
    $accident = $_GET['accident_id'];
    $rest=0;
    if (!isset($_GET['accident_cost'])) {
        $accident_cost = null;
    } else {
        $accident_cost = $_GET['accident_cost'];

        $sql8 = "SELECT * FROM accident_cost WHERE accident_cost_id='$accident_cost'";
        $res8 = mysqli_query($con, $sql8);
        $row8 = mysqli_fetch_array($res8);
        $sql7 = "SELECT * FROM companies_accident_expenses WHERE accident_cost_id = '$accident_cost'";
        $res7 = mysqli_query($con, $sql7);
        if (mysqli_num_rows($res7) !=0) {
            for ($i = 0; $i < mysqli_num_rows($res7); $i++) {
                $row7 = mysqli_fetch_array($res7);
                $req2 += $row7['required_amount'];
            }
            $rest = $row8['cost'] - $req2;
        } else {
            $rest = $row8['cost'];
        }
    }
    if ($accident_cost == $row['accident_cost_id'] && $accident == $row['accident_id']) {
        header("Location: edit_comp_acc_exp.php?comp_acc_id=" . $id);
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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet"> -->
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
                <h3>تعديل دفعة</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="edit_comp_acc_exp_inter.php?comp_acc_exp_id=<?php echo $id; ?>" method="post">
                                <div class="form-group">
                                    <label for="expert">الشركة*</label>
                                    <input type="text" class="form-control" id="company" name="company" value="<?php echo $row1['company_name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="accident">الحادث* :</label>
                                    <select name="accident" class="btn btn-light dropdown-toggle dropdown-toggle-split" onchange="refresh1()" id="accident" required>

                                        <?php
                                        $sql4 = "SELECT * FROM accident_cost JOIN contract ON accident_cost.contract_id = contract.contract_id
                                   AND contract.company_id = '" . $row['company_id'] . "'";
                                        $resultat4 = mysqli_query($con, $sql4);

                                        for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {
                                            $row4 = mysqli_fetch_array($resultat4);
                                            if ($accident == null) {

                                                if ($row['accident_id'] == $row4['accident_id']) {
                                                    echo "<option class='dropdown-item' value=" . $row4['accident_id'] . " selected>" . $row4['accident_id'] . "</option>";
                                                } else {
                                                    echo "<option class='dropdown-item' value=" . $row4['accident_id'] . ">" . $row4['accident_id'] . "</option>";
                                                }
                                            } else {
                                                if ($accident == $row4['accident_id']) {
                                                    echo "<option class='dropdown-item' value=" . $row4['accident_id'] . " selected>" . $row4['accident_id'] . "</option>";
                                                } else {
                                                    echo "<option class='dropdown-item' value=" . $row4['accident_id'] . ">" . $row4['accident_id'] . "</option>";
                                                }
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                                <script>
                                    function refresh1() {
                                        var person = <?php echo json_decode($id) ?>;
                                        var acc = document.getElementById("accident");
                                        var select = acc.value;
                                        location.href = "edit_comp_acc_exp.php?comp_acc_id=" + person + "&accident_id=" + select;
                                    }
                                </script>
                                <div class="form-group">
                                    <label for="accident_cost"> تفصيل الحادث* :</label>
                                    <select name="accident_cost" class="btn btn-light dropdown-toggle dropdown-toggle-split" onchange="refresh2()" id="accident_cost" required>

                                        <?php

                                        if ($accident == null) {
                                            $sql5 = "SELECT * FROM accident_cost JOIN contract ON accident_cost.contract_id=contract.contract_id AND
                                            accident_cost.accident_id = '".$row['accident_id']."' AND contract.company_id='" . $row['company_id'] . "'";
                                            $resultat5 = mysqli_query($con, $sql5);
                                            for ($i = 0; $i < mysqli_num_rows($resultat5); $i++) {
                                                $row5 = mysqli_fetch_array($resultat5);
                                                if ($row['accident_cost_id'] == $row5['accident_cost_id']) {
                                                    echo "<option class='dropdown-item' value=" . $row5['accident_cost_id'] . " selected>" . $row5['cost'] . " | " . $row5['date'] . "</option>";
                                                } else {
                                                    echo "<option class='dropdown-item' value=" . $row5['accident_cost_id'] . ">" . $row5['cost'] . " | " . $row5['date'] . "</option>";
                                                }
                                            }
                                        } else {
                                            $sql6 = "SELECT * FROM accident_cost JOIN contract ON accident_cost.contract_id=contract.contract_id AND
                                            accident_cost.accident_id = '$accident' AND contract.company_id='" . $row['company_id'] . "'";
                                            $resultat6 = mysqli_query($con, $sql6);
                                            echo "<option class='dropdown-item' value=0>NOT SELECTED</option>";
                                            for ($i = 0; $i < mysqli_num_rows($resultat6); $i++) {
                                                $row6 = mysqli_fetch_array($resultat6);
                                                if ($accident_cost == $row6['accident_cost_id']) {
                                                    echo "<option class='dropdown-item' value=" . $row6['accident_cost_id'] . " selected>" . $row6['cost'] . " | " . $row6['date'] . "</option>";
                                                } else {
                                                    echo "<option class='dropdown-item' value=" . $row6['accident_cost_id'] . ">" . $row6['cost'] . " | " . $row6['date'] . "</option>";
                                                }
                                            }
                                        }

                                        ?>

                                    </select>
                                </div>
                                <script>
                                    function refresh2() {
                                        var person = <?php echo json_decode($id) ?>;
                                        //var accident = <?php echo json_decode($accident) ?>;
                                        var accident = document.getElementById("accident");
                                        var select1 = accident.value;
                                        var acc = document.getElementById("accident_cost");
                                        var select = acc.value;
                                        location.href = "edit_comp_acc_exp.php?comp_acc_id=" + person + "&accident_id=" + select1 + "&accident_cost=" + select;
                                    }
                                </script>
                                <div class="form-group">
                                    <label for="rest_amount">المبلغ المتبقي دفعه بالدولار</label>
                                    <input type="text" class="form-control" id="rest_amount" name="rest_amount" value="<?php echo $rest; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="required_amount">قيمة الدفعة الإلزامي بالدولار*</label>
                                    <input type="text" class="form-control" id="required_amount" name="required_amount" value="<?php echo $row['required_amount']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="LL">قيمة الدفعة باللبناني</label>
                                    <input type="text" class="form-control" id="LL" name="LL" value="<?php echo $row['lebanese_amount']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="payday">تاريخ الدفعة*</label>
                                    <input type="date" class="form-control" id="payday" name="payday" value="<?php echo $row['date']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="check_number">رقم الحوالة المصرفية</label>
                                    <input type="text" class="form-control" id="check_number" name="check_number" value="<?php echo $row['check_number']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="check">تاريخ تسديد الشيك</label>
                                    <input type="date" class="form-control" id="check" name="check" value="<?php echo $row['check_date']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="bank">البنك :</label>
                                    <select name="bank" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="bank" required>

                                        <?php
                                        $query = "SELECT * FROM bank";
                                        $resultat = mysqli_query($con, $query);
                                        echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                        for ($i = 0; $i < mysqli_num_rows($resultat); $i++) {
                                            $row6 = mysqli_fetch_array($resultat);
                                            if ($row['bank_id'] == $row6['bank_id']) {
                                                echo "<option class='dropdown-item' value=" . $row6['bank_id'] . " selected>" . $row6['bank_name'] . "</option>";
                                            } else {
                                                echo "<option class='dropdown-item' value=" . $row6['bank_id'] . ">" . $row6['bank_name'] . "</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="btn btn-primary"> تعديل دفعة</button>
                    <a href="companies_expenses.php" name="back" class="btn btn-danger"> رجوع </a>
                    <a href="delete_comp_acc_expenses.php?comp_acc_expenses_id=<?php echo $id; ?>" class="btn btn-danger" id="delete_btn" onclick="return confirm('هل أنت متأكد ؟')">حذف الدفعة </a>
                </div>
                </form>

            </div>
        </div>
        </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/search9.js"></script>
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