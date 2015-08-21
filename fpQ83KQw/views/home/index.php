<?php $this->load->view('head'); ?>

<div id="container">
    <h1>Welcome to CodeIgniter!</h1>
    <div id="body">
        <?php if ($user): ?>
            <p>欢迎你, <?php echo $user['uid'].' ==>'.$user['username']; ?>
                <a href="<?php echo base_url(); ?>home/logout">退出</a></p>
        <?php else: ?>
            <p>尚未登录，到<a href="<?php echo base_url(); ?>home/login">登录</a></p>
            <a href="<?php echo base_url(); ?>home/register">注册</a>
        <?php endif; ?>
    </div>

    <p class="footer">Page rendered in <strong>0.0455</strong> seconds</p>
</div>
<?php $this->load->view('foot'); ?>