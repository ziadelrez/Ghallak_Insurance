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
    } ?>
    
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
            <!-- <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3>  </h3>
            </div> -->
            <?php
            $person = $_GET['person'];
            $query3 = "SELECT * FROM person WHERE person_name = '$person'";
            $resultat3 = mysqli_query($con, $query3);
            $row3 = mysqli_fetch_array($resultat3);
            $sql4 = "SELECT * FROM client_expenses WHERE client_id = '" . $row3['person_id'] . "'";
            $resultat4 = mysqli_query($con, $sql4);
            global $row;
            $req = 0;
            ?>

            <div class="page-heading" style="right: -200px; margin-right: 300px;">
               <h3>  دفعات الزبون : <?php echo $person ?></h3>
            </div>

            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover" id="table1">
                                <tr class="row2 header">
                                    <th style="width: 10px;"> </th>
                                    <th class="cell"> المبلغ بالدولار</th>
                                    <th class="cell"> المبلغ باللبناني</th>
                                    <th class="cell"> العقد</th>
                                    <th class="cell"> تاريخ الدفعة</th>
                                    <th class="cell"> رقم الشيك</th>
                                    <th class="cell"> البنك </th>
                                </tr>
                                <?php
                                $somme = 0;
                                for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {
                                    //$row = mysqli_fetch_array($resultat4);
                                    //echo json_encode($resultat4);
                                    $row = mysqli_fetch_array($resultat4);

                                    $req += $row['required_amount'];
                                    //echo json_encode($row);
                                    $sql = "SELECT * FROM contract WHERE contract_id = '" . $row['contract_id'] . "'";
                                    $res = mysqli_query($con, $sql);
                                    $row1 = mysqli_fetch_array($res);
                                    if($row['lebanese_amount'] == null){
                                        $lb = 0;
                                    }else $lb = $row['lebanese_amount'];
                                    $somme += $row['required_amount'];
                                    $sql3="SELECT * FROM bank WHERE bank_id = '".$row['bank_id']."'";
                                    $res3=mysqli_query($con, $sql3);
                                    $row70=mysqli_fetch_array($res3);
                                    echo "<tr class='row2' onclick='exx(" . $row['client_expenses_id'] . ")'>";
                                    echo "<td><input type='checkbox' onclick='GetSelected(event, " .  $person . ", " . $row['required_amount'] . ", " . $lb . ", \"" . $row1['contract_number'] . "\")'></td>";
                                    echo "<td data-title='المبلغ'>" . $row['required_amount'] . "</td>";
                                    echo "<td data-title='المبلغ باللبناني'>" . $row['lebanese_amount'] . "</td>";
                                    echo "<td data-title='العقد'>" . $row1['contract_number'] . "</td>";
                                    echo "<td data-title='تاريخ الدفعة'>" . $row['payday'] . "</td>";
                                    echo "<td data-title='رقم الشيك'>" . $row['check_number'] . "</td>";
                                    echo "<td data-title='البنك'>" . $row70['bank_name'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="buttons">
                        <button type="submit" name="submit" onclick="wasel()" formtarget="_blank" class="btn btn-primary"> الإيصال</button>
                    </div>
                </div>
            </div>
            <script>
                
                var amount=0;
                var lebanese=0;
                var ar = new Array();
                var arr = new Array();
                function GetSelected(event, id, amount1, lebanese1, contract) {
                    //Reference the Table.
                    event.stopPropagation();

                    var checkBox = document.getElementsByTagName("input");

                    if (!ar.includes(id)) {
                        // if(!arr.includes(contract)){
                            arr.push(contract);
                        // }
                        
                        amount += parseFloat(amount1);
                        lebanese += parseFloat(lebanese1);
                        ar.push(id);
                        console.log(ar);
                        console.log(arr);
                    } else {
                        const index1 = arr.indexOf(contract);
                        arr.splice(index1, 1);
                        amount -= amount1;
                        lebanese -= lebanese1;
                        const index = ar.indexOf(id);
                        ar.splice(index, 1);
                        console.log(index);
                        console.log(ar);
                        console.log(arr);
                    }
                }
            
                function wasel() {
                var cont = new Set(arr);
                    var person = <?php echo json_encode($person); ?>;
                    
                    var location = "client_receipt.php?client=" + person + "&somme=" + amount + "&contracts=" + [...cont].join(" - ") + "&lebanese=" + lebanese;
                    window.open(location, '_blank');
                }
            </script>
            <br>
            <?php
            $sql2 = "SELECT * FROM contract WHERE person_id = '" . $row3['person_id'] . "'";
            $res2 = mysqli_query($con, $sql2);
            if (mysqli_num_rows($res2)!=0) {
                for ($i = 0; $i < mysqli_num_rows($res2); $i++) {
                    $row2 = mysqli_fetch_array($res2);
                    global $total_amount;
                    $total_amount += $row2['price'];
                }
                $total = $total_amount - $req;
            }else $total = 0;
            ?>
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
                <table>
                    <tr>
                        <td>
                            <h3> الدفعات المتبقية :</h3>
                        </td>
                        <td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> الدفعات القادمة</h3>
            </div>
            <?php
            $now = date('y/m/d');
            ?>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell">تاريخ الدفعة القادمة</th>
                                </tr>
                                <?php
                                mysqli_data_seek($resultat4, 0);
                                for ($i = 0; $i < mysqli_num_rows($resultat4); $i++) {

                                    $row5 = mysqli_fetch_array($resultat4);

                                    //echo json_encode($row5);
                                    if (strtotime($row5['next_paydate']) > strtotime($now)) {
                                        echo "<tr class='row2' onclick='ex(" . $row5['client_expenses_id'] . ")'>";
                                        echo "<td data-title=' تاريخ الدفعة القادمة'>" . $row5['next_paydate'] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="page-heading" style="right: -200px; margin-right: 300px;">
                <h3> عقود الزبون</h3>
            </div>
            <?php
            $q = "SELECT * FROM contract WHERE person_id = '" . $row3['person_id'] . "'";
            $r = mysqli_query($con, $q);
            $somme2=0;
            ?>
            <div class="page-content" style="left: -300px; margin-right: 300px; ">
                <div class="card-body">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <table class="table table-striped table-hover">
                                <tr class="row2 header">
                                    <th class="cell"> رقم العقد</th>
                                    <th class="cell"> سعر العقد</th>
                                    <th class="cell"> حصة العميل</th>
                                    <th class="cell"> نوع العقد</th>
                                </tr>
                                <?php
                                for ($i = 0; $i < mysqli_num_rows($r); $i++) {
                                    $roww = mysqli_fetch_array($r);
                                    $qq = "SELECT * FROM contract_type WHERE contract_type_id = '" . $roww['contract_type_id'] . "'";
                                    $rr = mysqli_query($con, $qq);
                                    $rowww = mysqli_fetch_array($rr);
                                    $somme2+=$roww['price'] ;
                                    echo "<tr class='row2'>";
                                    echo "<td class='cell'>" . $roww['contract_number'] . "</td>";
                                    echo "<td class='cell'>" . $roww['price'] . "</td>";
                                    echo "<td class='cell'>" . $roww['agent_portion'] . "</td>";
                                    echo "<td class='cell'>" . $rowww['type'] . "</td>";
                                    echo "</tr>";
                                } ?>
                            </table>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function exx(id) {
                            location.href = "edit_client_expenses.php?client_expenses_id=" + id;
                        };
                    </script>

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
                        <h4><?php echo '$'.$somme2; ?></h4>
                        <!--<td><input type="text" class="form-control" id="total" name="total" style="margin-right: 10px" value="<?php echo $total; ?>" readonly>-->
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </div>
        <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"></script> -->
        <script src="assets/js/main.js"></script>  <!-- jQuery CDN - Slim version (=without AJAX) -->
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