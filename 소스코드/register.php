<!DOCTYPE html>
<html lang="en">
<head>
  <title>Digital</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/register.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="js/capstone.js"></script>
</head>

<body>
<?include_once("nav.php")?>
<br>
<div id="registerContainer">
<?=star();?>는 필수 입력 사항입니다.<br><br>
	<form method="post" onsubmit="return register();">
	<div class="row inputForm">
	  <div class="col-sm-4" style="text-align:right;">
		<div>&nbsp;&nbsp;아이디<?=star();?></div>
	  </div>
	  <div class="col-sm-8">
		<input type="email" name="email" id="inputEmail" class="form-control" style="width:80%;" placeholder="아이디는 본인의 이메일로 입력해 주세요."/>
		<span id="emailResult" style='color:red;'></span>
	  </div>
	</div>
	<div class="row inputForm">
		<div class="col-sm-4" style="text-align:right;">
		<div>&nbsp;&nbsp;닉네임<?=star();?></div>
		</div>
		<div class="col-sm-8">
		<input type="text" id="inputNickname" name="name" class="form-control" style="width:80%;" placeholder="한글,영문자,숫자만 8자리 이하로 입력"/>
		<span id="nicknameResult" style='color:red;'></span>
		</div>
	</div>
	<div class="row inputForm" style="text-align:right;">
		<div class="col-sm-4">
		<div>&nbsp;&nbsp;비밀번호<?=star();?></div>
		</div>
		<div class="col-sm-8">
		<input type="password" id="inputPass" name="pass" class="form-control" style="width:80%;" placeholder="영문자, 숫자, 기호가 혼합된 8자리 이상"/>
		</div>
	</div>
	<div class="row inputForm" style="text-align:right;">
		<div class="col-sm-4">
		<div>&nbsp;&nbsp;비밀번호 확인<?=star();?></div>
		</div>
		<div class="col-sm-8">
		<input type="password" id="inputRepass" name="repass" class="form-control" style="width:80%;" placeholder="영문자, 숫자, 기호가 혼합된 8자리 이상"/>
		</div>
	</div>
	<div class="row inputForm" style="text-align:right;">
		<div class="col-sm-4">
		<div>&nbsp;&nbsp;근무지</div>
		</div>
		<div class="col-sm-8">
		<input type="text" id="inputCompany" name="company" class="form-control" style="width:80%;" placeholder="회사, 학교, 단체 등"/>
		</div>
	</div>
	<center><br><br><button type="submit"  class="btn btn-primary btn-lg" id="submitBtn">가입하기</button></center><br>
	</form>
</div>
</body>
</html>

<?
function star()
{
	return "(<span style='color:red;'>*</span>)";
}
?>