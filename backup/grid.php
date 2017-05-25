<?
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($connect,"SELECT * FROM dg_workshop");
$ret = mysqli_fetch_array($result,MYSQLI_BOTH);
$i=0;
$col = $ret['process_cnt'];
$name = $ret['name'];
echo "<table><tr>";
while($i<$col){
    echo "<td> $name </td>";
    $i++;
    }
echo "</tr></table>";


?>