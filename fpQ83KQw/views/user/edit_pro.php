<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php  $this->load->view('user_left_menu',array('left_currentTab'=>1));?>
    <div class="user_right r">
        <div class="user_right_tit">
            <div class="user_right_title l">修改个人资料</div>
            <div class=" r"></div>
            <div class="clear"></div>
        </div>
        <form action="<?php echo site_url('user/edit_pro')?>" method="post">
        <table class="utable">
            <tr>
                <td width="95">用户名称：</td>
                <td><input name="name" type="text" class="residence" value="<?php echo $user['username']?>" readonly></td>
            </tr>
            <tr>
                <td>性<span class="width28"></span>别：</td>
                <td>
                    <input type="radio" name="sex" value="1" <?php if($user['gender']==1){echo 'checked';}?>/>&nbsp;男&nbsp;&nbsp;
                    <input type="radio" name="sex" value="2" <?php if($user['gender']==2){echo 'checked';}?>/>&nbsp;女&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td>生<span class="width28"></span>日：</td>
                <td>
                    <select class="year" name="year">
                        <?php for($i=date('Y');$i>=1967;$i--){?>
                            <option value="<?php echo $i;?>" <?php if($user['birthyear']==$i){echo 'selected';}?>><?php echo $i;?>年</option>
                        <?php }?>

                    </select>
                    <select class="month" name="month">
                        <?php for($i=1;$i<=12;$i++){?>
                            <option value="<?php echo $i;?>" <?php if($user['birthmonth']==$i){echo 'selected';}?>><?php echo $i;?>月</option>
                        <?php }?>
                    </select>
                    <select class="date"name="day" >
                        <?php for($i=1;$i<=31;$i++){?>
                        <option value="<?php echo $i;?>" <?php if($user['birthday']==$i){echo 'selected';}?>><?php echo $i;?>日</option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <tr height="65">
                <td>现居住地：</td>
                <td><input class="residence" type="text" name='address' value="<?php echo $user['address']?>"/></td>
            </tr>
            <tr height="65">
                <td>星座：</td>
                <td>
                    <select name="constellation">
                        <option value="">--请选择--</option>
                        <?php foreach($constellation as $key=>$c){?>
                        <option value="<?php echo $key?>" <?php if($user['constellation']==$key){echo 'selected';}?> ><?php echo $c?></option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <input name="old_name" type="hidden" class="residence" value="<?php echo $user['username']?>">
            <tr height="65">
                <td></td>
                <td align="left">
                    <input class="usub" type="submit" value="提交" />
                </td>
            </tr>
        </table>
        </form>
    </div>
	<div class="clear"></div>
</div>
<!--member-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>