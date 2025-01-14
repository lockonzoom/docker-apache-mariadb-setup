
# Project Docker Compose - PHP, MariaDB

โครงการนี้เป็นการตั้งค่าระบบ PHP, MariaDB ด้วย Docker Compose โดยรองรับการใช้งาน `vlucas/phpdotenv` สำหรับจัดการ Environment Variables ใน PHP

---

## โครงสร้างไฟล์ (File Structure)

```
project-docker-compose/
├── docker-compose.yml          # Configuration สำหรับ Docker Compose
├── .env                        # Environment Variables สำหรับ Docker Compose
├── php/
│   ├── Dockerfile              # Dockerfile สำหรับสร้าง PHP Container
│   └── src/                    # โฟลเดอร์เก็บโค้ด PHP
│       ├── composer.json       # Dependency สำหรับ PHP
│       ├── .env                # Environment Variables สำหรับ PHP
│       └── conn.php            # ตัวอย่างโค้ด PHP สำหรับเชื่อมต่อฐานข้อมูล
```

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
# docker-compose--webserverPHP-env-
# docker-compose-webserverPHP-env
# docker-compose-webserverPHP-env
