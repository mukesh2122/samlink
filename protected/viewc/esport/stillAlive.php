<?php    
    $file      = fsockopen ("127.0.0.1", 80, $errno, $errstr, 10);
    $status    = 0;

    if (!$file) $status = false;  // Site is down
    else {
        fclose($file);
        $status = true;
    }
    return $status;
?>