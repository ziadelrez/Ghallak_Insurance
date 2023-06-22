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
                                <li class="submenu-item active">
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
            <!-- <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>  </h3>
            </div> -->
            <?php
            $person = $_GET['person'];
            ?>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>  دفعات الخبير : <?php echo $person ?></h3>
            </div>
            <?php
            $query3 = "SELECT * FROM person WHERE person_name = '$person'";
            $resultat3 = mysqli_query($con, $query3);
            $row3 = mysqli_fetch_array($resultat3);
            $sql4 = "SELECT * FROM expert_expenses WHERE expert_id = '" . $row3['person_id'] . "'";
            $resultat4 = mysqli_query($con, $sql4);
            $q = "SELECT * FROM accident_cost WHERE expert_id = '" . $row3['person_id'] . "'";
            $r = mysqli_query($con, $q);
            global $roww;
            global  $total;
            $req = 0;
            $somme=0;
            ?>
            <div class="page-content" style="left: -300px; margin-right: 300px; width: 1000px;">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                <th style="width: 10px;"> </th>
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell"> المبلغ باللبناني</th>
                                    <th class="cell"> الزبون </th>
                                    <th class="cell"> الحادث</th>
                                    <th class="cell">تفصيل الحادث</th>
                                    <th class="cell"> تاريخ الدفعة</th>
                                    <th class="cell"> رقم الشيك</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {

                                    $row = mysqli_fetch_array($resultat4);
                                    $req += $row['required_amount'];
                                    global $row;
                                    $sql = "SELECT * FROM accident WHERE accident_id = '".$row['accident_id']."'";
                                    $res = mysqli_query($con, $sql);
                                    $rrow = mysqli_fetch_array($res);

                                    $sql2 = "SELECT * FROM person WHERE person_id = '".$rrow['person_id']."'";
                                    $res2 = mysqli_query($con, $sql2);
                                    $rrow2 = mysqli_fetch_array($res2);

                                    if($row['lebanese_amount'] == null){
                                        $lb = 0;
                                    }else $lb = $row['lebanese_amount'];
                                    echo "<tr class='row2' onclick='expert_info(" . $row['expert_expenses_id'] . ")'>";
                                    echo "<td><input type='checkbox' onclick='GetSelected(event, " . $row['expert_expenses_id'] . ", " . $row['required_amount'] . ", " . $row['lebanese_amount'] . ", \"" . $row['accident_id'] . "\", \"" . $rrow2['person_name'] . "\")'></td>";
                                    echo "<td data-title='المبلغ'>" . $row['required_amount'] . "</td>";
                                    echo "<td data-title='المبلغ باللبناني'>" . $lb. "</td>";
                                    echo "<td data-title='الزبون'>" . $rrow2['person_name'] . "</td>";
                                    echo "<td data-title='الحادث'>" . $row['accident_id'] . "</td>";
                                    echo "<td data-title=' تفصيل الحادث'>" . $row['accident_cost_id'] . "</td>";
                                    echo "<td data-title='تاريخ الدفعة'>" . $row['date'] . "</td>";
                                    echo "<td data-title='رقم الشيك'>" . $row['check_number'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="buttons">
                        <button type="submit" name="submit" onclick="wasel2()" formtarget="_blank" class="btn btn-primary"> الإيصال</button>
                    </div>
                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <table>
                    <tr>
                        <td>
                            <h3> مجموع الدفعات  :</h3>
                        </td>
                        <td>
                        <h4><?php echo '$'.$req; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
            <script>
                var amount=0;
                var lebanese=0;
                var ar = new Array();
                var arr = new Array();
                 var persons = new Array();
                function GetSelected(event, id, amount1, lebanese1, accident, person) {
                    //Reference the Table.
                    event.stopPropagation();

                    var checkBox = document.getElementsByTagName("input");

                    if (!ar.includes(id)) {
                        // if(!arr.includes(contract)){
                            arr.push(accident);
                        // }
                        
                        amount += parseFloat(amount1);
                        lebanese += parseFloat(lebanese1);
                        ar.push(id);
                        persons.push(person);
                        console.log(person);
                        console.log(ar);
                        console.log(arr);
                    } else {
                        const index1 = arr.indexOf(accident);
                        arr.splice(index1, 1);
                        amount -= amount1;
                        lebanese -= lebanese1;
                        const index = ar.indexOf(id);
                        ar.splice(index, 1);
                        const index2 = persons.indexOf(person);
                        persons.splice(index2, 1);
                        console.log(index2);
                        console.log(index);
                        console.log(ar);
                        console.log(arr);
                    }
                }
                
                function wasel2() {
                var cont = new Set(arr);
                var cont2 = new Set(persons);
                    var person = <?php echo json_encode($person); ?>;
                    var location = "expert_receipt.php?expert=" + person + "&somme=" + amount + "&accidents=" + [...cont].join(" - ") + "&clients=" + [...cont2].join(" - ") + "&lebanese=" + lebanese;
                    window.open(location, '_blank');
                }
            </script>
            
            <?php
            for ($i = 0; $i < mysqli_num_rows($r); $i++) {

                $roww = mysqli_fetch_array($r);
                $total += $roww['cost'];
            }
            $tot = $total - $req;
            ?>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <table>
                    <tr>
                        <td>
                            <h3>  الدفعات المتبقية:</h3>
                        </td>
                        <td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $tot; ?>" readonly>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> حوادث الخبير</h3>
            </div>
            <?php


            ?>
            <div class="page-content" style="left: -300px; margin-right: 300px; width: 1000px;">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                 <tr class="row2 header">
                                    <th class="cell"> رقم الحادث</th>
                                    <th class="cell"> الزبون </th>
                                    <th class="cell"> التكلفة</th>
                                    <th class="cell"> تاريخ التكلفة</th>
                                    <th class="cell"> المتضرر</th>
                                </tr>
                                <?php
                                mysqli_data_seek($r, 0);
                                for ($i = 0; $i < mysqli_num_rows($r); $i++) {

                                    $roww = mysqli_fetch_array($r);
                                    $sql3 = "SELECT * FROM accident WHERE accident_id = '".$row['accident_id']."'";
                                    $res3 = mysqli_query($con, $sql3);
                                    $rrow3 = mysqli_fetch_array($res3);

                                    $sql4 = "SELECT * FROM person WHERE person_id = '".$rrow3['person_id']."'";
                                    $res4 = mysqli_query($con, $sql4);
                                    $rrow4 = mysqli_fetch_array($res4);

                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $roww['accident_id'] . "</td>";
                                    echo "<td class='cell'>" . $rrow4['person_name'] . "</td>";
                                    echo "<td class='cell'>" . $roww['cost'] . "</td>";
                                    echo "<td class='cell'>" . $roww['date'] . "</td>";
                                    echo "<td class='cell'>" . $roww['afflicted'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function expert_info(id) {
                            location.href = "edit_expert_expenses.php?expert_expenses_id=" + id;
                        };
                    </script>

                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <table>
                    <tr>
                        <td>
                            <h3> مجموع تكاليف الحوادث  :</h3>
                        </td>
                        <td>
                        <h4><?php echo '$'.$somme2; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script> -->
        <script src="assets/js/main.js"></script>
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