<?php  $this->load->view('head');?>
</head>
<body>
<table>
  <tr>
  <th colspan="2">用户名检索</th>
  </tr>
<form id="form1" action="<?=site_url('user')?>" method="post">
    <tr>
      <td width="10%" class="right">用户名：</td>
      <td><input type="text" name="keyword" class="required" value="<?=$keyword?>"/></td>
    </tr>
    <tr>
      <td colspan="2" class="center"><input type="submit" value="提交" class="submit" /></td>
    </tr>
  </form>
</table>
<table id="t">
  <tr>
    <th width="21%">用户名</th>
    <th width="19%">邮箱</th>
    <th width="15%">最后登录时间</th>
    <th width="8%">邮箱激活状态</th>
    <th width="12%">操作</th>
  </tr>
<?php foreach($user_list as $u){?>
  <tr>
    <td><?=$u['username']?></td>
    <td><?=$u['email']?></td>
    <td><?= date('Y-m-d h:m:s',$u['lastdate'])?></td>
    <td><?php if($u['emailstatus']==1){echo '已激活';}else{echo '未激活';}?></td>
    <td>
        <a href="<?=site_url('user/edit/'.$u['uid'])?>">查看编辑</a>&nbsp;&nbsp;
       <?php if($u['emailstatus']==1){?>
           <a href="javascript:;" sta="<?=$u['status']?>" onclick="freeze(<?=$u['uid']?>,<?=$u['status']?>)"><?php if($u['status']=='1'){echo '<em style="color:red">已冻结</em>';}elseif($u['status']==='0'){echo '冻结';}?></a>
       <?php }else{?>
          <a style="color:#548f1e;"href="javascript:;" class="activate" uid="<?=$u['uid']?>">激活邮箱</a>
        <?php }?>
    </td>
  </tr>
<?php }?>
  <tr>
    <td colspan="8" class="center ui-page"><?php echo $this->pagination->create_links();?></td>
  </tr>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $('#form1').validateMyForm();
    });
    //冻结js
   function  freeze(id,sta){
       var url='<?php echo site_url('user/freeze')?>';
       $.post(url, {'uid':id,'status':sta},function(r){
          if(r==1){
            if(sta==1){
              alert('已解冻！');
            }else if(sta===0){
                alert('已冻结！');
            }
              window.location.reload();
          }else if(r===0){
             alert('操作失败！');
          }


       });
   }
   //手动邮箱激活
   $('.activate').click(function(){
   var auid= $(this).attr('uid');//用户ID
       var aurl='<?php echo site_url('user/email_activate')?>';
       $.post(aurl, {'uid':auid},function(r){
       if(r){
           alert('激活邮箱成功！');
           window.location.reload();
       }else{
           alert('激活邮箱失败！');
       }

       });

   })




</script>