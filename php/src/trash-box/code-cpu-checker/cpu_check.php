<?php
header('Content-Type: application/json');

// ดึงจำนวน Core CPU ด้วยคำสั่ง nproc
$numCores = (int)trim(shell_exec('nproc'));

// ค้นหา Process (เช่น ffmpeg)
$processName = "ffmpeg";

// คำสั่ง ps เพื่อดู CPU %, PID และชื่อ Process
$command = "ps aux | grep $processName | grep -v grep | awk '{print $3, $2, $11}'"; // $3 = %CPU, $2 = PID, $11 = Command
exec($command, $output, $retval);

// จัดรูปแบบผลลัพธ์
$processes = [];
foreach ($output as $line) {
    $parts = preg_split('/\s+/', $line, 3); // แบ่งข้อมูล

    $processes[] = [
        'cpu' => (int)($parts[0]/$numCores),  // CPU %
        'pid' => $parts[1],  // PID
        'name' => $parts[2]  // Command/Process Name
    ];
}

// ส่งข้อมูลกลับในรูปแบบ JSON
echo json_encode(['processes' => $processes]);