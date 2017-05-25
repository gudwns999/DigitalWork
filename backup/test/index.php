<DOCTYPE html>
<html>
<head>
<title> 캡스톤디자인 Three.js 테스트 </title>

<script src="js/Three.js"></script>
<script src="js/plane.js"></script>
<script src="js/thingiview.js"></script>
<script>
      window.onload = function() {
        thingiurlbase = "js";
        thingiview = new Thingiview("viewer");
        thingiview.setObjectColor('#C0D8F0');
        thingiview.initScene();
        thingiview.loadSTL("../big-hand.stl");
      }
</script>
<body>
<center>
캡스톤 디자인I 졸업프로젝트 관련 시연<br><br>
<div id="viewer" style="width:600px;height:600px"></div>