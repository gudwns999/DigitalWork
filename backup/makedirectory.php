<?php 
 $userdir = "KHJ"; 
 if(@mkdir($userdir, 0777)) { 
    if(is_dir($userdir)) { 
        @chmod($userdir, 0777); 
        echo "${userdir} 있다.";
    } 
 } 
 else { 
    echo "${mydir} 생성.";
 } 
?>