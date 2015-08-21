</head>
<body>
<table id="t">
    <tr class="b">
      <th width="10%" height="25">Field</th>
      <th width="15%">Type</th>
      <th width="10%">Null</th>
      <th width="10%">Key</th>
      <th width="10%">Default</th>
      <th width="45%">Extra</th>
    </tr>
	<?php foreach($d as $k=>$d){ ?>
    <tr>
      <td height="25" class="b">&nbsp;<?php echo $d['Field']; ?></td>
      <td><?php echo $d['Type']; ?></td>
      <td><?php echo $d['Null']; ?></td>
      <td><?php echo $d['Key'] ?>&nbsp;</td>
      <td><?php echo $d['Default']; ?>&nbsp;</td>
      <td><?php echo $d['Extra']; ?></td>
    </tr>
    <?php } ?>
</table>