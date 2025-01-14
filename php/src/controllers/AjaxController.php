<?php
class AjaxController {
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // ตัวอย่างข้อมูล JSON ที่ส่งกลับ
            $response = [
                'status' => 'success',
                'message' => 'This is a response from AJAX.',
                'data' => [
                    'id' => 456,
                    'name' => 'Jane Doe',
                    'email' => 'jane.doe@example.com'
                ]
            ];

            // ตั้งค่า Content-Type เป็น JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // กรณีที่คำขอไม่ใช่ GET
            http_response_code(405); // Method Not Allowed
            echo json_encode(['status' => 'error', 'message' => 'Only GET requests are allowed.']);
        }
    }
}