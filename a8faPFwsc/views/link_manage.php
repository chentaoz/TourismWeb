<script type="text/javascript">
$(document).ready(function() {
	tableHover('t',0,-2);
});
</script>
</head>
<body>
<table id="t">
    <tr>
      <th width="25%">网站名称</th>
      <th width="30%">网址</th>
      <th width="10%">状态</th>
      <th width="8%">排序</th>
      <th width="27%">操作</th>
    </tr>
	<?php foreach($links as $k=>$v){ ?>
    <tr>
      <td><a href="<?php echo $v['web']; ?>" target="_blank">&nbsp;<?php echo $v['name']; ?></a>&nbsp;</td>
      <td><a href="<?php echo $v['web']; ?>" target="_blank">&nbsp;<?php echo $v['web']; ?></a></td>
      <td><span><?php if ($v['flag']==1){ ?><img src="<?php echo base_url();?>images/yes.gif" onclick="setType(this,'<?php echo base_url(index_page().'/link/setStatus/id/'.$v['id'].'/flag/2');?>')" title="可编辑" /><?php }else{ ?><img src="<?php echo base_url();?>images/no_gray.gif" onclick="setType(this,'<?php echo base_url(index_page().'/link/setStatus/id/'.$v['id'].'/flag/1');?>')" title="可编辑" /><?php } ?></span></td>
      <td>&nbsp;<span title="点击可编辑" onmouseover="over(this,'edit');" onmouseout="out(this,'edit')" onclick="editable(this,<?php echo $v['id']; ?>,'<?php echo base_url(index_page().'/link/updateSort'); ?>',30)"><?php echo $v['paixun']; ?></span></td>
      <td><a href="<?php echo site_url('link/edit/id/'.$v['id']);?>">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delAlert('<?php echo site_url('link/del/id/'.$v['id']);?>')">删除</a></td>
    </tr>
	<?php } ?>
    <tr>
      <td colspan="5" class="center ui-page"><?php echo $this->pagination->create_links(); ?></td>
    </tr>
</table>