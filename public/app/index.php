<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallak Insurance</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel=”stylesheet” href=”assets/css/bootstrap.css”>
    <link rel=”stylesheet” href=”assets/css/bootstrap-responsive.css”>
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>
<body>
    <?php
        include_once "connection.php";
        if (isset($_COOKIE["adminAcc"]) && isset($_COOKIE["adminPass"])){
            $user = $_COOKIE["adminAcc"];
            $pass = $_COOKIE["adminPass"];
            $result = mysqli_query($con, "SELECT * FROM admin WHERE username = '$user' and password = '$pass'");
            if(mysqli_num_rows($result)==false){
              header("Location:logout.php");
            } else {
              session_start();
              
              $_SESSION["wp20admin"] = $user;
            }
          }
          
        ?>
    <div class="row"><Center>
        <div style="margin: 100px;">
        <h3> تسجيل دخول </h3>
    </div>
        <div class="col-md-6">
         <div class="form-group">
             <form action="signin.php" method="post">
            <label for="username" style="float: right; font-size: large;">إسم المستخدم</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="إسم المستخدم">
         </div>
         <div class="form-group">
            <label for="username"  style="float: right; font-size: large;">كلمة السر</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="كلمة السر">
         </div>
         <br>
         <div class="buttons">
            <button type="submit" name="SigninBtn" class="btn btn-primary"> تسجيل دخول</button>
            </div>
        </center>
    </div>

<script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="assets/js/pages/dashboard.js"></script>

    <script src="assets/js/main.js"></script>

</body>

</html>