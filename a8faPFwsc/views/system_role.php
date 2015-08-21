<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
	tableHover('t',0,-2);
});
</script>
</head>
<body>
<?php echo $form; ?>
<table>
  <tr>
    <th colspan="2">新增角色</th>
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
    <th width="20%">角色</th>
    <th width="20%">添加时间</th>
    <th width="20%">状态</th>
    <th width="40%">操作</th>
  </tr>
  <?php foreach($role as $k=>$v){?>
  <tr>
    <td>&nbsp;<?php echo $v['name']; ?></td>
    <td>&nbsp;<?php echo date('Y-m-d',$v['created']);?></td>
    <td>&nbsp;<span><?php if ($v['flag']==1){ ?><img src="<?php echo base_url('images/yes.gif'); ?>" onclick="setType(this,'<?php echo site_url('system/setRoleStatus/id/'.$v['id'].'/flag/2');?>')" title="可编辑" /><?php }else{ ?><img src="<?php echo base_url('images/no_gray.gif');?>" onclick="setType(this,'<?php echo site_url('system/setRoleStatus/id/'.$v['id'].'/flag/1');?>')" title="可编辑" /><?php } ?></span></td>
    <td><a href="<?php echo site_url('system/roleEdit/'.$v['id']); ?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('system/assignRight/'.$v['id']); ?>">分派权限</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('system/assignMenu/'.$v['id']); ?>">分派菜单</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delAlert('<?php echo site_url('system/roleDel/'.$v['id']);?>')" class="fontcolorB">删除</a></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="4" class="center ui-page"><?php echo $this->pagination->create_links(); ?></td>
  </tr>
</table>
