<!DOCTYPE html>
<html>
<meta charset="utf-8">
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;

    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s
    }

    .sidenav a:hover, .offcanvas a:focus{
        color: #f1f1f1;
    }

    .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px !important;
        margin-left: 50px;
    }

    .sidebar-wrapper-right {
        margin-right: -250px;
        right: 250px;
        width: 250px;
        background: #000;
        position: fixed;
        height: 100%;
        overflow-y: auto;
        z-index: 1000;
        transition: all 0.4s ease 0s;
    }

    .wrapper.active-right {
        padding-right: 0;
    }

    .wrapper.active-right #sidebar-wrapper-right {
        right: 0;
    }


    .page-content-wrapper {
        width: 100%;
    }

    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>
<head>
    <script src="/socket.io/socket.io.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>
<body>

<div id="mySidenav" class="sidenav"">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">Back</a>
<a href="#">About</a>
<a href="#">Services</a>
<a href="#">Clients</a>
<a href="#">Contact</a>
</div>

<h2>Animated Sidenav Example</h2>
<p>Click on the element below to open the side navigation menu.</p>

<span style="font-size:30px;cursor:pointer" onclick="openNav()">Click...</span>

<script type="text/javascript">
    function openNav() {
        //socket
        var socket = io.connect('http://localhost');
        $('#changename').click(function(){
            socket.emit('changename',{nickname:$('#nickname').val()});
        });
        $("#msgbox").keyup(function(event) {
            if (event.which == 13) {
                socket.emit('send_msg',{to:$('#to').val(),msg:$('#msgbox').val()});
                $('#msgbox').val('');
            }
        });
        socket.on('new',function(data){
            console.log(data.nickname);
            $('#nickname').val(data.nickname);

            document.getElementById("mySidenav").style.width = "250px";

        }
    });
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }


</script>
<script>
    $("#menu-toggle-right").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active-right");
    });
</script>

</body>
</html>