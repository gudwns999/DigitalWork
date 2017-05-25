<span style="font-size:14px; cursor:pointer; id:workshopMenu; text-decoration:underline;" onclick="openNav()">..show menu</span>
<div style="float: right;">
    <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a><br>
            <p align="center"><b>Menu</b></p>

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">초대하기
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <div class="row">
                        <div class="col-sm-7"><input style="height: 33px" type="text" id="memberName" placeholder="닉네임을 입력하세요." /></div>
                        <div class="col-sm-2" ><input style="margin-left: 10px" type="button" class="btn btn-default" id="addMemberBtn" value="추가" /><br></div>
                    </div>
                    <div id="projectMemberList" style="height:150px;overflow-y:scroll;">
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
                </ul>
            </div>

            <!--최신버전 알림-->
            <span>로그</span>
            <div class="well" style="width:100%;height:450px; scroll=auto ; overflow-x:hidden" >
            <pre style="word-wrap: break-word;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -o-pre-wrap;word-break:break-all;"><p id="dbmsg" ></p></pre>
            </div>
            <hr algin="center" >
        
            <!--채팅 부분은 바닥에 깔아버린다.-->
            <div style="position:absolute;bottom:0px;padding-bottom: 60px">
                <!--채팅 글 보여지는 곳-->

                <div class="well" id="scrollDiv"  style="border:1px solid gainsboro; text-align:left; width:100%;height:250px;margin-bottom: 30px; margin-top:20px; margin-left:20px;overflow: auto;">
                <span id="dbmsg2" ></span>
                </div>

                <!--채팅 글쓰기-->
                Message  <input type="text" id="msgbox"/>
            </div>
    </div>

</div>
