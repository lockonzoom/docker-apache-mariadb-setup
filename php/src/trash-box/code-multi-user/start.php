<?php
session_start();

$fileName = "video";

// ตั้งค่า Path และไฟล์
$ffmpegPath = "/usr/bin/ffmpeg";
$inputFile = "./mp4/video_user_" . $fileName . ".mp4";
$outputFile = "./m3u8/output_user_" . $fileName . ".m3u8";
$lockFile = "./locks/" . $fileName . "_" . md5($inputFile) . ".lock";

// ตรวจสอบว่ามีไฟล์ .lock อยู่หรือไม่
if (file_exists($lockFile)) {
    // อ่านข้อมูลจาก .lock
    $lockData = json_decode(file_get_contents($lockFile), true);
    $pid = $lockData['pid'];

    // ตรวจสอบว่า PID ยังคงทำงานอยู่หรือไม่
    if ($pid && posix_getpgid($pid)) {
        echo "This file is already being processed by PID $pid. Please wait.<br>";
        exit;
    } else {
        // หาก Process ไม่ทำงานแล้ว ให้ลบไฟล์ .lock เก่า
        unlink($lockFile);
    }
}

// สร้างไฟล์ .lock และเขียนข้อมูล
file_put_contents($lockFile, json_encode([
    'user_id' => $fileName,
    'file' => $inputFile,
    'status' => 'processing',
    'pid' => null
]));

// สร้างคำสั่ง FFmpeg
$command = "$ffmpegPath -i $inputFile -vf scale=1920:1080 -c:v libx264 -preset veryfast -crf 23 -c:a copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls $outputFile";

$descriptorspec = [
    0 => ["pipe", "r"],  // stdin
    1 => ["pipe", "w"],  // stdout
    2 => ["pipe", "w"],  // stderr
];

$process = proc_open($command, $descriptorspec, $pipes);

if (is_resource($process)) {
    // ดึง PID และอัปเดตในไฟล์ .lock
    $status = proc_get_status($process);
    $pid = $status['pid'];
    $lockData = json_decode(file_get_contents($lockFile), true);
    $lockData['pid'] = $pid;
    file_put_contents($lockFile, json_encode($lockData));

    echo "FFmpeg process started with PID: $pid<br>";

    // รอจนกระบวนการเสร็จสิ้น
    while (proc_get_status($process)['running']) {
        sleep(1);
    }

    // ลบไฟล์ .lock เมื่อเสร็จสิ้น
    unlink($lockFile);
    echo "Processing completed.<br>";
} else {
    unlink($lockFile); // ลบ .lock หากเริ่มไม่สำเร็จ
    echo "Failed to start FFmpeg process.<br>";
}
?>