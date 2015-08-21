</head>
<body>
<?php echo $form; ?>
<table>
  <tr>
    <th>运行sql语句</th>
  </tr>
    <tr>
      <td width="10%"><textarea name="sql" id="sql" cols="45" rows="5"></textarea>
        <br />
        <span class="fontcolorB b">执行SQL将直接操作数据库，请谨慎使用</span></td>
    </tr>
    <tr>
      <td class="center"><input name="Submit" type="submit" class="submit" value="提交" /></td>
    </tr>
 
</table> </form>