<script type="text/javascript">
$(document).ready(function() {
	tableHover('t',0,-2);
});
</script>
</head>
<body>
<?php echo $form; ?>
<table>
  <tr>
    <th colspan="2">系统日志</th>
  </tr>
  <tr>
    <td width="10%" class="right">用户名：</td>
    <td><input name="name" type="text" id="name" value="<?php echo $name; ?>" /></td>
  </tr>
  <tr>
    <td class="right">时间：</td>
    <td><input name="stime" type="text" readonly id="stime" class="wdate" onFocus="WdatePicker({skin:'twoer',readOnly:true,doubleCalendar:true})" value="<?php echo $stime; ?>" />
        -
    <input name="etime" type="text" readonly id="etime" class="wdate" onFocus="WdatePicker({skin:'twoer',readOnly:true,doubleCalendar:true})" value="<?php echo $etime; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="25%">用户名</th>
    <th width="50%">登陆时间</th>
    <th width="25%">ip</th>
  </tr>
  <?php foreach($log as $k=>$v){?>
  <tr>
    <td>&nbsp;<?php echo $v['username']; ?></td>
    <td>&nbsp;<?php echo date('Y-m-d H:i:s',$v['created']); ?></td>
    <td>&nbsp;<?php echo $v['ip']; ?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="3" class="center ui-page"><?php echo $this->pagination->create_links(); ?></td>
  </tr>
</table>
