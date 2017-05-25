<?
session_start();
echo "var sid = '".session_id()."';";
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

if(!$_SESSION[id]) {$email = "guest";$guest=1;}
else {$email = $_SESSION[id];$guest=0;}
if(!$_SESSION[nick]) $namename = "손님";
else $namename = $_SESSION[nick];
$token=md5(mb_convert_encoding("caps".$email."tone".$namename,'UTF-8', 'UTF-8'));
$room = $_GET[no];
?>

///////////////////////////////////// 글로벌 변수, config 설정////////////////////////.
var socket = io();
var id = "<?=$email?>";
var no = "<?=$_SESSION[no]?>";
var name = "<?=$namename?>";
var token = "<?=$token?>";
var room = <?=$room?>;
var isGuest = <?=$guest?>;
var cardCount = 0;
var inText = 1;

//////////////////////////////////socket.on 함수만///////////////////////////////////

socket.on('auth',function()
{
	//계정 정보와 닉네임, 토큰, 현재 접속한 공방의 정보를 전송한다.
	socket.emit("send information",id,name,token, room);
});

socket.on("send subject",function(name,description)
{
	$('#workshopTitle').html(name);
	$('#workshopDescription').html(description);
});

socket.on("send process name",function(e)
{
	for(var i=0;i<e.length;i++) createCard();

	var i = 0;

	$('.w3-card-12').each(function()
	{
		$(this).find('#cardTitle').html(e[i].name+'<span class="glyphicon glyphicon-edit" style="margin:0 0 0 5px;color:white;font-size:11px;cursor:pointer" id="modifySubject"></span>');
		$(this).append('<input id="wp" type="hidden" value="'+e[i].workshop_no+'"/><input id="pp" type="hidden" value="'+e[i].process_no+'"/>');
		$('#modifySubject').css({"z-index":"1"});
		i++;
	});

	//모든 처리가 끝나면 컨텐츠 정보를 요청한다.
	socket.emit("send workshop contents", id, name, token, room);
});


socket.on("send member names",function(e)
{

	for(var i =0; i<e.length;i++)
	{
		if(e[i].nickname == name) continue;
		$('#dialogMem').append('<li class="list-group-item">'+e[i].nickname+'<input type="hidden" name="members[]" value="'+e[i].nickname+'"/><input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="modalAddMember(\''+e[i].nickname+'\')" value="+" /></li>');
	}
});

socket.on("send update members",function(e)
{
	alert("!");
	$('#coMem').prepend(e);
});

socket.on("send workshop contents", function(e)
{
	var p = 1;
	for(var i =0;i<e.length; i++)
	{
		if(e[i].process_no == 0) continue;
		while(p != e[i].process_no) p++;
		$("<div id='cardThread'><input type='hidden' id='mp'/><input type='hidden' id='fp' value='"+e[i].file_no+"' /><img data-toggle='modal' data-target='#detailThread' id='cardImage' src='http://capstone.hae.so/v2/image_view.php?no="+e[i].file_no+"' style='cursor:pointer; border-top-left-radius:5px; border-top-right-radius:5px; border-bottom:1px solid #a9a9a9; max-width:100%; height:auto;' /><div style='margin:6px 3px 0 3px; white-space:normal; font-size:14px; font-weight:500;'><div id = 'cardFileName'>"+e[i].title+"</div><br><span style='color:#aaaaaa; font-size:12px;'> "+e[i].nickname+"</span><br><br><span style='font-size:13px;'>"+e[i].description+"</span></div></div><br>").insertAfter($(".w3-card-12").eq(p-1).find('#inButton'));
	}
});

socket.on("update subject",function(parentID, value)
{
	$('#'+parentID).find('#cardTitle').html(value+'<span class="glyphicon glyphicon-edit" style="margin:0 0 0 5px;color:white;font-size:11px; cursor:pointer;" title="수정" id="modifySubject"></span> <span class="glyphicon glyphicon-remove" style="color:white;font-size:11px; cursor:pointer;" title="취소" id="cancelSubject"></span>');
});

socket.on("update card",function()
{
	createCard();
});

socket.on("subject error",function()
{
	alert("존재하지 않는 공방입니다.");
	location.href = "http://capstone.hae.so/v2/";
});

socket.on("Permission denied", function()
{	
	alert("권한이 없습니다.");
});


socket.on('invalid token',function()
{
	alert("올바르지 않은 정보입니다.");
	//history.back();
});

socket.on('receive member list',function(a)
{
	alert("받은 데이터 : "+a);
});

 $("#msgbox").keyup(function(event) {
	if (event.which == 13) {
		 socket.emit('fromclient',{msg:$('#msgbox').val()});
		 $('#msgbox').val('');
	}
		  });

///////////////////////////////사용자 정의 함수////////////////////////////////////

$(function(){
	
	if(!isGuest)
	{
		$('#loginStatus').append('<li><a><span style="color:white"> <?= $_SESSION["nick"] ?>님 환영합니다. <span class="glyphicon glyphicon-log-out" style="cursor:pointer;color:white" onclick="location.href=\'http://capstone.hae.so/v2/logout.php\'" >로그아웃</span></span></a></li>');
	}
	else
	{
		$('#loginStatus').append('<li><a data-toggle="modal" data-target="#myModal"><span style="color:white" class="glyphicon glyphicon-log-in" ></span> <span style="color:white;cursor:pointer;" onclick="location.href=\'http://capstone.hae.so/v2/login.php?go=<?="http://capstone.hae.so:9000/workshop.php?no=".$_GET[no];?>\';"> 로그인</span></a></li><li><a href="register.php"><span class="glyphicon glyphicon-user" style="color:white"></span><span style="color:white"> 회원가입</span></a></li>');
	}
	$('#dialogMem').dialog(
	{
		autoOpen: false,
		title: "Members",
		dialogClass: 'addMember',
	});
	$('#memBtn').click( function()
	{
		$('#dialogMem').dialog('open');
		$('.addMember').css({"color":"black","z-index":3000,"top":$('#memBtn').offset().top, "left" : $('#memBtn').offset().left+30,});
	});
});

$(function(){
	
	$('#infinite').on('click','#modifySubject',function()
	{
		var target = $(this).closest("#cardTitle");
		var txt = target.text();
		target.html('<input type="text" id="modifyVal" value="'+txt+'" style="height:20px;color:black;width:50%;" /><span class="glyphicon glyphicon-ok-circle" style="margin:0 0 0 5px;color:white;font-size:11px; cursor:pointer;" title="완료" id="completeSubject"></span> <span class="glyphicon glyphicon-remove" style="color:white;font-size:11px; cursor:pointer;" title="취소" id="cancelSubject"></span>'); 
	})
	$('#infinite').on('click','#completeSubject',function()
	{
		var parent = $(this).closest("#cardTitle");
		var value = parent.find('#modifyVal').val();
		var parentID = parent.parent().attr('id');
		var workshopID = parent.parent().find('#wp').val();
		var processID = parent.parent().find('#pp').val();
		
		//update subject : 대상 카드id, 업데이트 되는 제목
		socket.emit("update subject", id, name, token, room, parentID, workshopID, processID, value);
	})
	$('#infinite').on('click','#cancelSubject',function()
	{
		var parent = $(this).closest("#cardTitle");
		var value = parent.find('#modifyVal').val();
		parent.html(value+'<span class="glyphicon glyphicon-edit" style="margin:0 0 0 5px;color:white;font-size:11px; cursor:pointer;" title="수정" id="modifySubject"></span>');
	})
	$('#infinite').on('click','#cardImage',function()
	{
		var fno = $(this).parent().find("#fp").val();
		var pname = $(this).parent().parent().find("#cardTitle").text();
		var fname =$(this).parent().find("#cardFileName").text();
		$('#modalProcessName').text(pname);
		$('#modalFileName').val(fname);
		$('#commentFno').text(fno);
	})

	$('#fileUploadForm').ajaxForm(
	{
		url : "http://capstone.hae.so/v2/upload_check.php",
		beforeSubmit:function(arr,$form, options)
		{
			options["url"] = "http://capstone.hae.so/v2/upload_check.php";
			arr.push({name:"mem_no",value:no});
			$('#submitBtn').val("업로드 중...");
			$('#submitBtn').attr("disabled",true);
		},
		success: function(req, res)
		{
			if(!isNaN(req))
			{
				socket.emit("refresh content",id, name, token, room, req);
				$('#fileContent').val("");
				$('#fileTitle').val("");
				$('#fileDecsription').val("");
				$('#submitBtn').val("업로드");
				$('#submitBtn').attr("disabled",false);
				$('#fileUpload').modal('hide');
			}
			else alert(req);
		},
		error: function(e)
		{
			alert("에러가 발생하였습니다. 다시 시도해 주세요.");
		},
		jsonpCallback:function(req,res)
		{
			alert(req+"!"+res);
		}
	});
});

function openNav()
{
	$('#mySidenav').css({
		"width":"250px",
		"z-index":"1000",
	});
	$('.glyphicon glyphicon-remove').css({
		"z-index":"1",
	});
	$('#infinite').css({
		"marginRight":"250px",
	});
	}
function closeNav()
{
	$('#mySidenav').css("width","0px");
	$('#infinite').css("marginRight","0px");

}

function confirmCreateCard()
{
	if(confirm("새로운 단계를 생성하시겠습니까?") == true)
	{
		socket.emit("add new process", id, name, token, room);
	}
}
function createCard()
{
	
	cardCount++;

	// 카드 생성
	var newCard = '<div class="w3-card-12" id="card'+cardCount+'" background="#ACACAC" style="display:inline-block; vertical-align:top; margin:0 12px 0 12px; "><div id="cardTitle">새로운 단계<span class="glyphicon glyphicon-edit" style="z-index:1;margin:0 0 0 5px;color:white;font-size:11px; cursor:pointer;" title="수정" id="modifySubject"></span></div><br>';
	
	var addBtn = '<button class="button button2" data-toggle="modal" data-target="#fileUpload" id="inButton" onclick="createInCard(this)"> 업로드 </button></div>';
	var delBtn = '<a href="#"><span class="glyphicon glyphicon-remove" onclick="delCard(this)" style="margin:0 4px 0 0; color:white; float:right; top:-35px;"></span></a>';
	
	$('#infinite').append(newCard);
	$("#makeCardBtn").insertAfter('#card'+cardCount);
	$('#card'+cardCount).hide().fadeIn(200);
	$("#card"+cardCount).append(addBtn);
	
	$("#card"+cardCount).append(delBtn);
	//$('#infinite').scrollLeft(1000000000000000000);
}

function createInCard (elmt) 
{	
	var fno = $(elmt).parent().find("#pp").val();
	$(elmt).parent().find("#mp").val();
	$(elmt).parent().find("#umode").val("0");
	$('#uploadPno').val(fno);
	$("#fileUpload").find("#currentpno").val(fno);
	$("#currentpname").text($(elmt).parent().find('#cardTitle').text()+" 단계 업로드");
}

function delCard (elmt)
{

	 // 해당 버튼이 속한 div class의 id를 받는다.
	 var thisClass = $(elmt).closest("div").attr("id");

	 // 해당 id를 갖는 div의 모든 요소 삭제.
	 console.log (thisClass);
	 $('#'+thisClass).remove();
}

function modalAddMember(target) //공방협업자를 디비에 저장.
{
	var fno = $('#inButton').parent().find("#pp").val();	
	
	//add card members : 대상 카드id, 업데이트 되는 협업자
	socket.emit("update members", id, name, token, room, fno, target);
}

$(document).ready(function(){
	$("#addText").hide();

    $("#descripstion").click(function(){
		$("#descripstion").hide();
		$("#addText").show();
	});
	 $("#cancel").click(function(){
		$("#addText").hide();
		$("#descripstion").show();
	});
	
});
<?
header("Content-type: application/javascript");
?>