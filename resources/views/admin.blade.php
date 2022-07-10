<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SweetSmile 甜點工坊後台管理</title>
    <link rel="shortcut icon" href="favicon.ico" >
    <link rel="stylesheet" type="text/css" href="<?php echo mix('css/app.css'); ?>">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo asset('css/app.css'); ?>"> -->
</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>
    <script src="<?php echo mix('js/app.js'); ?>"></script>
    <!-- <script src="<?php echo asset('js/app.js'); ?>"></script> -->
</body>
</html>
