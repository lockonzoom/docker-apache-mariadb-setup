<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Example with PHP Version</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fluid p-5 bg-primary text-white text-center">
  <h1>Project Docker Compose - PHP, MariaDB</h1>
  <p>โครงการนี้เป็นการตั้งค่าระบบ PHP และ MariaDB ด้วย Docker Compose</p>
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12">
      <h2>โครงสร้างไฟล์ (File Structure)</h2>
      <pre class="bg-light p-3">
project-docker-compose/
├── docker-compose.yml          # Configuration สำหรับ Docker Compose
├── .env                        # Environment Variables สำหรับ Docker Compose
├── php/
│   ├── Dockerfile              # Dockerfile สำหรับสร้าง PHP Container
│   └── src/                    # โฟลเดอร์เก็บโค้ด PHP
│       ├── composer.json       # Dependency สำหรับ PHP
│       ├── .env                # Environment Variables สำหรับ PHP
│       └── conn.php            # ตัวอย่างโค้ด PHP สำหรับเชื่อมต่อฐานข้อมูล
      </pre>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-sm-12">
      <h2>PHP Version</h2>
      <p>Current PHP Version: 
        <strong>
          <?php echo phpversion(); ?>
        </strong>
      </p>
    </div>
    <div class="col-sm-12">
    <h2>PHP Connect MariaDB</h2>
    <p>Connect : 
        <strong>
          <?php include('conn.php'); ?>
        </strong>
      </p>
    </div>
    <div class="col-sm-12">
    <h2>Conversion MP4 to M3U8</h2>
    <p>Test Conversion : 
        <strong>
          <?php include('convert-ui.php'); ?>
        </strong>
      </p>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-sm-12">
      <h2>License</h2>
      <p>This project is licensed under the MIT License.</p>
    </div>
  </div>
</div>

</body>
</html>
