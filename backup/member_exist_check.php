<?
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

$nickname = $_POST[name];

$query = mysqli_fetch_array(mysqli_query($connect, "select * from dg_member where nickname='{$nickname}'"),MYSQLI_BOTH);
if(count($query)) die("1");

die("0");
