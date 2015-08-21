<?php  $this->load->view('head_other_v1',array('currentTab'=>0));?>
<link rel="stylesheet" href="<?= WWW_domian ?>css/user.css">
<!--member-->
<div class="wp">
    <?php $this->load->view('user_top_v1',array('user_currentTab'=>0));?>
    <?php  $this->load->view('user_left_menu',array('left_currentTab'=>5));?>
<form id='form1' action="<?=site_url('user/edit_pwd')?>" method="post">
    <div class="user_right r">
        <div class="user_right_tit">
            <div class="user_right_title l">修改密码</div>
            <div class=" r"></div>
            <div class="clear"></div>
        </div>
        <table class="utable">
            <tr>
                <td width="90">当前密码：</td>
                <td><input class="residence" type="password" name="opwd"/></td>
            </tr>
            <tr>
                <td>新设密码：</td>
                <td><input class="residence" id="npwd" type="password" name="npwd"/></td>
            </tr>
            <tr>
                <td>重复密码：</td>
                <td><input class="residence" type="password" name="dpwd"/></td>
            </tr>
            <tr height="120">
                <td align="right"> &nbsp; </td>
                <td>
<input class="usub2" type="submit"  value="保存设置" />
                </td>
            </tr>
        </table>
    </div>
	<div class="clear"></div>
</div>
</form>
<!--member-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url()?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script>
    $(function() {
        $("#form1").validate({
            rules: {
                opwd: "required",
                npwd: {
                    required: true,
                    minlength: 5
                },
                dpwd: {
                    required: true,
                    minlength: 5,
                    equalTo: "#npwd"
                }
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                opwd: "请输入原始密码",
                npwd:"请输入密码",
                dpwd: {
                    required: "请输入确认密码",
                    minlength: "长度至少5",
                    equalTo: "与新密码不一致"
                }
            }
        });
    });
</script>
</body>
</html>