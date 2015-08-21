<script type="text/javascript">
$(document).ready(function() {
	tableHover('t',0,-2);
});
</script>
</head>
<body>
<table>
  <tr>
  <th colspan="2">广告检索</th>
  </tr>
  <?php echo $form;?>
    <tr>
      <td width="10%" class="right">广告标题：</td>
      <td><input type="text" name="keyword" /></td>
    </tr>
    <tr>
      <td class="right">广告位置：</td>
      <td><select name="sid" id="sid">
          <option value="">请选择广告位置</option>
          <?php foreach($classic as $k=>$v){?>
          <optgroup label="<?php echo $v['name']; ?>">
          <?php foreach($v['sclass'] as $i=>$j){?>
          <option value="<?php echo $j['id']; ?>"><?php echo $j['name']; ?></option>
          <?php } ?>
          </optgroup>
          <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" class="center"><input type="submit" value="提交" class="submit" /></td>
    </tr>
  </form>
</table>
<table id="t">
  <tr>
    <th width="31%">标题</th>
    <th width="19%">位置</th>
    <th width="6%">排序</th>
    <th width="8%">宽度</th>
    <th width="8%">高度</th>
    <th width="10%">上传时间</th>
    <th width="6%">状态</th>
    <th width="12%">操作</th>
  </tr>
  <?php foreach($ads as $k=>$v){?>
  <tr>
    <td>&nbsp;&nbsp;<a href="<?php echo base_url('../'.$this->config->item('upload_ad').'/'.$v['img']); ?>" target="_blank"><img src="<?php echo base_url().'images/image.png';?>" class="absmiddle" title="查看广告图片" /></a>&nbsp;<span title="点击可编辑" onmouseover="over(this,'edit');" onmouseout="out(this,'edit')" onclick="editable(this,<?php echo $v['id']; ?>,'<?php echo base_url(index_page().'/ad/updateTitle'); ?>',220)"><?php echo $v['title']; ?></span></td>
    <td class="left" vclass="middle">&nbsp;&nbsp;<?php echo $v['name']; ?></td>
    <td>&nbsp;<span title="点击可编辑" onmouseover="over(this,'edit');" onmouseout="out(this,'edit')" onclick="editable(this,<?php echo $v['id']; ?>,'<?php echo base_url(index_page().'/ad/updateSort'); ?>',30)"><?php echo $v['sort_number']; ?></span></td>
    <td>&nbsp;<?php echo $v['width']; ?></td>
    <td>&nbsp;<?php echo $v['height']; ?></td>
    <td>&nbsp;<?php echo date('Y-m-d',$v['created']); ?></td>
    <td><span><?php if ($v['flag']==1){ ?><img src="<?php echo base_url();?>images/yes.gif" onclick="setType(this,'<?php echo site_url('ad/setStatus/id/'.$v['id'].'/flag/2');?>')" title="可编辑" /><?php }else{ ?><img src="<?php echo base_url();?>images/no_gray.gif" onclick="setType(this,'<?php echo site_url('ad/setStatus/id/'.$v['id'].'/flag/1');?>')" title="可编辑" /><?php } ?></span></td>
    <td><a href="<?php echo site_url('ad/edit/id/'.$v['id']);?>">编辑</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delAlert('<?php echo site_url('ad/del/id/'.$v['id']);?>')" class="f2">删除</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="8" class="center ui-page"><?php echo $this->pagination->create_links();?></td>
  </tr>
</table>