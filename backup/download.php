<?$workshop_no = $_POST['workshop_no'];
$name = $_POST['name'];
$origin_no = $_POST['origin_no'];
$write_no = $_POST['write_no'];
$file_ver = $_POST['ver'];
$file_name = $_POST['file'];
$hash = md5($workshop_no.$name);
$folder_path = 'workshop/' . $hash . '/' . $origin_no . '/'.$file_ver.'/';
$file_server_path = realpath(__FILE__);
$file_path = str_replace(basename(__FILE__), "",$file_server_path.$folder_path.$file_name);
$url = 'http://hae.so/capstone/'.$folder_path.$file_name;
//echo $url;
header("Content-Type: text/html; charset=UTF-8");
header('Content-Type: image/png');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"".basename($url). "\"");
readfile($url); // do the double-download-dance (dirty but worky)?

// Must be fresh start
/*if( headers_sent() )
    die('Headers Already Sent');

// Required for some browsers
if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

// Parse Info / Get Extension
$fsize = filesize($url);
$path_parts = pathinfo($url);
$ext = strtolower($path_parts["extension"]);

// Determine Content Type
switch ($ext)
{
    case "pdf": $ctype="application/pdf"; break;
    case "exe": $ctype="application/octet-stream"; break;
    case "zip": $ctype="application/zip"; break;
    case "doc": $ctype="application/msword"; break;
    case "xls": $ctype="application/vnd.ms-excel"; break;
    case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpg"; break;
    default: $ctype="application/force-download";
}

header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"".basename($url)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".$fsize);
ob_clean();
flush();
*/
?>