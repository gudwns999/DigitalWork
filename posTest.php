<!DOCTYPE html>
<html>
   <title> Card Position Test </title>
   
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   
   <head>
      <style>
	   body { 
		 background: #832121;
		 height: 950px;
	  }
      .button {
         position: relative;
         background-color: #D84747;
         border: none;
         color: white;
         padding: 5px 10px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         margin: 2px 1px;
         cursor: pointer;
         -webkit-transition-duration: 0.4s;
         transition-duration: 0.4s;
		 border-radius:5px;
		 width:100px;
         font-size: 13px;
      }
      
      .button2:hover {
         box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
      }
      
      .container {
         position: relative;
      }
      
      div {
         height: relative;
         padding: 10px 15px;
      }
      
      input {
         font-size: 25px;
         width: 80%;
         border: none;
         background: transparent;
      }
      
      .w3-card-12 {
         background: #EC7373;
         width: 400px;
		 border-radius:5px;
      }
      .w3-card-12-2 {
         width: 400px;
         height: relative;
         background: white;
      }
      
      textarea {
         border: none;
         width: 100%;
         height: 100px;
      }

	  .glyphicon {
		 color: #D84747;
	  }

      </style>
      
      <script>
         var count = 0;
		 var inText = 1;
         
         function createCard (elmt)
         {
            count++;
            
            var id = $(elmt).attr('id'); // 버튼의 id를 받는다.
            $("#"+id).remove();
            
            // 카드 생성
            var newCard = $('<div class="w3-card-12" id="card'+count+'" background="#ACACAC" style="display:inline-block; vertical-align:top; margin:0 6px 0 6px; width: 400px;"><input type="text" id="subjectText'+count+'"><br>');
			
            var addBtn = $('<button class="button button2" id="inButton'+count+'" onclick="createInCard(this)"> 추가 </button></div>');
			var delBtn = $('<a href="#"><span class="glyphicon glyphicon-remove" onclick="delCard(this)" style="float:right; top:-40px;"></span></a>');
            
			
            $("#infinite").append(newCard);
			$('#card'+count).hide().fadeIn(200);
			$("#card"+count).append(addBtn);
			
            
            // 옆으로 버튼 계속 추가
            var newButton = $('<button class="button button2" id="makeCardBtn" onclick="createCard(this)"> 추가 </button>');
            $("#infinite").append(newButton);

			$('#subjectText'+count).focus();
			$("#card"+count).append(delBtn);
         }
         
         function createInCard (elmt) 
         {   
            var textArea = $('<div id="inText'+inText+'"><textarea style="max-width: 330px; border-radius:5px;" row="relative"></textarea><br>');
			var delBtn = $('<a href="#"><span class="glyphicon glyphicon-remove" onclick="delCard(this)"></span></a>');
            var id = $(elmt).attr('id'); // 버튼의 id를 받는다.
            
            //var $newInCard = $('<div class="w3-card-12 w3-card-12-2" id="inCard" background="white"><textarea style="width: relative;" row="relative">');
            
            // 카드의 버튼을 고유의 id를 붙여서 만든다.
            var addInBtn = $('<button class="button button2" id="'+id+'" onclick="createInCard(this)"> 추가 </button>');
			var saveBtn = $('<button class="button button2" id="save'+id+'" onclick=""> 저장 </button>');

            // 해당 버튼이 속한 div class의 id를 받는다.
            var divId = $(elmt).closest("div").attr("id");
            
            // 각 카드별로 버튼과 텍스트 area를 추가한다.
            $("#"+divId).append(textArea);
            $("#"+divId).append(addInBtn);
			console.log (divId);
			$("#inText"+inText).append(saveBtn);
			$("#inText"+inText).append(delBtn);
            $("#"+id).remove();
			console.log (inText);
			++inText;
         }

		 function delCard (elmt)
		 {
			 // 해당 버튼이 속한 div class의 id를 받는다.
			 var thisClass = $(elmt).closest("div").attr("id");

			 // 해당 id를 갖는 div의 모든 요소 삭제.
			 console.log (thisClass);
			 $('#'+thisClass).remove();
		 }
         
      </script>
   </head>
	  <body>
      <div class="container" id="infinite" style="overflow-x: scroll; white-space:nowrap; height:100%; width:100%">
         <h2 style="color:white">Card Position Test</h2>
         <button class="button button2" id="makeCardBtn" onclick="createCard(this)"> 추가 </button>
      </div>
   </body>
</html>