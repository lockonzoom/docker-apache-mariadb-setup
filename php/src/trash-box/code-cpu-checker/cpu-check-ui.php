<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Usage Monitor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>CPU Usage Monitor</h1>
    <table border="1">
        <thead>
            <tr>
                <th>PID</th>
                <th>Process Name</th>
                <th>CPU %</th>
            </tr>
        </thead>
        <tbody id="cpu-usage">
            <tr>
                <td colspan="3">Loading...</td>
            </tr>
        </tbody>
    </table>

    <script>
        function fetchCpuUsage() {
            $.ajax({
                url: "cpu_check.php", // ชื่อ PHP Script
                method: "GET",
                dataType: "json",
                success: function(data) {
                    // เคลียร์ข้อมูลเก่า
                    $('#cpu-usage').empty();

                    if (data.processes.length > 0) {
                        // แสดงข้อมูลใหม่
                        data.processes.forEach(function(process) {
                            $('#cpu-usage').append(`
                                <tr>
                                    <td>${process.pid}</td>
                                    <td>${process.name}</td>
                                    <td>${process.cpu}%</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#cpu-usage').append('<tr><td colspan="3">No process found</td></tr>');
                    }
                },
                error: function() {
                    $('#cpu-usage').html('<tr><td colspan="3">Error fetching data</td></tr>');
                }
            });
        }

        // เรียก fetchCpuUsage ทุก 2 วินาที
        setInterval(fetchCpuUsage, 2000);
        fetchCpuUsage(); // เรียกครั้งแรก
    </script>
</body>
</html>