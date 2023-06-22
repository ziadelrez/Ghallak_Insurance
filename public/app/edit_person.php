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

    $person_id = $row['person_id'];
    $sql2 = "SELECT * FROM types WHERE person_id = " . $person_id . "";
    $r = mysqli_query($con, $sql2);

    $sql3 = "SELECT * FROM person_type";
    $res = mysqli_query($con, $sql3);

    $sql4 = "SELECT * FROM regions";
    $rr = mysqli_query($con, $sql4);

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

                        <li class="sidebar-item active">
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
                        <p class="col-md-3 col-md-2"><a href="add_car.php?person=<?php echo $person; ?>" class="btn btn-primary btn-block" > سيارات الزبون</a></p>
                        <p class="col-md-3 col-md-2"><a href="person_contracts.php?person=<?php echo $person; ?>" class="btn btn-primary btn-block" > عقود الزبون</a></p>
                     </div>
                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">

                <h3>تعديل شخص</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <form action="edit_person_inter.php?person_id=<?php echo $row['person_id']; ?>" method="post">
                                <div class="form-group">
                                    <label for="name">الإسم*</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['person_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">تاريخ الميلاد</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['birthdate']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="address">العنوان*</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">الموبايل*</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">الهاتف الأرضي</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['home_number']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cars">المنطقة :</label>
                                    <select name="region" class="btn btn-light dropdown-toggle dropdown-toggle-split" id="region">
                                        <?php for ($i = 0; $i < mysqli_num_rows($rr); $i++) {
                                            $rrr = mysqli_fetch_array($rr);
                                            echo "<option class='dropdown-item' value=" . $rrr['region_id'] . ">" . $rrr['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                        </div>
                    </div>
                </div>
                <br>
                <section id="basic-checkbox">
                    <div class="row">
                        <div class="col-12">

                            <ul class="list-unstyled mb-0">
                                <?php
                                // echo $rowww;
                                $ar = array();
                                $arr = array();
                                $x = 0;
                                while ($roww = mysqli_fetch_array($res)) {
                                    $ar[$x]['name'] = $roww['name'];
                                    $ar[$x]['person_type_id'] = $roww['person_type_id'];
                                    $x++;
                                }
                                $x = 0;
                                while ($roww = mysqli_fetch_array($r)) {
                                    $arr[$x]['person_id'] = $roww['person_id'];
                                    $arr[$x]['person_type_id'] = $roww['person_type_id'];
                                    $x++;
                                }

                                $_SESSION['sesh'] = $arr;
                                for ($j = 0; $j < sizeof($ar); $j++) {
                                    //     $roww = mysqli_fetch_array($res); 
                                    $exists = 0;
                                ?>

                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <?php
                                                for ($i = 0; $i < sizeof($arr); $i++) {
                                                    //         $rowww = mysqli_fetch_array($r);

                                                    if ($ar[$j]['person_type_id'] == $arr[$i]['person_type_id']) {
                                                        $exists = 1;
                                                    }

                                                    if ($exists == 1 && ($i + 1) == sizeof($arr)) {
                                                        echo "<input type='checkbox' id='checkbox'" . ($j + 1) . " name='checkbox[]' value='" . ($j + 1) . "' class='form-check-input' style='float:right;' checked>";
                                                        echo "<label for='checkbox'" . ($j + 1) . " style='margin-right: 40px; font-weight: bold;' >" . $ar[$j]['name'] . "</label>";
                                                        $exists = 0;
                                                    } elseif ($exists == 0 && ($i + 1) == sizeof($arr)) {
                                                        echo "<input type='checkbox' id='checkbox'" . ($j + 1) . " name='checkbox[]'  value='" . ($j + 1) . "' class='form-check-input' style='float:right;'>";
                                                        echo "<label for='checkbox'" . ($j + 1) . " style='margin-right: 40px; font-weight: bold;' >" . $ar[$j]['name'] . "</label>";
                                                    }
                                                } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <br>
                                <?php
                                } ?>

                            </ul>
                        </div>
                    </div>
                </section>
                <br>
                <div class="buttons">
                    <button type="submit" name="submit" class="btn btn-primary"> تعديل الشخص</button>
                    <a href="person.php" class="btn btn-danger"> رجوع</a>
                    <?php 
                    $sql5="SELECT * FROM contract WHERE person_id = '".$row['person_id']."'";
                    $res5 = mysqli_query($con, $sql5);
                    $sql6="SELECT * FROM accident WHERE person_id = '".$row['person_id']."'";
                    $res6=mysqli_query($con, $sql6);
                    $sql7="SELECT * FROM car WHERE person_id = '".$row['person_id']."'";
                    $res7=mysqli_query($con, $sql7);
                    if (mysqli_num_rows($res5)!=0 || mysqli_num_rows($res6)!=0 || mysqli_num_rows($res7)!=0) { ?>
                     
                        <a class="btn btn-danger" onclick="mssg()" id="delete_btn">حذف الشخص </a>
                         
                        <script>
                        function mssg(){
                            alert("لا يمكنك حذف هذا الشخص");
                        }
                        </script>
                        
                    <?php 
                    }
                    else { ?>
                        <a href="delete_person.php?person=<?php echo $person; ?>" class="btn btn-danger" id="delete_btn" onclick="return confirm('هل أنت متأكد ؟');">حذف الشخص </a>
                    
                    <?php }
                ?>
                  
                </div>
                </form>
                        
            </div>
        </div>
    </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/search.js"></script>
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