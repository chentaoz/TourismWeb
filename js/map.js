/**
 * Created by 野孩子杰森 on 15/8/4.
 * email: jason.li@zoompoint.net
 */

var GwkMapController = {

    /*
     * config start
     */
    map : null,
    zoom : 10,
    default_location : new Microsoft.Maps.Location(39.9500, -75.1667),

    default_map_type : Microsoft.Maps.MapTypeId.road,
    bing_map_key : 'Avzz40HI34eq77CY-xHxkno6ysgzB8_74fyxlmIncDcIPId4LlOMm0GqkglhFVLA',

    init_user_location : null,
    default_cusor : null,
    enable_bound : false,

    GwkUserLayer :      new Microsoft.Maps.EntityCollection({zIndex: 1001}),
    // GwkPOILayer :       new Microsoft.Maps.EntityCollection({zIndex: 1002}),
    GwkPOILayer :       new Object(),
    GwkUtilLayer :      new Microsoft.Maps.EntityCollection({zIndex: 1003}),
    GwkActivityLayer :  new Microsoft.Maps.EntityCollection({zIndex: 1004}),
    GwkInfoboxLayer :   new Microsoft.Maps.EntityCollection({zIndex: 1005}),

    GwkPoiInfobox :     new Microsoft.Maps.Infobox(
        new Microsoft.Maps.Location(0, 0),
        {
            visible: false,
            offset: new Microsoft.Maps.Point(0, 30),
            showPointer: true,
            zIndex: 99998,
            actions:[
                {label: 'test1', eventHandler: function (e) {console.log(e);}},
                {label: 'test2', eventHandler: function (e) {console.log(e);}},
                {label: 'test3', eventHandler: function (e) {console.log(e);}}]
        }
    ),
    GwkActivityInfobox : new Microsoft.Maps.Infobox(
        new Microsoft.Maps.Location(0, 0),
        {
            visible: false,
            offset: new Microsoft.Maps.Point(0, 30),
            showPointer: true,
            zIndex: 99999,
        }
    ),

    geoLocationProvider : null,

    /*
     config ends
     */

    /*
     initialization
     */
    init : {
        handle : function (_callback) {
            Microsoft.Maps.loadModule('Microsoft.Maps.Themes.BingTheme', { callback: function () {
                GwkMapController.init.initMap();
                GwkMapController.init.initLayers();
                GwkMapController.init.initEvents();
                GwkMapController.init.initCoords();

                GwkMapController.geoLocationProvider = new Microsoft.Maps.GeoLocationProvider(GwkMapController.map);
                GwkMapController.default_cusor = GwkMapController.map.getRootElement().style.cursor;

                GwkMapController.eventHandler.mapViewChange();
                GwkMapController.helper.mapFitWindow();

                _callback();
            } });
        },

        initMap : function () {
            GwkMapController.map = new Microsoft.Maps.Map(
                document.getElementById('map'),
                {
                    credentials: GwkMapController.bing_map_key,
                    //theme: new Microsoft.Maps.Themes.BingTheme(),
                    showScalebar: true,
                    center: null == GwkMapController.init_user_location ?  GwkMapController.default_location : GwkMapController.init_user_location,
                    zoom: GwkMapController.zoom,
                    width: screen.width,
                    height: screen.height,
                    disablePanning: false,
                    mapTypeId: GwkMapController.default_map_type,
                    showBreadcrumb: true,
                    tilebuffer: 3,
                    backgroundColor: "#548F1E",
                    showDashboard: false,
                    enableHighDpi: true,
                    showCopyright: false,
                    disableKeyboardInput: true,
                    disableMouseInput: false,
                    useInertia: false,
                    // labelOverlay: Microsoft.Maps.LabelOverlay.hidden,
                }
            );

            GwkMapController.map.getZoomRange = function ()
            {
                return {
                    max:      18,
                    min:      2
                };
            };
        },

        initCoords : function () {
            var _init_local_lat = $.cookie('latitude');
            var _init_local_lon = $.cookie('longitude');
            if(undefined != _init_local_lat && undefined != _init_local_lon) {
                GwkMapController.init_user_location = new Microsoft.Maps.Location(_init_local_lat, _init_local_lon);
            }
        },

        initLayers : function () {
            if(null == GwkMapController.map) {
                GwkMapController.init.initMap();
            }

            GwkMapController.GwkInfoboxLayer.push(GwkMapController.GwkPoiInfobox);
            GwkMapController.GwkInfoboxLayer.push(GwkMapController.GwkActivityInfobox);

            // GwkMapController.map.entities.push(GwkMapController.GwkPOILayer);
            GwkMapController.map.entities.push(GwkMapController.GwkInfoboxLayer);
            GwkMapController.map.entities.push(GwkMapController.GwkUserLayer);
            GwkMapController.map.entities.push(GwkMapController.GwkUtilLayer);
            GwkMapController.map.entities.push(GwkMapController.GwkActivityLayer);
        },

        initEvents : function () {
            if(null == GwkMapController.map) {
                GwkMapController.helper.attempt(GwkMapController.initMap);
            }

            GwkMapController.helper.attempt(function () {Microsoft.Maps.Events.addHandler(GwkMapController.map, 'click', GwkMapController.eventHandler.mapClick)});
            GwkMapController.helper.attempt(function () {Microsoft.Maps.Events.addHandler(GwkMapController.map, 'viewchangeend', GwkMapController.eventHandler.mapViewChange)});
            GwkMapController.helper.attempt(function () {Microsoft.Maps.Events.addHandler(GwkMapController.map, 'mousemove', GwkMapController.eventHandler.mapMouseMove)});

            $(window).resize(function() {
                GwkMapController.helper.attempt(GwkMapController.helper.mapFitWindow);
            });
        },
    },

    eventHandler : {
        mapMouseMove: function (e) {
            if(e.targetType === 'pushpin') {
                GwkMapController.map.getRootElement().style.cursor = 'pointer';

                if(e.target.hasOwnProperty('raw_data')) {
                    if(!GwkMapController.GwkPoiInfobox.getOptions().visible) {
                        GwkMapController.GwkPoiInfobox.setLocation(e.target.getLocation());
                        GwkMapController.GwkPoiInfobox.setOptions({
                            width: 240,
                            height: 180,
                            visible: true,
                            htmlContent: e.target.HtmlContent,
                            offset: new Microsoft.Maps.Point(24,0)
                        });
                    }
                }
            } else {
                if(GwkMapController.GwkPoiInfobox.getOptions().visible) {
                    GwkMapController.GwkPoiInfobox.setOptions({
                        visible: false
                    });
                }
                GwkMapController.map.getRootElement().style.cursor = GwkMapController.default_cusor;
            }
        },

        mapClick: function (e) {
            GwkMapController.GwkPoiInfobox.setOptions({ visible: false});
            GwkMapController.GwkActivityInfobox.setOptions({ visible: false});

            if (e.targetType == 'pushpin') {
                var _pin = e.target;
                var _iBox = null;

                if(_pin.hasOwnProperty('POIType')) {
                    if('destination' == _pin.POIType) {
                        this._ibox = GwkMapController.GwkPoiInfobox;
                    } else if('activity' == _pin.POIType) {
                        this._ibox = GwkMapController.GwkActivityInfobox;
                    }
                } else {
                    this._ibox = GwkMapController.GwkPoiInfobox;
                }




                if(_pin.hasOwnProperty('HtmlContent')) {
                    this._ibox.setOptions({
                        width: 240,
                        height: 180,
                        visible: true,
                        htmlContent: _pin.HtmlContent,
                        offset: new Microsoft.Maps.Point(12,25)
                    });

                    if(_pin.hasOwnProperty('raw_data')) {
                        $('#modal-poi').find('h4.modal-title').html(_pin.raw_data.name);
                        // $('#modal-poi').find('div.modal-body>div').html(_pin.raw_data.name);

                        GwkMapController.GwkPoiInfobox.setOptions({ visible: false});

                        $.get('//activity.gowildkid.com/user/ws/' + $.base64.encode(JSON.stringify({
                                func : 'poi_single_view',
                                type : 'ski_resort',
                                id   : _pin.raw_data.id
                            })), function (_data) {
                            $('#modal-poi').find('div.modal-body>div').html(_data);

                            $('#modal-poi').modal('toggle');
                            $('body').removeClass('modal-open');

                            $('#modal-poi-ctn').css('height', $(document).height() - 120);

                            $('.poi-rating').raty({ starType: 'i', score: 3 });
                        })
                    }

                    this._ibox.setLocation(_pin.getLocation());
                    GwkMapController.map.setView({ center: _pin.getLocation() });

                } else {
                    this._ibox.setOptions({
                        visible: true,
                        title: _pin.Title,
                        description: _pin.Description
                    });
                }
            } else if (e.targetType == 'map') {
                // GwkMapController.toggleDestPanel();
                $('.panel-to-toggle').slideUp();
            }
        },

        mapViewChange : function () {
            $.get("//activity.gowildkid.com/user/ws/".concat($.base64.encode(JSON.stringify({
                func: 'ajax_events_query',
                left_up: GwkMapController.map.getBounds().getNorthwest(),
                right_lower: GwkMapController.map.getBounds().getSoutheast()}))), function(_data) {
                GwkMapController.activity.render (_data, GwkMapController.GwkActivityLayer, true);
            });

        },
    },

    helper : {
        mapFitWindow : function () {
            GwkMapController.map.setOptions({
                height: $(window).height(),
                width:  $(window).width()
            });
        },

        captureUserCoords : function () {
            GwkMapController.geoLocationProvider.getCurrentPosition({
                successCallback:function(_pos) {
                    GwkMapController.init_user_location = new Microsoft.Maps.Location(_pos.position.coords.latitude, _pos.position.coords.longitude);

                    $.cookie('latitude',    GwkMapController.init_user_location.latitude,  { expires: 7, path: '/' });
                    $.cookie('longitude',   GwkMapController.init_user_location.longitude, { expires: 7, path: '/' });
                }
            });
        },

        setUserLocCenter : function () {
            if(null == GwkMapController.init_user_location) {
                GwkMapController.helper.captureUserCoords();
            }

            GwkMapController.map.setView({
                center: GwkMapController.init_user_location,
            });

            GwkMapController.GwkUserLayer.clear();

            var _geo_pin = new Microsoft.Maps.Pushpin(GwkMapController.init_user_location, {
                text: "",
                typeName: "gwk-pin-dest-mypos",
                title: "您目前的位置"
            });
            // _geo_pin.Title = "您目前的位置";
            _geo_pin.Description = "坐标： （" + GwkMapController.init_user_location.latitude + "," + GwkMapController.init_user_location.longitude + ")";

            GwkMapController.GwkUserLayer.push(_geo_pin);
        },

        attempt : function (_func) {
            try {
                if("function" == typeof _func) {
                    _func ();
                }
            } catch(e) {
                console.log(e);
            }
        },

        optSelect : function (_obj) {
            //ok, we need this to be the input(state)
            var _self = $(_obj);
            _self.val('1');
            _self.parent().css('background-color', '#548F1E').css('color', 'white').css('font-style', 'oblique');
        },

        optUnSelect : function (_obj) {
            var _self = $(_obj);
            _self.val(0);
            _self.parent().css('background-color', 'white').css('color', '#548F1E').css('font-style', 'normal');
        },

        strip_tags : function (input, allowed) {
            allowed = (((allowed || '') + '')
                .toLowerCase()
                .match(/<[a-z][a-z0-9]*>/g) || [])
                .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
            var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
                commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
            return input.replace(commentsAndPhpTags, '')
                .replace(tags, function($0, $1) {
                    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
                });
        },

        sub : function(str,n){
            var r=/[^\x00-\xff]/g;
            if(str.replace(r,"mm").length<=n){return str;}
            var m=Math.floor(n/2);
            for(var i=m;i<str.length;i++){
                if(str.substr(0,i).replace(r,"mm").length>=n){
                    return str.substr(0,i)+"...";
                }
            }
            return str;
        },
    },

    /*
     toggle functions for map menu
     */
    toggle : {
        toggleDestPanel : function (_node) {
            GwkMapController.toggle.togglePanel('panel-dests');
        },

        togglePoiPanel : function () {
            GwkMapController.toggle.togglePanel('panel-pois');
        },

        toggleActivityRcmdPanel : function (_node) {
            GwkMapController.toggle.togglePanel('panel-act-recmd');
        },

        toggleSearchPanel : function (_node) {
            GwkMapController.toggle.togglePanel('panel-search');
        },

        togglePanel : function (_id, _node) {
            $('.panel-to-toggle').slideUp();

            $('.btn-to-toggle').each(function(){
                GwkMapController.helper.optUnSelect(this);
            });
            GwkMapController.helper.optSelect($(_node).find('input.ctr-btn-state'));

            if($('#'.concat(_id)).is(':hidden')) {
                $('#'.concat(_id)).slideDown();
            } else {
                $('#'.concat(_id)).slideUp();
                GwkMapController.helper.optUnSelect($(_node).find('input.ctr-btn-state'));
            }
        },

        toggleNationalParkData : function () {
            if('1' == $('input#toggleNP').val()) {
                GwkMapController.GwkUtilLayer.clear();
                $('input#toggleNP').val("0");
            } else {
                $.get(
                    '/ws/endpoint/get_national_parks',
                    function(_data) {
                        GwkMapController.render.renderDests(_data, GwkMapController.GwkUtilLayer, true, "gwk-pin-dest-np");
                    });
                $('input#toggleNP').val("1");
            }
        },

        togglePOIData : function (_type, _node) {
            try {
                var _state_node = $(_node).find('input.togglePoiState');
                if('1' == _state_node.val()) {
                    if(GwkMapController.GwkPOILayer.hasOwnProperty(_type)) {
                        GwkMapController.GwkPOILayer[_type].setOptions({visible: false});
                    }
                    _state_node.val("0");
                    $(_node).css('border-bottom', '2px solid #fff').css('font-weight', 'bold');

                } else {
                    if(GwkMapController.GwkPOILayer.hasOwnProperty(_type)) {
                        GwkMapController.GwkPOILayer[_type].setOptions({visible: true});
                    } else {
                        $('body').css('cursor', "wait");
                        $.get(
                            'http://activity.gowildkid.com/user/ws/'+ $.base64.encode(JSON.stringify({
                                func: 'pull_poi',
                                type: _type
                            })),
                            function(_data) {
                                GwkMapController.render.renderPois (_type, _data);
                                $('body').css('cursor', "auto");
                            });
                    }

                    _state_node.val("1");
                    $(_node).css('border-bottom', '2px solid #ccc').css('font-weight', 'normal');
                }
            } catch(e) { console.log(e); }
        },
    },

    render : {
        renderDests : function (_data, _layer, _enable_bound, _type_name) {
            if(_data) {
                _layer.clear();
                _locs = [];
                for(var i=0; i<_data.length; i++) {
                    try {
                        var _tmp_loc = _data[i];

                        if(0 == _tmp_loc.latitude.length) continue;

                        var _pin_loc = new Microsoft.Maps.Location(_tmp_loc.longitude, _tmp_loc.latitude);

                        var _pin = null;
                        var _pin_options = {
                            // icon: "//www.gowildkid.com/images/map_icons/"+_tmp_loc.sport_id+".png",
                            text: "",
                            title: '<a href="//www.gowildkid.com/place/index/pid/' + _tmp_loc.pid + '">' + (
                                _tmp_loc.hasOwnProperty('name')?_tmp_loc.name:(
                                    _tmp_loc.hasOwnProperty('title')?_tmp_loc.title:'没有标题')) + '</a>',
                            typeName: "gwk-pin-dest-" + _tmp_loc.sport_id
                        };

                        if(null != _type_name) {
                            _pin_options.typeName = _type_name;
                        }

                        if(_tmp_loc.hasOwnProperty('sport_id')) {
                            _pin = new Microsoft.Maps.Pushpin(_pin_loc, _pin_options);
                        } else {
                            _pin_options.typeName = "gwk-pin-dest-default";
                            _pin = new Microsoft.Maps.Pushpin(_pin_loc, _pin_options);
                        }

                        _pin.Title = '<a href="//www.gowildkid.com/place/index/pid/' + _tmp_loc.pid + '">' + (
                                _tmp_loc.hasOwnProperty('name')?_tmp_loc.name:(
                                    _tmp_loc.hasOwnProperty('title')?_tmp_loc.title:'没有标题')) + '</a>';

                        _pin.Description = GwkMapController.helper.strip_tags(_tmp_loc.description).substr(0, 80) + "...";

                        _pin.POIType = 'destination';


                        _layer.push(_pin);

                        if(_enable_bound) {
                            _locs.push(_pin_loc);
                        }
                    } catch (e) { console.log(e); }
                }

                if(_enable_bound && 0 < _data.length) {
                    if(1 < _locs.length) {
                        var viewBoundaries = Microsoft.Maps.LocationRect.fromLocations(_locs);
                        // GwkMapController.map.setView({bounds: viewBoundaries, padding: 100});

                    } else if (1 == _locs.length) {
                        GwkMapController.map.setView({center: _locs[0]});
                    }
                }
            }
        },

        renderPois : function (_type, _data) {
            if(_data) {
                if(GwkMapController.GwkPOILayer.hasOwnProperty(_type)) {
                    GwkMapController.GwkPOILayer[_type].setOptions({visiable: true});
                } else {
                    GwkMapController.GwkPOILayer[_type] = new Microsoft.Maps.EntityCollection({zIndex: 1002});
                    GwkMapController.map.entities.push(GwkMapController.GwkPOILayer[_type]);

                    _locs = [];
                    for(var i=0; i<_data.length; i++) {
                        try {
                            var _tmp_loc = _data[i];

                            // if('ski_resort' == _type) {
                                var _pin = GwkMapController.pin.poi[_type](_tmp_loc);
                                GwkMapController.GwkPOILayer[_type].push(_pin);

                                if(GwkMapController.enable_bound) {
                                    _locs.push(_pin.getLocation());
                                }
                            // }

                        } catch (e) { console.log(e); }
                    }

                    if(GwkMapController.enable_bound && 0 < _data.length) {
                        if(1 < _locs.length) {
                            var viewBoundaries = Microsoft.Maps.LocationRect.fromLocations(_locs);
                            GwkMapController.map.setView({bounds: viewBoundaries, padding: 100});

                        } else if (1 == _locs.length) {
                            GwkMapController.map.setView({center: _locs[0]});
                        }
                    }
                }
            }
        },
    },

    activity : {
        loadImages : function (_node, _eid) {
            var _self = $(_node);
            var _url  = _self.attr('src');

            /*$.get(_pin_html.find('.act-infobox-image').each(function() {
             var _self = $(this);
             $.get(_self.attr('src'), function(_data) {
             // console.log(_data);
             _self.attr('src', _data);
             console.log(_self);
             });
             }));*/
        },

        pull : function (_node) {
            var _toggle_node = $('input#toggleAct');
            // GwkMapController.GwkPOILayer.clear();

            if('0' == _toggle_node.val()) {
                $.get("//activity.gowildkid.com/user/ws/".concat($.base64.encode(JSON.stringify({
                    func: 'ajax_events_query',
                    left_up: GwkMapController.map.getBounds().getNorthwest(),
                    right_lower: GwkMapController.map.getBounds().getSoutheast()}))), function(_data) {
                    GwkMapController.activity.render (_data, GwkMapController.GwkActivityLayer, true);
                });
                _toggle_node.val('1');
            } else {
                GwkMapController.GwkActivityLayer.clear();
                _toggle_node.val('0');
            }
        },

        render : function (_data, _layer, _enable_bound) {
            if(_data) {
                _layer.clear();
                _locs = [];
                _acts = [];
                for(var i=0; i<_data.length; i++) {
                    try {
                        var _tmp_loc = _data[i];

                        if(0 == _tmp_loc.latitude.length) continue;

                        var _pin_loc = new Microsoft.Maps.Location(_tmp_loc.latitude, _tmp_loc.longitude);

                        var _pin = null;
                        _pin = new Microsoft.Maps.Pushpin(_pin_loc, {
                            // icon: "//www.gowildkid.com/images/map_icons/act.png"
                            text: "",
                            typeName: 'gwk-pin-dest-activity'
                        });

                        _pin.Title = '<a href="//activity.gowildkid.com/activity/detail/' + _tmp_loc.id + '">' + (
                                _tmp_loc.hasOwnProperty('name')?_tmp_loc.name:(
                                    _tmp_loc.hasOwnProperty('title')?_tmp_loc.title:'没有标题')) + '</a>';

                        _pin.Eid = _tmp_loc.id;
                        _pin.POIType = 'activity';

                        _pin.Description = GwkMapController.strip_tags(_tmp_loc.description).substr(0, 80) + "...";

                        _pin.HtmlContent = "<div class='box' style='width:360px; height:auto; border: 1px solid #548F1E; background-color: white; z-index: 99999999; display: block;'>" +
                            '<div class="panel panel-default" style="height: 100%;">' +
                            '<div class="panel-heading">' +
                            '<h3 class="panel-title">' + _pin.Title + '<span onclick="javascript:GwkMapController.GwkActivityInfobox.setOptions({ visible: false});" style="float: right;">X</span></h3>' +
                            '</div>' +
                            '<div class="panel-body">' +
                            _pin.Description +
                            '<br /><img class="act-infobox-image" src="http://activity.gowildkid.com/activity/thumb/' + _pin.Eid + '.jpg" /></div>' +
                            '</div>' +
                            '</div>' +
                            "</div>";

                        _layer.push(_pin);

                        if(_enable_bound) {
                            _locs.push(_pin_loc);
                        }

                        // we need to add act to left panel
                        if(6 > _acts.length) {
                            try{
                                var _new_node_act_recmd = $('<div class="rcmd-act-cell" onclick="javascript:location.href=\'http://activity.gowildkid.com/activity/detail/' + _pin.Eid + '\'">' +
                                    '<img class="act-infobox-image" src="http://activity.gowildkid.com/activity/thumb/' + _pin.Eid + '.jpg" />' +
                                    '<p style="width:120px;white-space:nowrap;">' +
                                    GwkMapController.strip_tags(_pin.Title).substr(0, 8) +
                                    '</p></div>');


                                _acts.push(_new_node_act_recmd);
                            } catch(e) { console.log(e); }
                        }
                    } catch (e) { console.log(e); }
                }

                if(_enable_bound && 0 < _data.length) {
                    if(1 < _locs.length) {
                        // var viewBoundaries = Microsoft.Maps.LocationRect.fromLocations(_locs);
                        // GwkMapController.map.setView({bounds: viewBoundaries, padding: 100});

                    } else if (1 == _locs.length) {
                        // GwkMapController.map.setView({center: _locs[0]});
                    }
                }

                var _list_group_act_recmd = $('#list-group-act-recmd');
                _list_group_act_recmd.html('');
                for(var _i=0; _i<_acts.length; _i++) {
                    _list_group_act_recmd.append(_acts[_i]);
                }
            }
        },
    },

    pin : {
        poi : {
            ski_resort : function (_poi) {
                var _pin_loc = new Microsoft.Maps.Location(_poi.lat, _poi.lon);
                var _pin = new Microsoft.Maps.Pushpin(_pin_loc, {
                    text: "",
                    typeName: "gwk-pin-dest-ski",
                    title: _poi.resort_name
                });
                _pin.raw_data = _poi;
                _pin.pin_type = 'poi';
                _pin.HtmlContent = "<div class='box box-infobox'>" +
                    "<span class='gwk-infobx-poi-skiing'></span><span style='padding-left: 6px;'>" + _poi.name + "</span></div>";

                return _pin;
            },
        },
    },

    infobox: {

    },

    deprecated : {
        initDestMap : function () {
            $.post(
                '/ws/endpoint/get_dests',
                {'filter_sports[]': 'all'},
                function(_data) {
                    GwkMapController.renderDests(_data, GwkMapController.GwkPOILayer, false, null);
                });
        },

        searchDest : function (_node) {
            var _keyword = $(_node).val().trim();

            if(0 < _keyword.length) {
                $.post('/ws/endpoint/search_dest_by_keywords?keyword='+encodeURIComponent($(_node).val()), function(data){
                    GwkMapController.render.renderDests(data,GwkMapController.GwkPOILayer,true, null);
                },'json');
            }
        },

        pullDestData : function (_obj) {
            var _self = _obj;

            $(_self).find('input').each(function(_index) {
                if($(this).attr('checked')) {
                    $(this).attr('checked', false);
                    $(this).parent().css('background-color', '#fff');
                } else {
                    $(this).attr('checked', true);
                    $(this).parent().css('background-color', '#ddd');
                }
            });

            GwkMapController.updateDestMap(true);
        },

        updateDestMap : function (_enableBound) {
            var _enable_bound = !!_enableBound;

            $.post(
                '/ws/endpoint/get_dests',
                $('form#form-map-filter').serialize(),
                function(_data) {
                    GwkMapController.renderDests(_data, GwkMapController.GwkPOILayer, _enable_bound, null);
                });
        },
    },
}


/**
 * trigger doc load ready events
 */
$(document).ready(function() {
    try {
        GwkMapController.init.handle(function() {
            if(null == GwkMapController.init_user_location) {
                GwkMapController.helper.captureUserCoords();
            }
            // GwkMapController.map.setView({zoom: 8});
            GwkMapController.helper.setUserLocCenter();
        });
    } catch (e) { console.log(e); }


    $("#navbar").on("click", "li", function(event){
        $('#navbar').collapse('hide');
    })

    try {
        if(!Modernizr.touch) {
            $('[data-toggle="tooltip"]').tooltip();
        }
        $('[data-toggle="popover"]').popover({
            html: true,
        });
    } catch(e) {
        console.log(e);
    }

    // GwkMapController.optSelect($('input#state-map-road'));
    try {
        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    } catch(e) { console.log(e); }
});
