/**
 * Created by qiangli on 15/8/4.
 */

var __map = {

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

    geolocationLayer : new Microsoft.Maps.EntityCollection({zIndex: 1001}),
    destLayer : new Microsoft.Maps.EntityCollection({zIndex: 1002}),
    ntnParkLayer : new Microsoft.Maps.EntityCollection({zIndex: 1003}),
    activityLayer : new Microsoft.Maps.EntityCollection({zIndex: 1004}),

    infoBoxLayer : new Microsoft.Maps.EntityCollection({zIndex: 1005}),
    destInfobox : new Microsoft.Maps.Infobox(
        new Microsoft.Maps.Location(0, 0),
        {
            visible: false,
            offset: new Microsoft.Maps.Point(0, 30),
            showPointer: true,
            zIndex: 99998,
        }
    ),
    actInfoBox : new Microsoft.Maps.Infobox(
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

    init : function () {
        this.init_map();
        this.init_layers();
        this.init_events();
        this.init_coords();

        this.geoLocationProvider = new Microsoft.Maps.GeoLocationProvider(this.map);

        this.default_cusor = this.map.getRootElement().style.cursor;
    },

    /*
     initialization
     */
    init_map : function () {
        __map.map = new Microsoft.Maps.Map(
            document.getElementById('map'),
            {
                credentials: __map.bing_map_key,
                showScalebar: true,
                center: "undefined" === typeof _init_geo_loc ?  __map.default_location : _init_geo_loc,
                zoom: __map.zoom,
                width: screen.width,
                height: screen.height,
                disablePanning: false,
                mapTypeId: __map.default_map_type,
                showBreadcrumb: true,
                tilebuffer: 3,
                backgroundColor: "#548F1E",
                showDashboard: false,
                enableHighDpi: true,
                disableKeyboardInput: true,
                disableMouseInput: false,
                inertiaIntensity: 0.5,
                labelOverlay: Microsoft.Maps.LabelOverlay.hidden,
            }
        );

        __map.map.getZoomRange = function ()
        {
            return {
                max:      18,
                min:      2
            };
        };
    },

    init_coords : function () {
        var _init_local_lat = $.cookie('latitude');
        var _init_local_lon = $.cookie('longitude');
        if(undefined != _init_local_lat && undefined != _init_local_lon) {
            __map.init_user_location = new Microsoft.Maps.Location(_init_local_lat, _init_local_lon);
        }
    },

    init_layers : function () {
        if(null == __map.map) {
            __map.init_map();
        }

        __map.infoBoxLayer.push(__map.destInfobox);
        __map.infoBoxLayer.push(__map.actInfoBox);

        __map.map.entities.push(__map.destLayer);
        __map.map.entities.push(__map.infoBoxLayer);
        __map.map.entities.push(__map.geolocationLayer);
        __map.map.entities.push(__map.ntnParkLayer);
        __map.map.entities.push(__map.activityLayer);
    },

    init_events : function () {
        if(null == __map.map) {
            __map.init_map();
        }

        Microsoft.Maps.Events.addHandler(__map.map, 'click', __map.displayInfobox);
        Microsoft.Maps.Events.addHandler(__map.map, 'viewchangeend', __map.initActMap);
        Microsoft.Maps.Events.addHandler(__map.map, 'mousemove', function(event) {
            if(event.targetType === 'pushpin') {
                __map.map.getRootElement().style.cursor = 'pointer';
            } else {
                __map.map.getRootElement().style.cursor = __map.default_cusor;
            }
        });

        $(window).resize(function() {
            try {
                __map.mapFitWindow();
            } catch(e) {console.log(e);}
        });
    },

    mapFitWindow : function () {
        __map.map.setOptions({
            height: $(window).height(),
            width:  $(window).width()
        });
    },

    displayInfobox : function (e) {
        __map.destInfobox.setOptions({ visible: false});
        __map.actInfoBox.setOptions({ visible: false});

        if (e.targetType == 'pushpin') {
            var _pin = e.target;
            var _iBox = null;

            if(_pin.hasOwnProperty('POIType')) {
                if('destination' == _pin.POIType) {
                    this._ibox = __map.destInfobox;
                } else if('activity' == _pin.POIType) {
                    this._ibox = __map.actInfoBox;
                }
            } else {
                this._ibox = __map.destInfobox;
            }

            this._ibox.setLocation(_pin.getLocation());
            __map.map.setView({ center: _pin.getLocation() });


            if(_pin.hasOwnProperty('HtmlContent')) {
                this._ibox.setOptions({
                    width: 240,
                    height: 180,
                    visible: true,
                    htmlContent: _pin.HtmlContent,
                    offset: new Microsoft.Maps.Point(12,25)
                });
            } else {
                this._ibox.setOptions({
                    visible: true,
                    title: _pin.Title,
                    description: _pin.Description
                });
            }
        }
    },

    captureUserCoords : function () {
        __map.geoLocationProvider.getCurrentPosition({successCallback:function(_pos) {
            __map.init_user_location = new Microsoft.Maps.Location(_pos.position.coords.latitude, _pos.position.coords.longitude);

            $.cookie('latitude',    __map.init_user_location.latitude,  { expires: 7, path: '/' });
            $.cookie('longitude',   __map.init_user_location.longitude, { expires: 7, path: '/' });
        }});
    },

    setUserLocCenter : function () {
        if(null == __map.init_user_location) {
            __map.captureUserCoords();
        }

        __map.map.setView({
            center: __map.init_user_location,
        });

        __map.geolocationLayer.clear();
        var _geo_pin = new Microsoft.Maps.Pushpin(__map.init_user_location, {
            text: "",
            typeName: "gwk-pin-dest-mypos",
            title: "您目前的位置"
        });
        // _geo_pin.Title = "您目前的位置";
        _geo_pin.Description = "坐标： （" + __map.init_user_location.latitude + "," + __map.init_user_location.longitude + ")";

        __map.geolocationLayer.push(_geo_pin);
    },

    /*
     toggle functions for map menu
     */

    toggleDestPanel : function (_node) {
        __map.togglePanel('panel-dests');
    },

    togglePoiPanel : function () {
        __map.togglePanel('panel-pois');
    },

    toggleActivityRcmdPanel : function (_node) {
        __map.togglePanel('panel-act-recmd');
    },

    toggleSearchPanel : function (_node) {
        __map.togglePanel('panel-search');
    },

    togglePanel : function (_id, _node) {
        $('.panel-to-toggle').slideUp();

        $('.btn-to-toggle').each(function(){
            __map.optUnSelect(this);
        });
        __map.optSelect($(_node).find('input.ctr-btn-state'));

        if($('#'.concat(_id)).is(':hidden')) {
            $('#'.concat(_id)).slideDown();
        } else {
            $('#'.concat(_id)).slideUp();
            __map.optUnSelect($(_node).find('input.ctr-btn-state'));
        }
    },

    toggleNationalParkData : function () {
        if('1' == $('input#toggleNP').val()) {
            __map.ntnParkLayer.clear();
            $('input#toggleNP').val("0");
        } else {
            $.get(
                '/ws/endpoint/get_national_parks',
                function(_data) {
                    __map.renderDests(_data, __map.ntnParkLayer, true, "gwk-pin-dest-np");
                });
            $('input#toggleNP').val("1");
        }
    },

    /*
     destinations
     */
    initDestMap : function () {
        $.post(
            '/ws/endpoint/get_dests',
            {'filter_sports[]': 'all'},
            function(_data) {
                __map.renderDests(_data, __map.destLayer, false, null);
            });
    },

    searchDest : function (_node) {
        var _keyword = $(_node).val().trim();

        if(0 < _keyword.length) {
            $.post('/ws/endpoint/search_dest_by_keywords?keyword='+encodeURIComponent($(_node).val()), function(data){
                __map.renderDests(data,__map.destLayer,true, null);
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

        __map.updateDestMap(true);
    },

    updateDestMap : function (_enableBound) {
        var _enable_bound = !!_enableBound;

        $.post(
            '/ws/endpoint/get_dests',
            $('form#form-map-filter').serialize(),
            function(_data) {
                __map.renderDests(_data, __map.destLayer, _enable_bound, null);
            });
    },

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

                    _pin.Description = __map.strip_tags(_tmp_loc.description).substr(0, 80) + "...";

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
                    // __map.map.setView({bounds: viewBoundaries, padding: 100});

                } else if (1 == _locs.length) {
                    __map.map.setView({center: _locs[0]});
                }
            }
        }
    },

    /*
     activities
     */
    loadActivityImages : function (_node, _eid) {
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

    initActMap : function () {
        $.get("//activity.gowildkid.com/user/ws/".concat($.base64.encode(JSON.stringify({
            func: 'ajax_events_query',
            left_up: __map.map.getBounds().getNorthwest(),
            right_lower: __map.map.getBounds().getSoutheast()}))), function(_data) {
            __map.renderActivities (_data, __map.activityLayer, true);
        });

    },

    pullActivities : function (_node) {
        var _toggle_node = $('input#toggleAct');
        // __map.destLayer.clear();

        if('0' == _toggle_node.val()) {
            $.get("//activity.gowildkid.com/user/ws/".concat($.base64.encode(JSON.stringify({
                func: 'ajax_events_query',
                left_up: __map.map.getBounds().getNorthwest(),
                right_lower: __map.map.getBounds().getSoutheast()}))), function(_data) {
                __map.renderActivities (_data, __map.activityLayer, true);
            });
            _toggle_node.val('1');
        } else {
            __map.activityLayer.clear();
            _toggle_node.val('0');
        }
    },

    renderActivities : function (_data, _layer, _enable_bound) {
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

                    _pin.Description = __map.strip_tags(_tmp_loc.description).substr(0, 80) + "...";

                    _pin.HtmlContent = "<div class='box' style='width:360px; height:auto; border: 1px solid #548F1E; background-color: white; z-index: 99999999; display: block;'>" +
                        '<div class="panel panel-default" style="height: 100%;">' +
                        '<div class="panel-heading">' +
                        '<h3 class="panel-title">' + _pin.Title + '<span onclick="javascript:__map.actInfoBox.setOptions({ visible: false});" style="float: right;">X</span></h3>' +
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
                                __map.strip_tags(_pin.Title).substr(0, 8) +
                                '</p></div>');


                            _acts.push(_new_node_act_recmd);
                        } catch(e) { console.log(e); }
                    }
                } catch (e) { console.log(e); }
            }

            if(_enable_bound && 0 < _data.length) {
                if(1 < _locs.length) {
                    // var viewBoundaries = Microsoft.Maps.LocationRect.fromLocations(_locs);
                    // __map.map.setView({bounds: viewBoundaries, padding: 100});

                } else if (1 == _locs.length) {
                    // __map.map.setView({center: _locs[0]});
                }
            }

            var _list_group_act_recmd = $('#list-group-act-recmd');
            _list_group_act_recmd.html('');
            for(var _i=0; _i<_acts.length; _i++) {
                _list_group_act_recmd.append(_acts[_i]);
            }
        }
    },

    /*
     helpers
     */

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
}

__map.init();

// typeahead
try {
    $('.ul-opts>li').click(function() {
        var _self = $(this).find('input.ctr-btn-state');
        if(1 == _self.length) {
            _self = _self.first();

            if('0' == _self.val()) {
                if(0 == _self.attr('id').indexOf('state-map-')) {
                    $('input[id^="state-map-"]').each(function(){
                        __map.optUnSelect(this);
                    });
                }

                __map.optSelect(_self);
            } else {
                __map.optUnSelect(_self);
            }
        }
    });
} catch(e) {console.log(e);}

/**
 * trigger doc load ready events
 */
$(document).ready(function() {
    try {
        __map.initActMap();
        __map.mapFitWindow();
    } catch(e) {
        console.log(e);
    }

    try {
        if(Modernizr.touch) {
            // $('#map-menu-content').collapse();
        } else {
            // do nothing
        }
    } catch (e) {

    }

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

    try {
        if(null == __map.init_user_location) {
            __map.captureUserCoords();
        }
        // __map.map.setView({zoom: 8});
        __map.setUserLocCenter();
    } catch(e) {
        console.log(e);
    }

    // __map.optSelect($('input#state-map-road'));
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
