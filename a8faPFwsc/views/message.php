<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?php echo $lang['notice']; ?></title>
        <!--
        <link type="text/css" href="" rel="stylesheet" />
        <script type="text/javascript" src=""></script>
        -->
        <style type="text/css">
body {
	margin: 0;
	line-height: 30px;
	font-size: 12px;
}
a {
	text-decoration: none;
	color: #E13300;
}
ul {
	list-style: none;
	margin: 0;
	padding: 0;
}
#container {
	width: 900px;
	margin: 20px auto
}
#message {
	width: 500px;
	margin: 200px auto;
	border: 1px solid #DDD;
	box-shadow:0 1px 3px #ddd;
	background:#fff;
}
#message .msg_title {
	font-weight: bold;
	font-size: 14px;
	color:#666;
	padding: 5px;
	border-bottom: 1px dotted #DDD;
	background:-webkit-linear-gradient(top,#fff,#efefef);
	background:-moz-linear-gradient(top,#fff,#efefef);
}
#message .msg_content {
	padding: 20px;
}
#message .notice {
	padding: 0 10px;
	text-align: right;
}
</style>
        </head>

        <body>
        <div id="container">
          <div id="message">
            <ul>
              <li class="msg_title"><?php echo $lang['notice']; ?></li>
              <li class="msg_content"><?php echo $content; ?></li>
              <li class="notice"><?php echo $delay_time; ?><?php echo $lang['auto_redirect']; ?>，<?php echo anchor($target_url, $lang['no_waiting']); ?></li>
            </ul>
          </div>
        </div>
</body>
        <script type="text/javascript">
        setTimeout(function() {
            window.location = "<?php echo site_url($target_url); ?>";
        }, <?php echo ($delay_time * 1000); ?>);
    </script>
</html>
<?php
die();
?>
