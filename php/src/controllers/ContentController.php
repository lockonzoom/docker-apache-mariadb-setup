<?php
class ContentController {
    /**
     * Handle GET request for /content
     * แสดงข้อความต้อนรับสำหรับหน้า Content Page
     */
    public function index() {
        echo "Welcome to the Content Page!";
    }

    /**
     * Handle GET request for /content/id/{id}/page/{page}
     * ดึงข้อมูลไดนามิกตาม ID และ Page
     *
     * @param int $id - Content ID ที่ส่งมาใน URL
     * @param int $page - Page ที่ส่งมาใน URL
     */
    public function show($id, $page) {
        echo "Content ID: $id<br>";
        echo "Page: $page";
    }

    /**
     * Handle POST request for /submit
     * รับข้อมูลที่ส่งมาผ่านฟอร์มและแสดงผล
     *
     * @throws Exception - ส่งข้อความแจ้งว่ารองรับเฉพาะคำขอ POST เท่านั้น
     */
    public function store() {
        // ตรวจสอบว่าคำขอเป็น POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // รับข้อมูลจากฟอร์ม
            $name = $_POST['name'] ?? 'Unknown'; // ค่า Default: Unknown
            $message = $_POST['message'] ?? 'No message'; // ค่า Default: No message

            // แสดงข้อมูลที่รับมา
            echo "Name: $name<br>";
            echo "Message: $message";
        } else {
            // กรณีที่คำขอไม่ใช่ POST
            echo "This route only accepts POST requests.";
        }
    }
}