<?php  $this->load->view('head');
function filter($filter,$array){
    $new_arr=array();
    foreach($array as $arr){
        if(in_array($filter,$arr)){
            array_push($new_arr,$arr['term_b_id']);
        }
    }
   return $new_arr;
}
?>
</head>
<?php echo $form; ?>
    <table>
        <tbody><tr>
            <th height="30" colspan="2" class="left">设置人员清单</th>
        </tr>
        <form action="http://www.yehaiz.com/a8faPFwsc/index.php/master/backupData.html" method="post" accept-charset="utf-8" id="form1"></form>  <tr>
        <?php foreach($people as $p):?>
            <th width="10%" class="right"><?=$p['name']?>：</th>
            <td>
                <?php foreach($list as $key=>$l):?>
                <div  style="height: 23px;float: left;margin: 2px;">
                    <input <?php if($key==0){echo "required  minlength='1'";} ?>
                        <?php if(!$detail){?>
                        checked
                        <?php }else{
                           if(in_array($l['ttid'],filter($p['ttid'],$detail))){
                               echo "checked";
                           }
                        }?>
                        type="checkbox" name="<?='p'.$p['ttid']?>[]" value="<?=$l['ttid']?>" class="radio check <?='pp'.$p['ttid']?>">
                    <?=$l['name']?>
                </div>
                <?php endforeach ?>
            </td>
        </tr>
        <?php endforeach ?>

        <tr>
            <td colspan="2" class="center"><input type="submit"  value="提交" class="submit"></td>
            <input type="hidden" name="sport_id" value="<?=$sport_id?>">
            <input type="hidden" name="pid" value="<?=$pid?>">
            <input type="hidden" name="lid" value="<?=$lid?>">
        </tr>


        </tbody></table>
</form>
<script>
    $(function() {
        $("#form").validate();
    });

</script>

