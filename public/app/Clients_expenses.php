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
                <h3>بحث عن زبون</h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search5" name="search5" placeholder="بحث">
                                </div>
                                <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->
                            </form>
                            <div class="list-group list-group-item-action" id="content5"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>إضافة دفعة</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="add_client_exp_inter.php" method="post">
                                <div class="form-group">
                                    <label for="client">الزبون*</label>
                                    <input type="text" class="form-control" id="client" name="client" required>
                                    <div class="list-group list-group-item-action" id="contents"></div>
                                </div>
                                <script>
                                    function search_client(e) {

                                        document.getElementById("client").value = e.target.innerHTML;
                                        $('#contents').html('');
                                        var someVarName = document.getElementById("client").value;
                                        localStorage.setItem("someVarKey", someVarName);
                                        var person = document.getElementById("client").value;
                                        location.href = "Clients_expenses.php?person=" + person;
                                    }

                                    var sss = localStorage.getItem("someVarKey");

                                    document.getElementById("client").value = sss;
                                    console.log(sss);
                                </script>
                                <?php
                                $total = 0;
                                if (!isset($_GET['person'])) {
                                    $person = NULL;
                                    $total = 0;
                                    $req = 0;
                                } else {
                                    $req = 0;
                                    $person = $_GET['person'];
                                    $query3 = "SELECT * FROM person WHERE person_name = '$person'";
                                    $resultat3 = mysqli_query($con, $query3);
                                    $row3 = mysqli_fetch_array($resultat3);
                                    $sql4 = "SELECT * FROM contract WHERE person_id = '" . $row3['person_id'] . "'";
                                    $resultat4 = mysqli_query($con, $sql4);
                                    for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {
                                        $row4 = mysqli_fetch_array($resultat4);
                                        $total += $row4['price'];
                                    }
                                    $sql5 = "SELECT * FROM client_expenses WHERE client_id = '" . $row3['person_id'] . "'";
                                    $resultat5 = mysqli_query($con, $sql5);
                                    if (mysqli_num_rows($resultat5) != 0) {
                                        // echo "hey";
                                        for ($i = 0; $i < mysqli_num_rows($resultat5); $i++) {
                                            $row5 = mysqli_fetch_array($resultat5);
                                            $req += $row5['required_amount'];
                                        }
                                        $total = $total - $req;
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
                                }
                                ?>
                                <div class="form-group">
                                    <label for="contract"> العقد* </label>
                                    <input type="text" class="form-control" id="contract_search" name="contract_search" onkeyup="myFunction()" placeholder="بحث">

                                    <div class="container-table100" style="margin-top: 20px;">
                                        <div class="wrap-table100">
                                            <table class="table table-striped table-hover" id="table1">
                                                <thead>
                                                    <tr class="row2 header">
                                                        <th class="cell"> رقم العقد</th>
                                                        <th class="cell"> السعر </th>
                                                        <th class="cell"> الشركة</th>
                                                        <th class="cell"> العميل</th>
                                                        <th class="cell"> تاريخ الإبتداء</th>
                                                        <th class="cell"> تاريخ الإنتهاء</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="contract_table">
                                                    <?php
                                                    if ($person != null  && $contract == null) {
                                                        $sql8 = "SELECT * FROM contract WHERE person_id = '" . $row3['person_id'] . "'";
                                                        $resultat8 = mysqli_query($con, $sql4);
                                                        for ($i = 0; $i < mysqli_num_rows($resultat8); $i++) {
                                                            $row8 = mysqli_fetch_array($resultat8);
                                                            $sql9 = "SELECT * FROM person WHERE person_id = '" . $row8['agent'] . "'";
                                                            $res9 = mysqli_query($con, $sql9);
                                                            $row9 = mysqli_fetch_array($res9);
                                                            $sql10 = "SELECT * FROM company WHERE company_id = '" . $row8['company_id'] . "'";
                                                            $res10 = mysqli_query($con, $sql10);
                                                            $row10 = mysqli_fetch_array($res10);
                                                            // if (isset($row2['person_name']) == null) {
                                                            //     $name = null;
                                                            // } else $name = $row2['person_name'];
                                                            echo "<tr class='row2' onClick='search_contract(\"".$row8['contract_number']."\")'>";
                                                            echo "<td>" . $row8['contract_number'] . "</td>";
                                                            echo "<td>" . $row8['price'] . "</td>";
                                                            echo "<td>" . $row10['company_name'] . "</td>";
                                                            echo "<td >" . $row9['person_name'] . "</td>";
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
                               
                                    function refresh() {
                                        var contract = document.getElementById("contract_search");
                                        var person = document.getElementById("client").value;
                                        var select = contract.value;
                                        console.log("contract"+ select);
                                        // localStorage.setItem("contract", select);
                                        location.href = "Clients_expenses.php?person=" + person + "&contract=" + select;
                                        //  $("#contract_search").text(select);
                                    }

                                    function search_contract(id) {
                                        document.getElementById("contract_search").value = id;
                                    //   $("#contract_search").text(id);
                                        // $('#contract_content').html('');
                                        refresh();
                                        console.log($('#contract_search').val());
                                        // $("#contract_search").text(id1);

                                    }
                                    var con = "<?php echo $_GET['contract']; ?>";
                                    document.getElementById('contract_search').value = con;
                                    function myFunction() {
                                        var filter = event.target.value.toUpperCase();
                                        var rows = document.querySelector("#table1").rows;

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
                                    
                                    $query3 = "SELECT * FROM person WHERE person_name = '$person'";
                                    $resultat3 = mysqli_query($con, $query3);
                                    $row3 = mysqli_fetch_array($resultat3);

                                    $sql6 = "SELECT * FROM contract WHERE contract_number = '$contract' AND person_id = '".$row3['person_id'] . "'";
                                    $res6 = mysqli_query($con, $sql6);
                                    $row6 = mysqli_fetch_array($res6);

                                    $sql7 = "SELECT * FROM client_expenses WHERE contract_id = '" . $row6['contract_id'] . "' AND client_id='" . $row3['person_id'] . "'";
                                    $res7 = mysqli_query($con, $sql7) ;
                                    $req2 = 0;
                                    if (mysqli_num_rows($res7) != 0) {
                                        for ($i = 0; $i < mysqli_num_rows($res7); $i++) {
                                            $row7 = mysqli_fetch_array($res7);
                                            $req2 += $row7['required_amount'];
                                        }
                                        $rest = $row6['price'] - $req2;
                                    } else $rest = $row6['price'];
                                } else $rest = 0;

                                ?>
                                <div class="form-group">
                                    <label for="rest_amount">المبلغ المتبقي دفعه بالدولار</label>
                                    <input type="text" class="form-control" id="rest_amount" name="rest_amount" value="<?php echo $rest; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="required_amount"> قيمة الدفعة الإلزامي بالدولار*</label>
                                    <input type="text" class="form-control" id="required_amount" name="required_amount" onchange="comp()" required>
                                </div>
                                <script>
                                    // function comp(){
                                    //     var rest = document.getElementById("rest_amount");
                                    // var req = document.getElementById("required_amount");
                                    // if(req.value>rest.value){

                                    // }
                                    // }
                                </script>
                                <div class="form-group">
                                    <label for="LL">قيمة الدفعة باللبناني</label>
                                    <input type="text" class="form-control" id="LL" name="LL">
                                </div>
                                <div class="form-group">
                                    <label for="payday">تاريخ الدفعة*</label>
                                    <input type="date" class="form-control" id="payday" name="payday" required>
                                </div>
                                <div class="form-group">
                                    <label for="next_payday">تاريخ الدفعة القادمة</label>
                                    <input type="date" class="form-control" id="next_payday" name="next_payday" >
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
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <label for="gift">هدية</label>
                                        <input class="form-check-input" type="checkbox" id="gift" name="gift">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" onclick="subfunc()" class="btn btn-primary"> إضافة دفعة</button>
                </div>
                </form>
                <script>
                    function subfunc() {
                        localStorage.removeItem("someVarKey");
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
        <script src="assets/js/search5.js"></script>
        <script src="assets/js/search6.js"></script>
        <!--<script src="assets/js/search18.js"></script>-->
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