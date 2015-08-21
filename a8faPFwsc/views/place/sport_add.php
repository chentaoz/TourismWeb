<script type="text/javascript">
$(document).ready(function() {
    tableHover('t');
});
</script>
</head>
<body>
<table>
    <tr>
        <th colspan="2">新增运动</th>
    </tr>
  <?php echo $sportform;?>
    <tr>
      <td class="right" width="10%">请选择运动：</td>
      <td>
      <?php
      foreach($sports as $k=>$v){?>
      <div class="table">
        <input type="radio" name="name" value="<?php echo $v['spid']; ?>" class="radio check" />
        <?php echo $v['name']; ?></div>
		<?php } ?>
      </td>
    </tr>
    <tr>
      <td class="right">状态：</td>
      <td>
      <input type="radio" name="sta" value="0" class="radio" />显示&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sta" value="1" class="radio" checked />隐藏
      </td>
    </tr>
    <tr>
      <td class="right">排序：</td>
      <td>
      <input type="text" name="weight" class="ex120" />
      </td>
    </tr>
    <tr>
      <td class="right">指数值：</td>
      <td>
      <input type="text" name="sport_index" class="ex120" />
      </td>
    </tr>
    <tr>
      <td class="right">指数值状态：</td>
      <td>
      <input type="radio" name="sport_index_disabled" value="0" class="radio" />显示&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sport_index_disabled" value="1" class="radio" checked />隐藏
      </td>
    </tr>
    <tr>
      <td></td>
      <td><input type="hidden" name="place_id" value="<?php echo $place_id;?>"><input type="submit" value="提交" class="submit" /></td>
    </tr>
  </form>
</table>
<table id="t">
  <tr>
    <th width="30%">运动名称</th>
    <th width="20%">状态</th>
    <th width="20%">排序</th>
    <th width="30%">操作</th>
  </tr>
    <?php if($place_sport){?>
      <?php foreach($place_sport as $k=>$v){?>
  <tr>
    <td>&nbsp;<?php echo $v['name']; ?></td>
    <td>&nbsp;<?php if($v['sta']==0){echo '显示';}else{echo '隐藏';} ?></td>
    <td>&nbsp;<?php echo $v['paixu']; ?></td>
    <td><a href="<?php echo site_url('place/sport_edit/pid/'.$v['place_id'].'/sid/'.$v['sport_id']);?>">编辑</a></td>
  </tr>
    <?php } ?>
    <?php }else{?>
        <tr>
            <td colspan="4" class="center ui-page">
                <em>对不起！暂无数据</em>
            </td>
        </tr>
    <?php }?>
</table>