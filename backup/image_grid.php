<style>
    table, td {
        border: 1px solid black;
    }
    th, td {
        padding: 5px;
    }
</style>
<?php
//DB연결
$no = $_GET[no];
$process_num = 0;
$member_num = 0;
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");
$query = mysqli_query($connect, "select * from dg_workshop_process where workshop_no='$no'");
$query1 = mysqli_query($connect, "select * from dg_workshop_member where workshop_no='$no'");
echo "<table>";
echo "<tr>";
echo "<td>공간 여유</td>";
while($ret1 = mysqli_fetch_array($query1,MYSQLI_BOTH))
{
    while($ret = mysqli_fetch_array($query,MYSQLI_BOTH))
        {
            $process_num++;
            echo "<td>".$ret['name']."</td>";
        }
    $member_num++;
}
echo "</tr>";

echo "단계: ".$process_num;
echo " 회원수: ".$member_num;
$ret1 = mysqli_fetch_array($query1,MYSQLI_BOTH);
/*for($i=0;$i<$member_num;$i++){
    echo "<tr>";
     echo "<td>회원정보</td>";
    for($j=0;$j<$process_num;$j++){
        echo "<td>"."이미지 보여질 공간"."</td>";
    }
    echo "</tr>";
}
*/
#JOIN을 써야함 ㅋㅋ
$query2 = mysqli_query($connect, "select * from dg_workshop_member join dg_member on dg_workshop_member.member_no = dg_member.no where dg_workshop_member.workshop_no='$no'");
while($ret2 = mysqli_fetch_array($query2,MYSQLI_BOTH)){
    echo "<tr>";
    echo "<td>".$ret2['nickname']."</td>";
    for($j=0;$j<$process_num;$j++){
        echo "<td>".$ret2['nickname']."의 작업 공간".$j."</td>";
    }
    echo "</tr>";
}
echo"</table>";
?>
