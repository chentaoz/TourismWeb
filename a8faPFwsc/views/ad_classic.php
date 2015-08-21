<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
	tableHover('t',0,-2);
});
</script>
</head>
<body>
<table>
  <tr>
    <th colspan="3">新增位置</th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right">位置名称：</td>
    <td><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td class="right">广告宽度：</td>
    <td><input name="width" type="text" id="width" class="required" />
      <span class="fontcolorA">单位：像素，以下类同</span></td>
  </tr>
  <tr>
    <td class="right">广告高度：</td>
    <td><input name="height" type="text" id="height" class="required" /></td>
  </tr>
  <tr>
    <td class="right">广告频道：</td>
    <td><select name="channel" id="channel" class="required">
        <?php foreach($bclass as $k=>$v){?>
        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
        <?php } ?>
      </select></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
    </form>
  
</table>
<div class="container">频道名称：<a href="<?php echo site_url('ad/classic');?>" class="<?php if($bid=='all'){?>fontcolorB<?php }?> b">全部</a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php foreach($bclass as $k=>$v){?>
<a href="<?php echo site_url('ad/classic/bid/'.$v['id']);?>"<?php if($bid==$v['id']){?> class="fontcolorB"<?php }?>><?php echo $v['name']; ?></a>&nbsp;&nbsp;
<?php }?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontcolorA">点击位置名称，则显示该位置的所有广告</span></div>
<table id="t">
  <tr class="b">
    <th width="10%">位置id</th>
    <th width="32%">位置名称</th>
    <th width="13%">频道名称</th>
    <th width="15%">宽度(像素)</th>
    <th width="15%">高度(像素)</th>
    <th width="15%">操作</th>
  </tr>
  <?php foreach($position as $k=>$v) {?>
  <tr align="center">
    <td>&nbsp;<?php echo $v['id'];?></td>
    <td><?php echo $v['name'];?></td>
    <td>&nbsp;<?php echo $v['channel'];?></td>
    <td>&nbsp;<?php echo $v['width'];?></td>
    <td>&nbsp;<?php echo $v['height'];?></td>
    <td align="left"><a href="<?php echo site_url('ad/classicEdit/'.$v['id']);?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($v['is_del']==1){ ?><a href="javascript:void(0);" onclick="delAlert('<?php echo site_url('ad/classicDel/'.$v['id']);?>')" class="fontcolorB">删除</a><?php }?></td>
  </tr>
  <?php }?>
  <tr>
    <td colspan="10" class="ui-page center"><?php echo $this->pagination->create_links();?></td>
  </tr>
</table>
