<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/modal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
    $("#popbutton").click(function(){
        $('div.modal').modal({remote : 'sehee.php'});
    })
})

</script>
<style>
.modal{
    background-color: transperent;  
}

#contentModal .modal-dialog  {
	width:40%;
} .modal-content {
	background:#f9f9f9;
}

</style>
</head>
<body>
<button class="btn btn-default" id="popbutton">모달출력버튼</button><br/>

<div class="modal fade" id = "contentModal">
   <div class="modal-dialog">
    <div class="modal-content">
        <!-- remote ajax call이 되는영역 -->


    </div>
  </div>
</div>
</body>
</html>