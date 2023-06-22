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

                        <li class="sidebar-item ">
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
                <h3>إضافة تكلفة الحادث</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                        <?php include_once "connection.php";
                                $accident_id = $_GET['accident_id'];
                                $sql = "SELECT * FROM accident WHERE accident_id = '$accident_id'";
                                $res = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($res);
                                // $sql1 = "SELECT * FROM person WHERE person_id = '".$row['person_id']."'";
                                // $res1 = mysqli_query($con, $sql1);
                                // $row1 = mysqli_fetch_array($res1);
                            ?>
                            <input type="hidden" value="<?php echo $row['person_id']; ?>" id="person">
                            <form action="add_accident_info_inter.php?accident_id=<?php echo $accident_id;?>" method="post" >
                            <div class="form-group">
                                <label for="cost">قيمة التكلفة*</label>
                                <input type="text" class="form-control" id="cost" name="cost" required>
                            </div>
                            <div class="form-group">
                                <label for="date">تاريخ التكلفة*</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="afflicted">المتضرر </label>
                                <input type="text" class="form-control" id="afflicted" name="afflicted">
                            </div>
                            <div class="form-group">
                                <label for="info">تكاليف أخرى </label>
                                <input type="text" class="form-control" id="info" name="info">
                            </div>
                            <div class="form-group">
                                    <label for="contract">رقم العقد* :</label>
                                    <input type="text" class="form-control" id="contract" name="contract" placeholder=" بحث عن عقد" required>
                                </div>
                                <div class="list-group list-group-item-action" id="contract_content"></div>
                                <div class="form-group">
                                    <label for="car">السيارة :</label>
                                    <input type="text" class="form-control" id="car" name="car" placeholder=" بحث عن سيارة" required>
                                </div>
                                <div class="list-group list-group-item-action" id="car_content"></div>
                            
                            <div class="form-group">
                                <label for="expert">الخبير : </label>
                                <select name="expert" class="btn btn-light dropdown-toggle dropdown-toggle-split" style="width:200px;" id="expert">
                                <?php 
                                    $sql4 = "SELECT * FROM person JOIN types ON person.person_id = types.person_id AND types.person_type_id = '4'";
                                    $res4 = mysqli_query($con, $sql4);
                                    echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                    for($i=0; $i<mysqli_num_rows($res4); $i++){
                                        $row2 = mysqli_fetch_array($res4);
                                        echo "<option class='dropdown-item' value=".$row2['person_id'].">".$row2['person_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="garage">الغراج : </label>
                                <select name="garage" class="btn btn-light dropdown-toggle dropdown-toggle-split" style="width:200px;" id="garage">
                                <?php 
                                    $sql5 = "SELECT * FROM garage";
                                    $res5 = mysqli_query($con, $sql5);
                                    echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                    for($i=0; $i<mysqli_num_rows($res5); $i++){
                                        $row3 = mysqli_fetch_array($res5);
                                        echo "<option class='dropdown-item' value=".$row3['garage_id'].">".$row3['garage_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hosp">المستشفى : </label>
                                <select name="hosp" class="btn btn-light dropdown-toggle dropdown-toggle-split" style="width:200px;" id="hosp">
                                <?php 
                                     $sql6 = "SELECT * FROM hospital";
                                     $res6 = mysqli_query($con, $sql6);
                                     echo "<option class='dropdown-item' value='0'>NOT SELECTED</option>";
                                    for($i=0; $i<mysqli_num_rows($res6); $i++){
                                        $row4 = mysqli_fetch_array($res6);
                                        echo "<option class='dropdown-item' value=".$row4['hospital_id'].">".$row4['hospital_name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="search2">السيارة </label>
                                <input type="text" class="form-control" id="search2" name="search2" placeholder="بحث" value="<?php echo $row1['person_name'];?>">
                             </div>
                            <!-- <input type="submit" name="btn" id="btn" style="display: none;" autofocus> -->
                           
                           <!-- <div class="list-group list-group-item-action" id="content2"></div> --> 
                        </div>
                    </div> 
                </div>   
                <div class="buttons">
                  <button type="submit" name="submit" class="btn btn-primary"> إضافة التكلفة</button>
                  </div>
                </form>
                <br>
               
            <script>
            function search_contract(e) {
                        document.getElementById("contract").value = e.target.innerHTML;
                        $('#contract_content').html('');
                    }
                    function search_contract(e) {
                        document.getElementById("car").value = e.target.innerHTML;
                        $('#car_content').html('');
                    }
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
    <script src="assets/js/search16.js"></script> <!-- jQuery CDN - Slim version (=without AJAX) -->
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