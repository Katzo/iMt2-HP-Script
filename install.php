<html>
<head>
<title>Installation - iMt2 Homepage Script</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style type="text/css">
@import url('css/install.css');
.success {
	color:#00AA00;
}
.error {
	color:#EE0000;
}
</style>
</head>
<div id="container">
<div class="title">Installation</div>
<div class="content">
<?php
if (isset($_GET["step"]))
	switch($_GET["step"]){
		case 1:dostuff(); break;
		case 2:dostuff2(); break;
		case 3:dostuff3();break;
		
	}
?>
</div>
<font color="#818181" size="-6"><a href="https://github.com/imermcmaps/iMt2-HP-Script">iMt2-HP-Script</a></font>
</div>

</div>
</html>