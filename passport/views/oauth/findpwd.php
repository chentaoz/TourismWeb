<?php $this->load->view('head'); ?>
<!-- login reg main-->
<div class="login_main">
    <div class="lg_img">
    </div>
    <div class="lg_input    button-rounded">
        <div class="lg_table">
            <div class="lg_title">野孩子&nbsp;&nbsp;欢迎您！</div>
            <div class="lg_title_s">北美户外运动第一平台</div>
            <form action="" method="post" accept-charset="utf-8" id="form1" class="form_login">
                <div class="input-group">
					    <span class="input-group-addon" id="basic-addon1">
					  		<img src="<?=WWW_domian?>images/uemail.jpg" align="absmiddle">
					    </span>
                    <input type="text" class="form-control" placeholder="邮箱" name="email" aria-describedby="basic-addon1">
                </div>
                <div class="btn-group submit-group" role="group" aria-label="...">
                    <input type="submit" value="发送邮件" class="btn btn-defaults btn_submit">
                </div>
                <div class="lg_tips">
                    <a href="<?=base_url()?>oauth/login">已有账号登录</a> &nbsp;&nbsp;
                    <a href="<?=base_url()?>oauth/register">没有注册账号?</a>
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
<!-- JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=WWW_domian?>js/jquery/jquery.placeholder.min.js"></script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script type="text/javascript">
    if(!"placeholder" in document.createElement("input")){
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
                email:{
                    required: true,
                    email: true
                }
            },
            messages: {
                email: "请输入您的Email 并保证格式正确"
            }
        });
    });
</script>
</body>
</html>