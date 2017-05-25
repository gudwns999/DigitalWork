 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
$(function(){
			/*Ajax*/
	$.post("http://lab.kookmin.ac.kr/Edu/ContentsViewNextProcess",{
		"scheduleMemberProgressNo": "562472", "gapTime": "20", "currentPage": "23" 
		},function(e)
		{
			alert(e);
		});
	return false;
});
</script>