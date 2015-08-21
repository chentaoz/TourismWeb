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
    <th colspan="2">新增频道</th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right">频道名称：</td>
    <td><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
    </form>
  
</table>
<table id="t">
  <tr>
    <th width="70%">频道名称</th>
    <th width="30%">操作</th>
  </tr>
  <?php foreach ($bclass as $k=>$v){ ?>
  <tr >
    <td><?php echo $v['name']; ?></td>
    <td ><a href="<?php echo site_url('ad/channelEdit/'.$v['id']); ?>">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;
      <?php if ($v['is_del']==1) {?>
      <a href="javascript:void(0);" onClick="delAlert('<?php echo site_url('ad/channelDel/'.$v['id']);?>');" class="fontcolorB">删除</a>
      <?php } }?>
      &nbsp;</td>
  </tr>
  <tr >
    <td colspan="2" class="center ui-page">&nbsp;<?php echo $this->	pagination->create_links();?></td>
  </tr>
</table>
