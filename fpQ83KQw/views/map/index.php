<?php $this->load->view('head_other_v1', array('currentTab' => 0)); ?>

<!--main-->
<div class="wp">
    <div class="map_title" >
        <?php $country_info['name']?$c_name='-'.$country_info['name'].'-':''?>
        <?php echo '有关'.$c_name.$sport_name['name'].$sport_name['name_en'].'部落分布图';?>
    </div>
    <div id="map" class="map">加载中..</div>
    <div class="map_mark">注:可点击名字进入详情</div>
</div>
<!--main-->
<?php $this->load->view('foot_v1'); ?>
<script>var g_siteUrl = "<?=site_url('')?>";</script>
<script src="<?=WWW_domian?>js/bootstrap.min.js"></script>
<script src="http://ditu.google.cn/maps?file=api&amp;v=2&amp;key=ABQIAAAAzr2EBOXUKnm_jVnk0OJI7xSosDVG8KKPE1-m51RBrvYughuyMxQ-i1QfUnH94QxWIa6N4U6MouMmBA&hl=zh-CN"
        type="text/javascript"></script>
<!--谷歌地图js-->
<script>
    var map;
    var polyline;
    var markers = [];
    var myIcon = new GIcon(G_DEFAULT_ICON,"<?php echo base_url('images/arrival_2x.png'); ?>");//去过的
    var geocoder;
    var location_data=<?=$location_array?>;
    var l=location_data.length;
    var name;
    $(function(){
        console.log(location_data);
        myIcon.iconSize=new GSize(32,32);
        if (GBrowserIsCompatible()) {
            var map_canvas = document.getElementById("map");
            map = new GMap2(map_canvas);
           <?php if($country_info){?>
            map.setCenter(new GLatLng(<?=$country_info['longitude']?>,<?=$country_info['latitude']?>),3);//默认的坐标点
            <?php }else{?>
            map.setCenter(new GLatLng(43.73935207915473,74.4873046875),1);//默认的坐标点
            <?php }?>
            geocoder = new GClientGeocoder();
//标记坐标点
            add_dottel();
        }
    })
    function createMarker(point,code,micon) {
        var marker = new GMarker(point,{ icon: micon, draggable: true, bouncy: true });
        GEvent.addListener(marker, "mouseover", function() {
            marker.openInfoWindowHtml(code);
        });
        return marker;
    }
    function add_dottel(){
        //        map.clearOverlays()//去除所有标点
            //循环添加标注
            for( var i=0;i<l;i++){
            var latlng = new GLatLng(location_data[i].longitude,location_data[i].latitude);//经纬度
            var id=location_data[i].pid;
            var url='<?php echo site_url('place/index/pid/')?>'+'/'+location_data[i].pid;
            name='<a target="_blank" href='+url+' >'+location_data[i].name+'</a>';
            map.addOverlay(createMarker(latlng,name,myIcon));//创建标记点 坐标点、显示的名字和图标
        }

    }
</script>
</body>
</html>