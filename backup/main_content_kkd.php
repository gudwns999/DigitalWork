  
<div class="container-fluid">
	<div class="row content" >
		<div class="col-sm-12" id="mainImage">
			<br><br>
			<h2>디지털 공방에서 프로젝트를 진행해 보세요.</h2><br>
			<p style="font-weight:800; font-size:15px;">디지털 공방에서는 누구나 쉽고 자유롭게 디자인 프로젝트를 진행할 수 있습니다.<br>
			여러 사람과 같이 프로젝트를 진행할 수 있으며, 모든 파일은 지워지지 않고 보관됩니다. </p> <br>
			<form method="post" action="search.php">
			<div class="input-group" style="width:450px; margin:0 auto;">
				
					<input type="text" name="keyword" style='border:none;' class="form-control" placeholder="공방 검색..">
					<span class="input-group-btn">
					<button class="btn btn-default" type="submit">
						<span class="glyphicon glyphicon-search"></span>
					</button>
					</span>
			</div>
			</form>
		</div>
		<br>
		<div class="row" style='max-width:900px; margin:0 auto; background-color:#f9f9f9;'>
		<?
		if($_SESSION[id])
		{
		?>
			<div class="col-sm-8">
				<h2>인기공방들</h2>
			<br>
			  <h2>최근 올라온 공방들</h2>
			  
			  
			</div>    
			<div class="col-sm-4" style='border:1px solid #f9f9f9; border-radius:6px; background-color:white;'>
			<center>
				<?
				if(!file_exists("img/profile/".$_SESSION[no].".png"))
				{
					echo "<br><img src='img/profile/default.png' id='myImage' style='width:64px; height:64px; border-radius:64px;'/>";
				}
				else
				{	
					echo "<br><img src='img/profile/".$_SESSION[no].".png' />";
				}
				?>
				<br>
				<h4><?=$_SESSION[nick]?></h4>
				<br>
				나의 공방<br>
				<?
				$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
				mysqli_query($connect, "set names utf8");
				#자기가 참여하고 있는 공방 목록 전부 보여준다.
				$query = mysqli_query($connect, "select * from dg_workshop_member where member_no='{$_SESSION[no]}'");
				while($ret = mysqli_fetch_array($query,MYSQLI_BOTH))
				{
					$query1 = mysqli_query($connect, "select * from dg_workshop where no='{$ret[workshop_no]}'");
					while($ret1=mysqli_fetch_array($query1,MYSQLI_BOTH)) {
						echo "<a href='make.php?no={$ret1[no]}' target='_self'>{$ret1[name]}</a><br>";
					}
				}


				?>

				<button type="button" class="btn btn-default" onclick="location.href='create.php'">공방 만들기</button></center><br>
			</div>
		<? } else { ?>
			<div class="col-sm-12">
				<h2>인기공방들</h2>
			<br>
			  <h2>최근 올라온 공방들</h2>
			  
			 
			</div> 
		<? } ?>
		</div>
	</div>
</div>
</body>