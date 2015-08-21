<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
	$("#send").bind("click",function(){
		tester=$('#tester').val();
		$('#info').text('测试中，请稍候...');
		$('#info').load('<?php echo base_url(index_page().'/system/emailTest/mail');?>'+'/'+encodeURIComponent(tester));
	});
});
</script>
</head>
<body>
<?php echo $form; ?>
<table>
  <tr>
    <th colspan="2">邮件参数设置</th>
  </tr>
  <tr>
    <td width="15%" class="right">SMTP服务器：</td>
    <td><input type="text" name="host" id="host" value="<?php echo $configs['smtp_host']; ?>" /></td>
  </tr>
  <tr>
    <td class="right">SMTP端口：</td>
    <td><input type="text" name="port" id="port" value="<?php echo $configs['smtp_port']; ?>" /></td>
  </tr>
  <tr>
    <td class="right">发信人邮件地址：</td>
    <td><input type="text" name="mail" id="mail" value="<?php echo $configs['smtp_mail']; ?>" /></td>
  </tr>
  <tr>
    <td class="right">SMTP身份验证用户名：</td>
    <td><input type="text" name="user" id="user" value="<?php echo $configs['smtp_user']; ?>" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="right">SMTP身份验证密码：</td>
    <td><input type="password" name="psw" id="psw" value="<?php echo $configs['smtp_psw']; ?>" autocomplete="off" /></td>
  </tr>
  <tr>
    <td class="right">测试邮件地址：</td>
    <td><input type="text" name="tester" id="tester" />
      <input type="button" value="测试" class="submit" id="send" />
    <span class="fontcolorB" id="info"></span></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
