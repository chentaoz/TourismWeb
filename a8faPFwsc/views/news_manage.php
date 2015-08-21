<script type="text/javascript">
$(document).ready(function() {
	tableHover('t',0,-3);
	$('#checkall').bind('click',function(){
		if($(this).attr('checked')){
			$('.check').parent().parent().addClass('checkedbg');
			$('.check').attr('checked','checked');
		}
		else{
			$('.check').parent().parent().removeClass();
			$('.check').removeAttr('checked');
		}
	});
	$('.check').bind('click',function(){
		if($(this).attr('checked')){
			$(this).parent().parent().addClass('checkedbg');
		}
		else{
			$(this).parent().parent().removeClass();
		}

	});
	flag=false;
	$('form:last').submit(function(){
		msg='<?php echo $lang['del_not_resume']; ?>';
		if(!flag){
			if(confirm(msg)){
				flag=true;
				$(this).submit();
			}
			else{
				return false;
			}
		}
		else{
			$(this).submit();
		}
	});

});
</script>
</head>
<body>
<table>
  <?php echo $formsearch; ?>
    <tr>
      <th colspan="2"><?php echo $lang['news_search']; ?></th>
    </tr>
    <tr>
      <td width="10%" class="right"><?php echo $lang['news_search_keyword']; ?>：</td>
      <td width="90%"><input name="keyword" type="text" id="keyword" class="ex300" value="<?php echo $keyword; ?>" x-webkit-speech /></td>
    </tr>
    <tr>
      <td class="right"><?php echo $lang['news_classic']; ?>：</td>
      <td><select name="classic" id="classic">
         <option value=""><?php echo $lang['news_classic']; ?></option>
          <?php foreach ($classic as $k=>$v){ ?>
          <optgroup label="<?php echo $v['name']; ?>"> <?php foreach($v['sclass'] as $i=>$j){ ?>
          <option value="<?php echo $j['id']; ?>" <?php if ($sid==$j['id']){echo 'selected';}?>><?php echo $j['name']; ?></option>
          <?php } ?> </optgroup>
          <?php } ?>
        </select></td>
    </tr>
    <tr>
      <td colspan="2" class="center"><input type="submit" name="Submit" value="<?php echo $lang['search']; ?>" class="submit" /></td>
    </tr>
  </form>
</table>
 <?php echo $forminfo; ?>
<table id="t">
  <tr class="b">
    <th width="4%"><?php echo $lang['choose']; ?></th>
    <th width="4%"><?php echo $lang['news_focus']; ?></th>
    <th width="4%"><?php echo $lang['news_top']; ?></th>
    <th width="8%"><?php echo $lang['news_creat']; ?></th>
    <th width="13%"><?php echo $lang['news_updated']; ?></th>
    <th width="25%"><?php echo $lang['news_title']; ?></th>
    <th width="8%"><?php echo $lang['thumb']; ?></th>
    <th width="12%"><?php echo $lang['class_name']; ?></th>
    <th width="5%"><?php echo $lang['status']; ?></th>
    <th width="18%"><?php echo $lang['operate']; ?></th>
  </tr>
    <?php foreach($news as $k=>$v) {?>
    <tr>
      <td class="center"><input name="<?php echo $v['id']; ?>" type="checkbox" class="radio check" value="<?php echo $v['id']; ?>" /></td>
      <td class="center"><span><?php if ($v['is_focus']==1){ ?><img src="<?php echo base_url();?>images/yes.gif" onClick="setType(this,'<?php echo site_url('/news/setStatus/id/'.$v['id'].'/flag/2/typical/1/stamp/'.time());?>')" title="<?php echo $lang['click_edit']; ?>" /><?php } else {?><img src="<?php echo base_url(); ?>images/no_gray.gif" onClick="setType(this,'<?php echo site_url('/news/setStatus/id/'.$v['id'].'/flag/1/typical/1/stamp/'.time());?>')" title="<?php echo $lang['click_edit']; ?>" /><?php }?></span></td>
      <td class="center"><?php if ($v['is_top']==1){ ?><img src="<?php echo base_url(); ?>images/yes.gif" onClick="setType(this,'<?php echo site_url('news/setStatus/id/'.$v['id'].'/flag/2/typical/2/stamp/'.time());?>')" title="<?php echo $lang['click_edit']; ?>" /><?php } else{ ?><img src="<?php echo base_url();?>images/no_gray.gif"onclick="setType(this,'<?php echo site_url('news/setStatus/id/'.$v['id'].'/flag/1/typical/2');?>')" title="<?php echo $lang['click_edit']; ?>" /><?php } ?></td>
      <td><?php echo date('Y-m-d',$v['created']);?></td>
      <td><?php echo date('Y-m-d H:i:s',$v['update']);?></td>
      <td>&nbsp;<a href="<?php echo site_url('news/preview/id/'.$v['id']);?>" target="_blank"><img src="<?php echo base_url();?>images/preview.png" align="absmiddle" title="<?php echo $lang['preview']; ?>" /></a>&nbsp;<span title="<?php echo $lang['click_edit']; ?>" onMouseOver="over(this,'edit');" onMouseOut="out(this,'edit')" onClick="editable(this,<?php echo $v['id']; ?>,'<?php echo base_url(index_page().'/news/updateTitle'); ?>',300)"><?php echo $v['title']; ?></span> &nbsp;</td>
      <td><?php if ($v['img']){?><a href="javascript:void(0)" onClick="delAlert('<?php echo base_url(index_page().'/news/imgDel/id/'.$v['id'].'/img/'.$v['img']); ?>','<?php echo $lang['del_not_resume']; ?>');"><?php echo $lang['del']; ?></a>&nbsp;<a href="<?php echo base_url('../'.$this->common->uploadpath.'news/'.$v['img']); ?>" target="_blank"><?php echo $lang['view']; ?></a><?php }else{ ?><a href="<?php echo base_url(index_page().'/news/imgAdd/id/'.$v['id']); ?>"><?php echo $lang['upload']; ?></a><?php } ?></td>
      <td><?php echo $v['name']; ?></td>
      <td class="center"><span><?php if ($v['is_visible']==1){ ?><img src="<?php echo base_url();?>images/yes.gif" onClick="setType(this,'<?php echo base_url(index_page().'/news/setStatus/id/'.$v['id'].'/flag/2/typical/3/stamp/'.time());?>')" title="<?php echo $lang['click_edit']; ?>" /><?php }else{ ?><img src="<?php echo base_url();?>images/no_gray.gif" onClick="setType(this,'<?php echo base_url(index_page().'/news/setStatus/id/'.$v['id'].'/flag/1/typical/3/stamp/'.time());?>')" title="<?php echo $lang['click_edit']; ?>" /><?php } ?></span></td>
      <td><a href="<?php echo site_url('news/edit/'.$v['id']); ?>"><?php echo $lang['edit']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($v['is_del']=="1"){ ?><a href="javascript:void(0)" onClick="delAlert('<?php echo site_url('news/del/'.$v['id']);?>','<?php echo $lang['del_not_resume']; ?>')" class="fontcolorB"><?php echo $lang['del']; ?></a><?php }else{ ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td class="center"><input name="checkall" type="checkbox" class="radio" id="checkall" value="checkbox" /></td>
      <td colspan="8"><input name="submit1" type="submit" class="bsubmit" value="<?php echo $lang['del_choose']; ?>" />
      <input name="submit2" type="submit" class="bsubmit" value="<?php echo $lang['move_choose']; ?>" /></td>
    </tr>
    <tr>
      <td colspan="10" class="center ui-page"><?php echo $this->pagination->create_links(); ?></td>
    </tr>
</table>
 </form>