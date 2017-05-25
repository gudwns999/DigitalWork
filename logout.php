<?
session_start();

unset($_SESSION["id"]);
unset($_SESSION["nick"]);
die("<script>location.href='http://capstone.hae.so/v2/index.php';</script>");
?>