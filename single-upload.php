<?php
/* upload one file */
$upload_dir = 'uploads';
$name = basename($_FILES["myfile"]["name"]);
$target_file = "$upload_dir/$name";
if ($_FILES["myfile"]["size"] > 100000000) { // limit size of 10KB
    echo 'error: your file is too large.';
    exit();
}
if (!move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file))
	echo 'error: '.$_FILES["myfile"]["error"].' see /var/log/apache2/error.log for permission reason';
else {
	if (isset($_POST['method'])) print_r($_POST);
	echo "\n filename : {$name}";
}
?>