<?

function delete_all($name){
    if(is_dir($name)){
        $ch=0;
        $data_list = opendir($name);
        while($file = readdir($data_list)){
            if ($file != "." && $file != ".."){$ch++;}
        }
        closedir($data_list);
        if($ch){
            $data_list = opendir($name);
            while($file = readdir($data_list)){
                if ($file != "." && $file != ".."){delete_all($name."/".$file);}
            }
            closedir($data_list);
        }
        rmdir($name);
    }
    else{
        unlink($name);
    }
}
delete_all("test3");
delete_all("test4");
delete_all("workshop");
?>