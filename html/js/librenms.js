function override_config(event, state, tmp_this) {
    event.preventDefault();
    var $this = tmp_this;
    var attrib = $this.data('attrib');
    var device_id = $this.data('device_id');
    $.ajax({
        type: 'POST',
        url: 'ajax_form.php',
        data: { type: 'override-config', device_id: device_id, attrib: attrib, state: state },
        dataType: 'json',
        success: function(data) {
            if (data.status == 'ok') {
                toastr.success(data.message);
            }
            else {
                toastr.error(data.message);
            }
        },
        error: function() {
            toastr.error('Could not set this override');
        }
    });
}

var oldH;
var oldW;
$(document).ready(function() {
    // Device override ajax calls
    $("[name='override_config']").bootstrapSwitch('offColor','danger');
    $('input[name="override_config"]').on('switchChange.bootstrapSwitch',  function(event, state) {
        override_config(event,state,$(this));
    });

    // Device override for text inputs
    $(document).on('blur', 'input[name="override_config_text"]', function(event) {
        event.preventDefault();
        var $this = $(this);
        var attrib = $this.data('attrib');
        var device_id = $this.data('device_id');
        var value = $this.val();
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: { type: 'override-config', device_id: device_id, attrib: attrib, state: value },
            dataType: 'json',
            success: function(data) {
                if (data.status == 'ok') {
                    toastr.success(data.message);
                }
                else {
                    toastr.error(data.message);
                }
            },
            error: function() {
                toastr.error('Could not set this override');
            }
        });
    });

    // Checkbox config ajax calls
    $("[name='global-config-check']").bootstrapSwitch('offColor','danger');
    $('input[name="global-config-check"]').on('switchChange.bootstrapSwitch',  function(event, state) {
        event.preventDefault();
        var $this = $(this);
        var config_id = $this.data("config_id");
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: {type: "update-config-item", config_id: config_id, config_value: state},
            dataType: "json",
            success: function (data) {
                if (data.status == 'ok') {
                    toastr.success('Config updated');
                } else {
                    toastr.error(data.message);
                }
            },
            error: function () {
                toastr.error(data.message);
            }
        });
    });

    // Input field config ajax calls
    $(document).on('blur', 'input[name="global-config-input"]', function(event) {
        event.preventDefault();
        var $this = $(this);
        var config_id = $this.data("config_id");
        var config_value = $this.val();
        if ($this[0].checkValidity()) {
            $.ajax({
                type: 'POST',
                url: 'ajax_form.php',
                data: {type: "update-config-item", config_id: config_id, config_value: config_value},
                dataType: "json",
                success: function (data) {
                    if (data.status == 'ok') {
                        toastr.success('Config updated');
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function () {
                    toastr.error(data.message);
                }
            });
        }
    });

    // Select config ajax calls
    $( 'select[name="global-config-select"]').change(function(event) {
        event.preventDefault();
        var $this = $(this);
        var config_id = $this.data("config_id");
        var config_value = $this.val();
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: {type: "update-config-item", config_id: config_id, config_value: config_value},
            dataType: "json",
            success: function (data) {
                if (data.status == 'ok') {
                    toastr.success('Config updated');
                } else {
                    toastr.error(data.message);
                }
            },
            error: function () {
                toastr.error(data.message);
            }
        });
    });

    oldW=$(window).width();
    oldH=$(window).height();
});

function submitCustomRange(frmdata) {
    var reto = /to=([0-9a-zA-Z\-])+/g;
    var refrom = /from=([0-9a-zA-Z\-])+/g;
    var tsto = moment(frmdata.dtpickerto.value).unix();
    var tsfrom = moment(frmdata.dtpickerfrom.value).unix();
    frmdata.selfaction.value = frmdata.selfaction.value.replace(reto, 'to=' + tsto);
    frmdata.selfaction.value = frmdata.selfaction.value.replace(refrom, 'from=' + tsfrom);
    frmdata.action = frmdata.selfaction.value;
    return true;
}

function updateResolution(refresh)
{
    $.post('ajax/set_resolution',
        {
            width: $(window).width(),
            height:$(window).height()
        },
        function(data) {
            if(refresh == true) {
                location.reload();
            }
        },'json'
    );
}

var rtime;
var timeout = false;
var delta = 500;
var newH;
var newW;

$(window).on('resize', function(){
    rtime = new Date();
    if (timeout === false && !(typeof no_refresh === 'boolean' && no_refresh === true)) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
});

function resizeend() {
    if (new Date() - rtime < delta) {
        setTimeout(resizeend, delta);
    }
    else {
        newH=$(window).height();
        newW=$(window).width();
        timeout = false;
        if(Math.abs(oldW - newW) >= 200)
        {
            refresh = true;
        }
        else {
            refresh = false;
            resizeGraphs();
        }
        updateResolution(refresh);
    }
};

function resizeGraphs() {
    ratioW=newW/oldW;
    ratioH=newH/oldH;

    $('.graphs').each(function (){
        var img = jQuery(this);
        img.attr('width',img.width() * ratioW);
    });
    oldH=newH;
    oldW=newW;
}


$(document).on("click", '.collapse-neighbors', function(event)
{
    var caller = $(this);
    var button = caller.find('.neighbors-button');
    var list = caller.find('.neighbors-interface-list');
    var continued = caller.find('.neighbors-list-continued');

    if(button.hasClass("fa-plus")) {
        button.addClass('fa-minus').removeClass('fa-plus');
    }
    else {
        button.addClass('fa-plus').removeClass('fa-minus');
    }

    list.toggle();
    continued.toggle();
});

//availability-map mode change
$(document).on("change", '#mode', function() {
    $.post('ajax_mapview.php',
        {
            map_view: $(this).val()
        },
        function(data) {
                location.reload();
        },'json'
    );
});

//availability-map device group
$(document).on("change", '#group', function() {
    $.post('ajax_mapview.php',
        {
            group_view: $(this).val()
        },
        function(data){
            location.reload();
        },'json'
    );
});

$(document).ready(function() {
    var lines = 'on';
    $("#linenumbers").button().click(function() {
        if (lines == 'on') {
            $($('.config').find('ol').get().reverse()).each(function(){
                $(this).replaceWith($('<ul>'+$(this).html()+'</ul>'))
                lines = 'off';
                $('#linenumbers').val('Show line numbers');
            });
        }
        else {
            $($('.config').find('ul').get().reverse()).each(function(){
                $(this).replaceWith($('<ol>'+$(this).html()+'</ol>'));
                lines = 'on';
                $('#linenumbers').val('Hide line numbers');
            });
        }
    });
});

function refresh_oxidized_node(device_hostname){
    $.ajax({
        type: 'POST',
        url: 'ajax_form.php',
        data: {
            type: "refresh-oxidized-node",
            device_hostname: device_hostname
        },
        success: function (data) {
            if(data['status'] == 'ok') {
                toastr.success(data['message']);
            } else {
                toastr.error(data['message']);
            }
        },
        error:function(){
            toastr.error('An error occured while queuing refresh for an oxidized node (hostname: ' + device_hostname + ')');
        }
    });
}

$(document).ready(function () {
    setInterval(function () {
        $('.bootgrid-table').each(function() {
            $(this).bootgrid('reload');
        });
    }, 300000);
});

function loadScript(src, callback) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    if(callback)script.onload=callback;
    document.getElementsByTagName("head")[0].appendChild(script);
    script.src = src;
}

function init_map(id, engine, api_key) {
    var leaflet = L.map(id);
    var baseMaps = {};
    leaflet.setView([0, 0], 15);

    if (engine === 'google') {
        loadScript('https://maps.googleapis.com/maps/api/js?key=' + api_key, function () {
            loadScript('js/Leaflet.GoogleMutant.js', function () {
                var roads = L.gridLayer.googleMutant({
                    type: 'roadmap'	// valid values are 'roadmap', 'satellite', 'terrain' and 'hybrid'
                });
                var satellite = L.gridLayer.googleMutant({
                    type: 'satellite'
                });

                baseMaps = {
                    "Streets": roads,
                    "Satellite": satellite
                };
                L.control.layers(baseMaps, null, {position: 'bottomleft'}).addTo(leaflet);
                roads.addTo(leaflet);
            });
        });
    } else if (engine === 'bing') {
        loadScript('js/leaflet-bing-layer.min.js', function () {
            var roads = L.tileLayer.bing({
                bingMapsKey: api_key,
                imagerySet: 'RoadOnDemand'
            });
            var satellite = L.tileLayer.bing({
                bingMapsKey: api_key,
                imagerySet: 'AerialWithLabelsOnDemand'
            });

            baseMaps = {
                "Streets": roads,
                "Satellite": satellite
            };
            L.control.layers(baseMaps, null, {position: 'bottomleft'}).addTo(leaflet);
            roads.addTo(leaflet);
        });
    } else if (engine === 'mapquest') {
        loadScript('https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=' + api_key, function () {
            var roads = MQ.mapLayer();
            var satellite = MQ.hybridLayer();

            baseMaps = {
                "Streets": roads,
                "Satellite": satellite
            };
            L.control.layers(baseMaps, null, {position: 'bottomleft'}).addTo(leaflet);
            roads.addTo(leaflet);
        });
    } else {
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        // var esri = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        //     attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        // });
        //
        // baseMaps = {
        //     "OpenStreetMap": osm,
        //     "Satellite": esri
        // };
        // L.control.layers(baseMaps, null, {position: 'bottomleft'}).addTo(leaflet);
        osm.addTo(leaflet);
    }

    if (location.protocol === 'https:') {
        // can't request location permission without https
        L.control.locate().addTo(leaflet);
    }

    return leaflet;
}

function init_map_marker(leaflet, latlng) {
    var marker = L.marker(latlng);
    marker.addTo(leaflet);
    leaflet.setView(latlng);

    // move marker on drag
    leaflet.on('drag', function () {
        marker.setLatLng(leaflet.getCenter());
    });
    // center map on zoom
    leaflet.on('zoom', function () {
        leaflet.setView(marker.getLatLng());
    });

    return marker;
}

function update_location(id, latlng, callback) {
    $.ajax({
        method: 'PATCH',
        url: "ajax/location/" + id,
        data: {lat: latlng.lat, lng: latlng.lng}
    }).success(function () {
        toastr.success('Location updated');
        typeof callback === 'function' && callback(true);
    }).error(function (e) {
        var msg = 'Failed to update location: ' + e.statusText;
        var data = e.responseJSON;
        if (data) {
            if (data.hasOwnProperty('lat')) {
                msg = data.lat.join(' ') + '<br />';
            }
            if (data.hasOwnProperty('lng')) {
                if (!data.hasOwnProperty('lat')) {
                    msg = '';
                }

                msg += data.lng.join(' ')
            }
        }

        toastr.error(msg);
        typeof callback === 'function' && callback(false);

    });
}

function http_fallback(link) {
    var url = link.getAttribute('href');
    console.log(url);
    try {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, false);
        xhr.timeout = 2000;
        xhr.send(null);

        if (xhr.status !== 200) {
            url = url.replace(/^https:\/\//, 'http://');
        }
    } catch (e) {
        // console.log(e);
        url = url.replace(/^https:\/\//, 'http://');
    }

    window.open(url, '_blank');
    return false;
}
