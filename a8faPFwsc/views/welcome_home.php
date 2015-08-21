</head>
<body>
<table>
  <tr class="tdbg fontcolorC b">
    <td colspan="2"><?php echo $lang['sys_online_user']; ?></td>
  </tr>
  <tr>
    <td width="12%"><?php echo $lang['sys_username']; ?></td>
    <td><?php echo $username; ?></td>
  </tr>
  <tr>
    <td width="12%"><?php echo $lang['sys_login_time']; ?></td>
    <td><?php echo $created;?></td>
  </tr>
  <tr>
    <td width="12%"><?php echo $lang['sys_login_ip']; ?></td>
    <td><?php echo $ip;?></td>
  </tr>
  <tr class="tdbg fontcolorC b">
    <td colspan="2"><?php echo $lang['sys_system_info']; ?></td>
  </tr>
  <tr>
    <td width="12%"><?php echo $lang['sys_server']; ?></td>
    <td><?php echo PHP_OS;?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sys_php_version']; ?></td>
    <td><?php echo PHP_VERSION;?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sys_server_software']; ?></td>
    <td><?php echo $this->input->server('SERVER_SOFTWARE');?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sys_mysql_version']; ?></td>
    <td><?php echo $this->db->version();?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sys_upload_size']; ?></td>
    <td><?php echo $upload;?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sys_post_size']; ?></td>
    <td><?php echo $post; ?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sys_timeout']; ?></td>
    <td><?php echo $timeout; ?>s</td>
  </tr>
  <tr>
</table>
