<?php
class AjaxGetController {
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // ตัวอย่างข้อมูลที่จะส่งกลับเป็น JSON
            $response = [
                'status' => 'success',
                'message' => 'This is a response from AJAX GET.',
                'data' => [
                    'id' => 123,
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com'
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

/*
ตัวอย่างผลลัพธ์ JSON

เมื่อคุณเรียก /ajax-get ผ่าน AJAX GET จะได้ผลลัพธ์:
{
    "status": "success",
    "message": "This is a response from AJAX GET.",
    "data": {
        "id": 123,
        "name": "John Doe",
        "email": "john.doe@example.com"
    }
}
    */