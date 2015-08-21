</head>
<body>
<table>
  <tr>
    <th height="30" colspan="2" class="left"><?php echo $lang['news_move']; ?></th>
  </tr>
  <?php echo $form; ?>
  <tr>
    <td width="10%" class="right"><?php echo $lang['news_classic']; ?>：</td>
    <td align="left"><select name="bid">
        <?php foreach ($classic as $k=>$v){
    	if ($bid==$v['id']) {
    		echo '<option value="'.$v['id'].'" selected>'.$v['name'].'</option>';
    	}
    	else {
    		echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
    	}
    }
    ?>
      </select></td>
  </tr>
  <tr>
    <td colspan="2" class="center"><input type="hidden" name="sid" value="<?php echo $sid;?>" />
      <input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>" class="submit" /></td>
  </tr>
    </form>
</table>
