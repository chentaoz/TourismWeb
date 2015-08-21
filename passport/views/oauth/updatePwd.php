<?php $this->load->view('head'); ?>
<!-- login reg main-->
<div class="login_main">
    <div class="lg_img">
    </div>
    <div class="lg_input    button-rounded">
        <div class="lg_table">
            <div class="lg_title">野孩子&nbsp;&nbsp;欢迎您！</div>
            <div class="lg_title_s">北美户外运动第一平台</div>
            <form action="<?=site_url('oauth/updatePwd')?>" method="post" accept-charset="utf-8" id="form1" class="form_login">
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/uemail.jpg" align="absmiddle">
					    </span>
                    <input type="text" class="form-control" placeholder="邮箱" aria-describedby="basic-addon1"  value="<?php echo $name?>" readonly>
                </div>
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/upass.jpg" align="absmiddle">
					    </span>
                    <input type="password" class="form-control" maxlength="25" placeholder="密码" name="userpwd" id="password" aria-describedby="basic-addon1">
                </div>
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/upass.jpg" align="absmiddle">
					    </span>
                    <input type="password" class="form-control" maxlength="25" placeholder="确认密码" name="userpwd2" id="password2" aria-describedby="basic-addon1">
                </div>
                <div class="btn-group submit-group" role="group" aria-label="...">
                    <input type="submit" value="提交" class="btn btn-defaults btn_submit">
                </div>
                <div class="lg_tips">
                    <a href="<?=base_url()?>oauth/login">已有账号登录</a> &nbsp;&nbsp;
                    <a href="<?=base_url()?>oauth/register">没有注册账号?</a>
                </div>
                <input type="hidden" name="u" value="<?php echo $uid?>" />
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
<!-- JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.placeholder.min.js"></script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    if(!"placeholder" in document.createElement("input")){
        $("#password").placeholder();
        $("#password2").placeholder();
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
                userpwd: {
                    required: true,
                    minlength: 6  //自带判断字符最小长度
                },
                userpwd2: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                    //自带判断当前文本框值与指定ID为password的文本框的值是否相同
                }
            },
            messages: {
                userpwd: {
                    required: "请输入密码",
                    minlength: jQuery.validator.format("密码不能小于{0}个字符")
                },
                userpwd2: {
                    required: "请输入确认密码",
                    minlength: "确认密码不能小于{0}个字符",
                    equalTo: "两次输入密码不一致不一致"
                }

            }
        });
    });
</script>
</body>
</html>