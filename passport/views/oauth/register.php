<?php $this->load->view('head'); ?>
<!-- login reg main-->
<div class="login_main">
    <div class="lg_img">
    </div>
    <div class="lg_input    button-rounded">
        <div class="lg_table">
            <div class="lg_title">野孩子&nbsp;&nbsp;欢迎您！</div>
            <div class="lg_title_s">北美户外运动第一平台</div>
            <form action="<?=base_url()?>oauth/register_save" method="post" accept-charset="utf-8" id="form1" class="form_login">
                <!--username-->
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/uname.jpg" align="absmiddle">
					  	</span>
                    <input type="text" class="form-control" placeholder="用户名" name="username" maxlength="40" aria-describedby="basic-addon1">
                </div>
                <!--key-->
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/upass.jpg" align="absmiddle">
					    </span>
                    <input type="password" class="form-control" placeholder="密码" name="userpwd" aria-describedby="basic-addon1">
                </div>
                <!--@example.com-->
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/uemail.jpg" align="absmiddle">
					    </span>
                    <input type="text" class="form-control" placeholder="邮箱" name="email" aria-describedby="basic-addon1">
                </div>
                <div class="btn-group submit-group" role="group" aria-label="...">
                    <input type="submit" value="注册" class="btn btn-defaults btn_submit">
                </div>
                <div class="lg_tips">
                    <div class="l">
                        <a href="<?=base_url()?>oauth/findpwd">忘记密码?</a> &nbsp;&nbsp;
                        <a href="<?=base_url()?>oauth/login">已有账号登录</a>
                    </div>
                    <div class="r">点击注册，表示同意会员条款和免责声明</div>
                </div>
                <?php if(isset($error)){ ?>
                    <div class=""><label class="error"><?php echo $error; ?></label></div>
                <?php }?>
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!-- login reg main-->
<?php $this->load->view('foot'); ?>
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.placeholder.min.js"></script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    if(!"placeholder" in document.createElement("input")){
        $("#username").placeholder();
        $("#userpwd").placeholder();
        $("#email").placeholder();
    }
    $(function() {
        $("#form1").validate({
            highlight: function(element) {
                $(element).closest('.input-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.input-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-error',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            rules: {
                username: "required",
                userpwd:{required:true,minlength: 6,maxlength:20},
                email:{required:true,email:true}
            },
            messages: {
                username: "请输入用户名",
                userpwd:{required: "请输入密码",
                minlength: jQuery.validator.format("密码不能小于{0}个字 符"),maxlength: jQuery.validator.format("密码不能大于{0}个字 符")},
                email:"邮箱格式不正确"
            }
        });
    });

</script>
</body>
</html>