# PHP Routing 
 
 - ./views
 - ./controllers
 - .htaccess (ไฟล์นี้ถูกซ่อนอยู่ hidden file)
 - controllers.php
 - routes.php

 # Connect Database 

 - .env
 - conn.php

---

# PHP Routing Example

โปรเจกต์นี้เป็นตัวอย่างการใช้งาน **PHP Routing** เพื่อจัดการกับคำขอ **GET** และ **POST** อย่างมีประสิทธิภาพ โดยสามารถเพิ่มหน้าใหม่หรือเส้นทาง (Route) ได้อย่างง่ายดาย

---

## การเพิ่มหน้าใหม่: Page "About"

### 1. เพิ่มเส้นทางใน `routes.php`
แก้ไขไฟล์ `routes.php` เพื่อเพิ่มเส้นทางสำหรับหน้า About:
```php
<?php
return [
    '/about' => 'AboutController@index',  
];
```

---

### 2. สร้างไฟล์ Controller: `AboutController.php`
สร้างไฟล์ `AboutController.php` ในโฟลเดอร์ `controllers/` พร้อมโค้ดดังนี้:
```php
<?php
class AboutController {  // ชื่อ class ต้องเหมือนชื่อไฟล์ AboutController.php
    public function index() {
        echo "Welcome to the About Page!";
    }
}
```

---

### 3. ทดสอบหน้า About
- เปิดเบราว์เซอร์และไปที่:
```
http://[localhost:port]/about
```
- คุณจะเห็นข้อความ:
```
Welcome to the About Page!
```

---

## ตัวอย่างการทดสอบ GET Request
ตัวอย่างการส่งคำขอ **GET** ไปยังเส้นทางแบบไดนามิก:
- URL: 
```
http://[localhost:port]/content/id/5001/page/1
```

### คำอธิบาย:
- `/content/id/{id}/page/{page}` เป็นเส้นทางแบบไดนามิกที่กำหนดไว้ใน `routes.php`
- ระบบจะส่งค่าพารามิเตอร์ `id=5001` และ `page=1` ไปยังฟังก์ชัน `show` ใน `ContentController.php`

---

## ตัวอย่างการเพิ่มเส้นทางสำหรับ **POST**
### 1. เพิ่มเส้นทางใน `routes.php`
```php
<?php
return [
    '/submit' => 'ContentController@store', // จัดการ POST Request
];
```

---

### 2. สร้างฟอร์ม HTML สำหรับส่ง POST
สร้างฟอร์ม HTML ดังนี้:
```html
<form action="http://[localhost:port]/submit" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    
    <button type="submit">Send</button>
</form>
```

---

### 3. สร้างฟังก์ชัน `store` ใน `ContentController.php`
```php
<?php
class ContentController {
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? 'Unknown';
            $message = $_POST['message'] ?? 'No message';

            echo "Name: $name<br>";
            echo "Message: $message";
        } else {
            echo "This route only accepts POST requests.";
        }
    }
}
```

---

### 4. ทดสอบ POST Request
1. เข้าสู่ฟอร์มที่คุณสร้างไว้
2. กรอกข้อมูลและกด "Send"
3. ระบบจะส่งข้อมูลไปยัง `/submit` และแสดงผลข้อมูลที่ได้รับ

---

## สรุป
- คุณสามารถเพิ่มหน้าใหม่ได้ง่าย ๆ โดยการเพิ่มเส้นทางใน `routes.php` และสร้าง Controller ที่เกี่ยวข้อง
- รองรับทั้ง **GET** และ **POST** อย่างครบถ้วน
- เส้นทางแบบไดนามิกช่วยให้คุณส่งค่าผ่าน URL ได้อย่างง่ายดาย

---

### ตัวอย่างอื่น ๆ
- **GET**: 
```
http://[localhost:port]/content
```
- **POST**:
```
http://[localhost:port]/submit
```

---

## การแก้ไขปัญหาเส้นทางของไฟล์ (Path Issue)

ในกรณีที่มีปัญหาเกี่ยวกับการกำหนดเส้นทางไฟล์ เช่น `include './views/form.php';` ใช้งานได้ แต่ `include '../views/form.php';` ไม่ได้
สาเหตุเกิดจาก PHP จะอ้างอิงเส้นทางจากตำแหน่งของไฟล์ที่ถูกเรียกใช้งานครั้งแรก (entry point) เช่น `index.php`

### วิธีแก้ไข:
1. ใช้เส้นทางแบบสัมพัทธ์ (`./views/form.php`) เฉพาะเมื่อไฟล์อยู่ในตำแหน่งที่สอดคล้องกับโครงสร้างการเรียกใช้งาน.
2. ใช้ **ค่าคงที่ (Constants)** ใน `index.php` เพื่อกำหนดตำแหน่งไฟล์ที่แน่นอน:
   ```php
   define('VIEW_PATH', __DIR__ . '/views/');
   ```

3. ใน Controller ใช้ค่าคงที่แทน:
   ```php
   include VIEW_PATH . 'form.php';
   ```

### ตัวอย่างโครงสร้างไฟล์:
```
src/
├── controllers/
│   ├── FormController.php
├── views/
│   ├── form.php
└── index.php
```

---

ด้วยวิธีนี้คุณจะสามารถหลีกเลี่ยงปัญหาการกำหนดเส้นทางไฟล์ใน PHP ได้.
