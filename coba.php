<?php

    CONST CHAT_ID = '1027787224';
    CONST BOT = '1607521967:AAErjzP0St1Y2_p44ZsWwJgIzXEjQJNsHTQ';

    CONST FILENAME = 'C:/xampp/htdocs/dms/dr_files/coba.zip';

    // Create CURL object
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".BOT."/sendDocument?chat_id=" . CHAT_ID);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Create CURLFile
    $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), FILENAME);
    $cFile = new CURLFile(FILENAME, $finfo);

    // Add CURLFile to CURL request
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        "document" => $cFile
    ]);

    // Call
    $result = curl_exec($ch);
    $output =  $result;

    // Show result and close curl
    var_dump($result);
    curl_close($ch);
    

    ?>