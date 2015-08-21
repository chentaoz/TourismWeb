<?php  $this->load->view('head');?>
</head>
<body>

<table>
 <form action="<?=site_url('user/edit')?>" method="post" >
  <tr>
    <th colspan="2" class="left">用户信息查看&编辑</th>
  </tr>

  <tr>
    <td width="10%" class="right">用户名：</td>
    <td><input name="name" type="text" id="name" value="<?php echo $user_info['username']  ?>" readonly/></td>
  </tr>
    <tr>
        <td width="10%" class="right">邮箱：</td>
        <td><input name="email" type="text" id="email" value="<?php echo $user_info['email']  ?>" readonly /></td>
    </tr>
     <tr>
         <td width="10%" class="right">所在地：</td>
         <td><input name="address" type="text"  value="<?php echo $user_info['address']  ?>"  /></td>
     </tr>
    <tr>
        <td width="10%" class="right">性别：</td>
        <td>
            男：  <input style="width:20px"name="sex" type="radio"  value="1" <?php if($user_info['gender']==1){echo 'checked';}?> />
            女：  <input style="width:20px" name="sex" type="radio"  value="2" <?php if($user_info['gender']==2){echo 'checked';}?> />

        </td>
    </tr>
    <tr>
        <td width="10%" class="right">生日：</td>
        <td>
            <select  name="year">
                <?php for($i=date('Y');$i>=1967;$i--){?>
                    <option value="<?php echo $i;?>" <?php if($user_info['birthyear']==$i){echo 'selected';}?>><?php echo $i;?>年</option>
                <?php }?>

            </select>
            <select  name="month">
                <?php for($i=1;$i<=12;$i++){?>
                    <option value="<?php echo $i;?>" <?php if($user_info['birthmonth']==$i){echo 'selected';}?>><?php echo $i;?>月</option>
                <?php }?>
            </select>
            <select name="day" >
                <?php for($i=1;$i<=31;$i++){?>
                    <option value="<?php echo $i;?>" <?php if($user_info['birthday']==$i){echo 'selected';}?>><?php echo $i;?>日</option>
                <?php }?>
            </select>
        </td>
    </tr>
  <tr>
    <td colspan="2" class="center">
        <input type="submit" name="Submit" value="提交" class="submit" /></td>
  </tr>
     <input type="hidden" name="id" value="<?=$user_info['uid']?>">
 </form>
  
</table>
