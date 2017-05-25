<?
session_start();
?>
<!DOCTYPE html>
<head>
<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/client.php?no=<?=$_GET[no]?>"></script>
	<script src="js/capstone.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 850px;}

    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
  </style>
</head>
<body>
<?include_once("sidebar.php");?>
<?include_once("nav.php");?>
<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-10 text-left" style="height:100%;">
      <!--메인화면-->
      <div style="white-space:nowrap; height:100%; overflow:auto;"> <!--가로 스크롤 생기게 하는부분-->
      <h1 id="workshopTitle"></h1>
     
    </div>
    </div>
    <div class="col-sm-2 sidenav">
      <!--사이드바-->
      <div class="well">
        <p></p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>
</body>
</html>
