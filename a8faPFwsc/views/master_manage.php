<script type="text/javascript">
$(document).ready(function() {
	tableHover('t',0,-2);
});
</script>
</head>
<body>
<table id="t">
    <tr>
      <th width="15%">数据表</th>
      <th width="10%">数据表类型</th>
      <th width="10%">记录数</th>
      <th width="15%">数据</th>
      <th width="15%">碎片</th>
      <th width="10%">字符集</th>
      <th width="10%">状态</th>
      <th width="15%">操作</th>
    </tr>
  <?php foreach ($info as $k=>$d){?>
  <tr>
    <td>&nbsp;<a href="<?php echo site_url('master/showTable/table/'.$d['Name']); ?>"><?php echo $d['Name']; ?></a></td>
    <td><?php echo $d['Engine']; ?></td>
    <td><?php echo $d['Rows']; ?></td>
    <td><?php echo $d['Data_length']; ?>&nbsp;KB</td>
    <td><?php if ($d['Data_free']>0){ ?>
      <span class="fontcolorB"><?php echo $d['Data_free']; ?></span>
      <?php } else{ ?>
      <?php echo$d['Data_free']; ?>
      <?php } ?>
      &nbsp;KB</td>
    <td><?php echo $d['Collation']; ?></td>
    <td><?php echo $d['status']; ?></td>
    <td><a href="<?php echo site_url('master/repair/table/'.$d['Name']); ?>">修复表</a>&nbsp;&nbsp;<a href="<?php echo site_url('master/optimize/table/'.$d['Name']); ?>">优化表</a></td>
  </tr>
  <?php } ?>
  <tr class="b">
    <td bgcolor="#F6F6F6"><?php echo $t['total']; ?>&nbsp;个表</td>
    <td bgcolor="#F6F6F6">总计</td>
    <td bgcolor="#F6F6F6"><?php echo $t['record']; ?></td>
    <td bgcolor="#F6F6F6"><?php echo $t['data']; ?>&nbsp;KB</td>
    <td bgcolor="#F6F6F6"><?php echo $t['free']; ?>&nbsp;KB</td>
    <td bgcolor="#F6F6F6">&nbsp;</td>
    <td bgcolor="#F6F6F6">&nbsp;</td>
    <td bgcolor="#F6F6F6">&nbsp;</td>
  </tr>
</table>
