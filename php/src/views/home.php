<?php require('./function/phpFunction.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET and POST Examples</title>
</head>
<body>
    <h1>GET and POST Examples</h1>



    <img src="../img/dog.png" style="width: 300px; height:auto;" alt="">

    <!-- ลิงก์ GET -->
    <a href="http://localhost:8000/content/id/5001/page/1">Go to Content Page (GET)</a><br><br>


    <a href="http://localhost:8000/form">Resive JSON Data form AJAX Example</a><br><br>

    <!-- ฟอร์มสำหรับ POST -->
    <form action="http://localhost:8000/submit" method="post" style="display: inline;">
        <input type="text" name="name" value="John">
        <input type="text" name="message" value="Hello, this is a test message!">
        <button type="submit">Go to Submit Page (POST)</button>
    </form>
</body>
</html>