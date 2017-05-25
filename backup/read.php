<html>
<head>
<title>초 허접 게시판</title>
<style>
<!--
    td  { font-size : 9pt;   }
    A:link  { font : 9pt;      color : black;     text-decoration : none;    font-family : 굴림;    font-size : 9pt;  }
    A:visited  {   text-decoration : none; color : black;    font-size : 9pt;  }
    A:hover  {     text-decoration : underline; color : black; font-size : 9pt;  }
-->    
</style>
</head>

<body topmargin=0 leftmargin=0 text=#464646>
<center>
<BR>
<?
//데이터 베이스 연결하기
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
$id = $_GET[id];

// 글 정보 가져오기

$sql1 = "select write_name,write_description from dg_write where write_no='{$id}'";
$query1 = mysqli_query($connect,$sql1);
$ret1 = mysqli_fetch_array($query1,MYSQLI_BOTH);

    

?>

<table width=580 border=0  cellpadding=2 cellspacing=1 bgcolor=#777777>

<tr>
    <td height=20 colspan=4 align=center bgcolor=#999999>
        <font color=white><B>글제목 : <?=$ret1[write_name]?></B></font>
    </td>
</tr>

<tr>
    <td bgcolor=white colspan=4>
        <font color=black>
            <pre>글내용 :<?=$ret1[write_description]?></pre>
        </font>
    </td>                
</tr>
<!-- 기타 버튼 들 -->
<tr>
    <td colspan=4 bgcolor=#999999>
        <table width=100%>
            <tr>
                <td width=200 align=left height=20>
                    <input type=button value="목록보기" onclick="history.back(-1)">
                    <a href=edit.php?id=<?=$id?>><font color=white>[수정]</font></a>
                    <a href=predel.php?id=<?=$id?>><font color=white>[삭제]</font></a>
                </td>
    
<!-- 기타 버튼 끝 -->

<!-- 이전 다음 표시 -->
                <td align=right>
                <?

                //  현재 글보다 id 값이 큰 글 중 가장 작은 것을 가져온다. 즉 바로 이전 글
                $query=mysqli_query("select id from dg_write where write_no > $id limit 1", $connect);
                $prev_id=mysqli_fetch_array($query);

                    if ($prev_id[id]) // 이전 글이 있을 경우
                    {
                         echo "<a href=read.php?id=$prev_id[id]><font color=white>[이전]</font></a>";
                    }
                    else 
                    {
                        echo "[이전]";
                    }

                $query=mysqli_query("select id from dg_write where write_no < $id order by id desc limit 1", $connect);
                $next_id=mysqli_fetch_array($query);

                    if ($next_id[id])
                    {
                         echo "<a href=read.php?id=$next_id[id]><font color=white>[다음]</font></a>";
                    }
                    else 
                    {
                        echo "[다음]";
                    }

                ?>
                </td>
            </tr>
        </table>
</b></font>
</td>
</tr>
</table>


</center>
</body>
</html>