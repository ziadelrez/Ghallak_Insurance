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
            <!-- <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>  </h3>
            </div> -->
            <?php
            $company = $_GET['company'];
            $query1 = "SELECT * FROM company WHERE company_name = '$company'";
            $resultat1 = mysqli_query($con, $query1);
            $row1 = mysqli_fetch_array($resultat1);
            $sql2 = "SELECT * FROM companies_expenses WHERE company_id = '" . $row1['company_id'] . "'";
            $resultat2 = mysqli_query($con, $sql2);
            $sql3 = "SELECT * FROM companies_accident_expenses WHERE company_id = '" . $row1['company_id'] . "'";
            $resultat3 = mysqli_query($con, $sql3);
            $sql4 = "SELECT * FROM accident_cost JOIN contract ON accident_cost.contract_id=contract.contract_id AND
             contract.company_id='" . $row1['company_id'] . "'";
            $resultat4 = mysqli_query($con, $sql4);
            $sql5 = "SELECT * FROM contract WHERE company_id='".$row1['company_id']."'";
            $resultat5 = mysqli_query($con, $sql5);
            ?>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>  دفعات الشركة : <?php echo $company ?></h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell"> العقد</th>
                                    <th class="cell"> تاريخ الدفعة</th>
                                    <th class="cell"> رقم الشيك</th>
                                </tr>
                                <?php
                                $somme=0;
                                for ($i = 0; $i < mysqli_num_rows($resultat2); $i++) {
                            
                                    $row2 = mysqli_fetch_array($resultat2);
                                    // $req += $row2['required_amount'];
                                    $somme+=$row2['required_amount'];
                                    global $row2;
                                    echo "<tr class='row2' onclick='comp_info(" . $row2['companies_expenses_id'] . ")'>";
                                    echo "<td data-title='المبلغ'>" . $row2['required_amount'] . "</td>";
                                    echo "<td data-title='العقد'>" . $row2['contract_id'] . "</td>";
                                    echo "<td data-title='تاريخ الدفعة'>" . $row2['date'] . "</td>";
                                    echo "<td data-title='رقم الشيك'>" . $row2['check_number'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
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
                        <h4><?php echo '$'.$somme; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>  دفعات الشركة بدل حادث</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell"> الحادث</th>
                                    <th class="cell"> تفصيل الحادث</th>
                                    <th class="cell"> تاريخ الدفعة</th>
                                    <th class="cell"> رقم الشيك</th>
                                </tr>
                                <?php
                                $somme2=0;
                                for ($i = 0; $i < mysqli_num_rows($resultat3); $i++) {

                                    $row3 = mysqli_fetch_array($resultat3);
                                    // $req += $row2['required_amount'];
                                    $somme2+=$row3['required_amount'];
                                    global $row3;
                                    echo "<tr class='row2' onclick='comp_acc_info(" . $row3['companies_accident_expenses_id'] . ")'>";
                                    echo "<td data-title='المبلغ'>" . $row3['required_amount'] . "</td>";
                                    echo "<td data-title='الحادث'>" . $row3['accident_id'] . "</td>";
                                    echo "<td data-title=' تفصيل الحادث '>" . $row3['accident_cost_id'] . "</td>";
                                    echo "<td data-title='تاريخ الدفعة'>" . $row3['date'] . "</td>";
                                    echo "<td data-title='رقم الشيك'>" . $row3['check_number'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <table>
                    <tr>
                        <td>
                            <h3> مجموع الدفعات بدل حوادث  :</h3>
                        </td>
                        <td>
                        <h4><?php echo '$'.$somme2; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> الحوادث</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="acc" name="acc" onkeyup="myFunction1()" placeholder="بحث"">
                            </div>
                        
                         </div> 
                    </div>
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover" id="table1">
                                <tr class="row2 header">
                                <th class="cell"> الحادث</th>
                                    <th class="cell"> المبلغ</th>
                                    <th class="cell">تفصيل الحادث</th>
                                    <th class="cell"> تاريخ الدفعة</th>
                                    <th class="cell">العقد </th>
                                </tr>
                                <?php
                                $somme3=0;
                                for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {

                                    $row = mysqli_fetch_array($resultat4);
                                    $somme3+=$row['cost'];
                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $row['accident_id'] . "</td>";
                                    echo "<td class='cell'>" . $row['cost'] . "</td>"; 
                                    echo "<td class='cell'>" . $row['accident_cost_id'] . "</td>";
                                    echo "<td class='cell'>" . $row['date'] . "</td>";
                                    echo "<td class='cell'>" . $row['contract_id'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
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
                        <h4><?php echo '$'.$somme3; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
            <!-- <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <table>
                    <tr>
                        <td>
                            <h3> مجموع الدفعات :</h3>
                        </td>
                        <td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $tot; ?>" readonly>
                        </td>
                    </tr>
                </table>
            </div> -->
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> عقود الشركة</h3>
            </div>
            <div class="page-content" style="left: -300px; margin-right: 300px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="contract" name="contract" onkeyup="myFunction2()" placeholder="بحث" ">
                            </div>
                        
                         </div> 
                    </div>
           
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover" id="table2">
                                <tr class="row2 header">
                                    <th class="cell">  الزبون  </th>
                                    <th class="cell">  رقم العقد </th>
                                    <th class="cell"> السعر</th>
                                    <th class="cell"> حصة الشركة</th>
                                    <th class="cell"> الصافي </th>
                                    <th class="cell"> تاريخ الإبتداء</th>
                                    <th class="cell"> تاريخ الإنتهاء</th>
                                </tr>
                                <?php
                                $somme4=0;
                                for ($i = 0; $i < mysqli_num_rows($resultat5); $i++) {

                                    $row5 = mysqli_fetch_array($resultat5);
                                    $somme4+=$row5['price'];
                                    $sql6="SELECT * FROM person WHERE person_id = '".$row5['person_id']."'";
                                    $res6=mysqli_query($con,$sql6);
                                    $row6=mysqli_fetch_array($res6);
                                    $rest_am = $row5['price'] - $row5['office_portion'];
                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $row6['person_name'] . "</td>";
                                    echo "<td class='cell'>" . $row5['contract_number'] . "</td>";
                                    echo "<td class='cell'>" . $row5['price'] . "</td>";
                                    echo "<td class='cell'>" . $row5['office_portion'] . "</td>";
                                    echo "<td class='cell'>" . $rest_am . "</td>";
                                    echo "<td class='cell'>" . $row5['start_date'] . "</td>";
                                    echo "<td class='cell'>" . $row5['end_date'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <table>
                    <tr>
                        <td>
                            <h3> مجموع العقود  :</h3>
                        </td>
                        <td>
                        <h4><?php echo '$'.$somme4; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
                    <script type="text/javascript">
                     function myFunction1() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("acc");
                filter = input.value.toUpperCase();
                table = document.getElementById("table1");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    }       
                }
                }
                function myFunction2() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("contract");
                filter = input.value.toUpperCase();
                table = document.getElementById("table2");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    }       
                }
                }
                        function comp_info(id) {
                            location.href = "edit_comp_exp.php?comp_exp_id=" + id;
                        };
                        function comp_acc_info(id){
                            location.href = "edit_comp_acc_exp.php?comp_acc_id=" +id;
                        }
                    </script>

                </div>
            </div>
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