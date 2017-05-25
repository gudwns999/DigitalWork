var stepNo = 1;
var processNo = 1;
var memberNo=1;



//Dropdown active function
$(function()
{
	$(".dropdown-menu").on('click', 'li a', function()
	{
		if($(this).text()!="기타")
		{
			$('#projectType').hide();
		}
		$('#projectType').val($(this).text());
		$(".btn:first-child").html($(this).text()+'<span class="caret"></span>');
	});

	$('.hideBox').change(function()
	{
		if($(this).is(':checked'))
		{
			$("."+$(this).val()).show();
		}
		else
		{
			$("."+$(this).val()).hide();
		}
	}
	);
});

//검색 함수
function workshopSearch()
{
	/*Ajax*/
	$.post("search.php",{
		keyword:$('#searchKeyword').val()
		},function(e)
		{
			if(e=="1")
				alert("검색어 입력은 필수입니다.");
			else if(e=="2")
				alert("검색어는 2글자 이상 입력해주세요.");
			else
			{
				$('#mainArea').hide();
				if(e=="3")
					$('#searchArea').html("검색 결과가 없습니다. <span style='cursor:pointer; color:blue; text-decoration:underline;' onclick='$(\"#mainArea\").show();$(\"#searchArea\").html(\"\");'>돌아가기</span>");
				else
					$('#searchArea').html(e);
			}
		});
	return false;
}

//로그인 함수
function login()
{
	/*Ajax*/
	$.post("login.php",{
		loginid:$('#email').val(),
		loginpwd:$('#pwd').val(),
		},function(e)
		{
			if(e=="1")
			{
				location.reload();
			}
			else alert(e);
		});
	return false;
}


//가입 함수
function register()
{
//var a=1;
		/*Ajax*/
		$.post("register_check.php",{
			emailCheck:1,
			nicknameCheck:1,
			email:$('#inputEmail').val(),
			name:$('#inputNickname').val(),
			pass:$('#inputPass').val(),
			repass:$('#inputRepass').val(),
			company:$('#inputCompany').val()
			},function(e)
			{
				if(e=="1")
				{
					alert("회원가입이 완료되었습니다.");
					location.href = 'index.php';
				}
				else alert(e);
			});
		return false;
}

//초대 함수
function invite(obj, w_no, m_no, accepted)
{
	$.post("invite_check.php",{
			workshop_no : w_no,
			member_no : m_no,
			accepted : accepted
			},function(e)
			{
				if(e=="1")
				{
					alert("수락했습니다.");
					
				}
				else if(e=="2")
				{
					alert("거절했습니다.");
				}
				$(obj).parent().remove();
			});
}



//프로젝트 유형 직접 입력시 텍스트박스 표시
function registerTypeView()
{
	$('#projectType').val("").show();
}

//과정 추가 함수
function addProcess()
{
	//$_POST[step][1]~
	var txt=$('#projectStepName').val();
	if(txt=="") return false;
	else
	{
		$('#projectProcessList').append('<li class="list-group-item" id="step'+stepNo+'"><span class="badge pull-left">'+
			processNo+'단계</span> &nbsp;'+txt+' <input type="hidden" name="step[]" value="'+txt+'" /><input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="removeProcess('+
			stepNo+');" value="ㅡ" /></li>');
		stepNo++;
		processNo++;
		$('#projectStepName').val("");
	}
}

//멤버 체크 함수
function addMember()
{
//var a=1;
	var txt=$('#memberName').val();
	if(txt=="") return false;
		/*Ajax*/
	else
	{
		$.post("member_exist_check.php",{
			name:$('#memberName').val(),
			},function(e)
			{
				if(e=="1")  //멤버가 존재하면 
				{
					$('#projectMemberList').append('<li class="list-group-item" id="member'+memberNo+'">'+
						'&nbsp;'+txt+' <input type="hidden" name="members[]" value="'+txt+'" /><input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="removeMember('+
						memberNo+');" value="ㅡ" /></li>');
					memberNo++;
					$('#memberName').val("");
				}
				else
				{
					$('#addMemberBtn').tooltip({"trigger":"hover","title":txt+"님은 회원이 아닙니다."}).tooltip("show");
					$('#addMemberBtn').mouseleave(function(){$(this).tooltip("destroy");});
				}
			});
	}
		return false;
}

//단계 제거 함수
function removeProcess(no)
{
	$("#step"+no).remove();

	var p = 1;

	$('#projectProcessList').each(function ()
	{
		var list = $(this).find ('li span');

		$(list).each(function ()
		{
			$(this).text(p+"단계");
			p++;
		});
	});

	processNo = p;
}
//멤버 제거 함수
function removeMember(no)
{
	$("#member"+no).remove();
}

//공방 생성 함수
function createWorkshop()
{
	//단계에 체크되서 엔터로 입력됬을경우
	if($('#projectStepName').is(':focus'))
	{
		addProcess();
		$('#projectStepName').val("");
	}
	//멤버에 체크되서 엔터로 입력됬을경우
	else if($('#memberName').is(':focus'))
	{
		addMember();
		$('#memberName').val("");
	}
	//이름에서 엔터입력시 또는 공방만들기(onsubmit)일 경우
	else
	{
		
		$.post("check_create_workshop.php",{
				"name":$('#prjName').val(),
				"privated":$('#privated').is(':checked'),
				"description":$('#prjDescription').val(),
				"type":$('#projectType').val(),
				"step":$("#projectProcessList li input[name='step\[\]'").serialize(),
				"member":$("#projectMemberList li input[name='members\[\]'").serialize(),
				"toDate":$('#toDate').val(),
				"fromDate":$('#fromDate').val()
			},
			function(e)
			{
				var result = parseInt(e,10);

				if(!isNaN(result))
				{
					alert("공방 생성이 완료되었습니다.");
					location.href = 'make.php?no='+result;
				}
				else
				{
					alert(e);
					return false;
				}
			});
	}
	return false;
}

//공방 수정 함수
function modifyWorkshop()
{
	$.post("check_create_workshop.php",{
		"no":$('#prjNo').val(),
		"mod":1,
		"name":$('#prjName').val(),
		"privated":$('#privated').is(':checked'),
		"description":$('#prjDescription').val(),
		"type":$('#projectType').val(),
		"step":$("#projectProcessList li input[name='step\[\]'").serialize(),
		"member":$("#projectMemberList li input[name='members\[\]'").serialize(),
		"toDate":$('#toDate').val(),
		"fromDate":$('#fromDate').val()
	},function(e){
			var result = parseInt(e,10);

			if(!isNaN(result))
			{
				alert("공방 정보가 수정되었습니다.");
				location.href = "index.php";
			}
			else
			{
				alert(e);return false;
			}
		});
	return false;
}

/*window.onload = function(){

$(document).ready();

$();*/


$(function()
{
	//이메일 중복검사
	$('#inputEmail').focusout(function()
	{
		if($(this).val()=="")
		{
			$('#inputEmail').css("border","1px solid silver");
			return;
		}
		$.post("register_check.php",{
			emailCheck:1,
			nicknameCheck:0,
			email:$(this).val()
		},function(e)
		{
			if(e=="1")
			{
				$('#inputEmail').css("border","1px solid green");
				$('#emailResult').html("");
			}
			else 
			{
				$('#inputEmail').css("border","1px solid red");
				$('#emailResult').html(e);
			}
		});
	});
	
	//닉네임 중복검사
	$('#inputNickname').focusout(function()
	{
		if($(this).val()=="")
		{
			$('#inputNickname').css("border","1px solid silver");
			return;
		}
		$.post("register_check.php",{
			emailCheck:0,
			nicknameCheck:1,
			name:$(this).val()
		},function(e)
		{
			if(e=="1")
			{
				$('#inputNickname').css("border","1px solid green");
				$('#nicknameResult').html("");
			}
			else 
			{
				$('#inputNickname').css("border","1px solid red");
				$('#nicknameResult').html(e);
			}
		});
	});

	//비밀번호 검사
	$('#inputRepass').focusout(function()
	{
		var pass1 = $('#inputPass').val();
		var pass2 = $('#inputRepass').val();

		if(pass1=="" || pass2=="" )
		{
			$('#inputPass').css("border","1px solid silver");
			$('#inputRepass').css("border","1px solid silver");
			return;
		}
		else
		{
			if(pass1==pass2)
			{
				$('#inputPass').css("border","1px solid green");
				$('#inputRepass').css("border","1px solid green");
		
			}
			else
			{
				$('#inputPass').css("border","1px solid red");
				$('#inputRepass').css("border","1px solid red");
			}
		}
	});

});


