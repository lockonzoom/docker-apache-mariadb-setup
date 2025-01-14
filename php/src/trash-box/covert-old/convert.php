<?php
$inputFile = "./mp4/video.mp4";
$outputFile = "./m3u8/output.m3u8";
$ffmpegPath = "ffmpeg";
$jsonFile = './mp4/process-convert-data.json';

if (!file_exists('./mp4')) {
    mkdir('./mp4', 0777, true); // สร้างโฟลเดอร์ mp4 หากยังไม่มี
}

if (!file_exists('./m3u8')) {
    mkdir('./m3u8', 0777, true); // สร้างโฟลเดอร์ m3u8 หากยังไม่มี
}

// ตรวจสอบว่า FFmpeg ติดตั้งแล้วหรือไม่
if (!shell_exec("$ffmpegPath -version")) {
    die(json_encode(["error" => "FFmpeg is not installed or not accessible."]));
}

// ดึงความยาววิดีโอจากไฟล์
$durationOutput = shell_exec("$ffmpegPath -i $inputFile 2>&1 | grep 'Duration'");
preg_match('/Duration: (\d+):(\d+):([\d.]+)/', $durationOutput, $matches);
if (!empty($matches)) {
    $hours = (int)$matches[1];
    $minutes = (int)$matches[2];
    $seconds = (float)$matches[3];
    $totalDuration = ($hours * 3600) + ($minutes * 60) + $seconds; // ความยาววิดีโอในหน่วยวินาที
} else {
    die(json_encode(["error" => "Failed to retrieve video duration."]));
}

// สร้างไฟล์ JSON เริ่มต้น
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode(["progress" => 0, "time-stamp" => date('Y-m-d H:i:s')]));
}

//$command = "$ffmpegPath -i $inputFile -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls $outputFile";

$command = "$ffmpegPath -i $inputFile -vf scale=1920:1080 -c:v libx264 -preset veryfast -crf 23 -c:a copy -start_number 0 -hls_time 10 -hls_list_size 0 -f hls $outputFile";

$descriptorspec = [
    1 => ["pipe", "w"], // stdout
    2 => ["pipe", "w"], // stderr
];

$process = proc_open($command, $descriptorspec, $pipes);

if (is_resource($process)) {
    while ($line = fgets($pipes[2])) {
        if (preg_match('/time=([0-9:.]+)/', $line, $matches)) {
            $currentTime = $matches[1];
            $currentSeconds = convertTimeToSeconds($currentTime);
            $progress = ($currentSeconds / $totalDuration) * 100;
           
            // เขียนข้อมูล progress และ timestamp ลงไฟล์ JSON
            file_put_contents($jsonFile, json_encode([
                "progress" =>  round($progress, 2),
                "time-stamp" => date('Y-m-d H:i:s'),
                "status" => 'Incomplete'
            ]));
  
        }
    }

    // แปลงเสร็จแล้ว อัปเดตไฟล์ JSON เป็น 100%
    file_put_contents($jsonFile, json_encode([
        "progress" => 100,
        "time-stamp" => date('Y-m-d H:i:s'),
         "status" => 'complete'
    ]));

    sleep(5); // หน่วงเวลา 5 วินาที
    // แปลงเสร็จแล้ว อัปเดตไฟล์ JSON เป็น 0
    file_put_contents($jsonFile, json_encode([
        "progress" => 0,
         "time-stamp" => date('Y-m-d H:i:s'),
         "status" => 'complete'
    ]));

    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);
}

function convertTimeToSeconds($time) {
    list($hours, $minutes, $seconds) = array_pad(explode(':', $time), 3, 0);
    return ($hours * 3600) + ($minutes * 60) + (float) $seconds;
}
?>
