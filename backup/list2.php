<?php
    $conn = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
    mysqli_query($conn, "set names utf8");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>자유게시판 | Kurien's Library</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="./css/board.css" />
</head>
<body>
	<article class="boardArticle">
		<h3>자유게시판</h3>
		<table>
			<caption class="readHide">자유게시판</caption>
			<thead>
				<tr>
					<th scope="col" class="no">번호</th>
					<th scope="col" class="title">제목</th>
					<th scope="col" class="author">작성자</th>
          while($row = $result->fetch_assoc())
						{

				</tr>
			</thead>
			<tbody>
					<?php
						$sql = 'select * from dg_write order by write_no desc';
						$result = $db->query($sql);
					?>
				<tr>
					<td class="no"><?php echo $row['write_no']?></td>
					<td class="title"><?php echo $row['write_name']?></td>
					<td class="author"><?php echo $row['member_no']?></td>

				</tr>
					<?php
						}
					?>
			</tbody>
		</table>
	</article>
</body>
</html>