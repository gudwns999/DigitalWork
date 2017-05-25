<?
session_start();

unset($_SESSION["id"]);
die("<script>location.href='index.php';</script>");
?>