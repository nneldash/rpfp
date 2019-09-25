<?php
	$filename1 = $_FILES["file"]["tmp_name"];
	$location = 'excel_file/salary/';
	
	print_r($filename1);
	if ($_FILES['file']['name']) {
	    $filename = explode(".", $_FILES['file']['name']);
	}




?>