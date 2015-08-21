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
    <th colspan="2">新增菜单组</th>
  </tr>
  <tr>
    <td width="10%" class="right">名称：</td>
    <td><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td class="right">排序：</td>
    <td><input name="paixun" type="text" id="paixun" value="255" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="30%">名称</th>
    <th width="15%">排序</th>
    <th width="20%">显示状态</th>
    <th width="35%">操作</th>
  </tr>
  <?php foreach($menu as $k=>$v){?>
  <tr>
    <td>&nbsp;<a href="<?php echo site_url('system/menu/'.$v['id']); ?>"><?php echo $v['name']; ?></a></td>
    <td>&nbsp;<span title="点击可编辑" onmouseover="over(this,'edit');" onmouseout="out(this,'edit')" onclick="editable(this,<?php echo $v['id']; ?>,'<?php echo base_url(index_page().'/system/updateMenuGroupSort'); ?>',30)"><?php echo $v['paixun']; ?></span></td>
    <td><span><?php if ($v['flag']==1){ ?><img src="<?php echo base_url('images/yes.gif'); ?>" onclick="setType(this,'<?php echo site_url('system/setMenuGroupStatus/id/'.$v['id'].'/flag/2');?>')" title="可编辑" /><?php }else{ ?><img src="<?php echo base_url('images/no_gray.gif');?>" onclick="setType(this,'<?php echo site_url('system/setMenuGroupStatus/id/'.$v['id'].'/flag/1');?>')" title="可编辑" /><?php } ?></span></td>
    <td><a href="<?php echo site_url('system/menu/'.$v['id']); ?>">查看下级菜单</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('system/menu/'.$v['id']); ?>">新增菜单</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('system/menuGroupEdit/'.$v['id']); ?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($v['is_del']==1){ ?><a href="javascript:void(0);" onclick="delAlert('<?php echo site_url('system/menuGroupDel/'.$v['id']);?>')" class="fontcolorB">删除</a><?php }?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="4" class="center ui-page"><?php echo $this->pagination->create_links(); ?></td>
  </tr>
</table>
