<!DOCTYPE html>
<head>
    <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://capstone.hae.so/v2/css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="http://capstone.hae.so/v2/js/clientKSH.php?no=1"></script>
    <script src="http://capstone.hae.so/v2/js/capstone.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?include_once("nav.php");?>

<div style="height:95%; white-space:nowrap;">
    <div class="container" id="infinite" style="overflow-x: scroll; height:100%; width:100%">
        <br>
        <button class="button button2" id="makeCardBtn" onclick="confirmCreateCard()"> 단계추가 </button>

        <div style="float: right;" class="fixed">
            <?include_once("sidebar.php");?>
        </div>
    </div>
</div>

<div class="modal fade" id = "contentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- remote ajax call이 되는영역 -->


        </div>
    </div>
</div>


</body>
</html>
