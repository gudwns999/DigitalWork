var stepNo = 1;
	  function view()
	  {
		  $('#projectType').show("slow");
	  }
	  function addMenu()
	  {
		  var txt=$('#projectStepName').val();
		  if(txt=="") alert("단계를 입력해 주세요.");
		  else
		  {
			  $('#projectStepLayer').append('<li class="list-group-item" id="step'+stepNo+'"><span class="badge">'+stepNo+'단계</span>'+txt+'</li><input type="button" class="btn-default2" id="btns'+stepNo+'" onclick="rmv('+stepNo+');" value="-" />');
			  stepNo++;
			  $('#projectStepName').val("");
		  }
	  }
	  /*function addMember() 
	  {
		  var memtxt=$('#memberName').val();
		  if(memtxt=="") alert("추가할 멤버의 닉네임을 입력하세요.");
		  else 
			  {
				<?php
					$servername = "localhost";
					$username = "capstone";
					$password = "zoqtmxhs";
					$dbname = "capstone";

					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);
					mysqli_query($conn, "set names utf8");
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}

					$sql = "select * from dg_member";
					$result = $conn->query($sql);

					while ($row = $result->fetch_assoc())
					{
						//if (strcasecmp($row["nickname"], memtxt))
							
						/*if ($row["nickname"] == memtxt)
							$('#memberLayer').append('<li class="list-group-item">'+txt+'</li>');
						else
							alert ("등록되지 않은 사용자 입니다.");
					}
					
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							echo "<br>". $row["nickname"]. "<br>";
							}
						} else {
							echo "0 results";
						}

					$conn->close();
				?>
			  }
	  }*/
	  function rmv(no)
	  {
		 $("#step"+no).remove();
		 $("#btns"+no).remove();

		 var p = 1;

		 $('.list-group-step').each(function ()
		  {
			 var list = $(this).find ('li span');

			 $(list).each(function ()
			  {
				 console.log (p);
				 $(this).text(p+"단계");
			     p++;
			  });
		  });

		  stepNo = p;
	  }
	  $(function()
	  {
	   	  $(".dropdown-menu").on('click', 'li a', function()
		  {
			  if($(this).val()!="write")
			  {
			   	  $('#projectType').hide("slow");
			  }
			  $(".btn:first-child").html($(this).text()+'<span class="caret"></span>');
		  });
	  });

	  //엔터키 누를시 submit되는거 방지
	  $(function() {
	  $("input:text").keydown(function(evt) {
        if (evt.keyCode == 13)
            return false;
        });
	  });