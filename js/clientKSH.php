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
    var imgIndex = -1;
    var ts=1;
    var fno;
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

    socket.on("send file_list",function(rows){
    for(var j=0; j<rows.length; j++){
    $('#dbmsg').append(rows[j].nickname+"님이"+"&nbsp파일&nbsp"+ rows[j].upload_filename+"&nbsp을(를)"+"<br>" +rows[j].upload_date.replace(/([A-Z]|\.[0]{3})/g," ")+"<br>"+" 에 추가하였습니다."+ "<hr>");
    }
    });



    socket.on("send process name",function(e)
    {
    for(var i=0;i<e.length;i++) createCard();

    var i = 0;

    $('.w3-card-12').each(function()
    {
    $(this).find('#cardTitle').html(e[i].name+'<span class="glyphicon glyphicon-edit" style="margin:0 0 0 5px;color:white;font-size:11px;cursor:pointer" id="modifySubject"></span>');
    $(this).append(' <span class="glyphicon glyphicon-remove" style="color:white;font-size:11px; cursor:pointer;" title="취소" id="cancelSubject"></span>');
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
    $('#dialogMem').append('<li class="list-group-item">'+e[i].nickname+'<input type="hidden" name="members[]" value="'+e[i].nickname+'"/><input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="modalAddMember(this,\''+e[i].nickname+'\')" value="+" /></li>');
    }
    });

    socket.on("send update members",function(target,e)
    {
    $(".w3-card-12 #cardThread").each(function()
    {

    if($(this).children("#fp").val() == target)
    {
    if(target == fno) $("#coMemList").append(" "+e);
    $(this).find("#cardMembers").append(" "+e);
    return false;
    }
    });
    });

    socket.on("add new comment",function(who, target, content)
    {
    socket.emit("get comment list",id,name,token,room,fno);
    });

    socket.on("get comment list", function(e)
    {
    $('#cardCommentList').html("");
    for(var i =0;i<e.length; i++)
    {
    $('#cardCommentList').append(e[i].nickname+" ( "+e[i].upload_date.replace(/([A-Z]|\.[0]{3})/g," ")+")<br><br>"+e[i].description+"<hr>");
    }
    });


    socket.on("send comember",function(e)
    {
    for(var i =0;i<e.length; i++)
    {
    $(".w3-card-12 #cardThread").each(function()
    {
    if($(this).children("#fp").val() == e[i].file_no)
    {
    $(this).find("#cardMembers").append(" "+e[i].nickname);
    return false;
    }
    });
    }
    });

    socket.on("send workshop contents", function(e)
    {
    var p = 1;
    for(var i =0;i<e.length; i++)
    {
    if(e[i].process_no == 0) continue;
    if(e[i].score == null) e[i].score = "평가가 없습니다.";
    else e[i].score = e[i].score.toFixed(1) + "점";
    while(p != e[i].process_no) p++;
    $("<div id='cardThread'><input type='hidden' id='mp'/><input type='hidden' id='fp' value='"+e[i].file_no+"' /><img data-toggle='modal' data-target='#detailThread' id='cardImage' src='http://capstone.hae.so/v2/image_view.php?no="+e[i].file_no+"' style='cursor:pointer; border-top-left-radius:5px; border-top-right-radius:5px; border-bottom:1px solid #a9a9a9; max-width:100%; height:auto;' onclick='checkVote("+e[i].file_no+")'/><div style='margin:6px 3px 0 3px; white-space:normal; font-size:14px; font-weight:500;'><div id = 'cardFileName'>"+e[i].title+"</div><br><span style='color:#aaaaaa; font-size:12px;' id='cardMembers'> "+e[i].nickname+"</span><br><br><span id='cardFiledescription' style='font-size:13px;'>"+e[i].description+"</span><br>★<span style='color:#666666; font-size:12px;'>"+e[i].score+"</span></div></div><br>").insertAfter($(".w3-card-12").eq(p-1).find('#inButton'));
    }
    socket.emit("send comember", id, name, token, room);
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

    socket.on('view vote',function(cnt)
    {
    $("#voteCnt").html('투표('+cnt+')');
    });

    socket.on("alert",function(msg)
    {
    alert(msg);
    });

    socket.on('view status',function(who,status)
    {
    if(who == id)
    {
    if(status == 1)
    {
    $("#voteCheck").html('<span class="glyphicon glyphicon-ok" />');
    $("#voteBtn").css("background-color","white");
    $("#voteBtn").css("color","black");
    $("#voteBtn").css("border","2px solid #f44336");
    }
    else
    {
    $("#voteCheck").html('');
    $("#voteBtn").css("background-color","#FF4000");
    $("#voteBtn").css("color","#fff");
    $("#voteBtn").css("border","none");
    }
    }
    });
    socket.on('update vote',function(room,data,who,status)
    {
    socket.emit("view vote",id,name,token,room,data,who);
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
    $('#detailThread').on('hidden.bs.modal', function ()
    {
    $( "#dialogMem" ).dialog( "close" );
    })
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
    })

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
    fno = $(this).parent().find("#fp").val();
    var pname = $(this).parent().parent().find("#cardTitle").text();
    var fname =$(this).parent().find("#cardFileName").text();
    var mname = $(this).parent().find("#cardMembers").text();
    var fdescription = $(this).parent().parent().find("#cardFileDescription").text();
    ts = fno;
    $('#modalProcessName').text(pname);
    $('#modalFileName').val(fname);
    $('#commentFno').text(fno);
    $('#coMemList').html(mname);
    $('#cardCommentList').html("댓글을 불러오는 중입니다....");
    socket.emit("get comment list",id,name,token,room,fno);
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
    })
    $(".image_rollover").each(function()
    {
    $(this).mouseover(function() {
    $("#star-inputs").css("display", "block");
    });
    $(this).mouseout(function() {
    $("#star-inputs").css("display", "none");
    })
    });
    var starRating = function()
    {
    var $star = $(".star-input"),
    $result = $star.find("output>b");

    $(document).on("focusin", ".star-input>.input", function(){
    $(this).addClass("focus");
    })
    .on("focusout", ".star-input>.input", function(){
    var $this = $(this);

    setTimeout(function(){
    if($this.find(":focus").length === 0){
    $this.removeClass("focus");
    }
    }, 100);
    })
    .on("change", ".star-input :radio", function(){
    $result.text($(this).next().text());
    })
    .on("mouseover", ".star-input label", function(){
    $result.text($(this).text());
    })
    .on("mouseleave", ".star-input>.input", function(){
    var $checked = $star.find(":checked");
    if($checked.length === 0){
    $result.text("0");
    } else {
    $result.text($checked.next().text());
    }
    });
    };
    starRating();
    });
    function rating(grade)
    {
    alert(grade + " 점을 주셨습니다.");
    file_no=ts;
    star_num=grade;
    socket.emit("update score", id, name, token, star_num, file_no);
    }
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

    function uploadComment()
    {
    socket.emit("add new comment", id, name, token, room, fno, $("#cardComment").val());
    return false;
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

    function modalAddMember(elmt, target) //공방협업자를 디비에 저장.
    {
    socket.emit("update members", id, name, token, room, fno, target);
    }

    function checkVote (elmt)
    {
    imgIndex = elmt;
    socket.emit ("view vote", id, name, token, room, elmt, id);
    }

    function vote ()
    {
    if (id == "guest")
    alert ("로그인 후 이용하세요.");
    else
    socket.emit ("check vote", id, name, token, room, imgIndex);
    }
<?
header("Content-type: application/javascript");
?>