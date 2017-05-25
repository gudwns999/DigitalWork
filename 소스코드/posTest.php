<!DOCTYPE html>
<html>
   <title> Card Position Test </title>
   
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   
   <head>
      <style>
      .button {
         position: relative;
         background-color: #D84747;
         border: none;
         color: white;
         padding: 10px 20px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         margin: 4px 2px;
         cursor: pointer;
         -webkit-transition-duration: 0.4s;
         transition-duration: 0.4s;
         font-size: 15px;
      }
      
      .button2:hover {
         box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
      }
      
      .container {
         position: relative;
      }
      
      div {
         height: relative;
         margin: 10px;
         padding: 16px;
      }
      
      input {
         font-size: 25px;
         width: 100%;
         border: none;
         background: transparent;
      }
      
      .w3-card-12 {
         background: #EC7373;
         width: 400px;
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
      </style>
      
      <script>
         var count = 0;
         
         function createCard (elmt)
         {
            count++;
            
            var id = $(elmt).attr('id'); // 버튼의 id를 받는다.
            $("#"+id).remove();
            
            // 카드 생성
            var newCard = $('<div class="w3-card-12" id="card'+count+'" background="#ACACAC" style="display:inline-block; margin:0 15px 0 15px; width: 400px;"><input type="text"><br>');
            var addBtn = $('<button class="button button2" id="inButton'+count+'" onclick="createInCard(this)"> 추가 </button></div>');
            
            $("#infinite").append(newCard);
            $("#card"+count).append(addBtn);
            
            // 옆으로 버튼 계속 추가
            var newButton = $('<button class="button button2" id="makeCardBtn" onclick="createCard(this)"> 추가 </button>');
            $("#infinite").append(newButton);
         }
         
         function createInCard (elmt) 
         {   
            var textArea = $('<textarea style="width: relative;" row="relative"></textarea><br>');
            var id = $(elmt).attr('id'); // 버튼의 id를 받는다.
            
            //var $newInCard = $('<div class="w3-card-12 w3-card-12-2" id="inCard" background="white"><textarea style="width: relative;" row="relative">');
            
            // 카드의 버튼을 고유의 id를 붙여서 만든다.
            var addInBtn = $('<button class="button button2" id="'+id+'" onclick="createInCard(this)"> 추가 </button>');

            // 해당 버튼이 속한 div class의 id를 받는다.
            var divId = $(elmt).closest("div").attr("id");
            console.log (id);

            
            // 각 카드별로 버튼과 텍스트 area를 추가한다.
            $("#"+divId).append(textArea);
            $("#"+divId).append(addInBtn);
            $("#"+id).remove();
         }
         
      </script>
   </head>
   <body bgcolor="#832121" style="height:950px;">
      <div class="container" id="infinite" style="overflow-x:auto; white-space:nowrap; height:100%;">
         <h2 style="color:white">Card Position Test</h2>
         <button class="button button2" id="makeCardBtn" onclick="createCard(this)"> 추가 </button>
      </div>
   </body>
</html>