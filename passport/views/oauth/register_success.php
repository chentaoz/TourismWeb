<?php $this->load->view('head'); ?>
<!-- login reg main-->
<div class="login_main">
    <div class="lg_img">
    </div>
    <div class="lg_input    button-rounded">
        <div class="lg_table">
            <div class="lg_title">野孩子&nbsp;&nbsp;欢迎您！</div>
            <div class="lg_title_s">北美户外运动第一平台</div>
            <div class="success_r">
                <p>确认信已经发到你的邮箱 <?php echo $email;?> ,你需要点击邮件中的确认链接来完成注册。</p>
                <p>没有收到确认信怎么办？</p>
                <p>
                <em>检查一下上面Email地址是否正确，错了就<a target="_blank" href="<?=site_url('oauth/register')?>" class="btn btn-link btn-sm">重新注册</a>一次吧 :)
                    看看是否在邮箱的垃圾箱(Spam Folder)里
                    稍等几分钟，若仍旧没收到确认信，让野孩子<a href="javascript:;" id="resend" class="btn btn-link btn-sm"> 重发一封</a>.<br/>
                    如果注册有问题，请联系技术支持团队（<a href="mailto:service@wildkid.co" class="btn btn-link btn-sm">联系邮箱</a>）
                </em></p>
            </div>
            <div class="lg_tips">
                <a href="<?=base_url()?>oauth/login">已有账号登录</a> &nbsp;&nbsp;
                <a href="<?=base_url()?>oauth/register">没有注册账号?</a>
            </div>
            <?php if(isset($error)){ ?>
                <div class=""><label class="error"><?php echo $error; ?></label></div>
            <?php }?>
            <input type="hidden" id="email" value="<?php echo $email;?>">
            <input type="hidden" id="code" value="<?php echo $code;?>">
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
<script type="text/javascript" src="<?=WWW_domian?>js/layer-v1.8.5/layer/layer.min.js"></script>
<script type="text/javascript">
$(function(){
    //重新发送邮件
    $('#resend').click(function(){
        var emails=$('#email').val();
        var codes=$('#code').val();
        if(!emails ||!codes){
            layer.msg('参数错误,不能发送邮件！',2,3);
            return false;
        }
        layer.msg('由于邮箱服务器原因,如果没有响应请稍等1分钟重新点击',10,5);
        var url='<?=site_url('oauth/resend_email')?>';
        $.post(url, {'email':emails,'code':codes},function(r){
            if(r==1){
                layer.closeAll();
                layer.msg('发送成功请注意查收',3,1);
            }else{
                layer.closeAll();
                layer.msg('对不起发送失败！请稍候重试',3,3);
            }
        });
    })
})
</script>
</body>
</html>