<?php  $this->load->view('head');?>
</head>
<body>
<div id="menu">
    <h3>分类管理</h3>
    <?php
    function showchildname($array) {
        if (is_null($array)) return;
        if (!count($array)) return;

        echo '<ul>';
        foreach($array as $k=>$v){
            if(isset($v['deep']) && $v['deep']==1){
                echo '<li >';
            }else{
                echo '<li id='.$v['ttid'].'>';
            }

            if ($v['tree'] && count($v['tree'])) {
                echo '<em></em>';
            }
            if(isset($v['deep']) && $v['deep']==1){
                echo '<div class="J-li"><a href="javascript:void(0);">'.$v['name'].'</a>&nbsp;<span class="J-op">&nbsp;&nbsp;<a href="taxonomy/add_child/'.$v['tid'].'/1" class="item">新增子级</a>';
            }else{

               if(count($v['tree'])){
                   echo '<div class="J-li"><a href="javascript:void(0);">'.$v['name'].'</a>&nbsp;<span class="J-op">&nbsp;<a href="taxonomy/edit_child/'.$v['ttid'].'" class="item">编辑</a>&nbsp;<a href="taxonomy/add_child/'.$v['ttid'].'/2/'.$v['tid'].'" class="item">新增子级</a>';

               }else{
                   echo '<div class="J-li"><a href="javascript:void(0);">'.$v['name'].'</a>&nbsp;<span class="J-op">&nbsp;<a href="taxonomy/edit_child/'.$v['ttid'].'" class="item">编辑</a>&nbsp;<a href="javascript:;" onclick=delete_category('.$v['ttid'].') class="item">删除</a>&nbsp;<a href="taxonomy/add_child/'.$v['ttid'].'/2/'.$v['tid'].'" class="item">新增子级</a>';
               }
            }


            echo '</span></div>';
            showchildname($v['tree']);
            echo '</li>';
        }
        echo '</ul>';
    }

    showchildname($category);
    ?>
</div>

<script type="text/javascript">
    (function(e){
        for(var _obj=document.getElementById(e.id).getElementsByTagName(e.tag),i=-1,em;em=_obj[++i];){
            em.onclick = function(){ //onmouseover
                var ul = this.parentNode.getElementsByTagName('ul');
                if(!ul){return false;}
                ul = ul[0]; if(!ul){return false;}
                for(var _li=this.parentNode.parentNode.childNodes,n=-1,li;li=_li[++n];){
                    if(li.tagName=="LI"){
                        for(var _ul=li.childNodes,t=-1,$ul;$ul=_ul[++t];){
                            switch($ul.tagName){
                                case "UL":
                                    $ul.className = $ul!=ul?"" : ul.className?"":"off";
                                    break;
                                case "EM":
                                    $ul.className = $ul!=this?"" : this.className?"":"off";
                                    break;
                            }
                        }
                    }
                }
            }
        }
    })({id:'menu',tag:'em'});

    $(document).ready(function() {
        $('.J-li').hover(function(){
            $(this).css('backgroundColor','#dedede');
        },function(){
            $(this).css('backgroundColor','#fff');
        });
    });
  //删除操作
    function delete_category(id){
     if(isNaN(id)){
       alert('操作可能有误');
         return false;
     }
        if(confirm('确实要删除吗?')){
            var url='<?=site_url('taxonomy/taxonomy_delete')?>';
            $.post(url, {'tid':id},function(result){
                if(result=1){
                    $('#'+id).remove();
                    alert('成功删除');
                }else{
                    alert('删除失败');
                }

            });
        }


    }
</script>