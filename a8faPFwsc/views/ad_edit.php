<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
</head>
<body>
<table>
  <tr>
    <th colspan="2">编辑广告</th>
  </tr>
  <?php echo $form; ?>
    <tr>
      <td class="right" width="12%">广告位置：</td>
      <td class="left"><select name="sid" id="sid" class="required">
          <option value="">请选择广告位置</option>
          <?php foreach($classic as $k=>$v){?>
          <optgroup label="<?php echo $v['name']; ?>">
          <?php foreach($v['sclass'] as $i=>$j){?>
          <option value="<?php echo $j['id']; ?>" <?php if($ads['classid']==$j['id']){echo 'selected';}?>><?php echo $j['name']; ?></option>
          <?php } ?>
          </optgroup>
          <?php } ?>
      </select></td>
    </tr>
    <tr>
      <td class="right">请选择广告文件：</td>
      <td class="left"><input name="userfile" type="file" id="file" class="file" /></td>
    </tr>
    <tr>
      <td class="right">广告标题：</td>
      <td class="left"><input name="title" type="text" id="title" class="ex500" value="<?php echo $ads['title']; ?>" /></td>
    </tr>
    <tr>
      <td class="right">广告描述：</td>
      <td class="left"><textarea name="intro" id="intro" cols="45" rows="6"><?php echo $ads['intro']; ?></textarea></td>
    </tr>
    <tr>
      <td class="right">广告链接：</td>
      <td class="left"><input name="link" type="text" id="link" class="ex500" value="<?php echo $ads['weblink'];?>" /></td>
    </tr>
    <tr>
      <td class="right">是否在前台显示：</td>
      <td class="left">是：
        <input name="flag" type="radio" class="radio" value="1" <?php if($ads['flag']==1){echo 'checked';}?> />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        否：
        <input name="flag" type="radio" class="radio" value="2" <?php if($ads['flag']==2){echo 'checked';}?> /></td>
    </tr>
    <tr>
      <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $ads['id']; ?>" /><input type="submit" name="Submit" value="提交" class="submit" /></td>
    </tr>
  </form>
</table>
