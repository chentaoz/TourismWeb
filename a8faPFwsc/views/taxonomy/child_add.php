<?php  $this->load->view('head');?>
</head>
<body>
<form id="form" action="<?=site_url('taxonomy/add_child')?>" method="post" enctype="multipart/form-data">
<table>
  <tr>
    <th colspan="2">新增子类</th>
  </tr>
    <tr>
        <td class="left" width="60px">所属父类：</td>
        <td class="left"><?=$p_name['name']?></td>
    </tr>
    <?php if($pid==2 && $level==1){?>
    <tr>
        <td class="left" width="60px">所属分类：</td>
        <td class="left">
            运动分类: <input type="radio" name="category" value="0" checked>
            标签分类:<input type="radio" name="category" value="1">
        </td>
    </tr>
    <?php }?>
    <tr>
      <td class="left" width="60px">子类名称：</td>
      <td class="left"><input name="name" type="text" id="name" class="ex100"/>

          <a class="add" style="display:none;padding:5px;text-decoration: underline;color:#FF6600"href="javascript:;">已存在请直接添加</a>


      </td>
    </tr>
    <tr id="a">
        <td class="left" width="60px">图片：</td>
        <td class="left"><input name="imgs" type="file" /><em>jpg|png|jpeg 小图标尺寸50x50 <?php if($pid!=2 || $lo==2) echo "不需要可以空白";?></em></td>
    </tr>
    <tr id="b">
        <td class="left" width="60px">描述：</td>
        <td class="left"><input name="description" type="text" id="description" class="ex300"/></td>
    </tr>
    <tr id="c">
        <td class="left" width="60px">排序：</td>
        <td class="left"><input name="weight" type="text" id="weight" class="ex100" value="255"/></td>
    </tr>
    <tr>
      <td colspan="2" class="left"><input type="hidden" name="parent" id="parent" value="<?=$pid?>">
          <input type="hidden" name="level" value="<?php if($level){ echo $level;}?>">
          <input type="hidden" name="lo" id='lo' value="<?php if($lo){ echo $lo;}?>">
          <input type="submit" name="Submit" value="提交" class="submit s" /></td>
    </tr>

</table>

</form>
<script>
    $(function() {
        $("#form").validate({
            rules: {
                name: "required",
                description: "required",
                weight:"digits"
                <?php if($pid==2 || $lo==2) echo ',imgs:"required"'; ?>
            },
            success: function(em) {
                em.text("ok!").addClass("success");
            },
            messages: {
                name: "请输入子类名称",
                description: "请填写描述",
                weight:"请输入整数"
                <?php if($pid==2 || $lo==2) echo ',imgs:"请上传一个图标"'; ?>
            }
        });
    });
    //判断数据库中是否已经存在装备。
    var parents='';
    var tid='';
    var lo='';
   $(function(){
       $('#name').blur(function(){
          // var f_name= $.trim($('#name').val());
           var f_name= $('#name').val().replace(/\s+/g,"");
              parents= $('#parent').val();
             lo= $('#lo').val();
           var url="<?=site_url('taxonomy/equip')?>";
           $.post(url, {'name':f_name,'l':lo},function(result){
               tid=result.ttid;
               if(tid){
                   $('#a').hide();
                   $('#b').hide();
                   $('#c').hide();
                   $('.s').hide();
                   $('.add').show();
               }else{
                   $('#a').show();
                   $('#b').show();
                   $('#c').show();
                   $('.s').show();
                   $('.add').hide();
               }
           },'json');
           //存在装备直接加入
           $('.add').click(function(){

               var url="<?=site_url('taxonomy/add_equip')?>";
               $.post(url, {'ttid':tid,'p':parents},function(result){

                   if(result==1){
                       alert('已经存在关系不用添加');
                       window.location.reload();
                   }else if(result==2){
                      alert('添加成功');
                       window.location.reload();
                   }else{
                       alert('添加失败');
                       window.location.reload();
                   }
               });

           })
       });

   })


</script>