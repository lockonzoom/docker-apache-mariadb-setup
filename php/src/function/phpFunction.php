<?php 
function detectSQLInjection($input) {
    $patterns = [
        '/\bSELECT\b/i',
        '/\bUNION\b/i',
        '/\bINSERT\b/i',
        '/\bUPDATE\b/i',
        '/\bDELETE\b/i',
        '/\bDROP\b/i',
        '/\b--\b/i',
        '/\b#\b/i',
        '/\bOR\b/i',
        '/\bAND\b/i',
        '/\b1=1\b/i',
        '/\b\' OR \'\b/i',
        '/\b\'=\'\b/i',
        '/\b;\b/i',
        '/<script\b[^>]*>/i',
        '/<\/script>/i',
        '/\balert\b/i',
        '/\bon\w+=/i',
        '/\bjavascript:/i',
        '/<img\b[^>]*onerror=/i',
        '/document\.cookie/i',
        '/<iframe\b[^>]*>/i',
        '/<\/iframe>/i'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return true;
        }
    }

    return false;
}

function checkRequestForSQLInjection() {
    foreach ($_POST as $key => $value) {
        if (detectSQLInjection($value)) {
            return "SQL Injection Detected in POST: " . htmlspecialchars($key);
        }
    }

    foreach ($_GET as $key => $value) {
        if (detectSQLInjection($value)) {
            return "SQL Injection Detected in GET: " . htmlspecialchars($key);
        }
    }

    return " No SQL Injection Detected.";
}

$result = checkRequestForSQLInjection();
echo $result;
?>