</head>
<body>
<table>
  <tr>
    <th colspan="2" class="left">编辑频道</th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right">频道名称：</td>
    <td><input name="name" type="text" id="name" value="<?php echo $channel[0]['name']; ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="id" value="<?php echo $channel[0]['id']; ?>" /><input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
    </form>
  
</table>
