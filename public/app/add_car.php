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
    $person = $_GET['person'];
    $query = "SELECT * FROM person WHERE person_name = '$person'";
    $resultt = mysqli_query($con, $query);
    $row = mysqli_fetch_array($resultt);

    $query2 = "SELECT * FROM car_name";
    $result2 = mysqli_query($con, $query2);

    $query3 = "SELECT * FROM car_type";
    $result3 = mysqli_query($con, $query3);
    
    $query4 = "SELECT * FROM car WHERE person_id = ".$row['person_id']."";
    $result4 = mysqli_query($con, $query4);

    

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

                        <li class="sidebar-item active ">
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
            <div class="container">
                <div class="buttons" style="margin-right: 250px;">
                    <div class="row">
                        <p class="col-md-3 col-md-2"><a href="edit_person.php?person=<?php echo $person; ?>" class="btn btn-primary btn-block" >  الزبون</a></p>
                        <p class="col-md-3 col-md-2"><a href="person_contracts.php?person=<?php echo $person; ?>" class="btn btn-primary btn-block" > عقود الزبون</a></p>
                     </div>
                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
            
                <h3>إضافة سيارة</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="add_person_car_inter.php?person_id=<?php echo $row['person_id'];?>" method="post" >
                            <div class="form-group">
                                <label for="number">رقم السيارة*</label>
                                <input type="text" class="form-control" id="number" name="number">
                            </div>
                            <div class="form-group">
                                <label for="year">سنة الصنع</label>
                                <input type="text" class="form-control" id="year" name="year">
                            </div>
                            <div class="form-group">
                                <label for="style">طراز السيارة</label>
                                <input type="text" class="form-control" id="style" name="style" >
                            </div>
                            <div class="form-group">
                                <label for="chassis">رقم الشيسي</label>
                                <input type="text" class="form-control" id="chassis" name="chassis">
                            </div>
                            <div class="form-group">
                                <label for="engine">رقم المحرك</label>
                                <input type="text" class="form-control" id="engine" name="engine">
                            </div>
                            <div class="form-group">
                                <label for="power">قوة المحرك</label>
                                <input type="text" class="form-control" id="power" name="power">
                            </div>
                            <div class="form-group">
                                <label for="seats">عدد المقاعد</label>
                                <input type="text" class="form-control" id="seats" name="seats">
                            </div>
                            <div class="form-group">
                                <label for="price">سعر السيارة</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                            <div class="form-group">
                            <label for="name">ماركة السيارة *:</label>
                                <select name="name" class="btn btn-light dropdown-toggle dropdown-toggle-split" style="width:200px;" id="name">
                                <?php for($i=0; $i<mysqli_num_rows($result2); $i++){
                                        $rr = mysqli_fetch_array($result2);
                                        echo "<option class='dropdown-item' value=".$rr['car_name_id'].">".$rr['name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                            <label for="type">وجهة إستعمال السيارة* :</label>
                                <select name="type" class="btn btn-light dropdown-toggle dropdown-toggle-split" style="width:200px;" id="type">
                                <?php for($i=0; $i<mysqli_num_rows($result3); $i++){
                                        $rrr = mysqli_fetch_array($result3);
                                        echo "<option class='dropdown-item' value=".$rrr['car_type_id'].">".$rrr['name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                    </div>
                   </div>
                   </div>
                   <br>
                 
                    <div class="buttons">
                  <button type="submit" name="submit" class="btn btn-primary">  إضافة السيارة</button>
                  <a href="person.php" class="btn btn-danger"> رجوع</a>
                </div>
                </form>
                <br>

                <div class="container-table100">
                    <div class="wrap-table100">
                        <table class="table table-striped table-hover">
                             <tr class="row2 header">
                             <th class="cell"> رقم السيارة</th>
                             <th class="cell"> نوع السيارة</th>
                             <th class="cell"> طراز السيارة</th>
                                </tr>
                         
                            <?php 
                            for ($i=0; $i< mysqli_num_rows($result4); $i++) {
                            $row2 = mysqli_fetch_array($result4); 

                            $sql5="SELECT * FROM car_name WHERE car_name_id=".$row2['car_name_id']."";
                            $result5 = mysqli_query($con, $sql5);
                            $row5 = mysqli_fetch_array($result5);
                            echo "<tr class='row2' onclick='go(\"".$row2['car_number']."\")'>";
                            echo "<td data-title='رقم السيارة'>".$row2['car_number']."</td>";
                            echo "<td data-title='نوع السيارة'>".$row5['name']."</td>";
                            echo "<td data-title='طراز السيارة'>".$row2['style']."</td>";
                            echo "</tr>";
                            } ?>
                        
                        </table>
                    </div>
                 </div>
                      
</div>
                   </div>
   </div>
                <script type="text/javascript">
                    function go(car_id) {
                        location.href = "edit_car.php?car_number="+car_id;
                    };
                </script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/search2.js"></script>  <!-- jQuery CDN - Slim version (=without AJAX) -->
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