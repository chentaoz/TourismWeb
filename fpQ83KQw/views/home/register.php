<?php  $this->load->view('head_other',array('currentTab'=>0));?>
    <!--login reg main-->
    <div class="wp pos_relative">
        <div class="lr_limg"><img src="<?php echo base_url('images/login.png');?>"></div>
        <div class="lr_rbg">
            <div class="lr_table">
                <div class="lr_title">野孩子 欢迎您！</div>
                <div class="lr_title_s">北美户外运动第一平台</div>
                <?php echo $form;?>
                    <div class="lr_input_border"><img src="<?php echo base_url('images/uname.jpg');?>" align="absmiddle"><input class="lr_input" type="text" placeholder="用户名" name="username" /></div>
                    <div class="lr_input_border"><img src="<?php echo base_url('images/upass.jpg');?>" align="absmiddle"><input class="lr_input" type="password" placeholder="密码" name="userpwd" /></div>
                    <div class="lr_input_border"><img src="<?php echo base_url('images/uemail.jpg');?>" align="absmiddle"><input class="lr_input" type="text" value="邮箱" onclick="if(this.value='邮箱'){this.value=''}" name="email" /></div>
                    <div><input type="submit" value="注册" class="lr_sub"></div>
                </form>
                <div class="lr_tips">
                    <div class="l"><a href="<?php echo site_url('home/login');?>">已有账号登录</a></div>
                    <div class="r">点击注册，表示同意会员条款和免责声明</div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
    <!--login reg main-->
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
                userpwd:{required:true,minlength: 6,maxlength:20},
                email:"email"

            },
            success: function(em) {
                em.text("ok!").addClass("success");
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