<?php
include_once "connection.php";
if (session_status() == PHP_SESSION_NONE) {
    //session has not started
    session_start();
    if(empty($_SESSION["wp20admin"])) {
        header('Location: index.php');
    }
} 
$client_expenses_id = $_GET['client_expenses_id'];
$sql = "SELECT * FROM client_expenses WHERE client_expenses_id = '$client_expenses_id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_array($res);
$sql2 = "SELECT * FROM person WHERE person_id = '" . $row['client_id'] . "'";
$res1 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($res1);
$sql3 = "SELECT * FROM contract WHERE person_id = '" . $row['client_id'] . "'";
$res3 = mysqli_query($con, $sql3);
$req2 = 0;
if (!isset($_GET['contract_id'])) {
    $contract_id = null;
} else $contract_id = $_GET['contract_id'];
if ($contract_id == null) {
    $sql6 = "SELECT * FROM contract WHERE contract_id = '" . $row['contract_id'] . "'";
    $res6 = mysqli_query($con, $sql6);
    $row6 = mysqli_fetch_array($res6);
    $sql7 = "SELECT * FROM client_expenses WHERE client_id = '" . $row['client_id'] . "' AND contract_id = '" . $row['contract_id'] . "'";
    $res7 = mysqli_query($con, $sql7);
    for ($i = 0; $i < mysqli_num_rows($res7); $i++) {
        $row7 = mysqli_fetch_array($res7);
        $req2 += $row7['required_amount'];
    }
    $rest =  $row6['price'] - $req2 + $row['required_amount'];
} else {
    if ($contract_id != $row['contract_id']) {
        $sql6 = "SELECT * FROM contract WHERE contract_id = '$contract_id'";
        $res6 = mysqli_query($con, $sql6);
        $row6 = mysqli_fetch_array($res6);
        $sql7 = "SELECT * FROM client_expenses WHERE client_id = '" . $row['client_id'] . "' AND contract_id = '$contract_id'";
        $res7 = mysqli_query($con, $sql7);
        for ($i = 0; $i < mysqli_num_rows($res7); $i++) {
            $row7 = mysqli_fetch_array($res7);
            $req2 += $row7['required_amount'];
        }
        $rest =  $row6['price'] - $req2;
    } else header('Location: edit_client_expenses.php?client_expenses_id=' . $client_expenses_id);


    // if (mysqli_num_rows($res7) > 1) {
    //     mysqli_data_seek($res7, mysqli_num_rows($res7) - 1);
    //     $rest = $row6['price'] - $row7['required_amount'];
    // } else $rest = $row6['price'];
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
                                <li class="submenu-item active">
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
                <h3>تعديل دفعة</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="edit_client_expenses_inter.php?client_expenses_id=<?php echo $client_expenses_id; ?>" method="post">
                                <div class="form-group">
                                    <label for="client">الزبون*</label>
                                    <input type="text" class="form-control" id="client" name="client" value="<?php echo $row2['person_name']; ?>" readonly>
                                    <div class="list-group list-group-item-action" id="contents"></div>
                                </div>
                                <div class="form-group">
                                    <label for="contract">  العقد* :</label>
                                    <select name="contract" class="btn btn-light dropdown-toggle dropdown-toggle-split" onchange="refresh()" id="contract" required>

                                        <?php
                                        mysqli_data_seek($res3, 0);
                                        for ($i = 0; $i < mysqli_num_rows($res3); $i++) {
                                            $row4 = mysqli_fetch_array($res3);
                                            if ($contract_id == null) {
                                                if ($row['contract_id'] == $row4['contract_id']) {
                                                    echo "<option class='dropdown-item' value=" . $row4['contract_id'] . " selected>" . $row4['contract_number'] . "</option>";
                                                } else {
                                                    echo "<option class='dropdown-item' value=" . $row4['contract_id'] . ">" . $row4['contract_number'] . "</option>";
                                                }
                                            } else {
                                                if ($contract_id == $row4['contract_id']) {
                                                    echo "<option class='dropdown-item' value=" . $row4['contract_id'] . " selected>" . $row4['contract_number'] . "</option>";
                                                } else {
                                                    echo "<option class='dropdown-item' value=" . $row4['contract_id'] . ">" . $row4['contract_number'] . "</option>";
                                                }
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>

                                <script>
                                    function refresh() {
                                        var contract = document.getElementById("contract");
                                        var id = <?php echo json_decode($client_expenses_id); ?>;
                                        var select = contract.value;
                                        location.href = "edit_client_expenses.php?client_expenses_id=" + id + "&contract_id=" + select;
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
                                    <input type="date" class="form-control" id="payday" name="payday" value="<?php echo $row['payday']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="next_payday">تاريخ الدفعة القادمة</label>
                                    <input type="date" class="form-control" id="next_payday" name="next_payday" value="<?php echo $row['next_paydate']; ?>" >
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
                                            $rowww = mysqli_fetch_array($resultat);
                                            if ($row['bank_id'] == $rowww['bank_id']) {
                                                echo "<option class='dropdown-item' value=" . $rowww['bank_id'] . " selected>" . $rowww['bank_name'] . "</option>";
                                            } else {
                                                echo "<option class='dropdown-item' value=" . $rowww['bank_id'] . ">" . $rowww['bank_name'] . "</option>";
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <label for="gift">هدية</label>
                                        <?php
                                        $gift = $row['gift'];

                                        if ($gift == "0") {
                                            echo "<input class='form-check-input' type='checkbox' id='gift' name='gift'>";
                                        } else {
                                            echo "<input class='form-check-input' type='checkbox' id='gift' name='gift' checked>";
                                        }
                                        ?>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="btn btn-primary"> تعديل الدفعة</button>
                    <a href="Clients_expenses.php" name="back" class="btn btn-danger"> رجوع </a>
                    <a href="delete_client_expenses.php?client_expenses_id=<?php echo $client_expenses_id; ?>" class="btn btn-danger" id="delete_btn" onclick="return confirm('هل أنت متأكد ؟')">حذف الدفعة </a>
                </div>
                </form>

            </div>
        </div>
        </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/search5.js"></script>
        <script src="assets/js/search6.js"></script>
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