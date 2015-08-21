<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
	tableHover('t',0,-1);
});
</script>
</head>
<body>
<?php echo $form; ?>
<table>
  <tr>
    <th colspan="2">新增权限组</th>
  </tr>
  <tr>
    <td width="10%" class="right">名称：</td>
    <td><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="50%">权限组名称</th>
    <th width="50%">操作</th>
  </tr>
  <?php foreach($module as $k=>$v){?>
  <tr>
    <td>&nbsp;<a href="<?php echo site_url('system/modRights/'.$v['id']); ?>"><?php echo $v['name']; ?></a></td>
    <td><a href="<?php echo site_url('system/modRights/'.$v['id']); ?>">新增权限</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('system/moduleEdit/'.$v['id']); ?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delAlert('<?php echo site_url('system/moduleDel/'.$v['id']);?>')" class="fontcolorB">删除</a></td>
  </tr>
  <?php }?>
</table>
