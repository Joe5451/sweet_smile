<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>檔案上傳測試</title>
    <link rel="shortcut icon" href="favicon.ico" >
</head>
<body>
    <form action="{{ route('test') }}" method="post" enctype="multipart/form-data">
        <input type="file" name="demo">
        <input type="submit" value="上傳">
    </form>
</body>
</html>