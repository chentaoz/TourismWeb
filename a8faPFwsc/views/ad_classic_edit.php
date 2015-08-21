<script type="text/javascript">
$(document).ready(function() {
	$('#form1').validateMyForm();
});
</script>
</head>
<body>
<table>
  <tr>
    <th colspan="3">编辑位置</th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right">位置名称：</td>
    <td><input name="name" type="text" id="name" class="required" value="<?php echo $ad['name']; ?>" /></td>
  </tr>
  <tr>
    <td class="right">广告宽度：</td>
    <td valign="middle"><input name="width" type="text" id="width" class="required" value="<?php echo $ad['width']; ?>" />
      <span class="fontcolorA">单位：像素，以下类同</span></td>
  </tr>
  <tr>
    <td class="right">广告高度：</td>
    <td><input name="height" type="text" id="height" class="required" value="<?php echo $ad['height']; ?>" /></td>
  </tr>
  <tr>
    <td class="right">广告频道：</td>
    <td><select name="channel" id="channel" class="required">
        <?php foreach($bclass as $k=>$v){?>
        <option value="<?php echo $v['id']; ?>" <?php if ($ad['bid']==$v['id']){?>selected<?php }?> ><?php echo $v['name']; ?></option>
        <?php } ?>
      </select></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $ad['id']; ?>" /><input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
    </form>
</table>
