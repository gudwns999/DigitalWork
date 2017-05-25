<?
session_start();
if(!$_SESSION[id])
{
	die("<script>alert('로그인 후 이용 가능합니다.');history.back();</script>");
}

if($_GET[no])
{
	if(!is_numeric($_GET[no])) die("<script>history.back();</script>");
	$no = $_GET[no];
	if($_GET[mod]==1)
	{
		//권한이 있는 유저인지 체크한다.
		//공방 수정은 마스터만 가능하다.

		$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
		mysqli_query($connect, "set names utf8");

		
		$chk = mysqli_fetch_array(mysqli_query($connect, "select * from dg_workshop where no={$no} and master='{$_SESSION[id]}'"),MYSQLI_BOTH);

		if(!count($chk)) alert("공방 설정 변경 권한이 없습니다.");
		else 
		{
			$mod = 1;
			$name = $chk[name];
			$private = intval($chk[privated]);
			$type = $chk[type];
			$description = $chk[description];
			$fromDate = $chk[fromdate];
			$toDate = $chk[todate];
			if($fromDate == "0000-00-00") $fromDate="";
			if($toDate == "0000-00-00") $toDate="";
			
		}

		$chk = mysqli_query($connect, "select * from dg_workshop_process where workshop_no={$no}");
		$chk2 = mysqli_query($connect, "select * from dg_workshop_member where workshop_no={$no}");

		$_SESSION[modno] = $no;


	}
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <title>디지털공방</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="css/register.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/capstone.js"></script>
  <script>
  $(function()
	{
		$('#fromDate').datepicker({
			changeYear:true,
			changeMonth:true,
			dateFormat:'yy-mm-dd',
			dayNamesMin: ["일","월","화","수","목","금","토"],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
		});
		$('#toDate').datepicker({
			changeYear:true,
			changeMonth:true,
			dateFormat:'yy-mm-dd',
			dayNamesMin: ["일","월","화","수","목","금","토"],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
		});
	});
  </script>
</head>
<body style="background-color:#f9f9f9;">
<?include_once("nav.php")?>
	  
<br><br><br>
<div class="container" style="max-width:900px; border:1px solid #f9f9f9; background-color:white; padding:15px 15px 15px 15px;">
	<div class="page-header">
		<?if($mod){?>
			<h1>공방 설정 변경</h1>
			<p>공방의 정보를 수정한 후, 하단의 공방 수정 버튼을 눌러주세요.</p><br><?=star();?>는 필수 입력 사항입니다.<br>
			<input type="hidden" id="prjNo" value="<?=$no?>" />
		<?}else{?>
			<h1>새로운 공방 만들기</h1>
			<p>공방을 만들기 위한 필요한 정보를 입력해 주세요.</p><br><?=star();?>는 필수 입력 사항입니다.<br>
		<?}?>
		
	</div>
	<form method="post" action="check_create_workshop.php" onsubmit="<?if($mod)echo "return modifyWorkshop();"; else echo "return createWorkshop();";?>">
		<div class="row" style="width:100%;">
			<div class="col-sm-3">
				이름<?=star();?>
			</div>
			<div class="col-sm-9">
				<input class="form-control" id="prjName" type="text" style="width:80%;"placeholder="생성할 공방의 이름을 적어주세요.(2~20 글자)" <?if($mod) echo "value='{$name}'";?>> <input type="checkbox" name="box" id="privated" <?if($mod)if($private)echo "checked";?>>&nbsp;&nbsp;비공개&nbsp;&nbsp;
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-3">
				프로젝트 설명
			</div>
			<div class="col-sm-9">
				<textarea style="width:80%;" class="form-control" rows="5" name="prjDescription" id="prjDescription"  placeholder="프로젝트에 대한 간단한 설명을 적어주세요.(200자 이내)" ><?if($mod) echo $description;?></textarea>
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-3">
				프로젝트 유형<?=star();?>
			</div>
			<div class="col-sm-9">
				<label class="dropdown">
				<button id="dropdownBtn" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><?if($mod) echo $type; else{?>프로젝트 유형<?}?><span class="caret"></span></button>
				  <ul class="dropdown-menu">
					<li value="personal"><a data-toggle="dropdown">개인 프로젝트</a></li>
					<li value="team"><a data-toggle="dropdown">팀 프로젝트</a></li>
					<li value="school"><a data-toggle="dropdown">학교 과제</a></li>
					<li value="contest"><a data-toggle="dropdown">공모전</a></li>
					<li class="divider"></li>
					<li value="write"><a href="javascript:registerTypeView();">기타</a></li>
				  </ul>
			  </label>
			  <input type="text" id="projectType" <?if($mod) echo "value='{$type}'";?> style="display:none; width:60%" placeholder="15자 이내로 작성해 주세요.">
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-3">
				프로젝트 단계<?=star();?>
			</div>
			<div class="col-sm-9">
				<input type="text" id="projectStepName" placeholder="원하는 단계명을 입력하세요." style="width:200px"/>
				<input type="button" class="btn btn-default" onclick="addProcess();" value="추가" /> 
				<div id="projectProcessList" style="width:80%;height:150px;overflow-y:scroll;">
				
				<?
				if($mod)
				{
					$i = 1;
					while($step = mysqli_fetch_array($chk, MYSQLI_BOTH))
					{
						echo '<li class="list-group-item" id="step'.$i.'"><span class="badge pull-left">'.$i.'단계</span> &nbsp;'.$step[name].' <input type="hidden" name="step[]" value="'.$step[name].'" /><input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="removeProcess('.$i.');" value="ㅡ" /></li>';
						$i++;
					}
					echo "<script>$(function(){stepNo = ".$i."; processNo = ".$i.";});</script>";
				}
				?>

				</div>
				<span style="font-size:11px;">단계명은 15글자 이내로 작성해 주세요.</span>
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-3">
				프로젝트 멤버
			</div>
			<div class="col-sm-9">
				<input type="text" id="memberName" placeholder="닉네임을 입력하세요." style="width:200px"/>
			 	<input type="button" class="btn btn-default" id="addMemberBtn" onclick="addMember();" value="추가" /><br>
				<div id="projectMemberList" style="width:80%;height:150px;overflow-y:scroll;">
				<?
				if($mod)
				{
					$i = 1;
					while($member = mysqli_fetch_array($chk2, MYSQLI_BOTH))
					{
						$name = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where no={$member[member_no]}"),MYSQLI_BOTH);
						if(!count($name)) alert("회원 정보를 불러오는 도중 오류가 발생하였습니다. 관리자에게 문의해주세요.");
						
						echo '<li class="list-group-item" id="member'.$i.'">'.$name[nickname].' <input type="hidden" name="members[]" value="'.$name[nickname].'" /><input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="removeMember('.$i.');" value="ㅡ" /></li>';

						$i++;
					}
					echo "<script>$(function(){memberNo = ".$i.";});</script>";
				}
				?>
				</div>
				<span style="font-size:11px;">추가한 회원에게 초대장이 발송되며, 수락할 경우 공방의 멤버가 됩니다.</span>
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-3">
				프로젝트 기간
			</div>
			<div class="col-sm-9">
				<input type='text' id='fromDate' value="<?if($mod) echo $fromDate;?>"/> 부터 <input type='text' id='toDate' value="<?if($mod) echo $toDate;?>"/> &nbsp;까지<br>
				<span style='font-size:11px;'>(프로젝트 기간을 '시작일 ~ 종료일'순으로 입력하세요.)</span>
			</div>
		</div>

		<br><br><center><input type="submit" class="btn btn-default"  value="<?if($mod) echo "공방 수정"; else echo "공방 만들기";?>" /></center>
		</form>
	</div>
	<br>
</body>
</html>
<?
function star()
{
	return "(<span style='color:red;'>*</span>)";
}

function alert($a)
{
	die("<script>alert('".$a."');history.back();</script>");
}
?>