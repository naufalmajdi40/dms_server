<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dms_database";

$connection = mysqli_connect($servername, $username, $password, $dbname);
if (!$connection){
        die("Connection Failed:".mysqli_connect_error());
    }

$query = mysqli_query($connection,"SELECT * FROM data WHERE flag=0");
$queryBot = mysqli_query($connection,"SELECT * FROM bot WHERE status=1");
//echo $query;
$dataId = mysqli_query($connection,"SELECT * FROM notif");
foreach($queryBot as $dataBot){
    $tokenBot = $dataBot["bot_token"];
}
echo $tokenBot;
define('BOT', $tokenBot);
$i=0;

foreach ($query as $row){
//while($data = mysqli_fetch_array($query)){

     $namaFile = $row["nama_file"];
     $relay = $row["relay_id"];
     $idProduct = $row["machine_code"];
     $lokasi = $row["lokasi"];
     $status = $row["status"];
     $formatTanggal = $row["tgl_kirim"];
     $date=date_create_from_format("Y/m/d",$formatTanggal);
     
    // date_format($date,"Y-m-d");
     $tanggal = date_format($date,"d/m/Y"); 
     $waktu = $row["waktu"];
     $nama_file="dr_files/".$namaFile.".zip";
     $listId = mysqli_fetch_array($dataId);

    // $filename = '/path/to/foo.txt';

    if (file_exists($nama_file)) {
        echo "The file $nama_file exists";
        foreach ($dataId as $row2){
            $chatId = $row2["chat_id"];
            $productId = $row2["machine_code"];
            if($productId == $idProduct){
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".BOT."/sendDocument?chat_id=" .$chatId."&caption=Silahkan download File Disturbance Record diatas%0a%0aRelay ID : ".$relay."%0aLokasi    : ".$lokasi."%0aStatus    : ".$status."%0aTanggal : ".$formatTanggal."%0aWaktu     : ".$waktu." WIB");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
        
            // Create CURLFile
            $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $nama_file);
            $cFile = new CURLFile(realpath($nama_file), $finfo);
        
            // Add CURLFile to CURL request
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                "document" => $cFile
                
            ]);
        
            // Call
            $result = curl_exec($ch);
            curl_close($ch);
            $queryy="UPDATE data SET flag='1' where nama_file='$namaFile'";
            mysqli_query($connection, $queryy);
               
         }
        }

      

    } else {
        echo "The file $nama_file does not exist";
    }

    
}

?>