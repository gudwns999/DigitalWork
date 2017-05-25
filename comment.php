<?php

	$link= mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
	$description = $_POST["description"];
	$upload_date = date("Y-m-d H:i:s",time());
	$mem_no = $_POST["mem_no"];
	$file_no = $_POST["file_no"];
	

	$sql="insert into dg_comment(description, upload_date, mem_no, file_no) values('$description','$upload_date','$mem_no','$file_no')";

	mysqli_query($link, $sql) or die(mysqli_error($link));
	die("완료");
?>