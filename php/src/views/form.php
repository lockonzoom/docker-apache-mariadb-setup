<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Example</title>
    <script>
        function fetchAjax() {
            fetch('http://localhost:8000/ajax') // URL เส้นทางที่กำหนดไว้ใน routes.php
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // เรียกฟังก์ชันแสดงข้อมูลในตาราง
                    displayTable(data.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayTable(data) {
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = ''; // ล้างข้อมูลเก่าในตาราง

            // แปลงข้อมูลให้เป็น Array เพื่อใช้ Template Literals
            Object.entries(data).forEach(field => {
                const row = `
                    <tr>
                        <td>${field[0]}</td> <!-- คีย์ เช่น id -->
                        <td>${field[1]}</td> <!-- ค่า เช่น 456 -->
                    </tr>
                `;
                tableBody.innerHTML += row; // เพิ่มแถวในตาราง
            });
        }
    </script>
    <style>
        table {
            width: 50%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>AJAX Example</h1>
    <button onclick="fetchAjax()">Fetch AJAX</button>

    <table>
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody id="table-body"></tbody> <!-- ตารางที่จะแสดงข้อมูล -->
    </table>



    <hr>
    <p> ลบ code ส่วนนี้ได้ไม่เกี่ยวของกัน  <a href="http://localhost:8000/content/id/5001/page/1">Go to Content Page (GET)</a><br><br></p>
</body>
</html>