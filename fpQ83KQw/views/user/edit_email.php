<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php  $this->load->view('user_left_menu',array('left_currentTab'=>1));?>
	<div class="user_right r">
		<div class="user_right_tit">
			<div class="user_right_title l">修改邮箱</div>
<!--			<div class="user_right_r r"><a href="user2.html">编辑资料</a></div>-->
			<div class="clear"></div>
		</div>
		<table class="utable">
			<tr>
				<td width="95">密码：</td>
				<td><input class="residence pwd" type="password" ></td>
			</tr>
			<tr>
				<td>新邮箱：</td>
				<td ><span id="email"><input class="residence email" type="text" ></span>
          </td>
			</tr>
            <tr height="65">
                <td></td>
                <td align="right">
                    提示：请保证邮箱的正确性，及时到邮箱中去验证.
                </td>
            </tr>
            <tr height="65">
                <td></td>
                <td align="left">

                    <input class="usub" type="reset" value="提交">
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
<script>
        $('.usub').click(function(){
            var email=$('.email').val();
            var pwd=$('.pwd').val();
            if(email=='' || pwd=='' ){
                alert('请填写完整信息！');return false;
            }
            var url='<?=site_url('user/edit_email')?>';
            $.post(url, {'em':email,'password':pwd},function(r){
                console.log(r)
                switch (r) {
                    case '1': alert("发送成功！请立即查看您的邮箱验证");
                        break;
                    case '2': alert("发送失败！请检查您的邮箱地址是否有效");
                        break;
                    case '3': alert("密码不正确！");$('.pwd').val('');$('.pwd').focus();
                        break;
                    case '4': alert("邮箱地址已经存在！");
                        break;
                    default: alert("发生错误!");
                }
            });
        });

</script>
</body>
</html>