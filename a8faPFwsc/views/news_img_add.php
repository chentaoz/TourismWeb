</head>
<body>
<table>
  <?php echo $form; ?>
    <tr>
      <th colspan="2"><?php echo $lang['news_thumb_add']; ?></th>
    </tr>
    <tr>
      <td width="10%" class="right"><?php echo $lang['thumb']; ?>：</td>
      <td><input name="userfile" type="file" class="file" id="userfile" />
        </td>
    </tr>
    <tr>
      <td colspan="2" class="center"><input type="hidden" name="id" value="<?Php echo $id; ?>" /><input type="submit" name="Submit" value="<?php echo $lang['submit']; ?>" class="submit" /></td>
    </tr>
  </form>
</table>