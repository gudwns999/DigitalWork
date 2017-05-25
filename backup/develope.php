<!DOCTYPE html>
<?
 $url = $_POST['url'];
 $write_order = $_POST['write_order'];
 $workshop_no = $_POST['workshop_no'];
 $project_name=$_POST['project_name'];
 $file_ver = $_POST['file_ver'];
 $process_no = $_POST['process_no'];
 $upload_filename = $_POST['upload_filename'];

?>
<html lang="ko">
<head>
    <title>디지털공방</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- default 버튼 색 지정-->
    <style>
        .btn-default {
            background: #FF4000;
            color: #fff;
        }
        .btn-default:hover {
            background: #fff;
            color: #000;
        }
        .nav-pills a {
            color:#FF4000;
        }
        .nav-pills > li.active > a {
            background-color:#FF4000;
        }
    </style>
</head>
<body>
<?include_once("nav.php")?>
<!--파일 미리보기 스크립트-->
<script>
    $.fn.setPreview = function(opt){
        "use strict"
        var defaultOpt = {
            inputFile: $(this),
            img: null,
            w: 200,
            h: 200
        };
        $.extend(defaultOpt, opt);

        var previewImage = function(){
            if (!defaultOpt.inputFile || !defaultOpt.img) return;

            var inputFile = defaultOpt.inputFile.get(0);
            var img       = defaultOpt.img.get(0);

            // FileReader
            if (window.FileReader) {
                // image 파일만
                if (!inputFile.files[0].type.match(/image\//)) return;

                // preview
                try {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        img.src = e.target.result;
                        img.style.width  = defaultOpt.w+'px';
                        img.style.height = defaultOpt.h+'px';
                        img.style.display = '';
                    }
                    reader.readAsDataURL(inputFile.files[0]);
                } catch (e) {
                    // exception...
                }
                // img.filters (MSIE)
            } else if (img.filters) {
                inputFile.select();
                inputFile.blur();
                var imgSrc = document.selection.createRange().text;

                img.style.width  = defaultOpt.w+'px';
                img.style.height = defaultOpt.h+'px';
                img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enable='true',sizingMethod='scale',src=\""+imgSrc+"\")";
                img.style.display = '';
                // no support
            } else {      }
        };
        // onchange
        $(this).change(function(){
            previewImage();
        });
    };
    $(document).ready(function(){
        var opt = {
            img: $('#img_preview'),
            w: 200,
            h: 200
        };
        $('#upload').setPreview(opt);
    });
</script>
<br><br><br>
<div class="container" style="max-width:900px;">
    <div class="page-header">
        <h1>버전 업그레이드</h1>
        <p>상위 버전으로 올리기.</p><br><br><br><br>
    </div>
    <?
    $connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
    mysqli_query($connect, "set names utf8");
    if(!$connect) {
        exit("DB연결오류");
    } ?>

    <form action=insertdvel.php method=post class="form-inline" role="form" align="strong" enctype="multipart/form-data">
        <div class="row" style="width:100%;">
            <div class="col-sm-2">
                작업자
            </div>
            <div class="col-sm-10">
                <?
                session_start();
                if($_SESSION["id"])
                {
                    ?>
                    <input class="form-control" id="disabledInput" type="text" disabled placeholder=<?= $_SESSION["nick"] ?>>
                    <fieldset>
                        <input type='hidden' name='url' value='<?=$url?>'>
                        <input type='hidden' name='write_order' value ='<?=$write_order?>'>
                        <input type='hidden' name='workshop_no' value='<?=$workshop_no?>'>
                        <input type='hidden' name='project_name' value ='<?=$project_name?>'>
                        <input type='hidden' name='file_ver' value ='<?=$file_ver?>'>
                        <input type='hidden' name='process_no' value='<?=$process_no?>'>
                        <input type='hidden' name='upload_filename' value ='<?=$upload_filename?>'>

                        <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                        <input type="hidden" name="mode" value="upload" />
                        <input type="file" id="upload" name="upload" style="float: right"/>
                    </fieldset>
                <?}?>
            </div>
        </div>
            <img src='<?=$url?>' id='myImage' style="width: 200px;height: 200px;float:left;">
            <img id="img_preview" style="display:none;float: right"/>


        <div class="col-sm-10">
        </div>
        <div class="row" style="width:100%;">
            <div class="col-sm-2">
                변경 제목
            </div>
            <div class="col-sm-10">
                <input class="form-control" name="write_name" type="text" style="width:75%;" placeholder="변경 내용을 입력하세요.">
            </div>
        </div>
        <br>
        <div class="row" style="width:100%;">
            <div class="col-sm-2">
                변경 설명
            </div>
            <div class="col-sm-10">
                <input class="form-control" name="write_description" type="text" row="5" style="width:75%;" placeholder="변경 내용을 입력하세요.">
            </div>
        </div>
    
        <center>
            <input type=submit value="버전올리기">
            &nbsp;&nbsp;
            <input type=button value="되돌아가기"
                   onclick="history.back(-1)">
        </center>
    </form>


</div>


</body>
</html>