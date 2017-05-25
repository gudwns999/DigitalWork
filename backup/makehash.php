<?php
$userdir = "./workshop/ss/ddd/ss/";
if(@mkdir($userdir, 0777,true)) {
    if(is_dir($userdir)) {
        @chmod($userdir, 0777,true);
        echo "${userdir} 만들었다.";
    }
}
else {
    echo "${mydir} 이미있음.";
}
?>