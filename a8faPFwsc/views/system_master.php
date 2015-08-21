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
    <th colspan="2">新增管理员</th>
  </tr>
  <tr>
    <td width="10%" class="right">账号：</td>
    <td><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td width="10%" class="right">密码：</td>
    <td><input name="psw" type="password" id="psw" class="required" /></td>
  </tr>
  <tr>
    <td width="10%" class="right">确认密码：</td>
    <td><input name="psw2" type="password" id="psw2" class="required" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
  </tr>
</table>
</form>
<table id="t">
  <tr>
    <th width="20%">管理员</th>
    <th width="20%">加入时间</th>
    <th width="20%">角色名称</th>
    <th width="20%">状态</th>
    <th width="40%">操作</th>
  </tr>
  <?php foreach($m as $k=>$v){?>
  <tr>
    <td>&nbsp;<?php echo $v['username']; ?></td>
    <td>&nbsp;<?php echo date('Y-m-d',$v['created']);?></td>
    <td>&nbsp;<?php echo $v['role']; ?></td>
    <td>&nbsp;<?php if($v['classic']!='1'){?><span><?php if ($v['flag']==1){ ?><img src="<?php echo base_url('images/yes.gif'); ?>" onclick="setType(this,'<?php echo site_url('system/setMasterStatus/id/'.$v['id'].'/flag/2');?>')" title="可编辑" /><?php }else{ ?><img src="<?php echo base_url('images/no_gray.gif');?>" onclick="setType(this,'<?php echo site_url('system/setMasterStatus/id/'.$v['id'].'/flag/1');?>')" title="可编辑" /><?php } ?></span><?php }?></td>
    <td><?php if($v['classic']!='1'){?><a href="<?php echo site_url('system/masterEdit/'.$v['id']); ?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('system/masterRole/'.$v['id']); ?>">分派角色</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="delAlert('<?php echo site_url('system/masterDel/'.$v['id']);?>')" class="fontcolorB">删除</a><?php }?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="5" class="center ui-page"><?php echo $this->pagination->create_links(); ?></td>
  </tr>
</table>
