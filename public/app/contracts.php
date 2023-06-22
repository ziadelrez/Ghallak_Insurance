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
                <h3>بحث عن عقد</h3>
            </div>
            
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="" method="post">
                             <div class="form-group">
                                <input type="text" class="form-control" id="search3" name="search3" placeholder=" بحث عن رقم العقد">
                            </div>
                            <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->
                           </form>
                           <div class="list-group list-group-item-action" id="content3"></div> 
                           
            
                        </div>
                    </div>
                 </div>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="" method="post">
                             <div class="form-group">
                                <input type="text" class="form-control" id="car_search" name="car_search" placeholder="بحث عن رقم السيارة أو الشيسي">
                            </div>
                            <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->
                           </form>
                           <div class="list-group list-group-item-action" id="car_content"></div> 
                           
            
                        </div>
                    </div>
                 </div>
            </div>
            <?php if (isset($_GET['car'])) {
                $car = $_GET['car'];
                $sql1 = "SELECT * FROM contract WHERE car_id=$car order by end_date desc";
                $res1 = mysqli_query($con, $sql1);
            ?>

            <div class="page-content" style="left: -300px; margin-right: 300px; width: 1000px;">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover" >
                                <tr class="row2 header">
                                    <th class="cell"> رقم العقد</th>
                                    <th class="cell"> الزبون </th>
                                    <th class="cell"> السعر </th>
                                    <th class="cell"> الشركة</th>
                                    <th class="cell"> العميل</th>
                                    <th class="cell">  تاريخ الإبتداء</th>
                                    <th class="cell">  تاريخ الإنتهاء</th>

                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($res1); $i++) {
                                    $row8 = mysqli_fetch_array($res1);
                            
                                    $sql2 = "SELECT * FROM company WHERE company_id = '" . $row8['company_id'] . "'";
                                    $res2 = mysqli_query($con, $sql2);
                                    $row9 = mysqli_fetch_array($res2);

                                    $sql3 = "SELECT * FROM person WHERE person_id='" . $row8['agent'] . "'";
                                    $res3 = mysqli_query($con, $sql3);
                                    $row10 = mysqli_fetch_array($res3);
                                    
                                    $sql4 = "SELECT * FROM person WHERE person_id='".$row8['person_id']."'";
                                    $res4 = mysqli_query($con, $sql4);
                                    $row11 = mysqli_fetch_array($res4);
                                    
                                    echo "<tr class='row2' onclick='function4(\"" . $row8['contract_number'] . "\")'>";
                                    echo "<td data-title='رقم العقد'>" . $row8['contract_number'] . "</td>";
                                    echo "<td data-title='الزبون '>" . $row11['person_name'] . "</td>";
                                    echo "<td data-title='السعر '>" . $row8['price'] . "</td>";
                                    echo "<td data-title='الشركة '>" . $row9['company_name'] . "</td>";
                                    echo "<td data-title='العميل'>" . $row10['person_name'] . "</td>";
                                    echo "<td data-title='تاريخ الإبتداء'>" . $row8['start_date'] . "</td>";
                                    echo "<td data-title='تاريخ الإنتهاء'>" . $row8['end_date'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            ?>


            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>إضافة عقد</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                         
                            <form action="add_contract_inter.php" method="post" id="myform">
                                <div class="form-group">
                                <label for="search2">الزبون*</label>
                                    <input type="text" class="form-control" id="search2" name="search2" required>
                                </div>
                             <!-- <input type="submit" name="btn" id="btn"  style="display: none;" >
                           </form> -->
                           <div class="list-group list-group-item-action" id="content2"></div>
                       <!-- <input type='text' style="display: none;" id='test'  name='test' > -->
                       <!-- <input type="submit" id="test1" name="test1" style="display: none;" onClick="clicking()"> -->
                           <script>
                           function function4(id){
                                        console.log(id);
                                        location.href = "edit_contract.php?contract_number=" + id;
                                    }
                           
                            function func(e) {
                            
                                document.getElementById("search2").value = e.target.innerHTML;
                                $('#content2').html('');
                            //document.getElementById("btn").click();
                            var someVarName =  document.getElementById("search2").value;
                            localStorage.setItem("someVarKey", someVarName);
                                var person = document.getElementById("search2").value;
                            // console.log(person);
                            //document.getElementById("test").value = person;
                            //document.getElementById("btn").click();
                            //document.getElementById("test1").click();
                            location.href="contracts.php?person="+person;
                            
                            }
                            function function2(e, id) {

                                        document.getElementById("car_search").value = e.target.innerHTML;
                                        $('#car_content').html('');
                                        //document.getElementById("btn").click();
                                        var someVarName1 = document.getElementById("car_search").value;
                                        localStorage.setItem("someVarKey1", someVarName1);
                                        var car = document.getElementById("car_search").value;
                                        // console.log(person);
                                        //document.getElementById("test").value = person;
                                        //document.getElementById("btn").click();
                                        //document.getElementById("test1").click();
                                        location.href = "contracts.php?car=" + id;

                                    }
                                    var sss = localStorage.getItem("someVarKey");

                                    document.getElementById("search2").value = sss;

                                    localStorage.removeItem("someVarKey");

                                    var ssss = localStorage.getItem("someVarKey1");

                                    document.getElementById("car_search").value = ssss;

                                    localStorage.removeItem("someVarKey1");
                            
                            </script>
                            
                            
                           <!-- <form action="add_contract_inter.php" method="post" > -->
                           
                            <div class="form-group">
                                <label for="num">رقم العقد* </label>
                                <input type="text" class="form-control" id="num" name="num" required>
                            </div>
                            <div class="form-group">
                                <label for="type">نوع العقد* :</label>
                                <select name="type" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="type" required>
                                    
                                    <?php
                                    $query = "SELECT * FROM contract_type";
                                    $resultat = mysqli_query($con, $query);

                                    for ($i=0; $i<mysqli_num_rows($resultat); $i++) {
                                        $row = mysqli_fetch_array($resultat);
                                        echo "<option class='dropdown-item' value=".$row['contract_type_id'].">".$row['type']."</option>";
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

                                    for ($i=0; $i<mysqli_num_rows($resultat2); $i++) {
                                        $row2 = mysqli_fetch_array($resultat2);
                                        echo "<option class='dropdown-item' value=".$row2['company_id'].">".$row2['company_name']."</option>";
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
                                    
                                    for ($i=0; $i<mysqli_num_rows($resultat3); $i++) {
                                        $row3 = mysqli_fetch_array($resultat3);
                                        echo "<option class='dropdown-item' value=".$row3['person_id'].">".$row3['person_name']."</option>";
                                    }
                                    ?>
                                
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="begin">تاريخ إبتداء العقد* </label>
                                <input type="date" class="form-control" id="begin" name="begin" required>
                            </div>
                            <div class="form-group">
                                <label for="end">تاريخ إنتهاء العقد* </label>
                                <input type="date" class="form-control" id="end" name="end" required>
                            </div>
                            <div class="form-group">
                                <label for="price">سعر العقد* </label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="office"> حصة المكتب*</label>
                                <input type="text" class="form-control" id="office" name="office" required>
                            </div>
                            <div class="form-group">
                                <label for="agent_potion"> حصة الوسيط*</label>
                                <input type="text" class="form-control" id="agent_potion" name="agent_potion" required>
                            </div>
                            <div class="form-group">
                                <label for="description"> تعريف العقد </label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="form-group">
                                <label for="info">البوليصة  </label>
                                <input type="text" class="form-control" id="info" name="info">
                            </div>
                            <?php
                                if (isset($_GET['person'])) {
                                    $person = $_GET["person"];
                                ?>
                                    <input type="hidden" id="person" value="<?php echo $person; ?>">
                                <?php }
                                ?>

                                <div class="form-group">
                                    <!-- <div id="content3"></div> -->
                                    <label for="info">السيارة </label>
                                    <input type="text" class="form-control" id="car_search2" name="car_search2" placeholder="بحث في سيارات الزبون">
                                </div>
                                <div class="list-group list-group-item-action" id="car_content2"></div>
                                <script>
                                    function function3(e) {

                                        document.getElementById("car_search2").value = e.target.innerHTML;
                                        $('#car_content2').html('');

                                    }
                                </script>
                            <div class="form-group">
                                <label for="estate"> رقم العقار </label>
                                <input type="text" class="form-control" id="estate" name="estate">
                            </div>
                            <div class="form-group">
                                <label for="workers"> عدد العمال </label>
                                <input type="text" class="form-control" id="workers" name="workers">
                            </div>
                            <div class="form-group">
                                <label for="worker_salary">معاش العامل</label>
                                <input type="text" class="form-control" id="worker_salary" name="worker_salary">
                            </div>
                            <div class="form-group">
                                <label for="emp_salary"> معاش المعلم </label>
                                <input type="text" class="form-control" id="emp_salary" name="emp_salary">
                            </div>
                            <div class="form-group">
                                <label for="degree"> درجات الإصابة </label>
                                <input type="text" class="form-control" id="degree" name="degree">
                            </div>
                            <div class="form-group">
                                <label for="value"> قيمة الغرض </label>
                                <input type="text" class="form-control" id="value" name="value">
                            </div>
                            <div class="form-group">
                                <label for="maid"> معلومات الخادم/ة</label>
                                <input type="text" class="form-control" id="maid" name="maid">
                            </div>
                            <div class="form-group">
                            <div class="form-check form-switch">
                            <label for="finished">منتهي</label>
                             <input class="form-check-input" type="checkbox" id="finished" name="finished">
                            </div>
                            </div>
                    </div>
                   </div>
                   </div>
               
                    <div class="buttons">
                  <button type="submit" name="submit" class="btn btn-primary"> إضافة العقد</button>
                </div>
                </form>

                   </div>
                   </div>
                   </div>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/search2.js"></script>
    <script src="assets/js/inter.js"></script>
    <script src="assets/js/inter2.js"></script>
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