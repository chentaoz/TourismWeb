<?php  $this->load->view('head_other',array('currentTab'=>0));?>
    <!--login reg main-->
    <div class="wp pos_relative">
        <div class="lr_limg"><img src="<?php echo base_url('images/login.png');?>"></div>
        <div class="lr_rbg">
            <div class="lr_table">
                <div class="lr_title">野孩子 欢迎您！</div>
                <div class="lr_title_s">北美户外运动第一平台</div>
                <?php echo $form; ?>
                    <div class="lr_input_border"><img src="<?php echo base_url('images/uname.jpg');?>" align="absmiddle"><input class="lr_input" type="text" placeholder="用户名/Email" name="username" /></div>
                    <div class="lr_input_border"><img src="<?php echo base_url('images/upass.jpg');?>" align="absmiddle"><input class="lr_input" type="password" placeholder="密码" name="userpwd" /></div>
                    <div><input type="submit" value="登录" class="lr_sub"></div>
                </form>
                <div class="lr_tips"><a href="<?php echo site_url('home/register');?>">未有账号注册</a></div>
            </div>
        </div>
    </div>
    <!--login reg main-->

    <p><?php if(isset($error)){ echo $error;} ?></p>

</div>
<?php $this->load->view('foot'); ?>
<script>
    ;(function ($) {
        $.fn.extend({
            placeholder : function () {
                if ("placeholder" in document.createElement("input")) {
                    return this //如果原生支持placeholder属性，则返回对象本身
                } else {
                    return this.each(function () {
                        var _this = $(this);
                        _this.val(_this.attr("placeholder")).focus(function () {
                            if (_this.val() === _this.attr("placeholder")) {
                                _this.val("")
                            }
                        }).blur(function () {
                            if (_this.val().length === 0) {
                                _this.val(_this.attr("placeholder"))
                            }
                        })
                    })
                }
            }
        })
    })(jQuery);
    if(!"placeholder" in document.createElement("input")){
        $.getScript("jquery.placeholder.js",function(){
            $("#username").placeholder();//让id=keyword的元素支持placeholder，换成你自己的选择器
            $("#userpwd").placeholder();
        })
    }
    $(function() {
        $("#form1").validate({
            rules: {
                username: "required",
                userpwd: "required"
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                username: "请输入用户名或Email",
                userpwd:"请输入密码"
            }
        });
    });

</script>