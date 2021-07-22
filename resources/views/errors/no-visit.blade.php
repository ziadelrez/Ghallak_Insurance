<!DOCTYPE html>
<html>
<head>
    <title>Sorry - SoClinics</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 700;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 40px;
            margin-bottom: 40px;
        }

        .red {
            color: #ff2e44;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title "><span class="red">{{trans('system.NO_VISIT')}}</span> <br/>
        </div>
        <br/>
        <span style="color: #171a1d"> <a href="javascript:;" style="color: #ff2e44" onclick="history.go(-1);"> Go Back </a>  </span>
    </div>
</div>
</body>
</html>
