<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php if(!$space && $space!='space'){?>
        <?php  $this->load->view('user_left_menu',array('left_currentTab'=>1));?>
    <?php }?>
	<div class="user_right r " <?php if($space && $space=='space'){echo "style='width:100%;padding-right:0'";}?>>
		<div class="user_right_tit">
			<div class="user_right_title l">个人资料</div>
            <?php if(!$space && $space!='space'){?>
			<div class="user_right_r r"><a href="<?php echo site_url('user/edit_pro')?>">编辑资料</a></div>
            <?php }?>
			<div class="clear"></div>
		</div>
		<table class="utable">
			<tr>
				<td width="95">用户名称：</td>
				<td><?=$user_info['username']?></td>
			</tr>
			<tr>
				<td>注册邮箱：</td>
				<td ><span id="email"><?=$user_info['email']?></span>
                    <?php if(!$space && $space!='space'){?>
                    <span class="vermail"><a href="javascript:;">
                            <?php if($user['emailstatus']){echo "当前邮箱已经验证激活";}?></a>
                    </span>|<span class="modmail"><a href="<?=site_url('user/edit_email')?>">修改邮箱</a>
                    </span>
                    <?php }?>
                </td>
			</tr>
			<tr>
				<td>性<span class="width28"></span>别：</td>
				<td><?php if($user_info['gender']==1){echo '男';}elseif($user_info['gender']==2){echo '女';}?></td>
			</tr>
			<tr>
				<td>生<span class="width28"></span>日：</td>
				<td><?php if($user_info['birthyear']) echo $user_info['birthyear'].' 年-'.$user_info['birthmonth'].' 月-'.$user_info['birthday'].' 日'?></td>
			</tr>
			<tr>
				<td>现居住地：</td>
				<td><?php echo $user_info['address']?></td>
			</tr>
			<tr>
				<td>星座：</td>
				<td>
                    <?php foreach($constellation as $key=>$c){
                        if($user_info['constellation']==$key){
                           echo $c;
                        }
                       ?>
                      <?php }?>
                </td>
			</tr>

		</table>
	</div>
	<div class="clear"></div>
</div>
<!--member-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
</body>
</html>