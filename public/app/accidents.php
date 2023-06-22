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

                        <li class="sidebar-item  ">
                            <a href="person.php" class='sidebar-link'>
                                <span>الأشخاص</span>
                            </a>
                        </li>
                        <li class="sidebar-item ">
                            <a href="contracts.php" class='sidebar-link'>
                                <span>العقود</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
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
                <h3>إضافة حادث</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <?php include_once "connection.php";
                            $res = mysqli_query($con, "SELECT * FROM accident ORDER BY accident_id DESC");
                            $num = mysqli_num_rows($res);
                            ?>
                            <form action="add_accident_inter.php" method="post">
                                <div class="form-group">
                                    <label for="num">رقم الحادث*</label>
                                    <input type="text" class="form-control" id="num" name="num" value="<?php echo ($num + 1); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="date">تاريخ الحادث*</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="search2">الزبون* </label>
                                    <input type="text" class="form-control" id="search2" name="search2" placeholder="بحث" required>
                                </div>
                                 <div class="list-group list-group-item-action" id="content2"></div>
                                <div class="form-group">
                                    <label for="name">إسم الخصم </label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="phone">رقم هاتف الخصم </label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="car">رقم السيارة </label>
                                    <input type="text" class="form-control" id="car" name="car">
                                </div>
                                <div class="form-group">
                                    <label for="vin">رقم الشيسي </label>
                                    <input type="text" class="form-control" id="vin" name="vin">
                                </div>
                                
                                <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->

                               
                        </div>
                    </div>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="btn btn-primary"> إضافة الحادث</button>
                </div>
                </form>

            </div>
            <br>
            <!-- <div class="col-md-8">
                <div class="form-group">
                  <input type="text" class="form-control" id="hades" name="hades" onkeyup="myFunction()" placeholder="بحث عن حادث">
                </div> -->
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>بحث عن حادث</h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-md-7"> -->
                        <div class="form-group">
                            <input type="text" class="form-control" id="hades" name="hades" onkeyup="myFunction()" placeholder="بحث" style="width:900px">
                        </div>

                        <!-- </div> -->
                    </div>

                    <div class="container-table100" style="width:900px">
                        <div class="wrap-table100" style="width:900px">
                            <table class="table table-striped table-hover" id="myTable" style="width:900px">
                            <!-- <tbody> -->
                                <tr class="row2 header">
                                    <th class="cell"> رقم الحادث</th>
                                    <th class="cell"> التاريخ</th>
                                    <th class="cell"> إسم الخصم</th>
                                    <th class="cell"> رقم هاتف</th>
                                    <th class="cell"> رقم السيارة</th>
                                    <th class="cell"> رقم الشيسي</th>
                                    <th class="cell"> الزبون</th>
                                </tr>
                        </div>
                        <?php
                        for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                            $row = mysqli_fetch_array($res);
                            $sql = "SELECT * FROM person WHERE person_id = '" . $row['person_id'] . "'";
                            $res1 = mysqli_query($con, $sql);
                            $row2 = mysqli_fetch_array($res1);
                            if (isset($row2['person_name']) == null) {
                                $name = null;
                            } else $name = $row2['person_name'];
                            echo "<tr class='row2' onclick='accident(" . $row['accident_id'] . ")'>";
                            echo "<td data-title='رقم الحادث'>" . $row['accident_id'] . "</td>";
                            echo "<td data-title='التاريخ'>" . $row['date'] . "</td>";
                            echo "<td data-title='إسم الخصم'>" . $row['name'] . "</td>";
                            echo "<td data-title='رقم هاتف'>" . $row['mobile'] . "</td>";
                            echo "<td data-title='رقم السيارة'>" . $row['car_number'] . "</td>";
                            echo "<td data-title='رقم الشيسي'>" . $row['car_vin'] . "</td>";
                            echo "<td data-title='الزبون'>" . $name . "</td>";
                            echo "</tr>";
                        } ?>
                        <!-- </tbody> -->
                        </table>
                    </div>
                </div>
                <script>
                    function myFunction() {
                        var filter = event.target.value.toUpperCase();
                        var rows = document.querySelector("#myTable ").rows;

                        for (var i = 0; i < rows.length; i++) {
                            var firstCol = rows[i].cells[0].textContent.toUpperCase();
                            var secondCol = rows[i].cells[1].textContent.toUpperCase();
                            var thirdCol = rows[i].cells[2].textContent.toUpperCase();
                            var fourthCol = rows[i].cells[3].textContent.toUpperCase();
                            var fifthCol = rows[i].cells[4].textContent.toUpperCase();
                            var sixthCol = rows[i].cells[5].textContent.toUpperCase();
                            var seventhCol = rows[i].cells[6].textContent.toUpperCase();
                            if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1 || fourthCol.indexOf(filter) > -1
                            || fifthCol.indexOf(filter) > -1 || sixthCol.indexOf(filter) > -1 || seventhCol.indexOf(filter) > -1) {
                                rows[i].style.display = "";
                            } else {
                                rows[i].style.display = "none";
                            }
                        }
                    }
                    document.querySelector('#hades').addEventListener('keyup', filterTable, false);
                    function func(e) {

                        document.getElementById("search2").value = e.target.innerHTML;
                        $('#content2').html('');
                    }

                    function accident(id) {
                        location.href = "edit_accident.php?accident_id=" + id;
                    };
                </script>
            </div>
        </div>
    </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/search4.js"></script>
        <script src="assets/js/search2.js"></script>
         <!-- jQuery CDN - Slim version (=without AJAX) -->
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