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
    } 
    ?>
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
                                <li class="submenu-item active">
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
                <h3>بحث عن غراج</h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="garage_search" name="garage_search" placeholder="بحث">
                                </div>
                                <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->
                            </form>
                            <div class="list-group list-group-item-action" id="garage_contents"></div>

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
                            <form action="add_garage_exp_inter.php" method="post">
                                <div class="form-group">
                                    <label for="garage">الغراج*</label>
                                    <input type="text" class="form-control" id="garage" name="garage" required>
                                    <div class="list-group list-group-item-action" id="garage_content"></div>
                                </div>
                                <script>
                                    function search_garage(e) {

                                        document.getElementById("garage").value = e.target.innerHTML;
                                        $('#contentsss').html('');
                                        var someVarName3 = document.getElementById("garage").value;
                                        localStorage.setItem("someVarKey3", someVarName3);
                                        var garage = document.getElementById("garage").value;
                                        location.href = "garages_expenses.php?garage=" + garage;
                                    }

                                    var s3 = localStorage.getItem("someVarKey3");

                                    document.getElementById("garage").value = s3;
                                    console.log(s3);
                                    //localStorage.removeItem("someVarKey");
                                </script>
                                <?php
                                $total = 0;
                                if (!isset($_GET['garage'])) {
                                    $total = 0;
                                    $garage = null;
                                    $req = 0;
                                } else {
                                    $req = 0;
                                    $garage = $_GET['garage'];
                                    $query3 = "SELECT * FROM garage WHERE garage_name = '$garage'";
                                    $resultat3 = mysqli_query($con, $query3);
                                    $row3 = mysqli_fetch_array($resultat3);
                                    $sql4 = "SELECT * FROM accident_cost WHERE garage_id = '" . $row3['garage_id'] . "'";
                                    $resultat4 = mysqli_query($con, $sql4);
                                    for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {
                                        $row4 = mysqli_fetch_array($resultat4);
                                        $total += $row4['cost'];
                                    }
                                    $sql5 = "SELECT * FROM garage_expenses WHERE garage_id = '" . $row3['garage_id'] . "'";
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
                                if(!isset($_GET['accident_id'])){
                                    $accident_id = NULL;
                                }
                                else{
                                    $accident_id = $_GET['accident_id'];
                                }
                                ?>
                                <div class="form-group">
                                <label for="accident">الحادث* </label>
                                    <input type="text" class="form-control" id="accident_search" name="accident_search" onkeyup="myFunction()" placeholder="بحث">
  
                                    <div class="container-table100" style="margin-top: 20px;">
                                        <div class="wrap-table100">
                                            <table class="table table-striped table-hover" id="table1">
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
                                                    if ($garage != null && $accident_id == null) {
                                                        $sql8 = "SELECT * FROM accident JOIN accident_cost ON accident.accident_id = accident_cost.accident_id AND accident_cost.garage_id = '".$row3['garage_id']."'";
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
                                   
                                   $query3 = "SELECT * FROM garage WHERE garage_name = '$garage'";
                                   $resultat3 = mysqli_query($con, $query3);
                                   $row3 = mysqli_fetch_array($resultat3);
                                    ?>
                                
                                </select>
                            </div>
                                <script>
                                    function refresh2() {
                                        var garage = document.getElementById("garage").value;
                                        var acc = document.getElementById("accident_search");
                                        var select = acc.value;
                                        location.href = "garages_expenses.php?garage=" + garage + "&accident_id=" + select;
                                    }
                                    function search_accident(id) {
                                        document.getElementById("accident_search").value = id;
                                        
                                        // $('#contract_content').html('');
                                        refresh2();
                                        console.log(document.getElementById("accident_search").value);

                                    }
                                    var acc = "<?php echo $accident_id ?>";
                                    document.getElementById('accident_search').value = acc;
                                    
                                    function myFunction() {
                                        var filter = event.target.value.toUpperCase();
                                        var rows = document.querySelector("#table1").rows;

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
                                    <select name="accident_cost" class="btn btn-light dropdown-toggle dropdown-toggle-split" onchange="refresh3()" id="accident_cost" required>

                                        <?php
                                        if (!isset($_GET['accident_id'])) {
                                            $accident = NULL;
                                        } else $accident = $_GET['accident_id'];
                                        if (isset($_GET['accident_cost'])) {
                                            $accident_cost= $_GET['accident_cost'];
                                        }
                                        else $accident_cost=null;
                                        $sql5 = "SELECT * FROM accident_cost WHERE accident_id = '$accident' AND garage_id='" . $row3['garage_id'] . "'";
                                        $resultat5 = mysqli_query($con, $sql5);
                                        echo "<option class='dropdown-item' value=0>NOT SELECTED</option>";
                                        for ($i=0; $i<mysqli_num_rows($resultat5); $i++) {
                                            $row5 = mysqli_fetch_array($resultat5);
                                            if($accident_cost==$row5['accident_cost_id']){
                                                echo "<option class='dropdown-item' value=".$row5['accident_cost_id']." selected>".$row5['cost']." | ".$row5['date']."</option>";
                                            }
                                            else echo "<option class='dropdown-item' value=".$row5['accident_cost_id'].">".$row5['cost']." | ".$row5['date']."</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <script>
                            function refresh3(){
                                var garage = document.getElementById("garage").value;
                                var acc = document.getElementById("accident_search");
                                var select = acc.value;
                                var cost = document.getElementById("accident_cost");
                                var acc_cost = cost.value;
                                location.href="garages_expenses.php?garage="+garage+"&accident_id="+select+"&accident_cost="+acc_cost;
                            }
                            </script>
                            <?php
                            if($accident_cost!=null){
                                $accident_cost= $_GET['accident_cost'];
                                $req2=0;
                                $sql8="SELECT * FROM accident_cost WHERE accident_cost_id='$accident_cost'";
                                $res8=mysqli_query($con, $sql8);
                                $row8=mysqli_fetch_array($res8);
                                $sql7 = "SELECT * FROM garage_expenses WHERE accident_cost_id = '$accident_cost'";
                                $res7=mysqli_query($con, $sql7);
                                if(mysqli_num_rows($res7)!=0){
                                    for($i=0; $i<mysqli_num_rows($res7);$i++){
                                        $row7=mysqli_fetch_array($res7);
                                        $req2+=$row7['required_amount'];
                                    }
                                
                                    $rest = $row8['cost'] - $req2;
                                }else $rest = $row8['cost'];
                            }else $rest=0;
                            ?>
                            <div class="form-group">
                                <label for="rest_amount">المبلغ المتبقي دفعه بالدولار</label>
                                <input type="text" class="form-control" id="rest_amount" name="rest_amount" value="<?php echo $rest;?>" readonly>
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
                    <button type="submit" name="submit" onclick="subfunc4()" class="btn btn-primary"> إضافة دفعة</button>
                </div>
                </form>
                <script>
                    function subfunc4() {
                        localStorage.removeItem("someVarKey3");
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