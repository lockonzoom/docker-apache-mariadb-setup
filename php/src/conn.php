<?php
require './function/phpFunction.php';
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

/**
 * ฟังก์ชันสำหรับการเชื่อมต่อฐานข้อมูล MySQL
 *
 * @return PDO
 * @throws PDOException
 */
function connectDatabase(): PDO
{
    // โหลดค่าจาก .env
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // อ่านค่าการตั้งค่าฐานข้อมูลจาก .env
    $dbHost = $_ENV['DB_HOST'] ?? 'localhost';
    $dbName = $_ENV['DB_NAME'] ?? 'test';
    $dbUser = $_ENV['DB_USER'] ?? 'root';
    $dbPass = $_ENV['DB_PASS'] ?? '';
    $dbPort = $_ENV['DB_PORT'] ?? '3306';

    try {
        // สร้าง Data Source Name (DSN)
        $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";

        // สร้างการเชื่อมต่อ PDO
        $pdo = new PDO($dsn, $dbUser, $dbPass);

        // ตั้งค่าข้อผิดพลาดให้โยนข้อผิดพลาดเป็น Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        // หากเกิดข้อผิดพลาด ให้โยนข้อผิดพลาดกลับไป
        throw new PDOException("Database connection failed: " . $e->getMessage());
    }
}

// ตัวอย่างการใช้งาน
try {
    $db = connectDatabase();
    echo "เชื่อมต่อฐานข้อมูลสำเร็จ!";
} catch (PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}