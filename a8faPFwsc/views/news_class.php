<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
	$('.bclass').toggle(function(){
			$k=$(this).attr('key');
			$('.'+$k).hide();
		},
		function(){
			$k=$(this).attr('key');
			$('.'+$k).show();
			});
	tableHover('t');
});
</script>
</head>
<body>
<table>
  <tr>
    <th height="30" colspan="2" class="left"><?php echo $lang['news_class_page_title']; ?></th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right"><?php echo $lang['name']; ?>：</td>
    <td align="left"><input name="name" type="text" id="name" class="required" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>" class="submit" /></td>
  </tr>
    </form>
  
</table>
<table id="t">
  <tr>
    <th width="15%" align="left">&nbsp;</th>
    <th width="30%" align="left"><?php echo $lang['name']; ?></th>
    <th width="15%" align="left"><?php echo $lang['sort']; ?></th>
    <th width="10%" align="left">&nbsp;</th>
    <th width="10%" align="left"><?php echo $lang['operate']; ?></th>
    <th width="10%" align="left">&nbsp;</th>
    <th width="10%" align="left">&nbsp;</th>
  </tr>
  <?php foreach ($results as $k=>$v){ ?>
  <tr class="b">
    <td align="left">&nbsp;</td>
    <td align="left"><span class="bclass" key="<?php echo $k; ?>"></span><?php echo $v['name']; ?></td>
    <td align="left">&nbsp;<span title="<?php echo $lang['click_edit']; ?>" onMouseOver="over(this,'edit');" onMouseOut="out(this,'edit')" onClick="editable(this,<?php echo $v['id']; ?>,'<?php echo base_url(index_page().'/news/updateBSort'); ?>',30)"><?php echo $v['paixun']; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left"><a href="<?php echo site_url('news/sclass/'.$v['id']);?>"><?php echo $lang['class_sub']; ?></a></td>
    <td align="left"><a href="<?php echo site_url('news/bclassEdit/'.$v['id']); ?>"><?php echo $lang['edit']; ?></a></td>
    <td align="left"><?php if ($v['flag']==2) {?>
      <a href="javascript:void(0);" onClick="delAlert('<?php echo site_url('news/bclassDel/'.$v['id']);?>','<?php echo $lang['del_not_resume']; ?>');" class="fontcolorB"><?php echo $lang['del']; ?></a>
      <?php }?>
      &nbsp;</td>
  </tr>
  <?php
  if ($v['sclass']) {
  	foreach ($v['sclass'] as $i=>$j){
  		?>
  <tr class="<?php echo $k; ?>">
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $j['name']; ?></td>
    <td align="left">&nbsp;<span title="<?php echo $lang['click_edit']; ?>" onMouseOver="over(this,'edit');" onMouseOut="out(this,'edit')" onClick="editable(this,<?php echo $j['id']; ?>,'<?php echo base_url(index_page().'/news/updateSSort'); ?>',30)"><?php echo $j['paixun']; ?></span></td>
    <td align="left">&nbsp;</td>
    <td align="left"><a href="<?php echo site_url('news/moveTo/'.$j['id']); ?>"><?php echo $lang['news_move']; ?></a></td>
    <td align="left"><a href="<?php echo site_url('news/sclassEdit/'.$j['id']); ?>"><?php echo $lang['edit']; ?></a></td>
    <td align="left"><?php if ($j['flag']==2) {?>
      <a href="javascript:void(0);" onClick="delAlert('<?php echo site_url('news/sclassDel/'.$j['id']);?>','<?php echo $lang['del_not_resume']; ?>');" class="fontcolorB"><?php echo $lang['del']; ?></a>
      <?php }?>
      &nbsp;</td>
  </tr>
  <?php		
  	}
  }
  }
  ?>
</table>
