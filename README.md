
# Project Docker Compose - Web Server

โครงการนี้เป็นการตั้งค่า ระบบ PHP, MariaDB, Router, และ FFmpeg ด้วย Docker Compose พร้อมรองรับการใช้งาน .env เพื่อเชื่อมต่อฐานข้อมูลและปรับค่าต่าง ๆ ได้

คุณสมบัติ
	1.	PHP 8.2 + Apache:
	- รองรับการพัฒนาแอปพลิเคชัน PHP
	- ใช้ mod_rewrite เพื่อรองรับระบบ Router
	2.	MariaDB:
	- ฐานข้อมูลสำหรับจัดการข้อมูลแบบ Relational Database
	- การตั้งค่าผ่านไฟล์ .env
	3.	FFmpeg:
	- ใช้สำหรับแปลงไฟล์วิดีโอเป็นรูปแบบ M3U8
	4.	Router:
	- ระบบจัดการเส้นทาง (Routing) สำหรับการสร้าง RESTful API
	5.	Security:
	- ตรวจจับ SQL Injection ในข้อมูลที่ส่งมาผ่าน $_POST และ $_GET

---

## การตั้งค่า (Setup)

### 1. ติดตั้ง Docker และ Docker Compose
ดาวน์โหลดและติดตั้ง Docker จากเว็บไซต์: [Docker Official Site](https://www.docker.com/)

### 2. สร้างไฟล์ `.env` สำหรับ Docker Compose
ในโฟลเดอร์ root (`project-docker-compose/`) สร้างไฟล์ `.env` ด้วยเนื้อหาดังนี้:
```env
# PHP-Apache
PHP_PORT=8000

# Database
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=test_db
MYSQL_USER=test_user
MYSQL_PASSWORD=test_pass
DB_PORT=9906

```

### 3. สร้างไฟล์ `.env` สำหรับ PHP
ในโฟลเดอร์ `php/src` สร้างไฟล์ `.env` ด้วยเนื้อหาดังนี้:
```env
DB_HOST=db
DB_NAME=test_db
DB_USER=test_user
DB_PASS=test_pass
DB_PORT=3306
```

### 4. สร้างไฟล์ `composer.json`
ในโฟลเดอร์ `php/src` สร้างไฟล์ `composer.json` ด้วยเนื้อหาดังนี้:
```json
{
    "require": {
        "vlucas/phpdotenv": "^5.6"
    }
}
```

---

## การใช้งาน (Usage)

### 1. สร้างและรัน Container
รันคำสั่งต่อไปนี้ในโฟลเดอร์ root ของโปรเจกต์:
```bash
docker-compose up --build -d
```

### 2. ตรวจสอบสถานะ Container
ตรวจสอบว่า Container ทั้งหมดกำลังทำงาน:
```bash
docker ps
```

### 3. เข้าถึงบริการ
- PHP: [http://localhost:8000](http://localhost:8000)

---

## ตัวอย่างโค้ด PHP เชื่อมต่อฐานข้อมูล (conn.php)

ไฟล์ `php/src/conn.php`:
```php
<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$port = $_ENV['DB_PORT'];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

---

## คำสั่งที่ใช้บ่อย (Common Commands)

### สร้างและรัน Container ใหม่
```bash
docker-compose up --build -d
```

### หยุด Container
```bash
docker-compose down
```

### เข้าไปใน Container
```bash
docker exec -it php-apache bash
```

### ตรวจสอบไฟล์ใน Container
```bash
docker exec -it php-apache ls /var/www/html
```

---

## ปัญหาที่พบบ่อย (Troubleshooting)

### 1. `vendor/autoload.php` ไม่ถูกสร้าง
ให้เข้าไปใน Container แล้วรันคำสั่ง `composer install`:
```bash
docker exec -it php-apache bash
composer install
```

### 2. MariaDB ไม่สามารถเชื่อมต่อกับฐานข้อมูล
- ตรวจสอบไฟล์ `.env` ว่าค่า `DB_HOST` และ `MYSQL_ROOT_PASSWORD` ถูกต้องหรือไม่
- ลองรีสตาร์ท Container:
  ```bash
  docker-compose restart
  ```

---

## License

This project is licensed under the MIT License - see the LICENSE file for details.

