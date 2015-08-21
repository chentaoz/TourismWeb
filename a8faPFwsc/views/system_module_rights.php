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
    <th colspan="2">新增权限</th>
  </tr>
  <tr>
    <td width="10%" class="right">名称：</td>
    <td><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td width="10%" class="right">权限码：</td>
    <td><input name="rights" type="text" id="rights" class="required" value="<?php echo $right; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $id;?>" /><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="40%">权限名称</th>
    <th width="20%">权限码</th>
    <th width="40%">操作</th>
  </tr>
  <?php foreach($rights as $k=>$v){?>
  <tr>
    <td>&nbsp;<?php echo $v['right_name']; ?></td>
    <td>&nbsp;<?php echo $v['rights']; ?></td>
    <td><a href="<?php echo site_url('system/modRightsEdit/'.$v['id']); ?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delAlert('<?php echo site_url('system/modRightsDel/'.$v['modid'].'/'.$v['id']);?>')" class="fontcolorB">删除</a></td>
  </tr>
  <?php }?>
</table>
