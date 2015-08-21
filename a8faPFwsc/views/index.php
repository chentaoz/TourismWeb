<style type="text/css">
body, html {
	background:url(<?php echo base_url(); ?>images/bg1.png) repeat;
}
.container {
	width:480px;
	margin:15% auto 30px;
	background:#fff;
	box-shadow:0 0 20px #bbb;
	overflow:hidden;
	padding-bottom:20px;
	border-radius:5px;
}
.title {
	height:45px;
	line-height:45px;
	background:#005889;
	font-size:20px;
	padding-left:20px;
	color:#fff;
}
form {
	display:block;
	margin-top:20px;
}
label {
	display:block;
	font-size:14px;
	margin:15px 65px 3px;
}
input {
	width:350px;
	height:30px;
	line-height:30px;
	padding-left:5px;
	border:1px solid #bbb;
	border-radius:3px;
	margin:0 65px;
}
.action {
	margin:10px 0;
}
#J-submit {
	width:120px;
	height:40px;
	line-height:40px;
	background:#005889;
	color:#fff;
	border:none;
	margin-top:15px;
	font-size:16px;
}
#copyright {
	text-align:center;
	color:#aaa;
	margin-top:10px;
}
</style>
<script type="text/javascript">
$(document).ready(function(e) {
    if(window.top!=window.self){
		window.top.location.href="index.php";
	}
});
</script>
</head><body>
<div class="container">
  <div class="title">Control Pannel</div>
  <?php echo $form; ?>
    <label for="username" ><?php echo $lang['sys_username']; ?></label>
    <input type="text" name="username" id="username" maxlength="30" />
    <label for="psw"><?php echo $lang['sys_psw']; ?></label>
    <input type="password" name="psw" id="psw" maxlength="50" />
    <div class="action">
      <input type="submit" name="submit" value="Login" id="J-submit" />
    </div>
  </form>
  <p id="copyright"> Copyright &copy; <?php echo date('Y',time()); ?> Xcenter All rights reserved. </p>
</div>
