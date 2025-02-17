/* Minification failed. Returning unminified contents.
(4381,69-70): run-time error JS1195: Expected expression: >
(4403,1-2): run-time error JS1002: Syntax error: }
(4405,46-47): run-time error JS1195: Expected expression: )
(4405,48-49): run-time error JS1004: Expected ';': {
 */
// @author Senior UI Developer Ugur Ugurlu
// @e-mail ugurluu@gmail.com 

var OGOO;
window.OGOO = {
    UI: {}, Helper: {}, Connect: {}, Service: {},
    LassaMap: {}, Templates: {}, Tyre: {}, Customized: {},
    RoadAssistant: {}, Warranty: {}, Base: {}
};

$(function () {
    OGOO.UI = new UI();
    OGOO.Helper = new Helper();
    OGOO.Connect = new Connect();
    OGOO.Service = new Service();
    OGOO.LassaMap = new LassaMap();
    OGOO.Tyre = new Tyre();
    OGOO.Customized = new Customized();
    /*	OGOO.RoadAssistant = new RoadAssistant(); */
    OGOO.Warranty = new Warranty();
    OGOO.Base = new Base();
    OGOO.Base.init();

    if (clientData.currententity.id == 3) {
        $('body').addClass("home");
    }

    try {
        OGOO.Helper.templateManager(function () {
            var queryObject = clientData.request.querystring;

            OGOO.UI.init();

            if (clientData.currententity.id == 3 || clientData.currententity.id == 413) {
                OGOO.Helper.queryStringObject = queryObject;
            }
            if (clientData.currententity.id == 402) {
                OGOO.UI.controlTyreFilters();
            }
            if (clientData.currententity.id == 408) {
                OGOO.RoadAssistant.init();
            }
            if (clientData.currententity.id == 1856) {
                OGOO.Warranty.init();
            }
        });
    } catch (e) {
        console.log(e.message);
    }
});


var Base = function () {

}
Base.prototype.init = function () {
    if (!OGOO.Helper.isMobile()) {
        var self = this;
        var t = 0;
        setTimeout(function () {
            $('.loader-shadow, .loader-logo').fadeOut("slow");
        }, 200);
        setTimeout(function () {
            $('.loader-overlay').addClass('loaded');
            var time = null;
            $('.loader-overlay').css({
                width: OGOO.Helper.getScreenSize().w,
                height: OGOO.Helper.getScreenSize().w,
                left: 0,
                top: (OGOO.Helper.getScreenSize().h - OGOO.Helper.getScreenSize().w) / 2 + "px"
            });
        }, 600);
    } else {
        setTimeout(function () {
            //$('.loader').fadeOut("fast");
        }, 200);
    }

};
/**
 * Created by U�ur U�urlu on 29.5.2015.
 */
var Connect = function () {
};

Connect.prototype.request = function (params) {
    var options = $.extend({
        url: "/",
        data: '',
        type: 'POST',
        completed: function (resultJSON) {
        },
        failed: function (status) {
        }
    }, params);

    try {
        $.ajax({
            type: options.type,
            url: "/api/" + options.url,
            data: JSON.stringify(options.data)
        }).done(function (resultJSON) {
            if ($.isFunction(options.completed)) {
                options.completed(resultJSON);
            }
        }).fail(function (jqXHR, status) {
            if ($.isFunction(options.failed)) {
                options.completed(jqXHR);
            }
        });
    } catch (e) {
    }
}

Connect.prototype.requestInsurance = function (params) {
    var options = $.extend({
        url: "/",
        data: '',
        type: 'POST',
        completed: function (resultJSON) {
        },
        failed: function (status) {
        }
    }, params);

    try {
        $.ajax({
            type: options.type,
            url: "/api/" + options.url,
            data: JSON.stringify(options.data)
        }).done(function (resultJSON) {
            if ($.isFunction(options.completed)) {
                options.completed(resultJSON);
            }
        }).fail(function (jqXHR, status) {
            if ($.isFunction(options.failed)) {
                options.completed(jqXHR);
            }
        });
    } catch (e) {
    }
};
/**
 * Created by U�ur U�urlu on 6.7.2015.
 */
var Customized = function () {
}

Customized.prototype.getDealerList = function (options, callback) {
    OGOO.Connect.request({
        url: "dealer/get",
        data: options,
        completed: callback
    });
}

Customized.prototype.countyByCityCode = function (cityID, callback) {
    var obj = {};
    obj.cityid = cityID
    OGOO.Connect.request({
        url: "customized/countiesbycityid/",
        data: obj,
        completed: callback
    });
}

Customized.prototype.dealerCountyByCityCode = function (cityID, callback) {
    OGOO.Connect.request({
        url: "/dealer/county",
        data: {
            parent: cityID
        },
        completed: callback
    });
}

Customized.prototype.getNews = function (callback) {
    OGOO.Connect.request({
        url: "customized/news",
        data: {
            page: 1,
            toprow: 10000
        },
        completed: callback
    });
}

Customized.prototype.getCampaigns = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/campaign",
        data: obj,
        completed: callback
    });
}

Customized.prototype.findRoadAssist = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/findroadassist",
        data: obj,
        completed: callback
    });
}

Customized.prototype.search = function (obj, callback) {
    var obj = {
        page: 1,
        search: OGOO.Helper.getParams("q") == null ? 0 : OGOO.Helper.getParams("q"),
        toprow: 10000,
        module: obj.module
    }
    OGOO.Connect.request({
        url: "customized/search",
        data: obj,
        completed: callback
    });
}

Customized.prototype.searchtyre = function (obj, callback) {
    var obj = {
        page: 1,
        querytext: OGOO.Helper.getParams("q") == null ? 0 : OGOO.Helper.getParams("q"),
        toprow: 10000
    }
    OGOO.Connect.request({
        url: "customized/searchtyre",
        data: obj,
        completed: callback
    });
}

Customized.prototype.sidebarNews = function (date, callback) {
    OGOO.Connect.request({
        url: "customized/newstimeline",
        data: date,
        completed: callback
    });
}

Customized.prototype.sidebarCampaigns = function (date, callback) {
    OGOO.Connect.request({
        url: "customized/campaigntimeline",
        data: date,
        completed: callback
    });
}

Customized.prototype.priceListPaging = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/pricelistproduct",
        data: obj,
        completed: callback
    });
}

Customized.prototype.roadAssistUpdate = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/roadassistupdatecustomerprofile",
        data: obj,
        completed: callback
    });
}

Customized.prototype.getWarrantyInfo = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/warrantyinformation",
        data: obj,
        completed: callback
    });
}

Customized.prototype.roadAssistCities = function (callback) {
    OGOO.Connect.request({
        url: "customized/roadassistcities",
        completed: callback
    });
}

Customized.prototype.roadAssistCounties = function (code, callback) {
    OGOO.Connect.request({
        url: "customized/roadassistcounties",
        data: {
            cityCode: code
        },
        completed: callback
    });
}

Customized.prototype.roadVehicleGroups = function (callback) {
    OGOO.Connect.request({
        url: "customized/roadassistvehiclegroups",
        completed: callback
    });
}

Customized.prototype.roadVehicleBrands = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/roadassistvehiclebrands",
        data: obj,
        completed: callback
    });
}

Customized.prototype.roadVehicleModels = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/roadassistvehiclemodels",
        data: obj,
        completed: callback
    });
}

Customized.prototype.olderCampaign = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/oldercampaign",
        data: obj,
        completed: callback
    });
}

Customized.prototype.setDealerParams = function (obj, callback) {
    OGOO.Connect.request({
        url: "customized/SetDealerParams",
        data: obj,
        completed: callback
    });
};
;
/**
 * Created by U�ur U�urlu on 26.5.2015.
 */
var Helper = function () {
    "use strict";
    this.extension = ".cshtml";
    this.version = clientData.assetversion;
    this.queryStringObject = {};
}

if (!Object.keys) {
    Object.keys = (function () {
        'use strict';
        var hasOwnProperty = Object.prototype.hasOwnProperty,
            hasDontEnumBug = !({ toString: null }).propertyIsEnumerable('toString'),
            dontEnums = [
                'toString',
                'toLocaleString',
                'valueOf',
                'hasOwnProperty',
                'isPrototypeOf',
                'propertyIsEnumerable',
                'constructor'
            ],
            dontEnumsLength = dontEnums.length;

        return function (obj) {
            if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
                throw new TypeError('Object.keys called on non-object');
            }

            var result = [], prop, i;

            for (prop in obj) {
                if (hasOwnProperty.call(obj, prop)) {
                    result.push(prop);
                }
            }

            if (hasDontEnumBug) {
                for (i = 0; i < dontEnumsLength; i++) {
                    if (hasOwnProperty.call(obj, dontEnums[i])) {
                        result.push(dontEnums[i]);
                    }
                }
            }
            return result;
        };
    }());
}

(function (fn) {
    if (!fn.map) fn.map = function (f) {
        var r = [];
        for (var i = 0; i < this.length; i++)if (this[i] !== undefined) r[i] = f(this[i]);
        return r
    }
    if (!fn.filter) fn.filter = function (f) {
        var r = [];
        for (var i = 0; i < this.length; i++)if (this[i] !== undefined && f(this[i])) r[i] = this[i];
        return r
    }
})(Array.prototype);

if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (elt /*, from*/) {
        var len = this.length >>> 0;

        var from = Number(arguments[1]) || 0;
        from = (from < 0)
            ? Math.ceil(from)
            : Math.floor(from);
        if (from < 0)
            from += len;

        for (; from < len; from++) {
            if (from in this &&
                this[from] === elt)
                return from;
        }
        return -1;
    };
}

if (typeof Array.prototype.forEach != 'function') {
    Array.prototype.forEach = function (callback) {
        for (var i = 0; i < this.length; i++) {
            callback.apply(this, [this[i], i, this]);
        }
    };
}

/**
 * This method geting page resolutions
 * @memberof Helper
 * @method getScreenSize
 */
Helper.prototype.getScreenSize = function () {
    var w, h;
    if (document.body && document.body.offsetWidth) {
        w = document.body.offsetWidth;
        h = document.body.offsetHeight;
    }
    if (document.compatMode == 'CSS1Compat' &&
        document.documentElement &&
        document.documentElement.offsetWidth) {
        w = document.documentElement.offsetWidth;
        h = document.documentElement.offsetHeight;
    }
    if (window.innerWidth && window.innerHeight) {
        w = window.innerWidth;
        h = window.innerHeight;
    }
    return { w: w, h: h }
}

/**
 * This method load all template data
 * @memberof Helper
 * @method templateManager
 */
Helper.prototype.templateManager = function (callback) {
    var self = this;
    self.templateCount = 0;
    if (localStorage.getItem("template") != null && self.version == localStorage.getItem("templateVersion")) {
        OGOO.Templates = JSON.parse(localStorage.getItem("template"));
        callback();
    } else {
        $.each(OGOO.Service.TemplatesList, function (key, value) {
            $.get("/View/Templates/" + value + self.extension + "?v=" + new Date().getTime().toString(), function (template, type, obj) {
                OGOO.Templates[value] = template;
                if (obj.status == 200) {
                    self.templateCount++;
                }
                if (self.templateCount == OGOO.Service.TemplatesList.length) {
                    if (typeof (Storage) !== "undefined") {
                        try {
                            localStorage.setItem("template", JSON.stringify(OGOO.Templates));
                            localStorage.setItem("templateVersion", self.version);
                            callback();
                        }
                        catch (e) {
                            callback();
                        }
                    }
                }
            });
        });
    }
}

/**
 * This method convert form to json data
 * @memberof Helper
 * @method convertObject
 */
Helper.prototype.convertObject = function (form) {
    var data = {};
    form.serializeArray().map(function (e) {
        data[e.name] = e.value;
    });
    return data;
}

Helper.prototype.convertObjectWithoutNull = function (form) {
    var data = {};
    form.serializeArray().map(function (e) {
        if (e.value != "") {
            data[e.name] = e.value;
        }
    });
    return data;
}

/**
 * This method convert queryString to object
 * @memberof Helper
 * @method convertObject
 */
Helper.prototype.queryStringToJSON = function (queryString) {
    if (queryString.indexOf('?') > -1) {
        queryString = queryString.split('?')[1];
    }
    var pairs = queryString.split('&');
    var result = {};
    pairs.forEach(function (pair) {
        pair = pair.split('=');
        result[pair[0]] = decodeURIComponent(pair[1] || '');
    });
    return result;
}

/**
 * This method process url
 * @memberof Helper
 * @method convertObject
 */
Helper.prototype.getRoute = function () {
    var parsedUrl = document.location.href.split("/");
    return parsedUrl;
}

/**
 * This method process query
 * @memberof Helper
 * @method convertObject
 */
Helper.prototype.getParams = function (param) {
    var match = RegExp('[?&]' + param + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

Helper.prototype.isNullOrEmpty = function (string) {
    var str = false;
    if (string == "" || string == "") {
        str = true;
    }
    return str;
}

Helper.prototype.lowerString = function (text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}

Helper.prototype.processHash = function () {
    var self = this;
    var hashList = [];
    var hash = document.location.hash.replace("#", "").split(",");
    if (hash.length > 0) {
        hash.forEach(function (item) {
            if (!self.isNullOrEmpty(item)) {
                hashList.push(item);
            }
        });
    }
    return hashList;
}


Helper.prototype.processPushState = function () {
    var self = this;
    var url = document.location.protocol + "//" + document.location.host + document.location.pathname + "?" + $.param(self.queryStringObject);
    window.history.pushState({ path: url }, '', url);
}
Helper.prototype.replacePushState = function (getUrl) {
    var self = this;
    var url = document.location.protocol + "//" + document.location.host + "/" + getUrl;
    window.history.pushState({ path: url }, '', url);
}

Helper.prototype.isMobile = function () {
    return (/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i).test(navigator.userAgent);
}

Helper.prototype.mapIsLoading = function () {
    if (typeof google === 'object' && typeof google.maps === 'object')
        return true
    else {
        return false
    }
}

/**
 * * @param: data value
 * */
Helper.prototype.stringTextSearch = function (value, text) {
    var findValue = value;
    var result = null;

    if (findValue != null) {
        result = findValue.includes(text);
    }

    return result;
}


// First, checks if it isn't implemented yet.
String.prototype.format = function () {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function (match, number) {
        return typeof args[number] != 'undefined'
            ? args[number]
            : match
            ;
    });
};
/**
 * Created by Uğur Uğurlu on 29.5.2015.
 */
var LassaMap = function () {

}
var initMap = function () {
    var self = OGOO.LassaMap;
    self.styles = [
        { featureType: 'road', elementType: 'all', stylers: [{ visibility: 'on' }] },
        { featureType: 'poi', elementType: 'all', stylers: [{ visibility: 'on' }] },
        { featureType: 'water', elementType: 'all', stylers: [{ color: '#03a0d5' }] },
        { featureType: 'landscape', elementType: 'all', stylers: [{ color: '#eeeeee' }] },
        { featureType: "administrative.country", elementType: "labels.text.fill", stylers: [{ "color": "#888888" }] },
        { featureType: "administrative.country", elementType: "labels.text", stylers: [{ visibility: "on" }] },
        { featureType: 'administrative.province', elementType: 'labels.text.stroke', stylers: [{ color: "#a0a0a0" }] },
        { featureType: 'administrative.province', elementType: 'labels.text.fill', stylers: [{ visibility: "on" }] },
        { featureType: 'administrative.province', elementType: 'geometry.stroke', stylers: [{ color: "#ffffff" }] }
    ];

    self.options = {
        zoom: 6,
        center: new google.maps.LatLng(38.436193, 35.903564),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true,
        styles: self.styles,
        zoomControl: true
    };

    self.map = null;
    self.directionsService = new google.maps.DirectionsService();
    self.directionsDisplay = new google.maps.DirectionsRenderer({
        polylineOptions: {
            strokeColor: "red"
        }
    });
    self.mapData = [];
    self.directionMarkers = [];
    self.markers = [];
    self.stepDisplay = null;
    self.initializeMap();
    self.lastSearch
}
LassaMap.prototype.initializeMap = function () {
    var self = this;
    try {
        this.map = new google.maps.Map(document.getElementById('map-canvas'), this.options);
        this.directionsDisplay.setMap(self.map);
        self.mapZoom = false;

        var query = $('#DealerSearchKey').val();
        var cityVal = $('#DealerSearchCity').val();
        var countyVal = $('#DealerSearchCounty').val();
        if (query != '') {
            this.getDealerData({ search: query }, true);

        } else {
            if (cityVal != '') {
                if (countyVal != '') {
                    this.getDealerData({ countyid: countyVal, cityid: cityVal }, true);

                } else {
                    this.getDealerData({ cityid: cityVal }, true);
                }
            } else {

                this.getDealerData({}, false);
            }

        }

        self.stepDisplay = new google.maps.InfoWindow();
        self.getUserLocation(function (result) {
            if (result != null) {
                self.map.setCenter(new google.maps.LatLng(result.coords.latitude, result.coords.longitude));
                self.map.setZoom(10);
            }
        });
    } catch (e) {
        //
    }
}

LassaMap.prototype.showHideMarkers = function (type) {
    var self = this;
    if (type == "hide") {
        self.markers.forEach(function (marker) {
            marker.setVisible(false);
        });
    } else {
        self.markers.forEach(function (marker) {
            marker.setVisible(true);
        });
    }
}

LassaMap.prototype.getDealerData = function (query, search) {
    var self = this;
    OGOO.Customized.getDealerList(query, function (result) {
        self.mapData = result.data;
        self.processMapData(result, search);
    });
}

LassaMap.prototype.processMapData = function (result, search) {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    self.lastSearch = result;
    if (!search) {
        self.setMarkers(result);
    } else {

        if ($(window).width() <= 767) {
            var template = _.template(OGOO.Templates["MapAutoComplete"]);
            $('.search-list').show().html(template({ data: result.data }));
            $('.auto-complete').css({
                width: $('#search-dealer').outerWidth(),
                "margin-left": -$('#search-dealer').outerWidth() / 2
            });
            $('.auto-complete').find('a').off('click').on('click', function (e) {
                e.preventDefault();
                var data = $(this).data();
                self.getDealerDetail(data.id);
                $('.auto-complete').remove();
                $('.search-list').hide();
            });
        }
        else {
            self.setMarkers(result, true);
        }
    }

    self.pageListeners();

    var dealerControl = OGOO.Helper.getParams("dealerID");
    if (dealerControl != null) {
        var index = result.data.map(function (e) {
            return e.delaerbranchcode
        }).indexOf(dealerControl);
        if (index != -1) {
            self.getDealerDetail(dealerControl);
        }
    }

    OGOO.UI.mapZoom = true;
}

LassaMap.prototype.setMarkers = function (result, isSearch) {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    var bounds = new google.maps.LatLngBounds();

    console.log("dealers rcv ", result.data.length);

    const filtered = result.data.filter(function (dealer) {
        if (dealer.dealercommunicationlatitude &&
            dealer.dealercommunicationlongitude &&
            dealer.dealercommunicationlatitude.trim().length > 1 &&
            dealer.dealercommunicationlongitude.trim().length > 1) {
            return true;
        }
        return false;
    });

    console.log("dealers filtered ", filtered.length);

    filtered.forEach(function (dealer) {
        if ((dealer.dealercommunicationlatitude != "" && dealer.dealercommunicationlongitude != "") && (dealer.dealercommunicationlatitude != 0 && dealer.dealercommunicationlongitude != 0)) {
            var pos = new google.maps.LatLng(Number(dealer.dealercommunicationlatitude.replace(",", ".")), (dealer.dealercommunicationlongitude.replace(",", ".")));
            var marker = new google.maps.Marker({
                position: pos,
                map: self.map,
                id: dealer.delaerbranchcode,
                icon: "assets/images/pin.png"
            });
            self.markers.push(marker);
            bounds.extend(marker.position);
            google.maps.event.addListener(marker, 'click', function () {
                self.getDealerDetail(dealer.delaerbranchcode);
            });
        }
    });
    if (isSearch) {
        self.map.fitBounds(bounds);
    }
    var template = _.template(OGOO.Templates["MapSearch"]);
    $('.dealer-detail').show().html(template({ data: result.data }))
    $('.dealer-list-template').height(pageSize.h - 180);
}

LassaMap.prototype.getClosestArea = function (callback) {
    var self = this;
    self.getUserLocation(function (result) {
        if (result != null) {
            self.map.setCenter(new google.maps.LatLng(result.coords.latitude, result.coords.longitude));
            self.map.setZoom(10);
        }
        if (callback) callback(result);
    });
}

LassaMap.prototype.smoothZoom = function (level, cnt, mode) {
    var self = this;
    // If mode is zoom in
    if (mode == true) {

        if (cnt >= level) {
            return;
        }
        else {
            var z = google.maps.event.addListener(self.map, 'zoom_changed', function (event) {
                google.maps.event.removeListener(z);
                self.smoothZoom(self.map, level, cnt + 1, true);
            });
            setTimeout(function () {
                self.map.setZoom(cnt)
            }, 80);
        }
    } else {
        if (cnt <= level) {
            return;
        }
        else {
            var z = google.maps.event.addListener(self.map, 'zoom_changed', function (event) {
                google.maps.event.removeListener(z);
                self.smoothZoom(self.map, level, cnt - 1, false);
            });
            setTimeout(function () {
                self.map.setZoom(cnt)
            }, 80);
        }
    }
}

LassaMap.prototype.pageListeners = function (repeat) {
    var self = this;
    $('.get-detail').each(function () {
        var data = $(this).data();
        $(this).off('click').on('click', function (e) {
            self.getDealerDetail(data.id);
        });
    });

    if (!repeat) {
        google.maps.event.addListener(self.map, 'zoom_changed', function () {
            self.markerMapBounds();
        });
        google.maps.event.addListener(self.map, 'dragend', function () {
            self.markerMapBounds();
        });
    }


}

LassaMap.prototype.calculateRoute = function (result, data) {
    var self = this;
    var start = new google.maps.LatLng(result.coords.latitude, result.coords.longitude);
    var end = new google.maps.LatLng(Number(data.ltd), Number(data.lng));
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
    };
    self.directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            self.directionsDisplay.setDirections(response);
            self.showSteps(response);
            self.showHideMarkers("hide");
        }
    });
}

LassaMap.prototype.getUserLocation = function (callback) {
    var self = this;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (result) {
            self.userLocation = {
                lat: result.coords.latitude,
                lng: result.coords.longitude
            };
            callback(result);
        }, function (error) {
            callback(null);
        }, { enableHighAccuracy: true, maximumAge: 0 });
    } else {
        callback(null);
    }
}

LassaMap.prototype.showSteps = function (directionResult) {
    var self = this;
    var myRoute = directionResult.routes[0].legs[0];
    for (var i = 0; i < myRoute.steps.length; i++) {
        var marker = new google.maps.Marker({
            position: myRoute.steps[i].start_location,
            map: self.map,
            icon: window.location.protocol + "//maps.google.com/mapfiles/ms/icons/yellow-dot.png",
        });
        self.directionMarkers.push(marker);
        self.showRouteInfo(marker, myRoute.steps[i].instructions);
    }
}

LassaMap.prototype.showRouteInfo = function (marker, text) {
    var self = this;
    google.maps.event.addListener(marker, 'click', function () {
        self.stepDisplay.setContent(text);
        self.stepDisplay.open(self.map, marker);
    });
}

LassaMap.prototype.getDealerDetail = function (dealerID) {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    var index = self.mapData.map(function (dealer) {
        return dealer.delaerbranchcode;
    }).indexOf(dealerID.toString());

    var item = self.mapData[index];

    self.centerMarker({
        ltd: Number(item.dealercommunicationlatitude.replace(",", ".")),
        lng: Number(item.dealercommunicationlongitude.replace(",", "."))
    });

    self.getUserLocation(function (result) {
        var template = _.template(OGOO.Templates["MapDealerDetail"]);
        item.coord = result;
        $('.dealer-detail').html(template(item));
        $('.dealer-template').height(pageSize.h);
        $('#map-canvas').height(pageSize.h);
        google.maps.event.trigger(self.map, 'resize');
        $('.dealer-finder').animate({
            top: -70
        }, {
            duration: 800,
            easing: "easeOutExpo"
        });
        $('.dealer-template').animate({
            right: 0
        }, {
            duration: 500,
            easing: "easeOutExpo"
        });


        /**
         *  Mobile Get Direction Route 
         */

        function getDirectionsLinkMobile(result) {

            var ltd = item.dealercommunicationlatitude.replace(",", ".");
            var lng = item.dealercommunicationlongitude.replace(",", ".");

            var url = 'http://www.google.com/maps/dir/?api=1&origin=' + result.coords.latitude + ',' + result.coords.longitude + '&destination=' + ltd + "," + lng + '&travelmode=driving';
            $('.find-route-mobile').attr('href', url);
            var origin = "";
            return url;
        };

        getDirectionsLinkMobile(result);

        function getDirectionsLinkDesktop(result) {

            var ltd = item.dealercommunicationlatitude.replace(",", ".");
            var lng = item.dealercommunicationlongitude.replace(",", ".");

            var url = 'http://www.google.com/maps/dir/?api=1&origin=' + result.coords.latitude + ',' + result.coords.longitude + '&destination=' + ltd + "," + lng + '&travelmode=driving';
            $('.find-route--desktop').attr('href', url);
            var origin = "";
            return url;
        };

        getDirectionsLinkDesktop(result);

        // End Mobile Get Direction Route

        $('.find-route').each(function () {
            var data = $(this).data();
            $(this).off('click').on('click', function () {
                self.getUserLocation(function (result) {
                    if (result != null) {
                        var isMobile;
                        if (pageSize.w <= 767 ? isMobile = true : isMobile = false);
                        if (isMobile) {
                            $('.back').trigger('click');
                            self.calculateRoute(result, data);
                        }
                        else {
                            self.calculateRoute(result, data);
                        }


                    }
                });
            });
        });

        $('.back').off('click').on('click', function (e) {
            e.preventDefault();
            if ($('.dealer-finder').hasClass('detail')) {
                $('#map-canvas').height(OGOO.Helper.getScreenSize().h - 150);
            } else {
                $('#map-canvas').height(OGOO.Helper.getScreenSize().h - 271);
            }
            $('.dealer-template').animate({
                right: -384
            }, "fast", function () {
                var template = _.template(OGOO.Templates["MapSearch"]);
                $('.dealer-detail').show().html(template({ data: self.lastSearch.data }))
                $('.dealer-list-template').height(pageSize.h - 180);
                $('.get-detail').each(function () {
                    var data = $(this).data();
                    $(this).off('click').on('click', function (e) {
                        self.getDealerDetail(data.id);
                    });
                });
            });



            google.maps.event.trigger(self.map, 'resize');
            $('.dealer-finder').animate({
                top: $('.dealer-finder').hasClass('detail') ? 70 : (pageSize.w <= 768 ? 154 : 178)
            }, {
                duration: 800,
                easing: "easeOutExpo"
            });
            self.showHideMarkers("show");
            self.directionsDisplay.set('directions', null);
            self.directionMarkers.forEach(function (marker) {
                marker.setMap(null);
            });
            self.directionMarkers = [];

            self.getClosestArea(function (result) {
                if (result == null) {

                    self.centerMarker({
                        ltd: 38.436193,
                        lng: 35.903564
                    });
                    self.map.setZoom(6);
                }
            });
        });

        $('.service-button').off('click').on('click', function (e) {
            e.preventDefault();
            $('.service-button').removeClass('active');
            $(this).addClass("active");
            if ($(this).index(0)) {
                $('.services').show();
                $('.contact-us').hide();

            } else {
                $('.services').hide();
                $('.contact-us').show();
            }
        });
    });
}

LassaMap.prototype.centerMarker = function (coord) {
    var self = this;
    if (!isNaN(Number(coord.ltd)) && !isNaN(Number(coord.lng))) {
        self.map.setCenter(new google.maps.LatLng(coord.ltd, coord.lng));
        self.map.setZoom(18);
    }
}

LassaMap.prototype.markerMapBounds = function () {
    var self = this;
    var filterData = [];
    self.markers.forEach(function (marker, count) {
        if (self.map.getBounds().contains(marker.getPosition())) {
            var index = self.mapData.map(function (dealer) {
                return dealer.delaerbranchcode;
            }).indexOf(marker.id);
            if (index !== -1) {
                filterData.push(self.mapData[index]);
            }
        }
    });
    var result = {
        data: filterData
    }	//var template = _.template(OGOO.Templates["MapSearch"]);
    //$('.search-list').show().html(template({data: result.data})).css({
    //	height: OGOO.Helper.getScreenSize().h - 250
    //});
    //$(".nano").nanoScroller();
    self.pageListeners(true);
};
/**
 * Created by Uğur Uğurlu on 18.11.2015.
 */
var RoadAssistant = function () {
    this.tyreData = [];
}

RoadAssistant.prototype.init = function () {
    //assistant form
    $('#assist-form').bValidator()
    $('.send-assist-form').on('click', function (e) {
        e.preventDefault();
        var form = $('#assist-form');
        if (form.data('bValidator').validate()) {
            var obj = OGOO.Helper.convertObject(form);
            $('.send-assist-form').text("Lütfen bekleyin...");
            OGOO.RoadAssistant.accessRoadAssistanInfo(obj);
        }
    });
}

RoadAssistant.prototype.accessRoadAssistanInfo = function (obj) {
    var self = this;
    OGOO.Customized.findRoadAssist(obj, function (result) {
        // Return test result
        //result.status.message = "Succeed";
        //result.status.code = "1";
        //result.data.result = "2";
        if (result.status.message == "Succeed") {
            $('.send-assist-form').text("Gönder");
            var template = _.template(OGOO.Templates["RoadAssist"]);
            result.data.roadassistnumber = obj.roadassistnumber;
            result.data.plate = obj.plate;

            $('.services-form-result').html(template(result));

            if (result.data.result == "0") {
                $('.contact-form.fix').css('margin-bottom', '0px');
            }
            else if (result.data.result == "2") {
                OGOO.UI.sectionWidth();
                self.roadAssistListener();

                $('.services-form').hide();

                try {
                    $(".detail-news").nanoScroller({ scrollTop: $('.services-form-result').position().top });
                } catch (e) {
                    //
                }

                $('#invoiceDate').datepicker({
                    format: 'dd.mm.yyyy',
                    language: 'tr',
                    autoclose: true,
                    weekStart: 1
                }).on('changeDate', function (e) {
                    $(this).removeClass('bvalidator_invalid');
                });;

                $('.phone').inputmask('0(999)999 99 99', {
                    onincomplete: function () {
                        var t = $(this);
                        setTimeout(function () {
                            t.val("");
                        }, 1);
                    }
                });

                $('.int').inputmask({
                    alias: "Regex",
                    regex: '^[0-9]+$'
                });

                $('.string').inputmask({
                    alias: "Regex",
                    regex: '^[a-zA-ZçÇıİğĞöÖşŞüÜ ]+$'
                });

                $('select[name="VehicleGroup"]').off('change').on('change', function () {
                    var t = $(this);
                    var val = t.val();
                    if (val != null) {
                        self.getVehicleBrands(val);
                        $('select[name="VehicleCode"]').empty().append('<option value="">Araç modeli seçiniz</option>');
                    }
                });

                $('#road-assist-register').bValidator();
            }
        }
        else {
            $('.services-form-result').html("<div class='alert alert-danger'><strong>Yol Yardım Servisinde Oluşan Teknik Bir Problemden Dolayı Şuanda Hizmet Veremiyoruz. Lütfen Daha Sonra Tekrar Deneyiniz. <strong><div>");
            $('.send-assist-form').text("Gönder");
        }

    });
}

RoadAssistant.prototype.roadAssistListener = function () {
    var self = this;
    $('select[name="CustomerCityCode"]').off('change').on('change', function () {
        var t = $(this);
        var val = t.val();
        OGOO.Customized.roadAssistCounties(val, function (result) {
            var select = $('select[name="CustomerCountyCode"]');
            select.empty();
            select.append('<option value="">İlçe Seçiniz</option>');
            result.data.forEach(function (district) {
                select.append('<option value="' + district.code + '">' + district.description + '</option>');
            });
        });
    });

    $('.update-assist-form').off('click').on('click', function (e) {
        e.preventDefault();
        var form = $('#road-assist-register');
        var obj = OGOO.Helper.convertObject(form);

        if (form.data('bValidator').validate()) {
            $('.update-assist-form').text("Gönderiliyor");
            $('.validation-error-message').html('<em>*</em> ile işaretli alanların doldurulması zorunludur.').css({ 'display': 'none', 'paddingLeft': '17px' });

            var tyreObject = self.getTyreByCode($('#productCode').val());

            obj.PatternCode = tyreObject.patterncode;
            obj.SizeCode = tyreObject.sizetext;
            obj.ProductCode = tyreObject.code;

            var date = obj.invoiceDate.split(".");
            var dateString = date[2] + "." + date[1] + "." + date[0] + " 03:00:00";

            obj.invoiceDate = new Date(dateString).getTime();

            OGOO.Customized.roadAssistUpdate(obj, function (result) {
                if (result.status.message == "Succeed") {
                    $('.services-form-result').html('<div id="road-assist-register-succeed">Form Başarıyla Gönderildi</div><iframe width="1" height="1" src="/View/Templates/alo-yol-dostu.html" style="visibility:hidden;"></iframe>');
                    $('html,body').animate({ scrollTop: $('#road-assist-register-succeed').offset().top - 200 }, 100);
                } else {
                    $('.update-assist-form').text("Gönder");
                    $('.validation-error-message').text(result.data).css({ 'display': 'block', 'paddingLeft': '0' });
                    $('html,body').animate({ scrollTop: $('.validation-error-message').offset().top - 200 }, 100);
                }
            });
        }
        else {
            $('.validation-error-message').show();
        }
    });
    $(document).on('click', '.tyre-list a', function () {
        $('.tyre-list li.active').removeClass('active');
        $('.tyre-list').removeClass('bvalidator_invalid');
        $('.validation-error-message').hide();

        $(this).parent().addClass('active');
        $('#productCode').val($(this).data('productcode'));

        return false;
    });
}

RoadAssistant.prototype.getVehicleBrands = function (groupId) {
    var self = this;
    OGOO.Customized.roadVehicleBrands({ "VehicleGroup": groupId }, function (result) {
        var select = $('select[name="VehicleBrand"]');
        select.empty();
        if (result.data.length > 0) {
            select.removeAttr("disabled")
        }
        else {
            select.prop("disabled", true);
        }
        select.append('<option value="">Araç markası seçiniz</option>');
        result.data.forEach(function (brand) {
            select.append('<option value="' + brand.code + '">' + brand.description + '</option>');
        });
        $('select[name="VehicleBrand"]').off('change').on('change', function () {
            var t = $(this);
            var val = t.val();
            if (val != null) {
                self.getVehicleModes(val);
            }
        });
    });
}

RoadAssistant.prototype.getVehicleModes = function (brandId) {
    var self = this;
    OGOO.Customized.roadVehicleModels({ VehicleBrand: brandId, VehicleGroup: $('#VehicleGroup').val() }, function (result) {
        var select = $('select[name="VehicleCode"]');
        select.empty();
        if (result.data.length > 0) {
            select.removeAttr("disabled")
        }
        else {
            select.prop("disabled", true);
        }
        select.append('<option value="">Araç modeli seçiniz</option>');
        result.data.forEach(function (model) {
            select.append('<option value="' + model.code + '">' + model.description + '</option>');
        });
        $('select[name="VehicleCode"]').off('change').on('change', function () {
            var t = $(this);
            var val = t.val();
            //if (val != "") {
            //	self.getVehicleYears(val);
            //}
        });
    });
}

RoadAssistant.prototype.getVehicleYears = function (modelId) {
    var self = this;
    OGOO.Tyre.getTyreYears({ vehiclemodel: modelId }, function (result) {
        var select = $('select[name="VehicleYear"]');
        select.empty();
        select.append('<option value="">Araç Yılı</option>');
        result.data.forEach(function (district) {
            select.append('<option value="' + district + '">' + district + '</option>');
        });
    });
}

RoadAssistant.prototype.getTyreByCode = function (code) {
    var self = this;
    var result = null;
    var index = self.tyreData.map(function (tyre) {
        return tyre.code;
    }).indexOf(code);
    if (index != -1) {
        result = self.tyreData[index];
    }
    return result;
}

RoadAssistant.prototype.getTyreList = function () {
    if ($('#road-assist-register').length > 0) {
        var obj = {
            "sectionwidth": $('#width').val(),
            "aspectratio": $('#height').val(),
            "jantcapı": $('#radius').val(),
            "loadindex": $('#loadindex').val(),
            "speedindex": $('#speedindex').val(),
            "toprow": 30
        }
        var tyreList = $('.tyre-dropdown');
        tyreList.empty();
        $('#productCode').val('');

        if (obj.sectionwidth) {
            tyreList.show();

            OGOO.Tyre.tyreList(obj, function (result) {
                OGOO.RoadAssistant.tyreData = result.data;

                result.data.forEach(function (tyre) {
                    //tyreList.append('<li><a href="#" data-productcode="' + tyre.code + '">' + tyre.patternname + " " + tyre.shortname + '</a></li>');
                    tyreList.append('<option value="' + tyre.code + '">' + tyre.patternname + " " + tyre.shortname + '</option>');
                });
            });
        }
    }
};
/**
 * Created by U�ur U�urlu on 13.8.2015.
 */
var Service = function () {
    "use strict";
    this.TemplatesList = [
        "MapDealerDetail", "MapAutoComplete", "MapSearch", "TyreFilter",
        "SelectorButtons", "TyreSelector", "Tyre", "Search", "Model", "Year", "ProductinSearch",
        "PriceList", "News", "RoadAssist", "Warranty", "Campaigns", "Pattern"
    ];
}

Service.prototype.contactForm = function (obj, callback) {
    OGOO.Connect.request({
        url: "common/contactform/",
        data: obj,
        completed: callback
    });
}

Service.prototype.tyreSearchForm = function (obj, url, type, callback) {
    OGOO.Connect.request({
        url: url,
        type: type,
        data: obj,
        completed: callback
    });
}

Service.prototype.insuranceForm = function (obj, url, type, callback) {
    OGOO.Connect.requestInsurance({
        url: url,
        type: type,
        data: obj,
        completed: callback
    });
};
/**
 * Created by Uğur Uğurlu on 6.7.2015.
 */

var Tyre = function () {
    this.modelFilter = [];
    this.sizeFilter = [];
    this.tyreSelector = {
        year: {
            id: null,
            name: null,
            template: "Year",
            next: "engine",
            attr: "year",
            title: "ARACINIZIN MODEL YILI NEDİR?"
        },
        brand: {
            id: null,
            name: null,
            template: "Brand",
            next: "model",
            attr: "brandname",
            title: "ARACINIZIN MARKASI NEDİR?"
        },
        model: {
            id: null,
            name: null,
            template: "Model",
            next: "year",
            attr: "modelname",
            title: "ARACINIZIN MODELİ NEDİR?"
        },
        engine: {
            id: null,
            name: null,
            template: "Engine",
            next: "",
            attr: "enginename",
            title: "ARACINIZIN MOTOR HACMİ NEDİR?"
        }
    };
    this.tyreFilter = {
        "season": {
            "name": "season",
            "displayName": "MEVSİM",
            "selected": null
        },
        "position": {
            "name": "position",
            "displayName": "POZİSYON",
            "selected": null
        },
        "service": {
            "name": "service",
            "displayName": "SERVİS",
            "selected": null
        },
        "usage": {
            "name": "usage",
            "displayName": "KULLANIM TİPİ",
            "selected": null
        }
    };
    this.tyrePaging = {
        "engine": "vehicleversionid",
        "enginecode": "vehicleversionname",
        "year": "year",
        "width": "sectionwidth",
        "height": "aspectratio",
        "radius": "jantcapı",
        "group": "anagrup",
        "usage": "ubykullanım",
        "season": "sezon",
        "model": "vehiclemodelid"
    }
}

Tyre.prototype.getTyreYears = function (obj, callback) {
    var groupType = typeof clientData.groupType == "undefined" ? $('input[name="tyregrouptype"]').val() : clientData.groupType;
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/vehicleproductyear",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.vehicleBrand = function (callback) {
    var obj = {};
    var groupType = typeof clientData.groupType == "undefined" ? $('input[name="tyregrouptype"]').val() : clientData.groupType;
    obj.grouptype = groupType
    OGOO.Connect.request({
        url: "tyre/vehiclebrand",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.vehicleModel = function (obj, callback) {
    var groupType = typeof clientData.groupType == "undefined" ? $('input[name="tyregrouptype"]').val() : clientData.groupType;
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/vehiclemodel",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.vehicleVersion = function (obj, callback) {
    var groupType = typeof clientData.groupType == "undefined" ? $('input[name="tyregrouptype"]').val() : clientData.groupType;
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/vehicleversion",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.getTyreDetail = function (tyreId, callback) {
    OGOO.Connect.request({
        url: "tyre/detail/" + tyreId,
        completed: callback
    });
}

Tyre.prototype.getSeason = function (obj, callback) {
    var groupType = typeof clientData.groupType == "undefined" ? $('input[name="tyregrouptype"]').val() : clientData.groupType;
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/season",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.getPosition = function (mainGroup, callback) {
    OGOO.Connect.request({
        url: "tyre/position",
        data: {
            anagrup: mainGroup
        },
        completed: callback
    });
}

Tyre.prototype.getService = function (mainGroup, callback) {
    OGOO.Connect.request({
        url: "tyre/service",
        data: {
            anagrup: mainGroup
        },
        completed: callback
    });
}

Tyre.prototype.getUsage = function (obj, callback) {
    var groupType = $('input[name="tyregrouptype"]').val();
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/usage",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.tyreList = function (obj, callback) {
    var grouptype = $('input[name="tyregrouptype"]').val();
    obj.grouptype = grouptype;
    OGOO.Connect.request({
        url: "tyre/list",
        data: obj,
        completed: callback
    });
}
Tyre.prototype.patternList = function (obj, callback) {
    OGOO.Connect.request({
        url: "tyre/patternlist",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.sectionWidth = function (obj, callback) {
    var groupType = $('input[name="tyregrouptype"]').val();
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/sectionwidth",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.aspectRatio = function (obj, callback) {
    var groupType = $('input[name="tyregrouptype"]').val();
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/aspectratio",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.radius = function (obj, callback) {
    var groupType = $('input[name="tyregrouptype"]').val();
    obj.groupType = groupType;
    OGOO.Connect.request({
        url: "tyre/jantcapı",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.LoadIndex = function (obj, callback) {
    OGOO.Connect.request({
        url: "tyre/loadindex",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.SpeedIndex = function (obj, callback) {
    OGOO.Connect.request({
        url: "tyre/speedindex",
        data: obj,
        completed: callback
    });
}
Tyre.prototype.getFriendlyPath = function (obj, callback) {
    OGOO.Connect.request({
        url: "tyre/tyrelistfriendlypath",
        data: obj,
        completed: callback
    });
}

Tyre.prototype.saveComments = function (obj, callback) {
    OGOO.Connect.request({
        url: "tyre/savecomments",
        data: obj,
        completed: callback
    });
}
Tyre.prototype.getAvgRating = function (patternID, callback) {
    OGOO.Connect.request({
        url: "tyre/avgrating/" + patternID,
        completed: callback
    });
};
/**
 * Created by Uğur Uğurlu on 13.8.2015.
 */
"use strict";
var UI = function () {
    this.nextPage = 2;
    this.nextPricePage = 2;
    this.divArray = [];
    this.textTimer = null;
    this.textTimerCount = 0;
    this.homeSliderD = null;
    this.billMaxDate = 0;
}

UI.prototype.init = function () {
    var self = this;
    self.onPageLoad();
    self.onPageResize();
    self.pageInfo();
    self.permalinkControl();
    self.onPageScroll();
    self.tyreDetailSlider();
    self.setDropDownWidth();
    self.hoverAnimation($('.sponsored .clip'));

    // check default car type
    UI.prototype.checkedDefaultCarType();
    UI.prototype.resetSearchForm();

    // widthBySize change event
    $('#widthBySize').on('change', function (e) {
        var self = this;
        var widthBySize = $(this).val();
        $('#heightBySize').empty();

        // reset rim diameter
        var selectRimDiameterBySize = $('#rimDiameterBySize')
        selectRimDiameterBySize.html('<option value="">JANT ÇAPI</option>');
        var _selectRimDiameterBySize = new Select();
        _selectRimDiameterBySize.init(selectRimDiameterBySize);

        OGOO.UI.getHeightListBySize(widthBySize);
    });

    // heightBySize change event
    $('#heightBySize').on('change', function (e) {
        var self = this;
        var heightBySize = $(this).val();

        OGOO.UI.getRimDiameterListBySize(heightBySize);
    });

    // brandByCar change event
    $('#brandByCar').on('change', function (e) {
        var self = this;
        var brandByCar = $(this).val();

        // reset motor
        var selectMotorByCar = $('#motorByCar')
        selectMotorByCar.html('<option value="">MOTOR</option>');
        var _selectMotorByCar = new Select();
        _selectMotorByCar.init(selectMotorByCar);

        // reset year
        var selectYearByCar = $('#yearByCar')
        selectYearByCar.html('<option value="">MODEL YILI</option>');
        var _selectYearByCar = new Select();
        _selectYearByCar.init(selectYearByCar);

        OGOO.UI.getModelListByCar(brandByCar);
    });



    // modelByCar change event
    $('#modelByCar').on('change', function (e) {
        var self = this;
        var modelByCar = $(this).val();

        // reset motor
        var selectMotorByCar = $('#motorByCar')
        selectMotorByCar.html('<option value="">MOTOR</option>');
        var _selectMotorByCar = new Select();
        _selectMotorByCar.init(selectMotorByCar);

        OGOO.UI.getYearListByCar(modelByCar);
    });

    // yearByCar change event
    $('#yearByCar').on('change', function (e) {
        var self = this;
        var yearByCar = $(this).val();

        OGOO.UI.getMotorListByCar(yearByCar);
    });

    // tyre-car-type change event
    $("input[name='tyre-car-type']").on('change', function (e) {
        var self = this;

        if (self.id === 'car-4' || self.id === 'car-5') {
            $('#tyreSearchCar').addClass('tyre-search-by--disabled');

            $(".tyre-search-season-wrap").hide();

            if ($('#tyreSearchCar').hasClass('tyre-search-by--active')) {
                $('#tyreSearchCar').removeClass('tyre-search-by--active');
                $('#tyreSearchSize').addClass('tyre-search-by--active');
                $('#tyreSearchCarContent').removeClass('tyre-search-select--active');
                $('#tyreSearchSizeContent').addClass('tyre-search-select--active');
            }

        } else {
            $(".tyre-search-season-wrap").show();
            $('#tyreSearchCar').removeClass('tyre-search-by--disabled');
        }


        var getCarTypeId = $(this).attr('data-vehiclegroup');

        // reset motor
        var selectMotorByCar = $('#motorByCar')
        selectMotorByCar.html('<option value="">MOTOR</option>');
        var _selectMotorByCar = new Select();
        _selectMotorByCar.init(selectMotorByCar);

        // reset year
        var selectYearByCar = $('#yearByCar')
        selectYearByCar.html('<option value="">MODEL YILI</option>');
        var _selectYearByCar = new Select();
        _selectYearByCar.init(selectYearByCar);

        // reset model
        var selectModelByCar = $('#modelByCar')
        selectModelByCar.html('<option value="">MODEL</option>');
        var _selectModelByCar = new Select();
        _selectModelByCar.init(selectModelByCar);

        // reset rim diameter
        var selectRimDiameterBySize = $('#rimDiameterBySize')
        selectRimDiameterBySize.html('<option value="">JANT ÇAPI</option>');
        var _selectRimDiameterBySize = new Select();
        _selectRimDiameterBySize.init(selectRimDiameterBySize);

        // reset height
        var selectHeightBySize = $('#heightBySize')
        selectHeightBySize.html('<option value="">YÜKSEKLİK</option>');
        var _selectHeightBySize = new Select();
        _selectHeightBySize.init(selectHeightBySize);

        UI.prototype.getBrandListByCar(getCarTypeId);
        UI.prototype.getWidthListBySize(getCarTypeId);
    });

    // Play Videos JS
    $('#cPlay-video').on('click', function () {
        var videoURL = $('#c-ytplayer').attr('src'),
            dataplay = $('#c-ytplayer').attr('data-play');

        //for check autoplay
        //if not set autoplay=1
        if (dataplay == 0) {
            $('#c-ytplayer').attr('src', videoURL + '?autoplay=1');
            $('#c-ytplayer').attr('data-play', 1);
            $('.c-iframe__play').css({ opacity: 0 });
            $('.c-iframe__thumb').css({ opacity: 0 });
            $('.c-iframe').addClass("c-iframe--active");

        }
        else {
            var videoURL = $('#c-ytplayer').attr('src');
            videoURL = videoURL.replace("?autoplay=1", "");
            $('#c-ytplayer').prop('src', '');
            $('#c-ytplayer').prop('src', videoURL);

            $('#c-ytplayer').attr('data-play', 0);
        }

    });


    // Select Arrow

    $('#tyreSearchSize').on('click', function () {

        $('#tyreSearchCar').removeClass('tyre-search-by--active');

        if (!$(this).hasClass('tyre-search-by--active')) {
            $(this).addClass('tyre-search-by--active');
        }

        $('#tyreSearchSizeContent').addClass('tyre-search-select--active');
        $('#tyreSearchCarContent').removeClass('tyre-search-select--active');
    });

    $('#tyreSearchCar').on('click', function () {
        var getSelectedCarType = $('input[name=tyre-car-type]:checked').attr('data-vehiclegroup');

        if (getSelectedCarType !== 'Tractor' || getSelectedCarType !== 'Commercial') {
            $('#tyreSearchSize').removeClass('tyre-search-by--active');
            if (!$(this).hasClass('tyre-search-by--active')) {
                $(this).addClass('tyre-search-by--active');
            }
            $('#tyreSearchSizeContent').removeClass('tyre-search-select--active');
            $('#tyreSearchCarContent').addClass('tyre-search-select--active');
        }
    });


    // Sliders

    $('.c-slider').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 4000,
        appendDots: $(".c-slider-dots"),
        lazyLoad: 'ondemand'
    });

    if (typeof window.orientation !== "undefined") {
        if (window.matchMedia("(max-width: 767px)").matches) {

            $('.c-home__videos').slick({
                arrows: false,
                dots: true,
                autoplay: true,
                autoplaySpeed: 4000,
                appendDots: $(".c-home__videos-dots")
            });

            $('.c-home-products__card').slick({
                arrows: false,
                dots: true,
                autoplay: true,
                autoplaySpeed: 4000,
                appendDots: $(".c-home-products__dots")
            });

            $('.c-home-tyre-knowledge-slider').slick({
                arrows: false,
                dots: true,
                autoplay: true,
                autoplaySpeed: 4000,
                appendDots: $(".c-home-tyre__dots")
            });
        }

    }

    $('#cBannerSlider').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 4000,
        appendDots: $(".c-slider-dots--banner"),
        lazyLoad: 'ondemand'
    });

    // Homepage Product Family Slider
    $('#productFamilySlider').slick({
        dots: true,
        arrows: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        dotsClass: "c-home-product-family__slider-dots",
        appendDots: $('.c-title--product-family'),
        lazyLoad: 'ondemand',
        autoplay: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });


    window.addEventListener("orientationchange", function () {
        if (window.innerHeight > innerWidth) {
            self.checkOrientation("portrait");
        } else {
            self.checkOrientation("landscape");
        }
    }, false);

    if ($('.dealer-finder').hasClass('detail')) {
        $('#map-canvas').height(OGOO.Helper.getScreenSize().h - 150);
        if (!OGOO.Helper.mapIsLoading()) {
            var script = document.createElement("script");
            var e = document.getElementById("map-canvas");
            script.type = "text/javascript";
            script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDZZHwxXryKMg3GSS8q9bozcISkQBoXKHo&sensor=true&libraries=drawing&sensor=false&language=tr&callback=initMap";
            e.parentNode.insertBefore(script, e)
        }
    } else {
        $('#map-canvas').height(OGOO.Helper.getScreenSize().h - 271);
    }
    $('.selectors').css("top", OGOO.Helper.getScreenSize().h - $('.selectors').height());
    $('.selectors-mobile').css("top", OGOO.Helper.getScreenSize().h - $('.selectors-mobile').height());
    self.dealerSearch();

    $('.form-types > div').hide();
    $('.form-types > div:first').show();
    $('.form-tabs').find('a').each(function (key) {
        $(this).on('click', function (e) {
            e.preventDefault();

            if (!$(this).hasClass('active')) {
                var getClassName = $(this).parent().attr('class');
                if (getClassName == 'searchTyreRegister') {
                    // reset register form
                    var form = $('#tyre-insurance-form');
                    form.trigger("reset");
                    form.show();
                    grecaptcha.reset(recaptcha1);
                    $('#insuranceProductBrand').prop('selectedIndex', 2);
                    var select = form.find('select');
                    var _select = new Select();
                    _select.init(select);
                    $('.c-warranty-success').hide();
                } else if (getClassName == 'searchTyreInquire') {
                    // reset search form
                    var form = $('#get-tyre-insurance-form');
                    form.trigger("reset");
                    $('#insuranceResults').html('');
                }

                $('.form-tabs').find('a').removeClass('active');
                $(this).addClass('active');
                $('.form-types > div').hide();
                $('.form-types > div').eq(key).show();
            }
        });
    });

    // control for open form tab when open tyre insurance page
    if (window.location.search == '?l=lassa-lastik-sigortasi' || window.location.search == '?l=arti-bir-yil-garanti-kampanyasi-hakkinda') {
        $('.form-types > div').hide();
        $('.form-types > div').eq(1).show();
    }

    // tyre links in about section
    $('#showTyreInsuranceRegister').on('click', function () {

        $('.form-tabs').find('a').removeClass('active');
        $('.searchTyreRegister a').addClass('active');
        $('.form-types > div').hide();
        $('.form-types > div').eq(1).show();

        $('body, html').animate({
            scrollTop: $('.contact-form--insurance').offset().top
        }, 1000);

        // reset register form
        var form = $('#tyre-insurance-form');
        form.trigger("reset");
        form.show();
        grecaptcha.reset(recaptcha1);
        $('#insuranceProductBrand').prop('selectedIndex', 2);
        var select = form.find('select');
        var _select = new Select();
        _select.init(select);
        $('.c-warranty-success').hide();

    });

    $('#showTyreInsuranceSearch').on('click', function () {

        $('.form-tabs').find('a').removeClass('active');
        $('.searchTyreInquire a').addClass('active');
        $('.form-types > div').hide();
        $('.form-types > div').eq(2).show();

        // reset search form
        var form = $('#get-tyre-insurance-form');
        form.trigger("reset");
        $('#insuranceResults').html('');

    });

    $('.phone').inputmask('0(999)999 99 99');
    //$('.email').inputmask({alias: "email"});
    $('.int').inputmask({
        alias: "Regex",
        regex: '^[0-9]+$'
    });
    $('.string').inputmask({
        alias: "Regex",
        regex: '^[a-zA-ZçÇıİğĞöÖşŞüÜ ]+$'
    });
    $('.alpha').inputmask({
        alias: "Regex",
        regex: '^[a-zA-ZçÇıİğĞöÖşŞüÜ0-9 ]+$'
    });


    $('#send-comment').bValidator();
    $('.send-button').off('click').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        var obj = OGOO.Helper.convertObject(form);
        var recaptcha = true;
        if (form.data('bValidator').validate()) {
            $.each(obj, function (k, v) {
                if (k.toString() == "g-recaptcha-response") {
                    if (v != "") {
                        recaptcha = true;
                    }
                    delete obj[k];
                }
            })
            if (recaptcha) {
                $('.captcha-area').removeAttr('style');
                $('.rating-error').remove();
                obj.performancerating = $('.rating-container:visible .caption .label').text();
                if (parseFloat(obj.performancerating) > 0) {
                    OGOO.Tyre.saveComments(obj, function (result) {
                        if (result.status.message == "Succeed") {
                            $('.interaction-form').slideUp(300);
                            setTimeout(function () {
                                $('.interaction-result').slideDown(300);
                                $('.comment-control-button').removeClass('active');
                            }, 500)
                            form.find('select, input, textarea').not($('[type="hidden"]')).each(function () {
                                $(this).val("");
                            });
                            grecaptcha.reset();
                            OGOO.Tyre.getAvgRating(obj.patterncode, function (result) {
                                var pointText = result.averageperformanceratingasstring;
                                var pointData = result.averageperformanceratingforjs;
                                var totalPoint = 5;
                                var percentage = ((pointData / totalPoint) * 100) + "%";
                                $('.rate-text').text(pointText);
                                $('.filled-stars').animate({
                                    width: percentage
                                }, 'slow');
                            });
                        } else {
                            //hata ekranı
                        }
                        setTimeout(function () {
                            $('.interaction-result').slideUp(300);
                        }, 10000)
                    });
                }
                else {
                    $('.rating-text').parent().append('<div class="rating-error">Lütfen ürün için puan verin</div>');
                }

            }
            else {
                $('.captcha-area').css('border', '1px solid #FFABAE');

            }
        }
    });

    $('.comment-control-button').off('click').on('click', function () {
        grecaptcha.reset();
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.interaction-form').slideUp(300);
        }
        else {
            $(this).addClass('active');
            $('.interaction-result').slideUp(300);
            $('.interaction-form').slideDown(300);
        }
    })
    $('.col-lg-5 .dealer-item').on('click', function () {
        $('.col-lg-7 .dealer-item .button').removeClass('red');
        $('.col-lg-5 .dealer-item .button').addClass('red');

    });
    $('.col-lg-7 .dealer-item').on('click', function () {
        $('.col-lg-5 .dealer-item .button').removeClass('red');
        $('.col-lg-7 .dealer-item .button').addClass('red');

    });
    //$('.col-lg-5 .dealer-item').on('click', function () {

    //    if ($('.col-lg-7 .dealer-item .button').hasClass('blue')) {
    //        $('.col-lg-5 .dealer-item .button').removeClass('red');
    //        $('.col-lg-7 .dealer-item .button').removeClass('blue');
    //    }
    //    else {
    //        $('.col-lg-5 .dealer-item .button').addClass('red');
    //    }
    //})
    //$('.col-lg-7 .dealer-item').on('click', function () {

    //    if ($('.col-lg-5 .dealer-item .button').hasClass('red')) {
    //        $('.col-lg-7 .dealer-item .button').removeClass('red');
    //        $('.col-lg-5 .dealer-item .button').removeClass('red');
    //    }
    //    else {
    //        $('.col-lg-7 .dealer-item .button').addClass('blue');
    //    }
    //})

    $('#DealerKeywordMenu').keypress(function (e) {
        if (e.which == 13) {//Enter key pressed
            $('.col-lg-5 .dealer-item .button').click();//Trigger search button click event
        }
    });
    $('.move-comment-area').off('click').on('click', function () {
        $('html, body').animate({
            scrollTop: $(".interaction-detail").offset().top - 110
        }, 1000);
    })

    $('body').on('click', '.message i', function () {
        $('.message').hide();
    });
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $('body').off('click touchstart').on('click touchstart', function (e) {
            if ($('.menu-icon a').hasClass('active')) {
                if (!$(e.target).closest('.menu, .menu-icon ').length) {
                    $('.menu-icon a').trigger('click');
                }
            }
        });
    }


    $('.store-request').on('change', function () {
        if ($(this).prop('checked')) {
            $('.store-area').removeClass('hidden');
            $('#Subject').val("8829aa34-aa2b-e111-b25c-005056b853b9");
            var select = new Select(true);
            select.init($("#Subject"));
        } else {
            $('.store-area').addClass('hidden');
            $('.store-area').find('input, select, textarea').each(function () {
                $(this).val("");
            });
            var select = new Select();
            select.init($("#Subject"));
            $(this).parents('form').find('#Subject').val("");
        }
    });
    if ($('.counter').length > 0) {
        var data = $('#counterValue').data();
        var date = data.counter;
        date = date.replace(/\./g, '/')
        $('.counter').countdown(date).on('update.countdown', function (event) {
            var $this = $(this).html(event.strftime(''
                + '<span>%D <i></i></span>'
                + '<span>%H <i></i></span>'
                + '<span>%M <i></i></span>'));
        });
    }


    $('.share-area > a').mouseenter(function () {
        $(this).hide();
        $(this).next().show();
    })
    $('.share-area').mouseleave(function () {
        $(this).children('a').show();
        $(this).children('div').hide();
    })


    if ($('.sponsored-announcement-area').length > 0) {
        var fullLength = 12;
        var itemLength = $('.sponsored-announcement-area .row > div').length;
        var colValue = fullLength / itemLength;
        $('.sponsored-announcement-area .row > div').each(function () {
            if (itemLength <= 2) {
                $(this).addClass('split-content')
            }
            else if (itemLength <= 4) {
                $(this).removeClass('col-lg-12').addClass('col-lg-' + colValue + '');
            }
            else {
                $(this).removeClass('col-lg-12').addClass('col-lg-3');
            }
        });
    }

    if ($('.sponsored-photos').length > 0) {
        $('.sponsored-photos img').each(function (key) {
            if (key > 3) {
                $(this).closest('div').hide();
            }
        })
    }



    $('.show-video').off('click').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        var isMobile = $(this).siblings('.image').height() != 320 ? true : false;
        if (isMobile) {
            var height = $(this).siblings('.image').height();
            var videoContent = '<iframe class="videoselector" width="320" height="180" src="' + url + '?autoplay=1" frameborder="0" allowfullscreen></iframe>';
            $(this).parent().append(videoContent)

        }
        else {
            var videoContent = '<iframe width="640" height="480" src="' + url + '?autoplay=1" frameborder="0" allowfullscreen></iframe>';
            $('#videoplayer').modal('show');
            $('.page').css('zIndex', 'initial');
            //var videoContent = "<video preload='yes' width='640' height='480' preload='auto' class='video-js vjs-default-skin' data-setup='{}' autoplay='autoplay' id='player' controls><source src='/Assets/mov_bbb.mp4' type='video/mp4'></video>"

            $('#videoplayer .modal-body').append(videoContent)
            //var player = videojs('player', {/* Options */}, function () {
            //	this.play();
            //	this.on('ended', function () {
            //		player.dispose();
            //		$('.modal-body').html('');
            //		$('.modal').trigger('click');
            //	});
            //});
            $('#videoplayer').on('hidden.bs.modal', function () {
                $('#videoplayer .modal-body').html('');
                $('.page').removeAttr('style');
                player.dispose();
            });
        }

    })
    $('#videoplayer').on('click', function (e) {
        $('.loader').remove();
    });

    if ($('.whylassa-detail').length > 0) {
        if ($(window).width() >= 768) {
            if (document.cookie.replace(/(?:(?:^|.*;\s*)nedenLassaLightbox\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
                // trigger lightbox
                if ($(window).width() >= 768) {
                    setTimeout(function () {
                        document.cookie = "nedenLassaLightbox=true; expires=Fri, 31 Dec 9999 23:59:59 GMT";
                        $('.show-video').trigger('click');
                    }, 300);

                }

            }

        }
    }

    // Home Page Video Modal
    //if ($('.home-video').length > 0) {

    //    if ($(window).width() >= 768) {
    //        if (document.cookie.replace(/(?:(?:^|.*;\s*)competusLightbox5\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
    //            // trigger lightbox
    //            if ($(window).width() >= 768) {
    //                var iframe = '<iframe width="560" height="315"  allow="autoplay; encrypted-media" src="https://www.youtube.com/embed/Pulk0psr7o4?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>';
    //                $('#videoplayer').find('.modal-body').append(iframe);

    //                setTimeout(function () {
    //                    document.cookie = "competusLightbox5=true; expires=Fri, 31 Dec 9999 23:59:59 GMT";
    //                    $('#videoplayer').modal('show');
    //                    $('.page').css('z-index', 'initial');
    //                }, 300);

    //            }


    //        }

    //    }

    // Home Page Image Modal
    //if ($('.home-modal-image').length > 0) {

    //    if ($(window).width() <= 1920) {
    //        if (document.cookie.replace(/(?:(?:^|.*;\s*)videoModalCookie1\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
    //            // trigger lightbox
    //            if ($(window).width() <= 1920) {

    //                // Youtube Embed Code
    //                var youtube = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/DCu6NFz6Auc"  srcdoc="<style>*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style><a href=https://www.youtube.com/embed/DCu6NFz6Auc?autoplay=1><img src=https://img.youtube.com/vi/DCu6NFz6Auc/hqdefault.jpg ><span>▶</span></a>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    //                // Image
    //                var iframe = '<a href="/konu-itibarsa-lider-lassa"><img src="assets/Images/lassa-itibar.jpg" class="img-responsive"></a> ';
    //                $('#videoplayerModal').find('.modal-body').append(youtube);


    //                setTimeout(function () {
    //                    document.cookie = "videoModalCookie1=true; expires=Fri, 18 Dec 2038 23:59:59 GMT";
    //                    $('#videoplayerModal').modal('show');
    //                    $('.page').css('z-index', 'initial');
    //                }, 300);
    //            }
    //        }
    //    }

    //    $('.c-modal-video-close').on('click', function () {
    //        $('#videoplayerModal .modal-body').remove();
    //    });

    //    // Home Page Slider Video Modal
    //    $('.show-video1').on('click', function (e) {
    //        e.preventDefault();


    //        if ($(window).width() >= 768) {

    //            var iframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/Pulk0psr7o4?rel=0&autoplay=1&ecver=2" frameborder="0" allowfullscreen></iframe>';
    //            if (
    //                $('#videoplayer').find('.modal-body').html().trim() == '') {

    //                $('#videoplayer').find('.modal-body').append(iframe);
    //            }
    //            setTimeout(function () {
    //                document.cookie = "competusLightbox6=true; expires=Fri, 31 Dec 9999 23:59:59 GMT";
    //                $('#videoplayer').modal('show');
    //                $('.page').css('z-index', 'initial');


    //            }, 300);

    //        }

    //    });
    //}



    $(".home-video").on('hidden.bs.modal', function (e) {
        $('#videoplayer').find('.modal-body').empty();
    });

    if ($('.competus-detail').length > 0) {
        if ($(window).width() >= 768) {
            if (document.cookie.replace(/(?:(?:^|.*;\s*)nedenLassaLightbox\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
                var link = document.location.href.split('/');
                // trigger lightbox
                if ($(window).width() >= 768) {
                    setTimeout(function () {
                        document.cookie = "nedenLassaLightbox=true; expires=Fri, 31 Dec 9999 23:59:59 GMT;path=/desen/" + link[link.length - 1];
                        //$('.show-video').trigger('click');
                    }, 300);

                }

            }

        }
    }
    if ($('.homevid').length > 0) {
        if ($(window).width() >= 768) {
            if (document.cookie.replace(/(?:(?:^|.*;\s*)nedenLassaLightbox\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
                var link = document.location.href.split('/');
                // trigger lightbox
                if ($(window).width() >= 768) {
                    setTimeout(function () {
                        document.cookie = "competusLightbox6=true; expires=Fri, 31 Dec 9999 23:59:59 GMT";
                        //$('.show-video').trigger('click');
                    }, 300);

                }

            }

        }
    }
    if ($('.comptyre-detail').length > 0) {
        if ($(window).width() >= 768) {
            if (document.cookie.replace(/(?:(?:^|.*;\s*)neden2LassaLightbox\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true") {
                var link = document.location.href.split('/');
                // trigger lightbox
                if ($(window).width() >= 768) {
                    setTimeout(function () {
                        document.cookie = "neden2LassaLightbox=true; expires=Fri, 31 Dec 9999 23:59:59 GMT;path=/lastik/" + link[link.length - 1];
                        $('#videoplayer').modal('show');
                        $('.show-video').trigger('click');
                    }, 300);

                }

            }

        }
    }
    $('select[name="City"]').each(function (key) {
        $(this).on('change', function () {
            var t = $(this);
            var val = t.val();
            OGOO.Customized.countyByCityCode(val, function (result) {
                var select = t.parent().parent().siblings().find('select[name="County"]');
                select.empty();
                select.append('<option value="">İlçe Seçiniz</option>');
                result.data.forEach(function (district) {
                    select.append('<option value="' + district.id + '">' + district.name + '</option>');
                });
                var _select = new Select();
                _select.init(select)
            });
        });
    });
    $('select[name="DealerCity"], select[name="DealerCityMenu"]').each(function (key) {
        $(this).on('change', function () {
            var t = $(this);
            var val = t.val();
            OGOO.Customized.dealerCountyByCityCode(val, function (result) {
                var select = t.attr('name') == 'DealerCity' ? $('select[name="DealerCounty"]') : $('select[name="DealerCountyMenu"]');
                select.empty();
                select.append('<option value="">İlçe Seçiniz</option>');
                result.data.forEach(function (district) {
                    select.append('<option value="' + district.id + '">' + district.name + '</option>');
                });
                var _select = new Select();
                _select.init(select)
                OGOO.LassaMap.getDealerData({ cityid: val }, true);
            });
        });
    });
    $('select[name="DealerCounty"],select[name="DealerCountyMenu"]').each(function (key) {
        $(this).on('change', function () {
            var t = $(this);
            var val = t.val();
            var cityVal = t.attr('name') == 'DealerCounty' ? $('select[name="DealerCity"]').val() : $('select[name="DealerCityMenu"]').val();
            OGOO.LassaMap.getDealerData({ countyid: val, cityid: cityVal }, true);
        });
    });


    $('.menuSearchBtn').off('click').on('click', function (e) {
        e.preventDefault();
        var t = $(this).attr("data-val");
        var k = $("#DealerKeywordMenu").val();
        var ci = $("#DealerCityMenu").val();
        var co = $("#DealerCountyMenu").val();
        OGOO.Customized.setDealerParams({ type: t, keyword: k, county: co, city: ci }, function (result) {
            if (result.status.message == "Succeed") {
                document.location.href = "/bayi-bulucu";
            }
        })
    });

    $('#personal-form, #company-form, #tyre-insurance-form, #pdpa-tyre-insurance-form').bValidator();
    var isFormSend = false;
    $('.send-form').off('click').on('click', function (e) {
        if ($('.send-form').data("isactive") == "false") {
            e.preventDefault();
        }
        else {
            e.preventDefault();
            if (!isFormSend) {
                var form = $(this).parents('form');
                var obj = OGOO.Helper.convertObject(form);
                obj.recaptcha = obj['g-recaptcha-response'];
                delete obj['g-recaptcha-response'];
                var response = grecaptcha.getResponse($($($($(this).parent()).parent()).parent()).attr("id") == "company-form" ? recaptcha2 : recaptcha1);

                if (form.data('bValidator').validate()) {
                    //var response = grecaptcha.getResponse();
                    if (response.length != 0) {

                        isFormSend = true;
                        $(".send-form").text("Gönderiliyor...");

                        $('.message').remove();
                        form.append('<div class="message"></div>');
                        OGOO.Service.contactForm(obj, function (result) {


                            if (result.status.message == "Succeed") {

                                $('.message').addClass('success').html("Mesajını başarı ile gönderilmiştir. En kısa zamanda sizinle iletişim kurulacaktır. <i></i>");
                                form.find('select, input, textarea').each(function () {
                                    $(this).val("");
                                });
                                $('.message iframe').remove();
                                $('.message').append('<iframe width="100" height="100" src="/View/Templates/iletisim-formu.html" style="visibility:hidden;"></iframe>');
                            } else {
                                $('.message').addClass('error').html("Mesajınız gönderilirken bir hata oluştu. <i></i>");
                            }
                            $(".send-form").text("GÖNDER");
                            grecaptcha.reset(recaptcha1);
                            grecaptcha.reset(recaptcha2);
                            $('.message').attr("data-sec", 0);
                            setInterval(function () {
                                var counter = $('.message').data("sec");
                                if (counter >= 2) {
                                    location.reload();
                                }
                                else {
                                    $('.message').data("sec", (counter + 1))
                                }
                            }, 1000);
                            setTimeout(function () {
                                $('.message').fadeOut('fast');
                            }, 3000);

                        });

                    }
                    else {
                        var form = $(this).parents('form');
                        form.append('<div class="message"></div>');
                        $('.message').addClass('error').html("'Lütfen Ben Robot Değilim' kutusunu işaretleyiniz. <i></i>");
                        if ($('.send-form').attr('data-isactive') != "true" && $('.send-form').attr('data-isactive') != "false") {
                            $('.send-form').attr('data-isactive', 'false');
                        }

                        setTimeout(function () {
                            $('.message').fadeOut('fast');
                        }, 5000)
                        $('.send-form').data('isactive', 'false');
                        $('.message').attr("data-errorsec", 0);
                        if (true) {

                        }

                        var myInterval = setInterval(function () {
                            var counter = $('.message').data("errorsec");
                            if (counter >= 5) {
                                $('.message').data("errorsec", 0);
                                $('.send-form').data('isactive', 'true');
                                clearInterval(myInterval);
                            }
                            else {
                                $('.message').data("errorsec", (counter + 1))
                            }
                        }, 1000);



                    }
                }
                else {
                    $(".form-types").nanoScroller({ scrollTop: 0 });
                    $('.message').addClass('error').html("Lütfen zorunlu alanları doldurun.<i></i>");
                    setTimeout(function () {
                        $('.message').fadeOut('fast');
                    }, 5000)
                }
            }
        }

    });

    $('.popular').bxSlider({
        maxSlides: 3,
        slideWidth: 250,
        pager: false,
        nextSelector: '#tyre-next',
        prevSelector: '#tyre-prev',
        nextText: '',
        prevText: ''
    });
    self.pageListeners();
    self.tyreFilter();
    self.setMobileContent();
    self.mobileControl();

    if ($('body').hasClass('home')) {
        setTimeout(function () {

            $('.tyre-selector').find('a').addClass('animate').css('visibility', 'visible');
            setTimeout(function () {
                $('.dealer-selector').find('a').addClass('animate').css('visibility', 'visible');
            }, 200);
        }, 1500);
    }
    else {
        $('.tyre-selector, .dealer-selector').find('a').css('visibility', 'visible');
    }


    $('select[name="width"]').on("change", function () {
        var val = $(this).val();
        if (val != null) {
            self.aspectratio(val);
        }
    });

    $('.sponsored-photos a').fancybox();

    $('#filter-form, #filter-form-mobile').submit(function (e) {
        e.preventDefault();
    });
    $('.filter-submit').on('click', function () {
        $(this).val("YÜKLENİYOR").attr("disabled");
        var form = OGOO.Helper.isMobile() ? $('#filter-form-mobile') : $('#filter-form');
        var queryObject = OGOO.Helper.queryStringToJSON(form.serialize());
        if (history.pushState) {
            Object.keys(queryObject).forEach(function (item) {
                if (item != "tyrelistingtype" && item != "tyregrouptype") {
                    OGOO.Helper.queryStringObject[item] = queryObject[item];
                }
            });
        }
        setTimeout(function () {
            OGOO.Tyre.getFriendlyPath({
                'tyrelistingtype': 'TyreSize',
                'tyregrouptype': queryObject.tyregrouptype
            }, function (result) {
                if (result.status.code == '0') {

                    delete queryObject.tyrelistingtype;
                    delete queryObject.tyregrouptype;
                    window.top.location.href = '/' + result.data.tyrecategorylink + '?' + $.param(queryObject);
                }
                else {
                    $(this).val("ARA")
                }
            });
        }, 100);
    });
    if ($('.tyre-template').length > 0) {
        self.processSorting();
    }
    self.changeTextHeight();
    $('.vertical-text').css("opacity", 0);


    /****** Video Modal JS ******/

    /**** Closed due to c-banner on HomePage. */

    $(document).on('click', '#video-button', function () {
        var html = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/vBdBzp4hCXk?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $('.video-modal').html(html);
        $('#video-modal').modal('show');
    });
    $('#video-modal').on('hidden.bs.modal', function (e) {
        $('.video-modal').html('');
    });

    // Cookie Expired

    if (typeof $.cookie('VideoModalCookie') == 'undefined') {
        $("#video-button").trigger("click");

        $(".c-modal-video-close").click(function () {
            $("#video-modal").modal("hide");
        });

        $.cookie('VideoModalCookie', 'true', { expires: 2, path: '/' });
    }

    // End Cookie Expired

    /***** End Video Modal JS ****/

    // search form

    if (typeof window.orientation !== "undefined") {
        $('body').on('click', function () {
            $('.tyre-search-submit-btn').data("trigger", "focus");
        });
    }

    $('#tyreSearchForm').on('submit', function (e) {
        e.preventDefault()
        var obj = OGOO.Helper.convertObject($(this));
        var getSearchType = $('.tyre-search-by--active').attr('data-value');
        var getSeason = $('input[name=seasonTyre]:checked').data("value");
        var seasonValue;

        /**
          * Car Type Required Controls
          **/

        var brandByCar = $('#brandByCar').val();
        var modelByCar = $('#modelByCar').val();

        var hasRequiredField = false;

        // Warning Tooltip

        if ((brandByCar === '' || modelByCar === '') && getSearchType === 'car') {
            hasRequiredField = true;
            $('.tyre-search-submit-btn').tooltip('show');

            setTimeout(function () {
                $('.tyre-search-submit-btn').tooltip('hide');
            }, 2000);
        } else {
            $('.tyre-search-submit-btn').tooltip('hide');
        }

        /**
           * End Car Type Required Controls
           **/

        if (!hasRequiredField) {
            // check season
            if (typeof getSeason !== 'undefined') {
                if (getSeason === 'summer') {
                    seasonValue = "01";
                } else if (getSeason === 'winter') {
                    seasonValue = "02";
                } else {
                    seasonValue = "03";
                }
            }

            var getWidth = obj.widthBySize;
            var getWidthUrl = $('#widthBySize').find(':selected').data('url');

            var getHeight = obj.heightBySize;
            var getHeightUrl = $('#heightBySize').find(':selected').data('url');

            var getRimDiameter = obj.rimDiameterBySize;
            var getRimDiameterUrl = $('#rimDiameterBySize').find(':selected').data('url');

            var getMotor = obj.motorByCar;
            var getMotorUrl = $('#motorByCar').find(':selected').data('url');

            var getYear = obj.yearByCar;
            var getYearUrl = $('#yearByCar').find(':selected').data('url');

            var getModel = obj.modelByCar;
            var getModelUrl = $('#modelByCar').find(':selected').data('url');

            var getBrand = obj.brandByCar;
            var getBrandUrl = $('#brandByCar').find(':selected').data('url');

            obj.searchType = getSearchType;

            switch (getSearchType) {
                case 'size':
                    if (typeof getRimDiameter !== 'undefined' && typeof getRimDiameterUrl !== 'undefined') {
                        if (getRimDiameter !== '' && getRimDiameterUrl !== '') {
                            window.location.href = getRimDiameterUrl + "?season=" + seasonValue;
                        }

                    } else if (typeof getHeight !== 'undefined' && typeof getHeightUrl !== 'undefined') {
                        if (getHeight !== '' && getHeightUrl !== '') {
                            window.location.href = getHeightUrl + "?season=" + seasonValue;
                        }

                    } else if (typeof getWidth !== 'undefined' && typeof getWidthUrl !== 'undefined') {
                        if (getWidth !== '' && getWidthUrl !== '') {
                            window.location.href = getWidthUrl + "?season=" + seasonValue;
                        }
                    }
                    break;

                case 'car':
                    if (typeof getMotor !== 'undefined' && typeof getMotorUrl !== 'undefined') {
                        if (getMotor !== '' && getMotorUrl !== '') {
                            window.location.href = getMotorUrl + "?season=" + seasonValue;
                        }

                    } else if (typeof getYear !== 'undefined' && typeof getYearUrl !== 'undefined') {
                        if (getYear !== '' && getYearUrl !== '') {
                            window.location.href = getYearUrl + "?season=" + seasonValue;
                        }

                    } else if (typeof getModel !== 'undefined' && typeof getModelUrl !== 'undefined') {
                        if (getModel !== '' && getModelUrl !== '') {
                            window.location.href = getModelUrl + "?season=" + seasonValue;
                        }
                    } else if (typeof getBrand !== 'undefined' && typeof getBrandUrl !== 'undefined') {
                        if (getBrand !== '' && getBrandUrl !== '') {
                            window.location.href = getBrandUrl + "?season=" + seasonValue;
                        }
                    }
                    break;
            }
        } else {
            // show error
        }

    });

    /**
    * tyre
    */

    if (location.href.indexOf("lastik-sigortasi") > -1) {
        self.GetInsuranceDealerCity();
        self.GetInsuranceProductBrands();
        self.GetInsuranceRimDiameters();
        self.GetInsuranceVehicleBrands();
        self.GetInsurancePatterns();
    }

    $('#insuranceCity').on('change', function (e) {
        var self = this;
        var cityId = $(this).val();

        OGOO.UI.GetInsuranceCounty(cityId);
    });

    /**
    * List Tyre Insurance Dealer For About Tab 
    **/
    $('#insuranceDealerCity').on('change', function (e) {
        var self = this;
        var cityId = $(this).val();

        OGOO.UI.GetInsuranceDealerCounty(cityId);
    });

    var countyIDList = [];


    $('#insuranceDealerCounty').on('change', function (e) {
        var self = this;

        $('#listDealer').removeAttr("disabled");

        countyIDList = [];

        var countyId = $(this).val();
        countyIDList.push(countyId);

    });

    $('#listDealer').on('click', function (e) {
        e.preventDefault();

        var cityId = $('#insuranceDealerCity').val();

        OGOO.UI.GetInsuranceDealers(countyIDList[0], cityId);
    });

    /**
       * End List Tyre Insurance Dealer For About Tab 
       **/

    // insuranceDealer
    $('#insuranceDealer').on('change', function (e) {
        var self = this;
        var dealerId = $(this).val();

        OGOO.UI.GetInsuranceDealersByCustomerTypeFilter(dealerId, function (result) {
            $('#insuranceDealerCustomerType').val(result);
        });
    });

    $('#insuranceVehicleBrand').on('change', function (e) {
        var self = this;
        var modelId = $(this).val();

        OGOO.UI.GetInsuranceVehicleModel(modelId);
    });

    $('#send-insurance-form').off('click').on('click', function (e) {
        e.preventDefault();

        // check bill date
        var getSelectedDateInput = $('#billDate').val();
        var selectedDate = moment(getSelectedDateInput, "DD-MM-YYYY").format();
        var offsetDate = moment().subtract(15, 'days').format();
        var getFileBillSize = $('#fileBill').attr('data-file-size');
        var getFileLicenseSize = $('#fileLicense').attr('data-file-size');

        // file upload extension validate
        var allowedFiles = [".doc", ".docx", ".pdf", ".jpg", ".png", ".jpeg"];
        var fileUpload = $("#fileBill");
        var fileLicenseUpload = $("#fileLicense");
        var regex = new RegExp("(" + allowedFiles.join('|') + ")$");
        // Endfile upload extension validate

        if (getFileBillSize > 8000000) {
            $('.content').append('<div class="message"></div>');
            $('.message').addClass('error').html("Fatura dosya boyutu 8 mb'dan büyük olamaz. <i></i>");
            setTimeout(function () {
                $('.message').fadeOut('fast');
                $('.message').remove();
            }, 3000);
        } else if (getFileLicenseSize > 8000000) {
            $('.content').append('<div class="message"></div>');
            $('.message').addClass('error').html("Ruhsat dosya boyutu 8 mb'dan büyük olamaz. <i></i>");
            setTimeout(function () {
                $('.message').fadeOut('fast');
                $('.message').remove();
            }, 3000);
        } else if (!regex.test(fileUpload.val().toLowerCase())) {
            // extension control
            $('.content').append('<div class="message"></div>');
            $('.message').addClass('error').html("Geçerli dosya türleri: " + allowedFiles.join(', ') + "");
            setTimeout(function () {
                $('.message').fadeOut('fast');
                $('.message').remove();
            }, 3000);
        } else if (!regex.test(fileLicenseUpload.val().toLowerCase())) {
            // extension control
            $('.content').append('<div class="message"></div>');
            $('.message').addClass('error').html("Geçerli dosya türleri: <b>" + allowedFiles.join(', ') + "</b>.");
            setTimeout(function () {
                $('.message').fadeOut('fast');
                $('.message').remove();
            }, 3000);
        } else if (selectedDate < offsetDate) {
            $('.content').append('<div class="message"></div>');
            $('.message').addClass('error').html("Fatura tarihi 15 günden eski olamaz. <i></i>");
            setTimeout(function () {
                $('.message').fadeOut('fast');
                $('.message').remove();
            }, 3000);
        } else {
            // if bill date is correct
            var form = $('#tyre-insurance-form');
            var recaptchaResponse = grecaptcha.getResponse(form[0].id == "company-form" ? recaptcha2 : recaptcha1);
            //var response = grecaptcha.getResponse($($($($(this).parent()).parent()).parent()).attr("id") == "company-form" ? recaptcha2 : recaptcha1);
            $('.content').append('<div class="message"></div>');
            OGOO.UI.preloader("start");

            if (form.data('bValidator').validate()) {
                // validate
                if (recaptchaResponse.length != 0) {
                    // get campaign source id
                    $('#insuranceCampaignSourceId').val(campaignSourceId);

                    $('#tyre-insurance-form').ajaxSubmit({
                        beforeSend: function () {
                            $('#tyre-insurance-form').bValidator();
                        },
                        uploadProgress: function (event, position, total, percentComplete) {
                        },
                        success: function () {
                        },
                        complete: function (xhr) {
                            var response = xhr.responseJSON;

                            // hide loader
                            OGOO.UI.preloader("stop");

                            if (response.status.message === 'Succeed') {
                                // Success
                                form.hide();
                                $('.c-warranty-success').show();
                                grecaptcha.reset(recaptcha1);
                                form.trigger("reset");
                                var select = form.find('select');
                                $('#insuranceProductBrand').prop('selectedIndex', 3);
                                var _select = new Select();
                                _select.init(select);
                            }
                            else {
                                // Error
                                if (!response.data.success) {
                                    $('.message')
                                        .removeClass('success')
                                        .addClass('error')
                                        .html(response.data.message);

                                    setTimeout(function () {
                                        $('.message').fadeOut('fast');
                                    }, 5000);
                                }
                            }

                        }
                    });
                } else {
                    // google recaptcha
                    OGOO.UI.preloader("stop");
                    $('.message').addClass('error').html("Lütfen 'Ben Robot Değilim' kutusunu işaretleyiniz. <i></i>");
                    setTimeout(function () {
                        $('.message').fadeOut('fast');
                    }, 5000);
                }
            } else {
                // not validate
                OGOO.UI.preloader("stop");
                $('.message').addClass('error').html("Lütfen zorunlu alanları doldurun.<i></i>");
                setTimeout(function () {
                    $('.message').fadeOut('fast');
                }, 5000);
            }
        }

    });

    $('#send-pdpa-insurance-form').off('click').on('click', function (e) {
        e.preventDefault();

        var form = $('#pdpa-tyre-insurance-form');
        var recaptchaResponse = grecaptcha.getResponse(form[0].id == "company-form" ? recaptcha2 : recaptcha1);
        //var response = grecaptcha.getResponse($($($($(this).parent()).parent()).parent()).attr("id") == "company-form" ? recaptcha2 : recaptcha1);
        $('.content').append('<div class="message"></div>');
        OGOO.UI.preloader("start");

        console.log(form);
        console.log(form.data('bValidator'));

        if (form.data('bValidator').validate()) {
            // validate
            if (recaptchaResponse.length != 0) {
                // get campaign source id
                $('#insuranceCampaignSourceId').val(campaignSourceId);

                $('#pdpa-tyre-insurance-form').ajaxSubmit({
                    beforeSend: function () {
                        $('#pdpa-tyre-insurance-form').bValidator();
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                    },
                    success: function () {
                    },
                    complete: function (xhr) {
                        var response = xhr.responseJSON;

                        // hide loader
                        OGOO.UI.preloader("stop");

                        if (response.status.message === 'Succeed') {
                            // Success
                            form.hide();
                            $('.c-warranty-success').show();
                            grecaptcha.reset(recaptcha1);
                            form.trigger("reset");
                            var select = form.find('select');
                            $('#insuranceProductBrand').prop('selectedIndex', 3);
                            var _select = new Select();
                            _select.init(select);
                        } else {
                            // Error
                            if (!response.data.success) {
                                $('.message')
                                    .removeClass('success')
                                    .addClass('error')
                                    .html(response.data.message);

                                setTimeout(function () {
                                    $('.message').fadeOut('fast');
                                }, 5000);
                            }
                        }

                    }
                });
            } else {
                // google recaptcha
                OGOO.UI.preloader("stop");
                $('.message').addClass('error').html("Lütfen 'Ben Robot Değilim' kutusunu işaretleyiniz. <i></i>");
                setTimeout(function () {
                    $('.message').fadeOut('fast');
                }, 5000);
            }
        } else {
            // not validate
            OGOO.UI.preloader("stop");
            $('.message').addClass('error').html("Lütfen zorunlu alanları doldurun.<i></i>");
            setTimeout(function () {
                $('.message').fadeOut('fast');
            }, 5000);
        }
    });

    function appendThis(item, index) {
        OGOO.UI.preloader("stop");
        if (item.attachments[0] === undefined) {
            item.attachments[0] = {
                documentbody: "",
                filename: "",
                subject: "",
            }
        }
        if (item.attachments[1] === undefined) {
            item.attachments[1] = {
                documentbody: "",
                filename: "",
                subject: "",
            }
        }

        var dateResources = {
            finish: "Kullanıldı",
            validUntil: "tarihine kadar geçerli",
            expired: "tarihinde süresi doldu",
        }

        return '<div class="panel-group c-panel-group c-panel-group--search-tyre" id="accordion" role="tablist" aria-multiselectable="true">' +
            '<div class="panel panel-default c-panel">' +
            '<div class="panel-heading c-panel-heading" role="tab" id="heading' + index + '" data-toggle="collapse" data-parent="#accordion" href="#collapse' + index + '" aria-expanded="true" aria-controls="collapseOne">' +
            '<div class="c-panel-heading__right">' +
            '<div class="c-panel-heading__bottom">' +
            (item.campaignengagementname === '' ? '<div>Kampanya Adı: <span>-</span></div>' : '') +
            (item.campaignengagementname !== '' ? '<div>Kampanya Adı: <span class="c-panel-gray-text">' + item.campaignengagementname + '</span></div>' : '') +
            (item.activationcode === '' && item.approvalstatus === 1 ? '<div>Kampanya Kodu: <span class="c-panel-gray-text">-</span></div>' : '') +
            (item.activationcode !== '' && item.approvalstatus === 1 ? '<div>Kampanya Kodu: <span class="c-panel-gray-text">' + item.activationcode + '</span></div>' : '') +
            (item.status === 0 && item.approvalstatus === 1 ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">' + dateResources.finish + '</span></div>' : '') +
            (item.status === 1 && item.approvalstatus === 1 ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Kullanılmadı</span></div>' : '') +
            (item.approvalstatustext === "Onay" && item.statustext === "Kullanıldı" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">' + item.statustext + ' </span></div>' : '') +
            (item.status === 1 && item.approvalstatus === 0 ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">' + item.statustext + '</span></div>' : '') +
            (item.approvalstatus === 1 && item.statustext === "Pasif" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">' + item.statustext + '</span></div>' : '') +
            (item.approvalstatus === 2 && item.approvalstatustext === "Onay Bekliyor" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">' + item.statustext + '</span></div>' : '') +
            '</div>' +
            '</div>' +
            '<div class="c-panel-heading__left">' +
            '<a role="button" class="c-panel-button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + index + '" aria-expanded="true" aria-controls="collapseOne">' +
            '<img src="/assets/images/arrow-down-insurance.png" alt="Arrow Down" class="img-responsive" />' +
            '</a>' +
            '</div>' +
            '</div>' +

            '<div id="collapse' + index + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + index + '">' +
            '<div class="panel-body">' +
            '<div class="panel-body-text">' +
            '<h3 class="form-title">Kişisel Bilgiler</h3>' +
            '<div class="d-flex insurance-results-row">' +
            (item.firstname === null ? '<div>Ad: <span class="c-panel-gray-text">-</span></div>' : '') +
            (item.firstname !== null ? '<div>Ad: <span class="c-panel-gray-text">' + item.firstname + '</span></div>' : '') +
            (item.lastname === null ? '<div>Soyad: <span class="c-panel-gray-text">-</span></div>' : '') +
            (item.lastname !== null ? '<div>Soyad: <span class="c-panel-gray-text">' + item.lastname + '</span></div>' : '') +
            '<div>GSM: <a href="tel+5303159311" class="c-panel-gray-text">' + item.mobilephone + '</a></div>' +
            '</div>' +
            '<div class="d-flex insurance-results-row">' +
            (item.governmentId === null ? '<div>TC Kimlik No: <span class="c-panel-gray-text">-</span></div>' : '') +
            (item.governmentId !== null ? '<div>TC Kimlik No: <span class="c-panel-gray-text">' + item.governmentid + '</span></div>' : '') +

            '</div>' +
            '</div>' +
            '<div class="panel-body-text">' +
            '<div class="d-flex insurance-results-row">' +
            '<div>Plaka: <span class="c-panel-gray-text">' + item.plate + '</span></div>' +
            '</div>' +
            '</div>' +

            '<div class="panel-body-text">' +

            '</div>' +
            '<div class="d-flex insurance-results-row" style="margin-top: 15px;">' +
            (item.invoicedate !== null ? '<div>Fatura Tarihi: <span class="c-panel-gray-text">' + new Date(item.invoicedate).toLocaleDateString('tr-TR') + '</span></div>' : '') +
            '</div>' +
            '</div>' +

            '<div class="panel-body">' +
            '<div class="panel-body-text">' +
            '<h3 class="form-title">Kampanya Bilgileri</h3>' +
            '<div class="d-flex insurance-results-row">' +
            (item.campaignengagementname === '' ? '<div>Kampanya Adı: <span>-</span></div>' : '') +
            (item.campaignengagementname !== '' ? '<div>Kampanya Adı: <span class="c-panel-gray-text">' + item.campaignengagementname + '</span></div>' : '') +
            '</div>' +

            // ValidityStatus
            (item.approvalstatus === 1 ?
                // true
                '<div class="d-flex insurance-results-row">' +
                (item.validitystatus !== '' ? '<div>Geçerlilik Durumu: <span class="c-panel-gray-text">' + item.validitystatus + '</span></div>' : '') +
                '</div>' :

                // false
                '') +

            '<div class="d-flex insurance-results-row">' +
            (item.approvalstatus === '' || item.approvalstatus === null ? '<div>Onay Durumu: <span class="c-panel-gray-text">-</span></div>' : '') +
            (item.approvalstatus !== '' && item.approvalstatus !== null ? '<div>Onay Durumu: <span class="c-panel-gray-text">' + item.approvalstatustext + '</span></div>' : '') +
            '</div>' +

            // Status
            (item.approvalstatus === 1 ?
                // true
                '<div class="d-flex insurance-results-row">' +
                (item.status === 0 ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Kullanıldı</span></div>' : '') +
                (item.status === 1 ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Kullanılmadı</span></div>' : '') +
                (item.statustext === "Kullanıldı" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Kullanıldı</span></div>' : '') +
                (item.statustext === "Pasif" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Pasif</span></div>' : '') +
                '</div>' :

                // false
                '') +

            // ValidityStatus
            (item.approvalstatus === 2 ?
                // true
                '<div class="d-flex insurance-results-row">' +
                (item.validitystatus !== '' ? '<div>Geçerlilik Durumu: <span class="c-panel-gray-text">' + item.validitystatus + '</span></div>' : '') +
                '</div>' :

                // false
                '') +

            // Status
            (item.approvalstatus === 2 ?
                // true
                '<div class="d-flex insurance-results-row">' +
                (item.statustext === "Aktif" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Aktif</span></div>' : '') +
                '</div>' :

                // false
                '') +

            // Status
            (item.approvalstatus === 0 || item.approvalstatustext === "Red" ?
                // true
                '<div class="d-flex insurance-results-row">' +
                (item.statustext === "Aktif" ? '<div>Kullanım Durumu: <span class="c-panel-gray-text">Aktif</span></div>' : '') +
                '</div>' :

                // false
                '') +

            // ActivationCode
            (item.approvalstatus === 1 ?
                // true
                '<div class="d-flex insurance-results-row">' +
                (item.activationcode === '' ? '<div>Kampanya Kodu: <span class="c-panel-gray-text">-</span></div>' : '') +
                (item.activationcode !== '' ? '<div>Kampanya Kodu: <span class="c-panel-gray-text">' + item.activationcode + '</span></div>' : '') +
                '</div>' :

                // false
                '') +

            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
    }
    // tyre insurance
    var isPending = false;

    // tyre insurance
    $('#search-tyre-insurance').off('click').on('click', function () {
        var self = this;
        $('#insuranceResults').html("");
        var insuranceActivationCode = $('#ActivationCode').val();
        var insurancePlate = $('#Plate').val();


        if ((typeof insuranceActivationCode === 'undefined' && typeof insurancePlate === 'undefined') ||
            (insuranceActivationCode === '' && insurancePlate === '')) {
            // form boşsa
            $('.content').append('<div class="message"></div>');
            $('.message').removeClass('success').addClass('error').html("Lütfen en az bir alanı boş bırakmayın. <i></i>");
            setTimeout(function () {
                $('.message').fadeOut('fast');
            }, 3000);
        } else {
            // form boş değilse
            OGOO.UI.preloader("start");
            var url = "customized/GetTyreInsurance";
            var obj = {
                "activationCode": insuranceActivationCode,
                "plate": insurancePlate
            };
            var type = "POST";

            if (!isPending) {
                OGOO.Service.insuranceForm(obj, url, type, function (result) {
                    /**
                        * @param: data get warranty
                      * @description warranty check page manual text operation
                    */
                    //$.each(result.data, function (key, value ) {
                    //    console.log(value);

                    //    // validityStatus logic control
                    //    if (value.statustext === "Aktif" && OGOO.Helper.stringTextSearch(value.validitystatus, "Doldu")) {
                    //        var validityStatus = value.validitystatus.split(' ');
                    //        var splitDate = value.validitystatus = validityStatus[0];
                    //    } else if (value.statustext === "Kullanıldı" && OGOO.Helper.stringTextSearch(value.validitystatus, "Geçerli")) {
                    //        var validitystatus = value.validitystatus.split('');
                    //        var splitText = value.validitystatus = validityStatus[10];
                    //    } else if (value.statustext === "Aktif" && OGOO.Helper.stringTextSearch(value.validitystatus, "Geçerli")) {
                    //        var validityStatus = value.validitystatus.split(' ');
                    //        var splitDate = value.validitystatus = validityStatus[0];
                    //    }

                    //    if (value.validitystatus !== null) {
                    //        var validityStatus = value.validitystatus.split(' ');
                    //        var splitDate = value.validitystatus = validityStatus[0];
                    //    }

                    //});

                    if (result.status.message === "Succeed") {
                        var searchResultsList = result.data;
                        if (typeof searchResultsList !== 'undefined') {
                            if (searchResultsList.length > 0) {

                                var testBase64 = "data:application/pdf;base64,JVBERi0xLjcNCiW1tbW1DQoxIDAgb2JqDQo8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFIvTGFuZyhlbi1HQikgL1N0cnVjdFRyZWVSb290IDEwIDAgUi9NYXJrSW5mbzw8L01hcmtlZCB0cnVlPj4vTWV0YWRhdGEgMjAgMCBSL1ZpZXdlclByZWZlcmVuY2VzIDIxIDAgUj4+DQplbmRvYmoNCjIgMCBvYmoNCjw8L1R5cGUvUGFnZXMvQ291bnQgMS9LaWRzWyAzIDAgUl0gPj4NCmVuZG9iag0KMyAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9SZXNvdXJjZXM8PC9Gb250PDwvRjEgNSAwIFI+Pi9FeHRHU3RhdGU8PC9HUzcgNyAwIFIvR1M4IDggMCBSPj4vUHJvY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdlQy9JbWFnZUldID4+L01lZGlhQm94WyAwIDAgNTk1LjMyIDg0MS45Ml0gL0NvbnRlbnRzIDQgMCBSL0dyb3VwPDwvVHlwZS9Hcm91cC9TL1RyYW5zcGFyZW5jeS9DUy9EZXZpY2VSR0I+Pi9UYWJzL1MvU3RydWN0UGFyZW50cyAwPj4NCmVuZG9iag0KNCAwIG9iag0KPDwvRmlsdGVyL0ZsYXRlRGVjb2RlL0xlbmd0aCAxNzg+Pg0Kc3RyZWFtDQp4nK2OzQqCQACE7wv7DnPUoP1L3RXEgz9JkYdyoYN0WKI8JWW9P6l08d7cBob5PvDm6XokCa/zXQHBD67v4H2GtT35aYqsyPGiRDAxxRgtIRDGIdsomECyWGG4UXJeoacks5TwrYSUTASwd0qmtYCEVkyoADqMWWBgH+OuajS693iNbm7m1ypKsJ54Rkaw19ZzzvkX2D0l5fh/pOQPPkYzEy18Zo2Z3npY8lDWOb4psztgDQplbmRzdHJlYW0NCmVuZG9iag0KNSAwIG9iag0KPDwvVHlwZS9Gb250L1N1YnR5cGUvVHJ1ZVR5cGUvTmFtZS9GMS9CYXNlRm9udC9CQ0RFRUUrQ2FsaWJyaS9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgNiAwIFIvRmlyc3RDaGFyIDMyL0xhc3RDaGFyIDk3L1dpZHRocyAxOCAwIFI+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ODM+Pg0Kc3RyZWFtDQo8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IjMuMS03MDEiPgo8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgo8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiAgeG1sbnM6cGRmPSJodHRwOi8vbnMuYWRvYmUuY29tL3BkZi8xLjMvIj4KPHBkZjpQcm9kdWNlcj5NaWNyb3NvZnTCriBXb3JkIGZvciBPZmZpY2UgMzY1PC9wZGY6UHJvZHVjZXI+PC9yZGY6RGVzY3JpcHRpb24+CjxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iPgo8ZGM6Y3JlYXRvcj48cmRmOlNlcT48cmRmOmxpPk1laG1ldCBHw7xsZXI8L3JkZjpsaT48L3JkZjpTZXE+PC9kYzpjcmVhdG9yPjwvcmRmOkRlc2NyaXB0aW9uPgo8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIj4KPHhtcDpDcmVhdG9yVG9vbD5NaWNyb3NvZnTCriBXb3JkIGZvciBPZmZpY2UgMzY1PC94bXA6Q3JlYXRvclRvb2w+PHhtcDpDcmVhdGVEYXRlPjIwMTktMDUtMTRUMTE6MjU6NDQrMDM6MDA8L3htcDpDcmVhdGVEYXRlPjx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTE0VDExOjI1OjQ0KzAzOjAwPC94bXA6TW9kaWZ5RGF0ZT48L3JkZjpEZXNjcmlwdGlvbj4KPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIj4KPHhtcE1NOkRvY3VtZW50SUQ+dXVpZDoxNDkxRDhBMy1EOUZDLTRBNzYtODE0RC0yNEE1RTJCNzBGQzE8L3htcE1NOkRvY3VtZW50SUQ+PHhtcE1NOkluc3RhbmNlSUQ+dXVpZDoxNDkxRDhBMy1EOUZDLTRBNzYtODE0RC0yNEE1RTJCNzBGQzE8L3htcE1NOkluc3RhbmNlSUQ+PC9yZGY6RGVzY3JpcHRpb24+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8L3JkZjpSREY+PC94OnhtcG1ldGE+PD94cGFja2V0IGVuZD0idyI/Pg0KZW5kc3RyZWFtDQplbmRvYmoNCjIxIDAgb2JqDQo8PC9EaXNwbGF5RG9jVGl0bGUgdHJ1ZT4+DQplbmRvYmoNCjIyIDAgb2JqDQo8PC9UeXBlL1hSZWYvU2l6ZSAyMi9XWyAxIDQgMl0gL1Jvb3QgMSAwIFIvSW5mbyA5IDAgUi9JRFs8QTNEODkxMTRGQ0Q5NzY0QTgxNEQyNEE1RTJCNzBGQzE+PEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPl0gL0ZpbHRlci9GbGF0ZURlY29kZS9MZW5ndGggODQ+Pg0Kc3RyZWFtDQp4nC3LvQFAYAyE4cv3g5YxLGQBc1hAYQsLMI9aYYeIOynyFMkLxLhb7B742MVF7CHpJnkjZRGHiFtinkQWRVRh4v9soqvOvF1JN5LpJPMAvD3QDBMNCmVuZHN0cmVhbQ0KZW5kb2JqDQp4cmVmDQowIDIzDQowMDAwMDAwMDEwIDY1NTM1IGYNCjAwMDAwMDAwMTcgMDAwMDAgbg0KMDAwMDAwMDE2NiAwMDAwMCBuDQowMDAwMDAwMjIyIDAwMDAwIG4NCjAwMDAwMDA0OTIgMDAwMDAgbg0KMDAwMDAwMDc0NCAwMDAwMCBuDQowMDAwMDAwOTExIDAwMDAwIG4NCjAwMDAwMDExNTAgMDAwMDAgbg0KMDAwMDAwMTIwMyAwMDAwMCBuDQowMDAwMDAxMjU2IDAwMDAwIG4NCjAwMDAwMDAwMTEgNjU1MzUgZg0KMDAwMDAwMDAxMiA2NTUzNSBmDQowMDAwMDAwMDEzIDY1NTM1IGYNCjAwMDAwMDAwMTQgNjU1MzUgZg0KMDAwMDAwMDAxNSA2NTUzNSBmDQowMDAwMDAwMDE2IDY1NTM1IGYNCjAwMDAwMDAwMTcgNjU1MzUgZg0KMDAwMDAwMDAwMCA2NTUzNSBmDQowMDAwMDAxOTMxIDAwMDAwIG4NCjAwMDAwMDIwOTAgMDAwMDAgbg0KMDAwMDAyMjQ1MiAwMDAwMCBuDQowMDAwMDI1NjE4IDAwMDAwIG4NCjAwMDAwMjU2NjMgMDAwMDAgbg0KdHJhaWxlcg0KPDwvU2l6ZSAyMy9Sb290IDEgMCBSL0luZm8gOSAwIFIvSURbPEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPjxBM0Q4OTExNEZDRDk3NjRBODE0RDI0QTVFMkI3MEZDMT5dID4+DQpzdGFydHhyZWYNCjI1OTQ2DQolJUVPRg0KeHJlZg0KMCAwDQp0cmFpbGVyDQo8PC9TaXplIDIzL1Jvb3QgMSAwIFIvSW5mbyA5IDAgUi9JRFs8QTNEODkxMTRGQ0Q5NzY0QTgxNEQyNEE1RTJCNzBGQzE+PEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPl0gL1ByZXYgMjU5NDYvWFJlZlN0bSAyNTY2Mz4+DQpzdGFydHhyZWYNCjI2NTYyDQolJUVPRg==";
                                var newTestBase64 = "'" + testBase64 + "'";
                                var resultHtml = "";
                                searchResultsList.forEach(function (item, index) {
                                    var count = 0;

                                    if (count === 0) {
                                        resultHtml += appendThis(item, index);
                                        $("#insuranceResults").html(resultHtml);
                                        isPending = false;
                                    }

                                    //OGOO.UI.GetInsuranceCityByFilter(item.CityId, function (result) {
                                    //    item["CityName"] = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //OGOO.UI.GetInsuranceCountyByFilter(item.CityId, item.CountyId, function (result) {
                                    //    item["CountyName"] = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //OGOO.UI.GetInsuranceProductBrandsByFilter(item.productbrandid, function (result) {
                                    //    item.productbrandname = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //OGOO.UI.GetInsuranceRimDiametersByFilter(item.rimdiameterid, function (result) {
                                    //    item["rimdiametername"] = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //OGOO.UI.GetInsuranceDealersByFilter(item.dealerid, function (result) {
                                    //    item.dealername = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //OGOO.UI.GetInsuranceVehicleBrandsByFilter(item.vehiclebrandid, function (result) {
                                    //    item.vehiclebrandname = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //OGOO.UI.GetInsuranceVehicleModelByFilter(item.vehiclebrandid, item.vehiclemodelid, function (result) {
                                    //    item.vehiclemodelname = result;
                                    //    count--;
                                    //    if (count === 0) {
                                    //        resultHtml += appendThis(item, index);
                                    //        $("#insuranceResults").html(resultHtml);
                                    //        isPending = false;
                                    //    }
                                    //});

                                    //var testCount = 0;
                                    item.attachments.forEach(function (attach) {
                                        //if (testCount === 0) {
                                        //    attach.Subject = 'Bill';
                                        //    attach.DocumentBody = "data:application/pdf;base64,JVBERi0xLjcNCiW1tbW1DQoxIDAgb2JqDQo8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFIvTGFuZyhlbi1HQikgL1N0cnVjdFRyZWVSb290IDEwIDAgUi9NYXJrSW5mbzw8L01hcmtlZCB0cnVlPj4vTWV0YWRhdGEgMjAgMCBSL1ZpZXdlclByZWZlcmVuY2VzIDIxIDAgUj4+DQplbmRvYmoNCjIgMCBvYmoNCjw8L1R5cGUvUGFnZXMvQ291bnQgMS9LaWRzWyAzIDAgUl0gPj4NCmVuZG9iag0KMyAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9SZXNvdXJjZXM8PC9Gb250PDwvRjEgNSAwIFI+Pi9FeHRHU3RhdGU8PC9HUzcgNyAwIFIvR1M4IDggMCBSPj4vUHJvY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdlQy9JbWFnZUldID4+L01lZGlhQm94WyAwIDAgNTk1LjMyIDg0MS45Ml0gL0NvbnRlbnRzIDQgMCBSL0dyb3VwPDwvVHlwZS9Hcm91cC9TL1RyYW5zcGFyZW5jeS9DUy9EZXZpY2VSR0I+Pi9UYWJzL1MvU3RydWN0UGFyZW50cyAwPj4NCmVuZG9iag0KNCAwIG9iag0KPDwvRmlsdGVyL0ZsYXRlRGVjb2RlL0xlbmd0aCAxNzg+Pg0Kc3RyZWFtDQp4nK2OzQqCQACE7wv7DnPUoP1L3RXEgz9JkYdyoYN0WKI8JWW9P6l08d7cBob5PvDm6XokCa/zXQHBD67v4H2GtT35aYqsyPGiRDAxxRgtIRDGIdsomECyWGG4UXJeoacks5TwrYSUTASwd0qmtYCEVkyoADqMWWBgH+OuajS693iNbm7m1ypKsJ54Rkaw19ZzzvkX2D0l5fh/pOQPPkYzEy18Zo2Z3npY8lDWOb4psztgDQplbmRzdHJlYW0NCmVuZG9iag0KNSAwIG9iag0KPDwvVHlwZS9Gb250L1N1YnR5cGUvVHJ1ZVR5cGUvTmFtZS9GMS9CYXNlRm9udC9CQ0RFRUUrQ2FsaWJyaS9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgNiAwIFIvRmlyc3RDaGFyIDMyL0xhc3RDaGFyIDk3L1dpZHRocyAxOCAwIFI+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ODM+Pg0Kc3RyZWFtDQo8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IjMuMS03MDEiPgo8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgo8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiAgeG1sbnM6cGRmPSJodHRwOi8vbnMuYWRvYmUuY29tL3BkZi8xLjMvIj4KPHBkZjpQcm9kdWNlcj5NaWNyb3NvZnTCriBXb3JkIGZvciBPZmZpY2UgMzY1PC9wZGY6UHJvZHVjZXI+PC9yZGY6RGVzY3JpcHRpb24+CjxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iPgo8ZGM6Y3JlYXRvcj48cmRmOlNlcT48cmRmOmxpPk1laG1ldCBHw7xsZXI8L3JkZjpsaT48L3JkZjpTZXE+PC9kYzpjcmVhdG9yPjwvcmRmOkRlc2NyaXB0aW9uPgo8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIj4KPHhtcDpDcmVhdG9yVG9vbD5NaWNyb3NvZnTCriBXb3JkIGZvciBPZmZpY2UgMzY1PC94bXA6Q3JlYXRvclRvb2w+PHhtcDpDcmVhdGVEYXRlPjIwMTktMDUtMTRUMTE6MjU6NDQrMDM6MDA8L3htcDpDcmVhdGVEYXRlPjx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTE0VDExOjI1OjQ0KzAzOjAwPC94bXA6TW9kaWZ5RGF0ZT48L3JkZjpEZXNjcmlwdGlvbj4KPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIj4KPHhtcE1NOkRvY3VtZW50SUQ+dXVpZDoxNDkxRDhBMy1EOUZDLTRBNzYtODE0RC0yNEE1RTJCNzBGQzE8L3htcE1NOkRvY3VtZW50SUQ+PHhtcE1NOkluc3RhbmNlSUQ+dXVpZDoxNDkxRDhBMy1EOUZDLTRBNzYtODE0RC0yNEE1RTJCNzBGQzE8L3htcE1NOkluc3RhbmNlSUQ+PC9yZGY6RGVzY3JpcHRpb24+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8L3JkZjpSREY+PC94OnhtcG1ldGE+PD94cGFja2V0IGVuZD0idyI/Pg0KZW5kc3RyZWFtDQplbmRvYmoNCjIxIDAgb2JqDQo8PC9EaXNwbGF5RG9jVGl0bGUgdHJ1ZT4+DQplbmRvYmoNCjIyIDAgb2JqDQo8PC9UeXBlL1hSZWYvU2l6ZSAyMi9XWyAxIDQgMl0gL1Jvb3QgMSAwIFIvSW5mbyA5IDAgUi9JRFs8QTNEODkxMTRGQ0Q5NzY0QTgxNEQyNEE1RTJCNzBGQzE+PEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPl0gL0ZpbHRlci9GbGF0ZURlY29kZS9MZW5ndGggODQ+Pg0Kc3RyZWFtDQp4nC3LvQFAYAyE4cv3g5YxLGQBc1hAYQsLMI9aYYeIOynyFMkLxLhb7B742MVF7CHpJnkjZRGHiFtinkQWRVRh4v9soqvOvF1JN5LpJPMAvD3QDBMNCmVuZHN0cmVhbQ0KZW5kb2JqDQp4cmVmDQowIDIzDQowMDAwMDAwMDEwIDY1NTM1IGYNCjAwMDAwMDAwMTcgMDAwMDAgbg0KMDAwMDAwMDE2NiAwMDAwMCBuDQowMDAwMDAwMjIyIDAwMDAwIG4NCjAwMDAwMDA0OTIgMDAwMDAgbg0KMDAwMDAwMDc0NCAwMDAwMCBuDQowMDAwMDAwOTExIDAwMDAwIG4NCjAwMDAwMDExNTAgMDAwMDAgbg0KMDAwMDAwMTIwMyAwMDAwMCBuDQowMDAwMDAxMjU2IDAwMDAwIG4NCjAwMDAwMDAwMTEgNjU1MzUgZg0KMDAwMDAwMDAxMiA2NTUzNSBmDQowMDAwMDAwMDEzIDY1NTM1IGYNCjAwMDAwMDAwMTQgNjU1MzUgZg0KMDAwMDAwMDAxNSA2NTUzNSBmDQowMDAwMDAwMDE2IDY1NTM1IGYNCjAwMDAwMDAwMTcgNjU1MzUgZg0KMDAwMDAwMDAwMCA2NTUzNSBmDQowMDAwMDAxOTMxIDAwMDAwIG4NCjAwMDAwMDIwOTAgMDAwMDAgbg0KMDAwMDAyMjQ1MiAwMDAwMCBuDQowMDAwMDI1NjE4IDAwMDAwIG4NCjAwMDAwMjU2NjMgMDAwMDAgbg0KdHJhaWxlcg0KPDwvU2l6ZSAyMy9Sb290IDEgMCBSL0luZm8gOSAwIFIvSURbPEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPjxBM0Q4OTExNEZDRDk3NjRBODE0RDI0QTVFMkI3MEZDMT5dID4+DQpzdGFydHhyZWYNCjI1OTQ2DQolJUVPRg0KeHJlZg0KMCAwDQp0cmFpbGVyDQo8PC9TaXplIDIzL1Jvb3QgMSAwIFIvSW5mbyA5IDAgUi9JRFs8QTNEODkxMTRGQ0Q5NzY0QTgxNEQyNEE1RTJCNzBGQzE+PEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPl0gL1ByZXYgMjU5NDYvWFJlZlN0bSAyNTY2Mz4+DQpzdGFydHhyZWYNCjI2NTYyDQolJUVPRg==";
                                        //}
                                        //if (testCount === 1) {
                                        //    attach.Subject = 'License';
                                        //    attach.DocumentBody = "data:application/pdf;base64,JVBERi0xLjcNCiW1tbW1DQoxIDAgb2JqDQo8PC9UeXBlL0NhdGFsb2cvUGFnZXMgMiAwIFIvTGFuZyhlbi1HQikgL1N0cnVjdFRyZWVSb290IDEwIDAgUi9NYXJrSW5mbzw8L01hcmtlZCB0cnVlPj4vTWV0YWRhdGEgMjAgMCBSL1ZpZXdlclByZWZlcmVuY2VzIDIxIDAgUj4+DQplbmRvYmoNCjIgMCBvYmoNCjw8L1R5cGUvUGFnZXMvQ291bnQgMS9LaWRzWyAzIDAgUl0gPj4NCmVuZG9iag0KMyAwIG9iag0KPDwvVHlwZS9QYWdlL1BhcmVudCAyIDAgUi9SZXNvdXJjZXM8PC9Gb250PDwvRjEgNSAwIFI+Pi9FeHRHU3RhdGU8PC9HUzcgNyAwIFIvR1M4IDggMCBSPj4vUHJvY1NldFsvUERGL1RleHQvSW1hZ2VCL0ltYWdlQy9JbWFnZUldID4+L01lZGlhQm94WyAwIDAgNTk1LjMyIDg0MS45Ml0gL0NvbnRlbnRzIDQgMCBSL0dyb3VwPDwvVHlwZS9Hcm91cC9TL1RyYW5zcGFyZW5jeS9DUy9EZXZpY2VSR0I+Pi9UYWJzL1MvU3RydWN0UGFyZW50cyAwPj4NCmVuZG9iag0KNCAwIG9iag0KPDwvRmlsdGVyL0ZsYXRlRGVjb2RlL0xlbmd0aCAxNzg+Pg0Kc3RyZWFtDQp4nK2OzQqCQACE7wv7DnPUoP1L3RXEgz9JkYdyoYN0WKI8JWW9P6l08d7cBob5PvDm6XokCa/zXQHBD67v4H2GtT35aYqsyPGiRDAxxRgtIRDGIdsomECyWGG4UXJeoacks5TwrYSUTASwd0qmtYCEVkyoADqMWWBgH+OuajS693iNbm7m1ypKsJ54Rkaw19ZzzvkX2D0l5fh/pOQPPkYzEy18Zo2Z3npY8lDWOb4psztgDQplbmRzdHJlYW0NCmVuZG9iag0KNSAwIG9iag0KPDwvVHlwZS9Gb250L1N1YnR5cGUvVHJ1ZVR5cGUvTmFtZS9GMS9CYXNlRm9udC9CQ0RFRUUrQ2FsaWJyaS9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcvRm9udERlc2NyaXB0b3IgNiAwIFIvRmlyc3RDaGFyIDMyL0xhc3RDaGFyIDk3L1dpZHRocyAxOCAwIFI+Pg0KZW5kb2JqDQo2IDAgb2JqDQo8PC9UeXBlL0ZvbnREZXNjcmlwdG9yL0ZvbnROYW1lL0JDREVFRStDYWxpYnJpL0ZsYWdzIDMyL0l0YWxpY0FuZ2xlIDAvQXNjZW50IDc1MC9EZXNjZW50IC0yNTAvQ2FwSGVpZ2h0IDc1MC9BdmdXaWR0aCA1MjEvTWF4V2lkdGggMTc0My9Gb250V2VpZ2h0IDQwMC9YSGVpZ2h0IDI1MC9TdGVtViA1Mi9Gb250QkJveFsgLTUwMyAtMjUwIDEyNDAgNzUwXSAvRm9udEZpbGUyIDE5IDAgUj4+DQplbmRvYmoNCjcgMCBvYmoNCjw8L1R5cGUvRXh0R1N0YXRlL0JNL05vcm1hbC9jYSAxPj4NCmVuZG9iag0KOCAwIG9iag0KPDwvVHlwZS9FeHRHU3RhdGUvQk0vTm9ybWFsL0NBIDE+Pg0KZW5kb2JqDQo5IDAgb2JqDQo8PC9BdXRob3Io/v8ATQBlAGgAbQBlAHQAIABHAPwAbABlAHIpIC9DcmVhdG9yKP7/AE0AaQBjAHIAbwBzAG8AZgB0AK4AIABXAG8AcgBkACAAZgBvAHIAIABPAGYAZgBpAGMAZQAgADMANgA1KSAvQ3JlYXRpb25EYXRlKEQ6MjAxOTA1MTQxMTI1NDQrMDMnMDAnKSAvTW9kRGF0ZShEOjIwMTkwNTE0MTEyNTQ0KzAzJzAwJykgL1Byb2R1Y2VyKP7/AE0AaQBjAHIAbwBzAG8AZgB0AK4AIABXAG8AcgBkACAAZgBvAHIAIABPAGYAZgBpAGMAZQAgADMANgA1KSA+Pg0KZW5kb2JqDQoxNyAwIG9iag0KPDwvVHlwZS9PYmpTdG0vTiA3L0ZpcnN0IDQ2L0ZpbHRlci9GbGF0ZURlY29kZS9MZW5ndGggMjk2Pj4NCnN0cmVhbQ0KeJxtUdFqwjAUfRf8h/sHt7GtYyDCmMqGWEor7KH4EOtdDbaJpCno3y937bADX8I5N+ecnCQihgBEBLEA4UEQg/DodQ5iBlE4AxFCFPvhHKKXABYLTFkdQIY5pri/XwlzZ7vSrWtqcFtAcABMKwhZs1xOJ70lGCwrU3YNaffMKbhKdoDBNVLsLVFmjMPM1LSTV+7Ieam0Pot3uS5POCbqY0a7Cd3clu4ghuiNz9LGESa8rPXpQfZeejQ3zKl0+EHyRLbH7PnDn7pWmvKz5IY8eNM+QTpl9MCtU9/Sg1/2ZezlaMzlcXuetGcixyUd7mRpzYi/n/064isla1ONBnmtTjTS9ud4WWVlgxtVdZaGuyZd0xb8x/N/r5vIhtqip4+nn05+AFQKorsNCmVuZHN0cmVhbQ0KZW5kb2JqDQoxOCAwIG9iag0KWyAyMjYgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMCA0NzldIA0KZW5kb2JqDQoxOSAwIG9iag0KPDwvRmlsdGVyL0ZsYXRlRGVjb2RlL0xlbmd0aCAyMDI3MS9MZW5ndGgxIDgxODYwPj4NCnN0cmVhbQ0KeJzsfQd4lFXa9jnvO8lMpmRmkkzaJJkJkwaTAiGBhJYhjV4CGUyoCSkEDR1EETCKAkawo7Kyit0Vy2RACVZULGsv2Cu7rmvDsmtFIf993mdOKL/6/9f3ubr7ffMk99z3eU55z3vqk4twhXHGmA0fOtZQVV5Zu2dbTQnjru2MKdaq8vEV25ePMTKeWof06ElTCwq3PjTrLsb4RtRqaFrQuPiySZc9x9j805D/VdOpy917Fr9WzNjV5zAWcV/r4nkL1r6jDmasvZ0xi3de++mtr15XeAljN/gYi72praWx+duLv70f7ZnR3qA2OCy3pxxEuhLpjLYFy08b/aDhVqQ/ZGzeBe2LmhrnVyxE+7uRLipZ0Hja4twfMl9HfhvKuxe0LG986/qUSYynB0T/FjYuaDnv4X14/qduxgY4Fi9atrzHydbjfUpE+cVLWxbHzuuTxNjpV+JxnzAxFpHFj6S2H355jnXY1yzJwITd+8nqpwW/svnQqh8OHe6I+tQwCMkopjAy1ItkRxjfZ9z+w6FD26M+1Vo6xpJuE55kJ+tgNjYMWgEXsA2MxQzSnsuZqvPyi1gEM0RsjRiIJtOI1efZeoUZMBsRiqLoVEX3HuvXs5dlnKH1ADZhqtvNMJ6ZT1Mf9FcrWW7Ge0SeujsiWrwpi9NFH+0Nf479r7fIV9ltv3cffi9Tv8Lq+xVN18Ku/TXb+1dbZOS/pr/qwX//cVBfZjP/le3riljDv7L9sP02pjzJtv7effh3NeU2Vtmr/8ZG/1fa4N+w9l+vR2ELW9jCFrb/rilXcePP5jWwg79lX/5TTC1m5//efQhb2MIWtrD91033EGv9zZ+5gF3wWz8zbGELW9jCFrawhS1sYQtb2ML2P9fCP2eGLWxhC1vYwha2sIUtbGELW9jCFraw/XsbD/82etjCFrawhS1sYQtb2MIWtrCFLWxhC1vYwha2sIUtbGELW9jCFrawhS1sYQtb2MIWtrCFLWxhC1vYwha2sIUtbGEL27+J9dzze/fgNzI1hJTQXwu6BCkoZS3TsVORTmQ2eMSfILKwPmwCa2TNbCnbnlrqjsp8ukf7+z7Icf9EDu/5GuP4LbuW3c2Te5o+2XAw+93hoafE/VRP1LHqFSySf6qlvjzxrxdpf6+I/taRwn7Z+DHt/Sus8v9dROuG1k+e/AslNv0a3fkNTf1VW/tdVphv+vpzly9bumTxooUL2k85eX7bvNaW5rlzZs+aOWN6fZ2/duqUmsmTJk4YP27smNGjqqsqK8pH+spGDB82dEhpyeBBxQX5ebk5WZkZnj6uxDi7zWoxGaMM+sgInapwllvlqW5wB7IaArosz+jReSLtaYSj8RhHQ8ANV/XxZQLuBq2Y+/iSPpRsPaGkj0r6ektym3sYG5aX667yuAPPVHrc3Xx6TR305kpPvTtwUNMTNK3L0hIWJNLTUcNdldhW6Q7wBndVoPrUts6qhkq012UyVngqWox5uazLaII0QQVyPIu7eM4Irgklp2pIl8IMFvHYgJpZ1dgcmFxTV1XpTE+v13ysQmsrEFkR0GttueeLPrPz3V25ezs3ddvY3AavudnT3DizLqA2olKnWtXZuSFg9wb6eioDfVe9n4hXbgnkeiqrAl4PGhs3pfcBPBCRafO4O79m6Lzn4KfHexpDnshM29dMSPGKvcOEfKkZ+oYe4v3S00Vfzu/2sblIBDpq6ijtZnOdQeYr8NYHlAaRs1fmOPwip0Pm9FZv8KSLqapqCH2f2pYY6JjrzsvF6GvfmfhGvjugZjXMbWoT3NjS6amspHGrrQv4KiF8jaF3rerqX4DyjQ14ifliGGrqAgWexYE4TzkVgMMt5mD+1DqtSqhaIK4iwBqaQrUCBVWVol/uqs6GSuqgaMtTU7eHDex5r6vI7dw5kBWxetGPQHwFJiWrqrOuuTXganA2Y322uuuc6QFfPYav3lPXUi9myWML9H0Pj0vXnqjVwrudUFoWFm+uzzS46xSnWi9mCw53NT485cOQYcN0aUkxo+XD3HXcyWQxPCVUQqjj2kFCzawYLbJUUbVitDO9Pp3sF7rkDPUpIjNgOKYtGxy9faLn/GzXqLToUF93VUvlMR08rtGIUAdDrf10PxUxFqEHo4ZBTOdomaVmYufCp6AZzSVmMdEdYJPddZ4WT70Ha8g3uU68mxhrbX7HTfWMq5lep812aJXUHpei/BJKBVg6smVCqcAarPY65bRq6VFaujc5+oTsMTLbI/rV2dncxdRMsZSdXVwTERXn1wcmees9gbleT7roZ15ul4GZ02sbKrBXq3HceaobPW6bu7qzsbunY25nl8/XubiqoW0I9kWnZ0xzp2dq3TCn1vkpdWucq8SzY9g4Pq62HE0prLzLwzfWdPn4xqnT6/bYGHNvrK0LKlypaCiv78pAXt0eN2M+zasIr3CKhFskREtTkDBo5Z17fIx1aLk6zaGlm7o503wG6eOsqVshn40elKU9yIcopalbRzk+WVoHn4F8HVQ6J1TagBybyLmHKSL+EplkXUwMsM8Y4TP4onxmxaJgSIUrCM89KBvF2U4zt3BnF9qcorm7eUdXlM+5R2tpSqhkB0oKX0evDz0XxY5pCM+jF/cffQP/9LqdZob2tU+UKBeGVZjYhjWE+6TK3SzW3+r6ts6GenF6sHisVXzzAPeMYAHFMwI9jjQHjJ6W8oDJUy78ZcJfRv5I4ddj5fN4jskWh25ngwcHMXZMHXNy2muqaNLd3dNTW5f+jPNgfTr20kxgel0gyovLLSJzLMqNEmiAe1Sgo6lR9IP560RdfeaYpnrsS9kgiowJRKGFqFALKFGt1RH7DZWasNYaPZqEG0dHR32g3iseWje/XtuvtgAb7RkSiMyiNiOyxIMK6jtjPIXa4YO9bszcICgKfWNT68jjRBIPq6dB0pvR8yYPspoa3LRGpmIv02VhdJKnBWe+LqtFg9EZymTitdRMk8UYiMpHg/gW2pQvzpyITH19PXVeS20IFcCzbQETepR1zFCGKmB0kDVG9AXfG9BVUfQh0UxNN5viOQ1Hp+i01pIe2QFL5phG3G5U3wSPp0RWNohD0BRqYx959eLNzRh3HAndPTd7Tk8/xnB2iNtPrD/m3IONyuo7T3QEZnjzcg0nei2au7PTYPnpCjReBksva04ls0ncCmCx4LT15q4SV6VnbJcy0asx17hzrAc3iJIpgEBHxfZJdzfXi1Lo8mTtLPvZQvyYQuKa1hrvtA2VKR5K0WR2BuYdn2zrTVYLIBjMzKcYAq8izlqslZOdgXasTFlEzIi7023zDPGID63yKIEGTFLvtsDyx6oTm6ajyV03F4sdDVY3dFZ3ihC1qTE0bKEnBRZ6j2sS+4Jj8aAh8TqBjsnuhnp3A0JTXlOXnu7EbgS7WxGnehrFVTCZ3mfydC1UaewUS5whUql3BvS4mFobWzzpuEEC4gSi0Rd91IW2DXN2dno6A9q+rUZhNJ+FbTdGEL4Xez2NLSKEbhURdItWtxrd1UZHtOas8mAvt8CtjSUGDkffXPHR1CkC9FkNXoyEvTOm013aiSN4Fm4PXVbTtAZcVeJGcmtT3ehECoMwRqTq0RAVjMoUBWkLiN4s8HbN0mce9Wjfi7xU2KC1ip5NqQtMlkW0/STEEm9ASShBpnh5PmV6nTynVJE9BsPrw6pyitrugFJbF5oerf4YUdUpJ4yqwaPdIaH91XvbyHtophNj+rN+XA7qyKnKE8pjrIS5lMdD/DYrUd5gfuV18Kvg10L8Cvhl8H7wS+AXwS+AHwQ/AL4ffB/zM53yJisCagG1VzUDNwD7gQh2ClrizIT6nMUpD7NKoBlYDlwGRKDsA8i7AS1y5lbO2RWVyMdiQtdJcbYUZ0nRIcWZUqyVYo0Uq6U4Q4pVUpwuxWlSrJTiVClWSLFcimVSLJFisRSLpFgoxQIp2qU4RYqTpZgvRZsU86RolaJFimYpmqSYK0WjFA1SzJFithSzpJgpxQwppktRL0WdFCdJMU0KvxS1UkyVYooUNVJMlmKSFBOlmCDFeCnGSTFWijFSjJZilBTVUlRJUSlFhRTlUoyUwidFmRQjpBguxTAphkoxRIpSKUqkGCzFICmKpSiSYqAUhVIMkKK/FAVS5EuRJ0WuFF4p+knRV4ocKbKlyJIiU4oMKTxS9JEiXQq3FC4p0qRIlSJFCqcUyVIkSZEoRYIU8VI4pIiTIlaKGCnsUtiksEoRLYVFCrMUJimMUkRJYZBCL0WkFBFS6KRQpVCk4FKwkOA9UhyR4rAUP0rxgxSHpPheiu+k+FaKb6T4WoqvpPinFP+Q4kspvpDicyk+k+KgFJ9K8YkUH0vxkRQfSvF3KT6Q4m9SvC/FX6X4ixQHpHhPineleEeKt6V4S4o3pXhDiteleE2KV6V4RYqXpdgvxUtSvCjFC1I8L8VzUjwrxTNSPC3FU1I8KcWfpXhCiseleEyKR6XYJ8UjUjwsxUNS7JXiQSkekOJ+Ke6T4l4p7pFijxTdUuyW4m4p7pJilxQ7pQhK0SVFQIo7pbhDituluE2KHVLcKsWfpLhFipuluEmKG6W4QYrrpbhOimul2C7FNVJcLcUfpdgmxVVS/EGKrVJcKcUVUlwuxRYpLpPiUikukeJiKS6S4kIpLpBisxSbpDhfik4pzpNioxQbpFgvxblSyLCHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHy7CHL5VCxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9cxj9chj1chj1chj1cRjtcRjtcRjtcRjtcRjtcRjtcRjtcRjtcRju8YqcQ3co5wbQRLsTMwTQH6GxKnRVMGwLqoNSZRGuDaWbQGkqtJjqDaBXR6cHUkaDTgqkVoJVEpxKtoLzllFpGtJScS4Kp5aDFRIuIFlKRBUTtRKcEU6pAJxPNJ2ojmkfUGkypBLVQqpmoiWguUSNRA9EcotlUbxalZhLNIJpOVE9UR3QS0TQiP1Et0VSiKUQ1RJOJJhFNJJpANJ5oHNHYoHMMaAzR6KBzLGgUUXXQOQ5UFXSOB1USVRCVU95IqucjKqN6I4iGEw2jkkOJhlD1UqISosFEg4iKqbEiooHUSiHRAKL+1FgBUT7VyyPKJfIS9SPqS5RDlE1NZxFlUpsZRB6iPtR0OpGb6rmI0ohSiVKInETJweSJoCSixGDyJFACUTw5HURx5IwliiGyU56NyErOaCILkZnyTERGoijKMxDpiSKDSZNBEcGkGpCOSCWnQilOxDTiPURHtCL8MKV+JPqB6BDlfU+p74i+JfqG6OtgYi3oq2DiVNA/KfUPoi+JvqC8zyn1GdFBok8p7xOij8n5EdGHRH8n+oCK/I1S71Pqr5T6C9EBovco712id8j5NtFbRG8SvUFFXqfUa0SvBhNOAr0STJgGeploPzlfInqR6AWi56nIc0TPkvMZoqeJniJ6kor8megJcj5O9BjRo0T7iB6hkg9T6iGivUQPUt4DRPeT8z6ie4nuIdpD1E0ld1PqbqK7iHYR7QzGl4GCwfgZoC6iANGdRHcQ3U50G9EOoluD8Tiv+Z+olVuIbqa8m4huJLqB6Hqi64iuJdpOdA01djW18keibZR3FdEfiLYSXUkVrqDU5URbiC6jvEuplUuILqa8i4guJLqAaDPRJip5PqU6ic4j2ki0gWh90NEIOjfomAs6h2hd0NEKOpvorKDDD+oIOnAY8zODjkGgtURrqPpqqncG0aqgoxl0OlU/jWgl0alEK4iWEy2jppdS9SVEi4OOJtAiamwhlVxA1E50CtHJRPOpXhvRPOpZK1VvIWqmkk1Ec4kaiRqI5hDNppeeRT2bSTSDXno6NV1PD6ojOom6O40e5KdWaommEk0hqgnG+UCTg3HiCZOCcWJ5TwzGrQNNCMblgcZTkXFEY4NxiAv4GEqNJhpFzupg3FpQVTBuA6gyGHcmqCIY1wEqD8ZUg0YS+YjKiEYEY3C/8+GUGha014OGEg0J2sXSKCUqCdpHgQYH7XWgQUH7dFAx5RURDQzac0GFVHJA0C5erH/QLvZmAVE+Vc+jJ+QSeamxfkR9qbEcomyiLKLMoF2MUgaRh9rsQ22mU2NuasVFlEb1UolSiJxEyURJQdssUGLQNhuUELTNAcUTOYjiiGKJYqiCnSrYyGkliiayEJmppIlKGskZRWQg0hNFUskIKqkjp0qkEHEi5uuxznUJHLE2uQ5bm10/Qv8AHAK+h+87+L4FvgG+Br6C/5/AP5D3JdJfAJ8DnwEH4f8U+AR5HyP9EfAh8Hfgg+h5rr9Ft7neB/4K/AU4AN974HeBd4C3kX4L/CbwBvA68JrlFNerlgGuV8AvW9pd+y1ZrpeAF6FfsHhdzwPPAc8i/xn4nrYscD0F/ST0n6GfsJzsetwy3/WYpc31qGWeax/qPoL2HgYeAnw9e/H5IPAAcL95ies+81LXveZlrnvMy117gG5gN/x3A3chbxfydsIXBLqAAHCn6XTXHaZVrttNq123mda4dpjWum4F/gTcAtwM3ATcaMpz3QC+HrgOda4Fbzed4roG+mroPwLboK9CW39AW1vR1pXwXQFcDmwBLgMuBS5BvYvR3kXGia4LjZNcFxjnuTYbb3RtMt7sOlfNdJ2jlrjW8RLX2f4O/1k7Ovxn+tf41+5Y4zet4aY1zjXj1pyxZseaN9f4YiKNq/2r/GfsWOU/3b/Sf9qOlf57lPWsVTnXN8x/6o4Vft2KuBXLV6hfreA7VvDKFbz/Cq6wFbYV7hWqebl/qX/ZjqV+tnTy0o6lgaW6oYGl7y1V2FJu7O7Zu3OpM60a7Fu91GKrXuJf5F+8Y5F/YesC/8no4PySef62HfP8rSXN/pYdzf6mkrn+xpIG/5ySWf7ZO2b5Z5ZM98/YMd1fX1LnPwnlp5XU+v07av1TS2r8U3bU+CeVTPRPhH9CyTj/+B3j/GNLRvvH7BjtH1VS7a/Cy7MUW4o7RbWJDkxMQU+Yk5f3d/qc7zm/cOqYM+Dc61RjrMmuZKWvNYlXTErii5LOTLowSbUmPpeo+BL75lZbE55LeDfh8wRdrC+hb341i7fFu+NVh3i3+Am11RqXVRIPKNbe1RXvyaq2OrjV4XIoVZ87+HqmcjfnjNtAqgFldnGHq1q9n4tfo4tgnF/Ear3jug1syriAYfKMAN8YyJwqPn010wORGwPMP31GXRfnF9Rrv5MQiBO/VKKlz928maWWjwukTq0Lqtu3p5bXjwt0CO3zabpHaIYi9d7Zy1Ys89b5hjP7e/Yv7KrjQdtzNsVq5VZrj1XxWdF5a7QrWhEfPdGqL3rA4GqrxWVRxEePRY33WeAR75dtnlxbbTW5TIq/zDTJpPhMZRXVPlNe/+r/6z13ivekJ3uXz8bH7GXLvdo3UvV8hUh6hVd8L1uOtPhaoaWZ9xeNioHmLIMtl87lv1zr3934792B/3yj3+QZ2aOcw5qVdcDZwFlAB3AmsBZYA6wGzgBWAacDpwErgVOBFcByYBmwBFgMLAIWAguAduAU4GRgPtAGzANagRagGWgC5gKNQAMwB5gNzAJmAjOA6UA9UAecBEwD/EAtMBWYAtQAk4FJwERgAjAeGAeMBcYAo4FRQDVQBVQCFUA5MBLwAWXACGA4MAwYCgwBSoESYDAwCCgGioCBQCEwAOgPFAD5QB6QC3iBfkBfIAfIBrKATCAD8AB9gHTADbiANCAVSAGcQDKQBCQCCUA84ADigFggBrADNsAKRAMWwAyYACMQBRgAPRAJRAC6kT34VAEF4ABjzRw+fgQ4DPwI/AAcAr4HvgO+Bb4Bvga+Av4J/AP4EvgC+Bz4DDgIfAp8AnwMfAR8CPwd+AD4G/A+8FfgL8AB4D3gXeAd4G3gLeBN4A3gdeA14FXgFeBlYD/wEvAi8ALwPPAc8CzwDPA08BTwJPBn4AngceAx4FFgH/AI8DDwELAXeBB4ALgfuA+4F7gH2AN0A7uBu4G7gF3ATiAIdAEB4E7gDuB24DZgB3Ar8CfgFuBm4CbgRuAG4HrgOuBaYDtwDXA18EdgG3AV8AdgK3AlcAVwObAFuAy4FLgEuBi4CLgQuADYDGwCzgc6gfOAjcAGYD1wLmse2cGx/zn2P8f+59j/HPufY/9z7H+O/c+x/zn2P8f+59j/HPufY/9z7H+O/c+x/zn2P18K4AzgOAM4zgCOM4DjDOA4AzjOAI4zgOMM4DgDOM4AjjOA4wzgOAM4zgCOM4DjDOA4AzjOAI4zgOMM4DgDOM4AjjOA4wzgOAM4zgCOM4DjDOA4AzjOAI4zgGP/c+x/jv3Psfc59j7H3ufY+xx7n2Pvc+x9jr3Psfc59v7vfQ7/h1v9792B/3Bjy5YdE5gJS5wzmzGmv5qxI5ce9z9GJrOT2TLWga/1bDO7lD3I3mRz2TqorWw7u4n9iQXYQ+zP7NX/3n+EOd6OnB6xgJnV3SySxTLWc6jn4JGbgO6I6GM8lyIVq3Mf9fTYej47wffZkUt7bEe6I2OYUatrUV6E95/8cM8hXLlI9wwSaWUDtFWr8aX+6iN3Hrn5hDGoYdPZDDaTzWINrBHv38za2HyMzCmsnS1gC7XUQuTNw2crUnNQCseLpo+WWsQWA0vZcraCnYqvxdDLQimRt0RLr2Ar8XUaO52tYmew1WxN6HOl5lmNnFVa+jRgLTsTM3MWO1tTksmzjp3DzsWsbWAb2Xm/mDqvV3Wy89kmzPMF7MKf1ZuPS12Er4vZJVgPl7Et7HJ2JdbFVWzbCd4rNP8f2NXsGqwZkbcFnms0JXLvY4+xu9gd7E52tzaWTRg1GhE5Lq3aGC7GGKzGG647psc0fit7R2st3l28W2foTU+D/+xjapwaGkdRch1KUis0D6KVNSeMxEV4B9JH34hSW7T3P+o9dlR+ySvHY9sxI3OVlhLqRO/P6cvZH7EDr8WnGFWhroMmdY2mj/Vf3Vt2u5a+nt3AbsRc3KwpyeS5Cfpmdgv29q1sB7sNX0f1sYr4Dna7NnMB1sWCbCfbhZm8m+1m3Zr/l/J+yr8z5A/2evawe9i9WCEPsL04aR7Gl/TcD9+DIe8+zUfph9kjSItSlHqMPY4T6kn2FHuaPcceRepZ7fMJpJ5nL7KX2KvcAvUC+wifh9nzEe+zaDYSP/7fg3Hexmaz2b/m6XaiRSQzB9ve813Pyp7v1NGsldcigLwNs7SLbcJP7AuPluQuZtT9hcWxXT3fqDPBOYffiGg7cl3P5ywCp+Yy9UWccirTs1I2gU1kVwTO9dbdxyyIUuLZEH7XXY7KSkOe/gFEIApzI4YxMM4rfFadYtmdnFzm2V0cuVm1j+nmebvK9JsRnZcdfufwswWH3zkYU1pwkBe8feCdA7Yvn7WXFgw8sP/AgP5OX1yyZXc7qhZ7drcXq5Gb21V7majvi2ov8yn6ze1oJLHMm/ys99kC77NeNOPtP6Ce29PtGuKiFb0+LtLTJ18pzs4aNHBg4QiluCjL0yda0XxFgwaPUAcWpilqnPSMUESaqy/+OF2ddDhSWespmzYwIi3ZGmeJjFBSEmPyhmXaps7IHJafqlf1kWqEQZ8zuLzPuPaqPm/o7amO+NQYgyEmNd6RatcffjMi+tA/IqJ/qNC1/3CZGjl0ZlmGeqXRoOgiI7vTEpP6DU0fM80aa9OZYm32eIM+xm7OqZx5eL0jRbSR4nBQW4cnMM5u6zkU6cXoD2OviFH32RpGLB6hWPr3TygoMOYnJiZ393y408YngL/YaQ2xReNvdpo1/nCnSbBi96VlDDCbjYkobrRZxQcKGo0oZUxEEeM9+LGL9ez1JSHBMgbVmBITLAWJA/IjXTk1Ln+MP8LPymAxCaX2gWW8YL/3gHbHF9oH2nqVvXR4wcCB9oED+s/CNP5kG4lHG8GkZcopsHt4tCpUNvfYe51FYvbSlAQ+kGPKhHREeg1xrqSE9FiDcmSganKkxjnS4kzKkVHcEOdOSnTH6nOdbe7+GYlRfGUEX29KdmUlLbA6Y83JBrM+IkJvNujm/XCZ3qhXdXpjJKZoa6//pn4Z5uQc548nqTel9UsyRcWmOrCkbT2H1Pd1WSyD5bAlYhbuSkzINmdZuhXui0rIcsNvyjJ2K0N9NpaVmdov+zuzOSa1JaYtok0MmFjk9phSnlSQuP+AvbQ0pjTZ9jYJsdZtqGHO/q79aJ1EquRFJTFA8fGR2lLOzk7XixHKyho0mGvrV5eg96jp6ht61ZaVnp4ZZ1BPOuKbojPGZqSkeqIVA5+vMydmpyV5EmNMBnWNciefNyw+OVqnRpqjDn4SZTaoEdEpDvVRU7Re5VjSZkPHEaP4X+DXMqb+iHgnhrnYCNrtsUopTopkJc4XFZX4fXSz8/uIeazsYBn2b2jTmqMTv2+Pbo5wft+OLGzPMm1TiqlEp7WpTMf86Yvy4bCLPan+OKbzic0/xGVkxHF750PrKgM5/g3tF1/Uur4+V3Ftenr9yNR09Yb01KpzHlw7ZdO8IT9+NqDlCvG/0K/tORTRgv6VsJNF73blOvKyE7t5jy+qj6XAmJfXp8goUnbWp7g5L96kpmY1p7bZQvMh1p5YvgcKY7BYY0pLbQcKMRviFawnFpdr9cSVGpqRX1qp8Y6IFn2sOyHJHaNXjpyv8+Rgf0epR7Yq+hh3UpIrRp+V2O7KTccy7avjheak9L4prUkZCXqTXqfDh7ryx3PMZjUyKlJd/eN5vd7H+7jFEj1cpDyR1i/Z5O6jzRdW6DaMx0DmY81iRPYwo+LYNcDmtReJX0rJGmrvxsxZU7z2D4YOTSj9xt2cEBoN7QwuxSQW7j+AsXhFm8oY71D7B+0o6S79pj1UVgyFdtKWHjMW2dn5quf4QRBz7BAncJqakBAfrx4z3dsMjswUZ7rDqE6zZvQfWTRP27DpcQbMf3LDuTP6pxaPH+DMy0y31Rv1nzr6j/NtuWDExMKkWD0GQY2KNv2jX2VB8pFJvYPxVHpqVvW8kUXTqgptpvT+vpyPkpOUdzzDvElH7kgqEP/PbmbPQbVMfVIbmW+0E9RtLXeVF5SrpqiEIjPOviJxChaJA7DIZrXx8UXd/FtfNMvOtjJuZuKcZEPEoYqiQ8RhagmxiXiXqDOkWzH44uwJj7IiW5EydG8RZ0W8qCh/ZL9ujlX1fB/ep48u9eP8scPfMk/QsQKxbzCUs8S5UDBryexZYheJE3Sfd/as0gI6TguxJGfjFLWYEnhRwqPtor0+WoPx7awPj9ehzfzUj9vzx5qHv9Uu2k0sEJsOTc6ZPUucHgXeWdpcidWalVVcTKtWu+wGFot56b0QR+i0o1UvPI64+IGFgwarZbYUZ7IreujFNaOW1eSNWH7L/NXxAyaWDm8cM8BsMEfp9M7yaa1FjRtrs27YXNlc7qqfPHLR8ESzOTLSbJ5eVp1Z3Tpy/OKxmdVFk4udqZ5Ugy3JmpSa7EmNzfWvrd2XkFfWt3pqeSXmqAFztA0/mWUhvrhPmyNX2VBucpaKmSkV91OpzSY+MBelYqJK7+Xf4zAq6HlPzEZB6AosCF2BBaHZKgjNUkG3YvQZY9OrTaXZTl10P/GPpIljMc26ndETIsZjE4jZ0M4Eusb2h26zUu0SM8qKiaLmrvbEsdGi7q52rTJ2hRjyE06IY0e6MD7BHgovHGpWFo1wmiI2xGB1m96eEifu/VFbZzRtOimncO7Fcyat8+njXIk4N6JuqlhTWVY3OMlRNG1k+nBfdXYSriosfbNh5YRpE9Z1zV1+7zmjqioUk94ibjCL/nDV1JOGzV3tqzy7ZXhMv4oBOCu34mfSm7UdsF47KxcX8yxrKDqwhoYI/IW2kK2h8MHazb/zxTBfLFa/z44PN5wsGadqpi/KOzbL6nCPcYihw5EhroB9GC9t1LQx6/JqBY3tR0smUtHeG6EPrT79MUdHaIwc2tUWqdysREYZDAmpGY6k/sVDPIYYutsjY1IS4lNt+syRQ0pTLekZqWYd7q658Wn2qKgoQ1z++MGHAwaTQafDh3qOwRSFg8NkWDeoMtuqGozGqGgnVlyl8qjii3CyPDaEbRKjEtQ7hohfK2UeD8Ps1vtSrZlb3G6n42J3Pu+f78tX8vONzi05SwZfalyuLgutGbF3D9q1GPbAPrFtC7VbJNOduaUdlfMdF7ezfFv+F/mqWUX9HOeW9pwlxsGXtmtthJZOaLeGQlgRtf7sTs2ScepxG1XxOdPSkzNnDckdN8iVM669otbiGpiVOSwvzWCJiR7aPLxyVmny+ik5Q7NiCnNzyzKUv5rNJkv/zL7xuWX98qvy4j3OfimWGIfdkxIbl5aYOmhCQYc53h2fnZ2RjbEajbFaFWlH9FPMpmtjFZVUfC+vwwbM4+f5bHbXgqQoNScQv6TwKvMxY6Ptp/2hIYnVCsXnBNrjl5gLr2o3HzsA2t7hoXj9/2vr4KVXJaXb462RBY3DymeUJrtHzikbMCVHb02Oi0u2RW7MGZWTUeSymtP+D3vfAdfU2TV+bzZhKjIFuQgCKoTLUtCKIjPKMiDOiiEJEAlJTMJSaxFHsWoddXeIWmutdddqq1bcVq271tZad60Dt3XU8T/Pc29CoOpr39/X//d+7y85cvOM85z9nPPcXIiRQYFSCeeigyMPCmlCeER4lvqNFGNWx6AgUsIX8bhcnoj/LEcioaITAwJTYvw7xqDzhYaznzyC4yMFabyurTcBO6JfDwdv8c7g4W2d3dro3YyN0X97J3OUcwwW79Q0zr9GzHdC5wQm4nnkEQ5PyBfZO7u1cPahAtz5LowyXgEBHp4dggJcnfzdhTySd7SFp5OQL+Dbe4b4PvsM1OIh3TiQeR0cUv1CPEQ8kcDJg+CQ4ud/kL/wh8BdYHuiHT638tu1znBJAcFPHwR5v+K364H7IKj36YNWYsZwg1izuza/Q9oiRHcoPi2FLUiRW4BP6wA3kZOdV4ifX3tPOBi29/ML8bIjy+AoCTsQDpjfOLR04AscWjj8GeffsbW9feuO/v5hXvb2XmHo3NLwvIFcxcvHEsYy50x3jpKgCDdO3Ff2Lh1AXjUBwrrsNJ8yv0KDPWDUE4nsstNK6GBu9MuEniV0bu3m3tpFQLYQwOG4dVs4Udi5B/r6BHnYwQnexzfQ3Y6MQbcEXLhwnju4iPl8e2eHJ5RvsKe9vWewr2+Il1jsFQIyT+IWcubzy6yt2joo1SUVrPp9JLZq6x64j6z6fWQTq7LyCJuNuLtxxgpcPFq29HQWeIhb+XvAmciOfPZOkzE6iDvBbFbykLn1LKLpmIsLQbgQhcRA3iBeJtyxOxMecIYPJsKJzkR3IpXIIvoR+UQRoSMqiLfJdFxttdnFmlxNbOWoN0aF6E2hJmqoMlApSkt3SCd6JPGSXOjoVtGaUSZlelJ0dFK60jRKI/TpP9jTp5ehPLO854jRKaMjh2k7ab0HDmkzpKUszz2P0yVeEC/uIHGSlI/WDsmLl0ji84ZoR5cLgwoL2gYR4d+Hf9/CIy6cecHd4/eRr76QaEXLv7MC7cbYf0++HkFwjvL+uyJiNwe0jYmOigxm313Zdw/23TwvbNZv/t58XujetN+uGX0zP+5xOjqanokuD6IioiICUetZ50h4rYiKiIjiyND1qTca4Iy14D5dSUdHRgaSEdHREeQeNPlsMLo+QNgzUYs7Gy409J79GBUVcQY65Bxo5CFqI+FCbokMj3maBq1ZNB3NoVikZ0Jo/I6W/RRNR0ug8fw58R7nEPcM/3eOQFSPPngy94muxFAUi2vCvNAvQgbQYvRGBMRs5IxfL/Gw57YJQa02xhZGvtH6Jq4h0qUBeftrIuZFmNb3b5ZN14LLftDADXD9y+2ba5Sr+YMG7hmhi5eba2sn4RXSztnd2cXdyY78hSSFLp4w6ixs45riQXm5CL7jHhO2dPNq2Uvs6mDHucCHExqc0ficHk83cwV8Dpcn4EF7h2X8hLcbkGjx9A7HsaW3s4Dv0MKxyXeyOSBLtMaXAQNosNLzb4RTObTwPvo2rzWQgsKj6Aiuv5t/Cqf86bvC+4V41db/DCDH/K/C49cDTq9/CI6+PnDz/6eBF/E34ex/P/CH/SeBgMAw4hVw2gY2+O8AoaQJ1P4Hwc82sMF/N9gF/9sQbgMb2MAGNrCBDV4LvrSBDWxgAxvYwAY2+C+D7TawgQ1sYAMb2MAGNrCBDWxgAxvYwAY2sIENbGADG9jABv8FcOy/HdAf8XLawpWL/oSI44L/koiL/zLLCfdQm0M48VazbS4RyPuWbfOscPiEJ+882xZYjQuJct5jti0iOvBHs207ghLWsG0xp86Cb0/kCRexbQeig/Ah23Z0EojMcjoRGvcQ819MkSL3mWybJIQeH7JtDiH0vM62uYSn5122zbPC4RMOXvZsW2A1LiS6enmwbRHh5v4B27YjXLxkbFtMZlvw7YmOXgVs24Fw85rCth2FXK9FbNuJ6EQtAUlInh0I15KvZ9uMnZk2Y2emzdiZafOscBg7M22B1ThjZ6bN2JlpM3Zm2oydmTZjZ6bN2JlpOzp5UqfYNmPnZQRFRBI0EUHEQisDf4uagdARRvgpJEwwloi/fY75Djo5jKihpSUkMJNAaAAoQgZjRUQxzBlxTwXvKsAuh6sSMB2JNGgVwIiKqACMLKCmAhq5RBVuUUQ6UK4CumWYowZaRVgSCn50+PvbDBYelEVmmoiCVpCl15kIxfzlQEEPuBTwlQMfRENBlLC4vaBXDKNotgzkM1r0ycXfImfEErxMnkJsB4roCf0CmEGjcmyFpjoydHSsphTmUgazCqyv2boVsNaAR8oAS4mtRsF4MR7LIKQgE7KOGq/TYrt2xetVGENFlAJPZGUlvlKsRGZcCo8bsU/VIIvZe416oHkTSKGGlUawQiLWRo01UVv0kMNPKaxgJGT0kWMeFOtrNVBEVOWAh2hVQa8CWibsB/T9hAXQ1mCZDNgWSF/0/YdFrKUYqiasE8NTizVSYEm1mIsR+0mKvVIII3L8/XsGrCOF3xlfqLFOjC2MOCqMQFXOxivymJ4dN3MpBToabB89K6UWRkoxV4amEVuqUQLEUY91MX8/I2NbRnYNjhoUCcVs5CKp0HcRou94NOGeFvvaHNeMzRgujB+1rF46bNsCjNkosbVGyGqVeB2jdQn0JXjvWnszGFMrxRSqsB3K2F1qbW9z9GnZSEb6M34x4Ggwx6gK+xpFrt6iDSNjEYtjhN4IlroJtGA8VG7xkhzHCNoBpU30MmceBUgix/wVLH8Jzi5F2Fdo5q/5qstftM5jI8cc+Z2ASiTku5dHugnzVOJIRFxKLD5o3Jl/zZNFbFzrLdgochmPawFfhWPn/0++Fdsy7v+ZjJsOkiiIELzL2rPzFJGKo0KHJTMB6CGywwEqMEhwlm0aORI23sKhXYXjpwhHEPJLFYyiPVSIZUFx05SqBsuAJGjEMNN7UYwacZzrse6MFczrkFcHYMszmaYKW5qxjMnibTO2OS8o2NyNdnkotgHC07NRYZ2n9diuWjY/MFRUbF/O5mQVzihqrCEjXQGWw+zl5h4zsSuY+DH8ZaTQokPoa2UCpioosU1NbPVh9ifDN9TCp7kGTBatYL/NtvglNqtgNVXjnabBe4rZ+X+1PVrDVJYQwG/fJIJfTJ2R4d+1rfX+YKo7xdZnE/acokmdbK5BY1VsLldXqxhAmjC6MKcFc640WE4eSlx7tTiPyF+qKRN78iZRxeQDHXtltGLaZXi/MPlJieuYms0tDB2EqcHZ/+UxymRxLeuZRurmHaK2OlUU43ynZu2MsrojzpcqVgfzCcNs5aZRHYo9I8dtJWE+XzXPc813QkizvKDCeboCnyjU2PvIq3IYQxYqwvmImQtnaeY3y53t2d3bmC0aTwNmaf5OdXrNakD5NKORbqZB+VqiGX1bNOMnc9QwpxMNW0Uao/tVFc4clS+vcshz2ZadY7Q6izD+ZqJAxfJisraW9Xso1tnAVh/zuYI5FxWxfjbHMRNXeva8w3DQ4XO3HOtpjhQ50Vjlm+ezf8AXFgvJse7Ibmo21yvZvapgz9paLKt1zVTj07gRxyYr48t9C+2cpnUevN3eykZKqzsE6/3w2vSIxrsaM/aLs1tos+xmtn3z1Rp8V6BuprdZrsYzWOOuaaxEZh+GEua7M3QXZu6rrCJEj++/NDjeiq0qLCN1AZZFxVaqMosvrXMJ48Nw1uNGvEs0FhnM+7ppLL2+Va0rPKOldaVpGtONlqjAdiz9N/1orgZl+O6SsYzKSgIlviKejXYZBhgKq9phekU+ZjK/EmtgrnhdmmRx9H8C6HDGefGpW4trhLnKWN+fmevEi3JK01VGnCsYXxWwer+45spf4lGDRXsjjlItps7sor/e+f67EWCub2lEMp7NIlKg1w+qpQyPSGGMgiwqg5k86CXBaBKMBANGDjsfjD3VD9ehNMDri2scQ0MG10zoD8A5LoWgcB/1egN+JtBCa5OJ/phHMlDLwZgyTDsDRtPhPZnFQysSYaQv9FE7FWdBhl8mrGLuIaRsTWQkzYVxyqJhU6mkmKNZsgzoyYB+GjubALSlmB6SH/FPwe1Mi5wprKQJ2EaIMqKZCBKl4x4a7Qvv2YCXg/knYJ0ZaTOxDikwz+iSjCVAnCWsrgwesk8eO4N8hORLB2jUKgHbIA1L02i/RHjPBskR/VSYzcUVIgtWJmFNc7D1klmbIW3Tca9RK8ZTiVgbZFVkgyRoZ8BPqsV2MnxlZJFZUWtqu354vhGL0S+BvSZiy2XhHuONRNzLxb5Cs6GsL2VYj+Zc++FITMZYCVjjHEuEpODoZaQ3RyfDI8tKEoYf8q21LOaopl6xRxgq5vm+rKf/ahdk9QRsEyRXjoXzyyijvfk/dRfaeH8ZjvMP+sSQ+eRNgs8HeqJyGRVJR8RSGWqFQWfUFZqoRJ1BrzPITWqdVkIlaDSUTF1UbDJSMpVRZShXKSWOaaoCg6qCytKrtLlVehWVLq/SlZkoja5IraAUOn2VAa2gEGU6igpCb51DKZlcoy+m0uRahU5RAqO9dMVaKq1MaUR8covVRkpjTadQZ6B6qgs0aoVcQ7EcAUcHTCmjrsygUFFI3Aq5QUWVaZUqA2UqVlEZ0lwqXa1QaY2qrpRRpaJUpQUqpVKlpDTMKKVUGRUGtR6ph3koVSa5WmOUJMo16gKDGvGQU6U6IAh85FojUDGoC6lCealaU0VVqE3FlLGswKRRUQYd8FVri0AoQDWpSmGlVgkGMGhVBqOEkpqoQpXcVGZQGSmDCrRQm4CHwhhKGUvlYFeFXA9ttKS0TGNS64GktqxUZQBMo8qECRgpvUEH3kDSAnWNRldBFYNxKXWpXq4wUWotZUK2BslgCeioBV66QqpAXYQJM4xMqkoTLFaXqCQUq2awkSqVa6soRRm4lJEbmU8LRjbIQReD2ogsqpKXUmV6xAYoFsGIUT0C0E06UKgcqSSnwAGlDC8UPIpiuQEEUxkkMlVRmUZusMRVFzPrLigeYvLARMgFnSSREU1MbzLIlapSuaEE6YFdaonMIrC4Hg0rdKC+Vq0yStLLFCFyY3vwIpVq0OlMxSaTvkt4eEVFhaTUvE4C6OGmKr2uyCDXF1eFK0yFOq3JyKJqyhRyIx5AeI3MjGV6vUYNgYPmJNQAXRlYrIoqgxAyoWBFw8gQCnCtSRVKKdVGPQQw41C9QQ2zCkBRwbsc3KgylKpNJiBXUIW1MocjmAriRmcwNwoRh9C/6g5xoCxTmEJROJbD2lC0xswA/FNRrFYUW0lWAUzVWoWmDGK/UXqdFiIlRN2e2RZW6EDhVdIyuwhiHfxuNBnUCiYgzQxwHJppdcUWCFEDF9gTKJUY0M5R6iq0Gp1c2dR6csZUEFmgDrgPNcpMesgCShVSE+EUqzT6phaFvASxy6Ajh6jxPilWF6hNKD855oLIhTq0W5DIrKlDqQK5EWTVaS2ZwuyEEDYWVFpJhbpErVcp1XKJzlAUjnrhgJnP5pT24F4cFngPIDIvToIvSl5HWYx0hHEMmXmYDnRCpoG9pIHEhs3dNE0iUzZJlI6O2cg5Rrx5QG8wgQpWQWiDZZShVKEBkh7aIrARi0BnZGOwFXgUllO6Akh2WmQUOU7U5jh7fS2QQHKjUadQy1F8KHUKSFlak5zJp2oNWCYEUWyiLZXDZupj7bFESpwNGT+8EA/nWTRsFW6hbLgh6c3TGjXEKcMb0TIwlQo44E2ENAxFuVxdiN5V2CD6MlDIWIw3LJAuKEOb14gG2SgBDcNBcaMKpWidXs1k1JeKymx4YMlsGtbSWIiKYl3pK3RE26DMoAVhVJiAUgc5FMsyTKUwmQOsMY4h+JVqvPG6MCEuL9CVq6wKrlZnQluGSeZqdhszkcJOGYtRPShQNdm5citFDYi90QTBpAYXWSrPqwyA9ltaMpWTlZLbL0GWTElzqGxZVp40KTmJCk7IgX5wKNVPmpuW1TeXAgxZQmbuACorhUrIHED1lmYmhVLJ/bNlyTk5VJaMkmZkp0uTYUyamZjeN0mamUr1hHWZWVDXpbATgWhuFoUYsqSkyTmIWEayLDENugk9penS3AGhVIo0NxPRTAGiCVR2gixXmtg3PUFGZfeVZWflJAP7JCCbKc1MkQGX5IzkzFwouZkwRiXnQYfKSUtIT8esEvqC9DIsX2JW9gCZNDUtl0rLSk9KhsGeySBZQs/0ZIYVKJWYniDNCKWSEjISUpPxqiygIsNorHT90pLxEPBLgH+JudKsTKRGYlZmrgy6oaClLNeytJ80JzmUSpBJc5BBUmRZQB6ZE1ZkYSKwLjOZoYJMTTXxCKCgft+c5EZZkpIT0oFWDlpsjSxxfJ0SiutluFJVKIeTi0Ru1FfaHlzYHlz8DdvaHlz8cw8uxPjH9vDi/+bDC8Z7tgcYtgcYtgcYtgcYzbO57SFG04cYZuvYHmTYHmTYHmT85z3IEJv/BgJezz2JCcSLXhz2rwYIMgTeafzXB696JXHnODiQgIP/47TXwnd0xPi1r4vv7IzxN74uvosLxv/9dfFbtED4HM/XxXd1BXx4J9BfUfAwPo9ANkuCxRzCkfQmPMnJRDtuL4IGrG4wl9wMX2qF7wb4FOBLAD8OsFJhLqsZ/lwrfA/ADwD8SMCPB6wMmMtrhn/DCt8L8NsBfgzgJwBWH5gb2BSfTLPCbw34IYAfB/gpgNUP5oY2w//MCt8X8DsCfjfA7w1Yb8JcEYojkYgUiXfsWAKvefMEfFIgvCWqrK2tFPFJkVCEmtARcEkB72w1eolIUsTDrWqimsslRfy6ujqRHSmy31a9rXoRwEyAWgArYnZ80g6ImanxSAF/dT0iYUeSdiw1hpwdImcnJu0c6uG1sMfCHjMwTAYQ8kmhUF8LVOYWiwWkWMTj8UyTx40bN9kk5JFClmS1mOSI+Raa1TweKRZMg5fYnhQ71g+tHwoc6qZT06l3AcYBCAWkUFQ5jjcKCNkLSPTfN76QsD3JsTcTZinbY8r2jqS9c71nvWddSF3ItLRpaUjN8aLxohqRSECKGNpAzEFIOthx4NUlpQZeKV1EPFIkYKlXO5AcB0F1U/oOQkTfwYl0cDnrc9bn1huHQ09qTmr2ph84sHPynsk7HHY42AlJO7tRuwWC0bt3Hyx3FJGOYi68uhbtQK+irtj2J8/WMy9HDsdRUG95EfX1fAHpKDqAXoTVvkJ5haPUaIvYto+RaSehdoJBXhBKJVYZNKFUqkFVEoo/6w6l0uUm7avmMH0S84Af34/hvRXDznc2XeM7Q2DXYULahAeOpJBTV+M7Fobe5pBkhD1tJ+B3dOJyvPkELReIOwpIHlnTmUPy6nLoPnSo1YjPojbVPsQbGLLwaUqH72/Q6TseAe1vRYzX6qfMbS03iK5/2G1oXt+G8v4hV3ZLa+pqPHPpGt52uob7eR2XQ3I4rlEg4qavKgKH96IgbaPXJtrRIi3JB7kqsJjcvjyBK6dvToQr3QJ1RK7ifnJjsVpbZNJpI1xoJzQodBXKVMpSnVYZ0Yb2QSNiV7cXPk6O8Kf90DzX1bNxPlddqgrLMclL9VR2YgLdxsMxohMdR3eO6BwTG915IHRjrbr0mLX/iGQOtBjN27tyE7ISI4LpdkyvjTZRrUdPmZJykqnknMwudFJybFhkUmJMWFRiQlxEOzqAUcjnhQrlMM/q6BqyrbWBST7BrSGdCRgXc2ogsW+8e6nzne23e5zaHNug/6h7YftzNx89v7Br6TG3Ubfv96m6V7N1wcP9W8fsHXJGYgzbN7nVgYtzHjtLD898z79X6IWVo5d0XTHsUX5IYZDnhNgWpxZ0HLuD23bdFeWBXr9fGXvktP6r3sJB/QSn8sRj556dePyPCUry07ZPxV9tGL47bvq1L2cMee+t6cVTq3cdDbNL7iPbn72levFDv19Ng2svcQtDMhQmybmdvmPD67sVdpnW4acf9N3mjth1oWhJfqtniy6PDHoacO9zxfOuX+3uuWBMaoPv7SOx4p8u6peoztQXHtflvt0n8vSplGmPNRtjNC3XVgxp3RC+ZrK3xxT/St8li3PPzfVZHkcXtpzkyuHCNlpcQ9qBRfi0L5jU14nnzms19Zcp+TfiU7fNu7Eh8uyeosCygx164xDyDeB50u7VrQKiH/4kS9GLG3r8Wf7nuo6rd8Ssc6ZzEYIfL4PuTUvrUuuSJySyH2krDJpmH2nrS9RoNJx9umoMt7gReRE7EYJSAih0f4EI9iWfLyRJXjrdi04z92nOhDde+pk5ZqAyvIKyiXZF8rbjoRBkSXJFzfYjF0WJfvsbiYm3EwbdVlH3R3eN2hg/y+Px1MLIeVN/mJQZs1jV7ZM/Bu/ed2/SjSdbgr8u2lvvuuLrrz/9ufqtn4M7h9gXe3158btrbR86t6vZ/MDh/YDA9Zu2lCze/KzFwN3dFs2r7T5789st+z9/b8BMx7c/znfZGlY4df6JMb/92pdIkZSknh4RZ3/qnHS7yy+zxm73m3+1aPuHqYYCsk9haXqdpEPJnKeHBKfixcG7Fq78LeCNmLkJhpLED0bGuw/88cjH0y6seFfU5l7PWrJ4QPY8+v6jMymltW5vUQOPrUsuyxjva7o3bv7wdcMrerXSjuvfRj2sftjBQyu7n6ZOx10YGd91f/2A9ydc9Wh7oGQK8SSWrhGQkMWuWGWxnVcmPhwxJvvKc5zFdlpbzR6y2Oh/JFeE0EHMpveznleqqBx1EX62Co5Fv1QTgZNZZzo2IiKSBohmklljlzb9I/Kx89yXzP/LbFT77sbAHcKp86ur3J4EDX1iqA19fG/xnNrZKRsW78+fGN4lStJmeuXjUcv8asj1I/Z7b+buS7m2a96DP3m+d8aLn7fVLrxT1G1XsOelEL/7vJkJiusXvnGb3OA6P+bXWH2uruv1Fcl2tHTbt1PpeQ77y797YJzlXnFk0qaZe0TjqYY2n8XcHr79rIno/e7RX6ZfO1H5bMrjFUNru2352m9lwZytu8atmbbyxKqOx3L/jPn5++Ezfmvz/Prwkv1vi8pNZ136pB2/TexNS18sjLk0wPHpqA/3/jbwwvj7J+Y7+7336cVxHttO7FvgS+55mrbUdUbUHP+0yIfbAxcRa7/N2TdW237QmJux2uq7m6672l8zZ6NqsMgoJt20Q+nGUpjTRaRlp3Kt0tX+EwXjDg2Nu/q8aPvgo3s3Ld+ww3UuLUPTLXiQiz5JpZMjHGl7prTwMrKyZRHRdCTq8l07RkbRdERkR0UsHV0Qo5KHRccVRIdFR0bFhsVGdYoMU8bGRBTKIyNjogsVTVJgmlZ5KZt/rOZzj86d264v/WxfGWfWy1PgCzOUTm/EWRDCBeIYohgCGMVvPrqE0Z3D6FicAuVWKbAvDYcVqxSY/C8ZmLPgK1iYaAckONzrPOdxaKLZdubWcEhC4O53qt/27L0BWYv6VP7Y8PDp91t+qL/9qHVeQ85edSr/h537r59/Mm/QrPwWsSH1/GTXs/OrajcXLj+16Rqnb8CGbgGVCaUrH94mBs6c967PAbtZh+f7JNHLlrjv+SZ10P2O0ZMWTO3feUemz6q2+1y+P1njsizm1sq2e6cGfjpm0plgn4uFvhPjJc/7cTO2acfWRV77cl14dt6bgjVuk/f6KjYYHS6cGBHk3GF28tLIsfGz4/tJKwImPlvjsufdSyK3Prs6DowYFDds9mef1JbMDtHd3rny6pZkjwMFmWPW53qnvjd3SWm9Nnj3w2C/vQ3UMvs1tw/az595fthH6rELO/1YSj0b/8PzHRvndLJ71q3VtrmtltVPOHCzZtvyvoGJnuvTxldOOPzo6EfdvX5qNfHylAXFgbXFXZftqc4MuizyT1c8/fB9t4yo9XlDs37s9XXse88lp9fkf5JY8l3loTWbSqaO1bxj+Pzqkj8XnPY+EfdE+V1pvOjSqLFrVmxe/M3IQ7PzPhnRf3/L1IKj/jefvLEzwv5BeLxySWfd0OzuG5KmZdXZT/p2dP8/9hS9Iz/18dydeyfv16Weq5fMbFjzx2q69Pow6WdXZpfv3SLa+azr/ZXGzoK1eYe8jm+6P3PfOz53qoeRWV+1HmNcd2xQ2+5d+nueqb1RtFO6NPyXdpO6DTl8PTppuu/m6Q7lNfE3d54MW8jjvJf26OZpziHuIigCQigCN5kiIJa7F0fj3O/T/ASbj9Op2G5G0MT374QqSS93LkRjhBft0WTQzhKsEIYdmbwZ2Jg3ZTodJE8IXXWhWiE3qaiEMlOxzqA2VaHkTnemo+moiMiYKDoOkntkBO5G0aj7v3eE/lf5fcFCzZozp9JmdBhVIvE6t+X8hV3z+gRkrzh42jMz0PnGkaVH0leYaKrFNeEPubPcpDNb95yxcu5gOuhnouT3kVuuTxQ6P3Dizb018YDf/qjAdz66c6/IJ/TJyMu1vlcvZy5euC0gZ9+Ux8mH7A4PWXV4dU/eokefat4v+jHkl5Sc1RMOXwpJkQR/MSGrr8zhIjf0z2HTptHad+4OoD96PPrEnHW/+88Z/fCo613RhpxS2ZfJ0xakEb1SC1sEty/8bM7FY4IxvRY9Gre0RWoru5oF4xr6Vj4j5/tmi8YTLnRKw4ZfA1I27QzLXbCqTWVCRMWBD850Hfv+Qjlnva/jmicPPlhLHmzbO/f5I/6O7ZS9Ob8vB4sspZ0tGYdPc+HNKp+/8HSJ0revM48H8TeBdhHYsTXBjUQjBD1mLpObx0yjx0ypbuX0Rc3QHnnBcy61c33S4Zw4Z9aAi58sVHwi/8fDs8alaoX7wl51S1akG/vfE7pKVHQ2UxSkNNShusS6hAndX/9cbJlGv2SJUjkuCLlWBSGNTqGTrApC7N85EyM9Ehmqr3keBlu7zHl3x2BuUqfTV75cUXHqYFWfDHKNxDR8UKmD6/KD346culFyvOWiyaUFG/tx9mdSrtnzTo/ocb7fplX95/uc8yUnfLGp8s6kw9e7kjfOfztVzN87Je38rRy301nLZ1y8PGXYD9Xbfpt5RxA+nntleofAtvo//3hysXKexPGB8Lx+s2fmR++ViA2zNi6M+7AobFcfp6sFg7u7z51EdT8v9I58dCCiV3lEt44G+71X9d2ejxe7ntkulr9368eNHtcyJ729K6bjkMVbr21+y77nyOM5Bv8b9L5NlarBg0gPcSunoz+3mnv/ja8L+68LC7/8aPyEA33yfv9IP1PzRVz68T+qtn7uOaKg/c1FH7SPFlR4F3zXrU2pX80t+z2hmw4lrrv06Ppb6y988pkpZmPmruEBLYPK7d+QTR4+MCWx1eZ161ZnFO1d0PN5dZV/9cdudOHvPVsO8d77cVv/w4lXOl7ZdC/tQOjxk5HV6UEd0gLzB17Nu/npr/M+2tdFt2VMsEnQ4ka5/9YParYF5361Zli3iQvL5V9qF7p+uvXz1FstdU/fjdSsfXamz97JAd8VbvnI952WSk63sFUDpm686H9p/ep9ii8rc/nHEyTZX8xcvaRy+bq62WXeP814x7WsbXjkZyJt3aDJ7bbW3Ry3z//EtTZZ382/IT37gFTpJtq/tVe99zft1aVzDka0f+60a9DgkxmtF558HP5xd0lf95LvXBc/pWuEI+gafoG5FDhNO4pLAbf5bcCY2n8kFUfSNLMh27/Ohmy8I4iAshEbScfEMUWjE+5G0Kj7v37HUsP5a+3goNrBgdoBe275rccGFx/JipPaz2tcMqK/ufNVf/8FPVt3KLkyMPvzjYJYb570m7d3OLQ53blkd8uT9rdit88TrN4b9wPZKqLnsYmOVcp3Rs8cGqhZ9bH0wyvFQ46e+SBnrTh0x6qflnVcOcJu1Y+zB+wb6s2/Ulj+e6QsqGX45eWi7EPrkja8eXKnhFu2vPju/tK7XQYvdL+X8s3ZWOUXWmVM5ad1CuewYz3ef3jhV6HjD4OrlkjbX3b8ts614tuZ3W7+eaHjQBe/jLyQRSMMZ1t22SAdcrKhIXH62J9Grh05ofVP8Wsmv/n7xKxx3ncWhg+4OK1r2Mqo/rs2xD+LPLaO223N2lUzYkcf/ag69H5m3nT/mHY74rTKt3O++dB5hVfAuP33vuFOmPIg/9Zh2dbJM9/ZXO9vapfvGfLVgeCQ2HZz43p1OjRqzYyVPgFLlxVel/sNOxci/Si/9ny7N4/5946X7Vzfr3sg99aREYPCfwi4oH/TuU9KxbqHxLnNX3Bq8k/Vu63b0vp4396X4xY6XwmQbvbcmDQq+eK2HYYRZw2XA89sTZm36+Z2n36nxk65niGlly5/78z1QQtWPTm9uvD8tjljRjacaOh9Wdp+qWvIp0vfKqr+7d2Cyvy14eN+7Pfh4K0VISG3G0p3hEwNndqjc9a2c+OTJu60S991fEliuGnWA+3DSqp/qOubQ2fNj8+KGvfz6lqPXz/OvDd79eaUOs3co2dP1E621M4GqJ1XXlD+GovnC+9LvCwLWnF4Dm3ERA5+SpxIJDStq38pytZ3PIawLpyIaYlft+Jnnru6dE/EkYCJ0fRAprihT1Cz6jLqek+Q/q0PfWDfwq6FzWq5Kcmno/IjI3GZG2JV5mR0Np1pVeZ6vl6ZewV9Ez1mARKe4o2ZQ4+ZSY+ZbjGShEuPGUt3N7PjkO5R/+o2S6lTGEEzdancUKXQGyXFplK6h4UAh45uE0n5EukE+l4X9EA+Hz+QZ36Bowp6RvZXS1SWX7CRUL4vuhErujNhydyzuVXekmMnTUVtP7Cf3eKcYsa8nrPfOlrlMG2bKl8SGv9wh+FI6dhn33b/Xbyv69bUZYvvqk8ptraNWTLnTdW4aW9NSsnue9Jhxqij3r197r7Rc5Ls8OqnJRfihZL2H/zWrfWS4+t9K2bGnb+i/C6pW+WIgLuub306zTR2yr39QZyUDtvfddn0yTK+wwcNxY+LJbPqOnTvUNJfqvCzU2sHzp19cey9+ql3Uzr++qTr4S0xN7XtVl5aFdxw+PRdp1XzQubMzXDqZn9HNPGE345Iz/O3doUdHPTxl9I48W7x9t0rVl5a+9Mpt9o+yf1jI4cHe7+95l7ww19Du1DquWsHTCzW6pZuMO3owRd8SnYIia/p7ppRaF+/LuP+ualv++jc3kpeWn6pRwfV4h1vygom7PBVdJoz4czPdx/ecV84P/jc90vmHL7xpiLhwiDhh+/ECyoERwRryvxafSuXr7/1y+7WvG/PJOxxCrnxqyr8+pw/Fg6efZI4sTBly4C7c5bY9U5zmVftd5hov2vNB0u6J1e0idl9dNGiBSNGtH2cNstv+Z+pAdX3P364tWRD7znnr5VVel+/2nlelWfv5yfWBRSX/bbq8ZNJ1+yrr6q7rvp/+2PwlsWn7/790tzkibYX54b5+e9vCFdaWCFopFj13pFro/3vFWeWxB5c2DE7vDDMz8P1gNPJ2WXRXA0e2X8r5x/cm5ubdTKoWJi3KuCsYRPLBoMmljVMjIwGjVMHuuLCPhyImBtZ0HgEVPhAEzEnsyEP8sQL0BUIHrchnwGyrKiBMkIjiyGwaPN8d9W8J5xB+C33tDcFoSYBBuc/3DBIQdLCYxhmELJAq0ED67rfEMytegvVGlRw5uwQ+LprBbS6maWJkaFMfeYmpsVb5ifVRHpcfPF2R8snqei9Uz8zdD9s/3h3r+SNqPfZBTsye5y3sBxUczeYacjw7Y+TQdGJwxylqT/M5jCI3WJhuxWxu+D9ctf1888eXXU2pmeVsd3RA9MOpM3g+Bz/Zu3sgBS23Ym/vNXcfzs3cr/r8cot+eYed9erYvH+4r1Gb7xdxdNFUid99uewiJA+tWn+gwn3T5/afubd3Il9rw9YzRJ5Eczx98b3G9q7jdin1wjdDF5TETQ7YeKxs4n5/k8lfyi4h876L/v0993Yqy/562taPZ2U/Vtinfoaf2Rc0EnsZ/BeM8nYLNHj6OwDVyv4eLo1w6Ojds3ewOYqrV20x2/a+aMePz8tbGLSADZPVBBxxGbYxCQKFBIEJ82+AeuIY59oQ0qTsQYSyEmSGzFhyAi0HC7DasgPHjg2NDIxNDcyN7GIwkiRZdz8Yd3JpRV6ovrt1bsyt07YYWaF1mUCpRUpHkeh7v02T/U82vqnX30enCBw35Jj08oj+4zf+uU1dKnsSr13QPS3RvcszevSMrzPWyaFbGbilsx9IHtvfxH74kdnFe+kRk5xrDmmm5Rl+aT6+5fbebefLZwyYVn3p5t7nNPS/uRuSTS9KLDg5ILblvcv737DMmfJ2jPaWzMWCX1K/5s0r2lJJwvzJWfDCwaXfGvl/bpfxTyY1TWjTKUpKluXZ21JsKXmkuCTH5ZsyO+7/WPezI9/XD/ue3+5Vmqvulr4vvelcQ2Z177ITsuv5furw92+dQZPZM4em4T0+bevFH6pCzxgo32tv7PjVHnCj3Tn3Y6sDtm3P1Y0imae1jx6W/PAdc3+WW5fC9sYGABPVT9EDQplbmRzdHJlYW0NCmVuZG9iag0KMjAgMCBvYmoNCjw8L1R5cGUvTWV0YWRhdGEvU3VidHlwZS9YTUwvTGVuZ3RoIDMwODM+Pg0Kc3RyZWFtDQo8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/Pjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IjMuMS03MDEiPgo8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgo8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiAgeG1sbnM6cGRmPSJodHRwOi8vbnMuYWRvYmUuY29tL3BkZi8xLjMvIj4KPHBkZjpQcm9kdWNlcj5NaWNyb3NvZnTCriBXb3JkIGZvciBPZmZpY2UgMzY1PC9wZGY6UHJvZHVjZXI+PC9yZGY6RGVzY3JpcHRpb24+CjxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iPgo8ZGM6Y3JlYXRvcj48cmRmOlNlcT48cmRmOmxpPk1laG1ldCBHw7xsZXI8L3JkZjpsaT48L3JkZjpTZXE+PC9kYzpjcmVhdG9yPjwvcmRmOkRlc2NyaXB0aW9uPgo8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiAgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIj4KPHhtcDpDcmVhdG9yVG9vbD5NaWNyb3NvZnTCriBXb3JkIGZvciBPZmZpY2UgMzY1PC94bXA6Q3JlYXRvclRvb2w+PHhtcDpDcmVhdGVEYXRlPjIwMTktMDUtMTRUMTE6MjU6NDQrMDM6MDA8L3htcDpDcmVhdGVEYXRlPjx4bXA6TW9kaWZ5RGF0ZT4yMDE5LTA1LTE0VDExOjI1OjQ0KzAzOjAwPC94bXA6TW9kaWZ5RGF0ZT48L3JkZjpEZXNjcmlwdGlvbj4KPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIj4KPHhtcE1NOkRvY3VtZW50SUQ+dXVpZDoxNDkxRDhBMy1EOUZDLTRBNzYtODE0RC0yNEE1RTJCNzBGQzE8L3htcE1NOkRvY3VtZW50SUQ+PHhtcE1NOkluc3RhbmNlSUQ+dXVpZDoxNDkxRDhBMy1EOUZDLTRBNzYtODE0RC0yNEE1RTJCNzBGQzE8L3htcE1NOkluc3RhbmNlSUQ+PC9yZGY6RGVzY3JpcHRpb24+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAo8L3JkZjpSREY+PC94OnhtcG1ldGE+PD94cGFja2V0IGVuZD0idyI/Pg0KZW5kc3RyZWFtDQplbmRvYmoNCjIxIDAgb2JqDQo8PC9EaXNwbGF5RG9jVGl0bGUgdHJ1ZT4+DQplbmRvYmoNCjIyIDAgb2JqDQo8PC9UeXBlL1hSZWYvU2l6ZSAyMi9XWyAxIDQgMl0gL1Jvb3QgMSAwIFIvSW5mbyA5IDAgUi9JRFs8QTNEODkxMTRGQ0Q5NzY0QTgxNEQyNEE1RTJCNzBGQzE+PEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPl0gL0ZpbHRlci9GbGF0ZURlY29kZS9MZW5ndGggODQ+Pg0Kc3RyZWFtDQp4nC3LvQFAYAyE4cv3g5YxLGQBc1hAYQsLMI9aYYeIOynyFMkLxLhb7B742MVF7CHpJnkjZRGHiFtinkQWRVRh4v9soqvOvF1JN5LpJPMAvD3QDBMNCmVuZHN0cmVhbQ0KZW5kb2JqDQp4cmVmDQowIDIzDQowMDAwMDAwMDEwIDY1NTM1IGYNCjAwMDAwMDAwMTcgMDAwMDAgbg0KMDAwMDAwMDE2NiAwMDAwMCBuDQowMDAwMDAwMjIyIDAwMDAwIG4NCjAwMDAwMDA0OTIgMDAwMDAgbg0KMDAwMDAwMDc0NCAwMDAwMCBuDQowMDAwMDAwOTExIDAwMDAwIG4NCjAwMDAwMDExNTAgMDAwMDAgbg0KMDAwMDAwMTIwMyAwMDAwMCBuDQowMDAwMDAxMjU2IDAwMDAwIG4NCjAwMDAwMDAwMTEgNjU1MzUgZg0KMDAwMDAwMDAxMiA2NTUzNSBmDQowMDAwMDAwMDEzIDY1NTM1IGYNCjAwMDAwMDAwMTQgNjU1MzUgZg0KMDAwMDAwMDAxNSA2NTUzNSBmDQowMDAwMDAwMDE2IDY1NTM1IGYNCjAwMDAwMDAwMTcgNjU1MzUgZg0KMDAwMDAwMDAwMCA2NTUzNSBmDQowMDAwMDAxOTMxIDAwMDAwIG4NCjAwMDAwMDIwOTAgMDAwMDAgbg0KMDAwMDAyMjQ1MiAwMDAwMCBuDQowMDAwMDI1NjE4IDAwMDAwIG4NCjAwMDAwMjU2NjMgMDAwMDAgbg0KdHJhaWxlcg0KPDwvU2l6ZSAyMy9Sb290IDEgMCBSL0luZm8gOSAwIFIvSURbPEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPjxBM0Q4OTExNEZDRDk3NjRBODE0RDI0QTVFMkI3MEZDMT5dID4+DQpzdGFydHhyZWYNCjI1OTQ2DQolJUVPRg0KeHJlZg0KMCAwDQp0cmFpbGVyDQo8PC9TaXplIDIzL1Jvb3QgMSAwIFIvSW5mbyA5IDAgUi9JRFs8QTNEODkxMTRGQ0Q5NzY0QTgxNEQyNEE1RTJCNzBGQzE+PEEzRDg5MTE0RkNEOTc2NEE4MTREMjRBNUUyQjcwRkMxPl0gL1ByZXYgMjU5NDYvWFJlZlN0bSAyNTY2Mz4+DQpzdGFydHhyZWYNCjI2NTYyDQolJUVPRg==";
                                        //}

                                        attach.documentbodyparse = "'" + attach.documentbody + "'";
                                        attach.filenameparse = "'" + attach.filename + "'";
                                        //testCount++;
                                    });



                                });


                            } else {
                                // no results
                                OGOO.UI.preloader("stop");
                                isPending = false;
                                $("#insuranceResults").html('Sonuç bulunamadı.');
                            }
                        }

                    }
                    // no results
                    OGOO.UI.preloader("stop");
                    isPending = false;
                    // $("#insuranceResults").html('Sonuç bulunamadı.');
                });
                isPending = true;
            }
        }
    });

    // date
    $("#billDate").datepicker({
        autoclose: true,
        language: "tr"
    });

    self.tagInformationLightbox();

    self.tyreDetailPrintOperation();
}

UI.prototype.changeTextHeight = function () {
    var self = this;
    clearInterval(self.textTimer);
    self.textTimer = setInterval(function () {
        $('.vertical-text').each(function () {
            var item = $(this);
            var textHeight = $(this).height();
            var h = (item.parent().outerHeight() - textHeight) / 2;
            if (OGOO.Helper.getScreenSize().w <= 1024) {
                h = 0;
            }
            $('.vertical-text').animate({
                opacity: 1
            }, "fast");
            item.css({
                "position": "relative",
                "top": h + "px"
            });
        });
        self.textTimerCount++;
        if (self.textTimerCount == 10) {
            clearInterval(self.textTimer);
        }
    }, 250);

    $('.close-button').on('click', function () {
        $('.modal-body').empty();
    });
}

UI.prototype.permalinkControl = function () {
    var self = this;
    var permalink = clientData.request.permalinks.replace("/", "");
    var module = clientData.currententity.module;
    var moduleId = clientData.currententity.id;
    switch (moduleId) {
        case 3:
            $('body').addClass("home");
            //var height = $(window).height();
            var setHeight = $(window).height();
            if ($(window).width() >= 992) {
                $('.main-anchors-wrapper').css({
                    'height': setHeight,
                    'top': -setHeight
                }).addClass('shown');
            }
            self.menuControl();
            $('.page').animate({
                backgroundColor: "#fff"
            }, {
                duration: 1000,
                easing: "swing"
            });
            if (Array.isArray(clientLightboxData)) {
                var videoItem = clientLightboxData[0];
                try {
                    if (document.cookie.replace(/(?:(?:^|.*;\s*)mainPageLightboxN\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== videoItem.cookiekey) {
                        // trigger lightbox
                        // BLT-230 | Update main page lightbox for mobile devices because of the Kahramanmaraş earthquake condolence message
                        // if ($(window).width() >= 768) {
                        setTimeout(function () {
                            document.cookie = "mainPageLightboxN={0}; expires=Fri, 31 Dec 9999 23:59:59 GMT".format(videoItem.cookiekey);
                            $('.menu-icon a').trigger('click');
                            var videoContent = $('<textarea />').html(videoItem.description).text();
                            $('#mainlightbox .modal-body').html(videoContent);
                            const isMainPageLightBoxClosedBefore = localStorage.getItem('mainPageLightBoxClosed');
                            const day = 60 * 60 * 24 * 1000;
                            if (isMainPageLightBoxClosedBefore == null)
                                $('#mainlightbox').modal('show');
                            else if (isMainPageLightBoxClosedBefore - new Date().getTime() > day)
                                $('#mainlightbox').modal('show');

                            $('#mainlightbox .modal-body').off('click').on('click', function () {
                                $('#mainlightbox').modal('hide');
                                $('#mainlightbox').empty();
                            })
                            $('#mainlightbox').on('hidden.bs.modal', function () {
                                $('.page').removeAttr('style');
                                $('.menu-icon a').trigger('click');
                                localStorage.setItem('mainPageLightBoxClosed', new Date().getTime());
                            });
                        }, 2000);
                        // }
                    }

                } catch (e) {

                }
            }

            self.homeSlider();
            break;
        case 396:
            $('#get-campaigns').on('click', function () {
                self.getAllCampaigns($(this))
            });
            $('body').addClass("campaign");
            $('.footer, .social-area').show();
            break;
        case 397:
            $('.get-all-news').on('click', function (e) {
                self.getAllNews($(this));
            });
            $('body').addClass("news");
            $('.footer, .social-area').show();
            break;
        case 398:
            $('body').addClass("search");
            $('.get-search-data').on('click', function (e) {
                self.search($(this));
            });
            $('.footer, .social-area').show();
            break;
        case 399:
            $('body').addClass("contact");
            $('.footer, .social-area').show();
            break;
        case 402:
            $('body').addClass("tyre") //.addClass('scroll-hide');
            $('.footer, .social-area').show();
            break;
        case 395:
            $('body').addClass("about");
            $('.footer, .social-area').show();
            break;
        case 431:
            $('body').addClass("hr");
            $('.footer, .social-area').show();
            break;
        case 404:
            $('body').addClass("wrapper").addClass("dealer-body") //.addClass("scroll-hide");
            OGOO.LassaMap.getClosestArea();
            break;
        case 406:
            $('body').addClass("wrapper").addClass("scroll-hide");
            self.processSponsoredImages();
            break;
        case 413:
            if (clientData.fromHome) {
                self.selectorAnimation("tyre", "open");
            }
            else {
                $('.home-templates, .selectors, .selectors-mobile').css('opacity', '0');
                $('.selectors, .selectors-mobile').addClass('active');
                self.selectorAnimation("tyre", "open");
            }
            setTimeout(function () {
                self.processDiv(".tyre-search .slide-size", function () {
                    $('.tyre-template').animate({ opacity: 1 }, "fast")
                    $('.tyre-search .slide-size').bxSlider({
                        auto: false,
                        controls: true,
                        pager: false
                    });
                });
                self.processDiv(".tyre-search .slide", function () {
                    $('.tyre-template').animate({ opacity: 1 }, "fast")
                    $('.tyre-search .slide').bxSlider({
                        auto: false,
                        controls: true,
                        pager: false
                    });
                });
                self.processDiv(".tyre-search-mobile .slide", function () {
                    $('.tyre-template').animate({ opacity: 1 }, "fast")
                    $('.tyre-search-mobile .slide').bxSlider({
                        auto: false,
                        controls: false,
                        pager: false
                    });
                });
                self.processDiv(".tyre-search-mobile .slide-size", function () {
                    $('.tyre-template').animate({ opacity: 1 }, "fast")
                    $('.tyre-search-mobile .slide-size').bxSlider({
                        auto: false,
                        controls: false,
                        pager: false
                    });
                });
            }, 300);



            if (typeof clientData.tyreListRedirectionRule != "undefined") {
                var activeSelection;
                if (typeof clientData.tyreListRedirectionRule.tyrelistingtype != "undefined") {
                    self.handleFilters(clientData.tyreListRedirectionRule.tyrelistingtype);
                    activeSelection = clientData.tyreListRedirectionRule.tyrelistingtype;
                }
                if (typeof activeSelection !== "undefined") {
                    var obj = {}
                    var value = 1;
                    var percentage;
                    if (activeSelection === "VehicleModel") {
                        percentage = 100 / 4;
                        obj.tyremodel = clientData.tyreListRedirectionRule.tyremodel;
                        obj.tyrebrand = clientData.tyreListRedirectionRule.tyrebrand;
                        if (typeof clientData.tyreListRedirectionRule.tyreyear != "undefined") {
                            obj.tyreyear = clientData.tyreListRedirectionRule.tyreyear;
                        }
                    }
                    else {
                        percentage = 100 / 3;
                        obj.tyresectionwidth = clientData.tyreListRedirectionRule.tyresectionwidth;
                        obj.tyreaspectratio = clientData.tyreListRedirectionRule.tyreaspectratio;
                    }

                    Object.keys(obj).forEach(function (item) {
                        if (obj[item] > 0) {
                            value++;
                        }
                    });

                    $('._progress-bar').animate({ width: value * percentage + '%' }, "slow");

                    $('.tyre-search-mobile .tyre-filter-types > div:not(".hidden") .filter-progress-area span').each(function (i) {
                        if (i == value - 1) {
                            $(this).addClass('active');
                            $(this).parent().addClass('active');
                        }
                        else {
                            $(this).parent().addClass('passive');
                        }
                    });
                    $('.tyre-search .tyre-filter-types > div:not(".hidden") .filter-progress-area span').each(function (i) {
                        if (i == value - 1) {
                            $(this).addClass('active');
                        }
                    });
                }


            }
            break;
        //case 400:
        //    $('body').addClass('scroll-hide');
        //    break;
        default:
            if (clientData.currententity.permalink == "haftanin-en-saglami") {
                $('body').addClass("saglamsa-lassa");
            }
            else if (clientData.currententity.permalink == "saglam-bilgiler") {
                $('body').addClass("saglambilgiler");
            }
            else {
                $('body').addClass("wrapper");
                $('.footer, .social-area').show();
            }

            break;
    }

    switch (module) {
        case "campaign":
        case "service":
            $('body').addClass("campaign-detail");
            break;
    }

    $('.menu').find('a').each(function () {
        var href = $(this).attr("href").replace("/", "");
        if (href == permalink) {
            $(this).addClass('active');
        }
    });
}

UI.prototype.checkOrientation = function (type) {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    if (type == "landscape") {
        self.processResize();
    }
    else {
        self.processResize();
    }

    //bu bir süreliğine eklendi. Daha sonra kaldırılması gerekiyor.
    window.location.reload();
}

UI.prototype.onPageLoad = function () {
    var self = this;
    self.changeTextHeight();
    if (!OGOO.Helper.isMobile()) {
        self.loaderAnimation();
    }
    else {
        setTimeout(function () {
            $('.loader').fadeOut(300, function () {
                $(this).remove();
            });
        }, 200);
    }


    $(window).on('load', function () {
        self.hoverAnimation($('.sponsored .clip'));
        self.processSponsoredImages();

    });
}

UI.prototype.onPageResize = function () {
    var self = this;
    $(window).on('resize', function () {
        $('.scene').css('width', window.innerWidth + 'px');
        $('.scene').css('height', window.innerHeight + 'px');
        if (typeof window.orientation == "undefined") {
            self.processResize();
        }

    });
}

UI.prototype.processResize = function () {
    var self = this;
    self.pageInfo();
    self.changeTextHeight();
    self.checkIfInView();
    var pageSize = OGOO.Helper.getScreenSize();
    $('.dealer-template').height(pageSize.h - 40);
    if (!$('.selectors').hasClass('active')) {
        $('.selectors').css("top", pageSize.h - $('.selectors').height());
        $('.selectors-mobile').css("top", pageSize.h - $('.selectors-mobile').height());
    } else {
        $('.selectors').css("top", "98");
        $('.selectors-mobile').css("top", "122");
    }

    $('.tyre-search-mobile, .tyre-search').css("min-height", $(window).height() - (OGOO.Helper.getScreenSize().w <= 768 ? 210 : 145))

    if ($('.dealer-finder').hasClass('detail')) {
        $('#map-canvas').height(pageSize.h);
    } else {
        $('#map-canvas').height(OGOO.Helper.getScreenSize().h - 271);
    }
    if ($('.sponsored-photos .row > div').length > 0) {
        self.resizeSponsoredPhotos();
    }

    if ($('.dealer-list-template').length > 0) {
        $('.dealer-list-template').height(pageSize.h - 180);
    }


    self.tyreFilter();
    if (clientData.request.permalinks.replace("/", "") == "sponsorluklar") {
        self.processSponsoredImages();
    }
    self.mobileControl();
    self.tyreSearch();
    self.setDropDownWidth();

    var setHeight = $(window).height();
    if ($(window).width() >= 992) {
        $('.main-anchors-wrapper').css({
            'height': setHeight,
            'top': -setHeight
        }).addClass('shown');
    }

    if ($('.home-slider-wrapper .bx-wrapper').length > 0) {
        $(window).on('load', function () {
            setTimeout(function () {
                self.homeSliderD.destroySlider();
                self.homeSlider();
            }, 500);
        });
    }

}

UI.prototype.onPageScroll = function () {
    var self = this;
    self.total = 0;

    $(document).on('mousewheel', function (event) {
        try {
            self.checkIfInView();
            //if ($('body').hasClass('tyre')) {
            //	event.preventDefault();
            //	var count = 0;
            //	if (typeof event.originalEvent.wheelDelta != "undefined") {
            //		if (event.originalEvent.wheelDelta / 120 > 0) {
            //			count = -40;
            //		} else {
            //			count = 40;
            //		}
            //	} else {
            //		if (event.deltaY > 0) {
            //			count = -40;
            //		} else {
            //			count = 40;
            //		}
            //	}
            //	self.total += count;
            //	$(".tyre-results").nanoScroller({scrollTop: self.total});
            //}
        } catch (e) {
            //
        }
    });
}

UI.prototype.pageInfo = function () {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    var moduleHeight = pageSize.h - 383;
    for (var i = 1; i <= 8; i++) {
        $('.scroll-type-' + i).height(moduleHeight).nanoScroller();
    }
    //$(".scroll-area").each(function (key) {
    //    var parent = $(this).find('tbody');
    //    $(this).unbind("scrollend").bind("scrollend", function (e) {
    //        self.getPricesList(parent);
    //        self.nextPricePage++;
    //    });
    //});
    $('.tyre-results').height(pageSize.h - 250).nanoScroller();
    //$(".tyre-results").bind("scrollend", function (e) {
    //    self.tyreLoader();
    //});
}

UI.prototype.pageListeners = function () {
    var self = this;
    self.checkIfInView();

    var siteHeader = $('.header');

    if ($('.main-anchors-item.type-1 .maslider div').length > 1) {
        if ($('.main-anchors-item.type-1 .bx-wrapper').length == 0) {
            $('.main-anchors-item.type-1 .maslider').bxSlider({
                auto: true,
                controls: false,
                pager: false
            });
        }
    }

    $('.header nav>ul>li>a').off('click').on('click', function (e) {
        if ($(this).siblings('.menu-content').length > 0) {
            e.preventDefault();
            if ($(this).parent().hasClass('active')) {
                $('.menu-content').hide();
                $('.header nav>ul>li').removeClass('active');
                $('.hover-overlay').remove();
            }
            else {
                $('.hover-overlay').remove();
                $('.menu-content').hide();
                $('.header nav>ul>li').removeClass('active');
                $(this).siblings('.menu-content').show();
                $(this).parent().addClass('active');
                $('.page').append('<div class="hover-overlay"></div>');
                $('.hover-overlay').off('click').on('click', function (e) {
                    e.preventDefault();
                    $('.menu-content').hide();
                    $('.header nav>ul>li').removeClass('active');
                    $('.hover-overlay').remove();
                })
            }

        }
    });

    //footer selectors animate
    $('.selectors, .selectors-mobile').find('a').each(function () {
        var t = $(this);
        var data = t.data();
        t.off('click').on('click', function (e) {

            if ($('body').hasClass('home')) {
                if (t.parent().hasClass('tyre-selector')) {
                    window.top.location.href = "/lastik-secici";
                }
                else {
                    e.preventDefault();
                    if (!t.hasClass('active')) {
                        $('.selectors, .selectors-mobile').find('a').removeClass('active');
                        self.selectorAnimation(data.action, "open");
                        t.addClass('active');
                        $('.selectors, .selectors-mobile').addClass('active');
                    } else {
                        self.selectorAnimation(data.action, "close");
                        $('.selectors, .selectors-mobile').find('a').removeClass('active');
                        $('.selectors, .selectors-mobile').removeClass('active');
                    }
                }
                if ($('.dealer-finder').hasClass('active')) {
                    if (!OGOO.Helper.mapIsLoading()) {
                        var script = document.createElement("script");
                        var e = document.getElementById("map-canvas");
                        script.type = "text/javascript";
                        script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDZZHwxXryKMg3GSS8q9bozcISkQBoXKHo&sensor=true&libraries=drawing&sensor=false&language=tr&callback=initMap";
                        e.parentNode.insertBefore(script, e)
                    }
                }
            }
            else {
                e.preventDefault();
                if (!t.hasClass('active')) {
                    $('.selectors, .selectors-mobile').find('a').removeClass('active');
                    self.selectorAnimation(data.action, "open");
                    t.addClass('active');
                    $('.selectors, .selectors-mobile').addClass('active');
                } else {
                    self.selectorAnimation(data.action, "close");
                    $('.selectors, .selectors-mobile').find('a').removeClass('active');
                    $('.selectors, .selectors-mobile').removeClass('active');
                }
                if ($('.dealer-finder').hasClass('active')) {
                    if (!OGOO.Helper.mapIsLoading()) {
                        var script = document.createElement("script");
                        var e = document.getElementById("map-canvas");
                        script.type = "text/javascript";
                        script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDZZHwxXryKMg3GSS8q9bozcISkQBoXKHo&sensor=true&libraries=drawing&sensor=false&language=tr&callback=initMap";
                        e.parentNode.insertBefore(script, e)
                    }
                }
            }

        });
        if (t.parents().hasClass('selectors')) {
            t.on('mouseenter', function () {
                t.stop().animate({
                    top: 0
                }, {
                    duration: 300,
                    easing: "swing"
                });
            });
            t.on('mouseleave', function () {
                t.stop().animate({
                    top: 19
                }, {
                    duration: 300,
                    easing: "swing"
                });
            });
        }

    });
    self.resizeSponsoredPhotos();
    //slide page menu
    $('.menu-icon').find('a').off('click').on('click', function (e) {
        e.preventDefault();
        var t = $(this);
        if (!t.hasClass('active')) {
            //$('.menu-icon').animate({
            //	left: 252
            //}, {
            //	duration: 800,
            //	easing: "easeOutExpo"
            //});
            $('.menu').animate({
                left: 0
            }, {
                duration: 800,
                easing: "easeOutExpo"
            });
            t.addClass('active');
            //self.menuAnimate();
        } else {
            //$('.menu-icon').animate({
            //	left: 0
            //}, {
            //	duration: 400,
            //	easing: "easeOutExpo"
            //});
            $('.menu').animate({
                left: -200
            }, {
                duration: 400,
                easing: "easeOutExpo"
            });
            t.removeClass('active');
        }
    });

    //search result animation
    //self.searchResultAnimation();

    //pricelist accordion menu
    self.accordionMenu();
    self.accordionMenuMobile();
    $('.price-list').css('opacity', '1');

    var searchTimer;

    $('.price-list-filter').each(function () {
        $(this).on('keyup', function () {
            var value = $(this).val().toUpperCase();
            var thisEl = $(this);
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                clearTimeout(searchTimer);
                if (value == "") {
                    $('.list-detail:visible *').show();
                    $('.price-error-result').hide();
                    $('.scroll-area').nanoScroller({ destroy: true });
                    setTimeout(function () {
                        $('.scroll-area').nanoScroller();
                    }, 200);
                }
                else {
                    $('.list-detail:visible *').show();
                    $('.list-detail:visible tbody tr').each(function () {
                        var productID = $(this).children().eq(0).text().trim();
                        var dimension = $(this).children().eq(1).text().trim();
                        var pattern = $(this).children().eq(2).text().trim();
                        var string = productID.toUpperCase() + dimension.toUpperCase() + pattern.toUpperCase();

                        if (string.indexOf(value) !== -1) {
                            $(this).show();
                        }
                        else {
                            $(this).hide();
                        }
                    });
                    $('.list-detail:visible table').each(function () {
                        if ($(this).find('tr:visible').length == 0) {
                            $(this).prev().hide();
                            $(this).hide();
                            $(this).parent('.price-group-item').prev('.price-title-group').hide();
                            $(this).closest('.price-group-item').hide();
                        }
                        else {
                            $(this).prev().show();
                            $(this).show();
                            $(this).parent('.price-group-item').prev('.price-title-group').show();
                            $(this).closest('.price-group-item').show();
                        }
                    });

                    //$('.list-detail:visible .nano-content > *:visible').not($('.list-detail:visible .tyre-loader')).length == 0
                    if ($("tr[data-product-code]:visible").length < 1) {
                        $('.price-error-result').show().text('"' + thisEl.val() + '" aramanızla eşleşen sonuç bulunamadı');
                        $('.price-list-header').hide();
                    }
                    else {
                        $('.price-error-result').hide();
                    }

                    $('.scroll-area').nanoScroller({ destroy: true });
                    setTimeout(function () {
                        $('.scroll-area').nanoScroller();
                    }, 200);
                }
            }, 500);
        })
    })



    $('.search-icon').find('a').off('click').on('click', function (e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $('.search-box').show();
            $(this).addClass('active');
            $('.hover-overlay').remove();
            $('.page').append('<div class="hover-overlay"></div>');
            $('.hover-overlay').off('click').on('click', function () {
                $('.search-box').hide();
                $('.search-icon a').removeClass('active');
                $('.hover-overlay').remove();
            })
            $(this).parent().find('input[type="text"]').focus();
            $('.header nav>ul>li').removeClass('active');
            $('.header nav>ul>li .menu-content').hide();
            $('.search-box span').off('click').on('click', function () {
                $('.search-box').hide();
                $(this).removeClass('active');
                $('.hover-overlay').remove();
            })
        } else {
            if ($('#search').val() != "") {
                $('#search-form')[0].submit();
            } else {
                $('.search-box').hide();
                $(this).removeClass('active');
            }
        }
    });

    $('body').off('click').on('click', function (e) {
        var target = e.target;
        if ($(target).attr('id') != "search" && !$(target).parents().hasClass('search-icon') && !$(target).parents().hasClass('header')) {
            $('.search-box').hide();
            $('.search-icon a').removeClass('active');
            if ($('.header nav>ul>li.active').length > 0) {
                $('.menu-content').hide();
                $('.header nav>ul>li').removeClass('active');
            }
            $('.hover-overlay').remove();
        }
    })

    $('.search-disable-area').off('click').on('click', function () {
        if ($(this).hasClass('passive')) {
            $('.search-disable-area').addClass('passive').show();
            $(this).removeClass('passive').hide();
            $('.search-disable-area').next().not($(this).next()).css('opacity', '0');
            $(this).next().css('opacity', '1');

        }
        else {
            $(this).hide();
            $('.search-disable-area').next().not($(this).next()).css('opacity', '0');
            $('.search-disable-area').addClass('passive');
        }
    })
    if ($('#dealer-finder-trigger').length > 0) {
        var searchForDealer;

        try {
            searchForDealer = $('#dealer-finder-trigger').data().searchtype;
        } catch (e) {
            console.log(e);
        }

        $('.search-disable-area').each(function (i) {

            if (searchForDealer === parseInt(searchForDealer, 10)) {
                if (searchForDealer == i) {
                    $(this).trigger('click');
                }
            }

        });
    }

    /**
    * DPP Cookie Bar
    **/

    if (!$.cookie("dpp-accepted")) {
        $("#cookieBand").addClass("active");
    } else {
        $("#cookieBand").removeClass("active");
    }

    $(document).on("click", '[data-role="cookie"]', function (e) {
        e.preventDefault();
        $.cookie("dpp-accepted", 1, {
            expires: 365,
            path: "/"
        });

        setTimeout(function () {
            $("#cookieBand").removeClass("active");
        }, 500);
    });

    // End DPP Cookie 


    //Temporarirly Season Price List Active

    function priceListActive() {
        return;
        setTimeout(function () {
            $('.price-list').find('.tab-links button').eq(1).trigger('click');
        }, 100);
    }

    priceListActive();

    if ($('.btn--live-help').length > 0) {
        $('.btn--live-help').on('click', function (e) {
            e.preventDefault();
            if ($('.cbot-dialog-button-regular').length > 0) {
                $('.cbot-dialog-button-regular').trigger('click');
            }
        })
    }
}

UI.prototype.searchResultAnimation = function () {
    var self = this;
    $('.result').find('a').each(function () {
        var t = $(this);
        t.on('mouseenter', function () {
            t.find('.tyre').stop().animate({
                bottom: 0
            }, {
                duration: 300,
                easing: "easeOutExpo"
            });
        });
        t.on('mouseleave', function () {
            t.find('.tyre').stop().animate({
                bottom: -50
            }, {
                duration: 300,
                easing: "easeOutExpo"
            });
        });
    });
}

/**
 * This method activate accordion menu
 * @memberof UI
 * @method accordionMenu
 */
UI.prototype.accordionMenu = function () {
    var self = this;
    $('.main-detail').hide();
    $('.main-detail:first').show();
    $('.main-group').find('a.main-list').each(function (key) {
        $(this).on('click', function (e) {
            e.preventDefault();
            if (key == 1) {
                $('.price-list-filter').attr('placeholder', 'Ebat veya desen ile ticari lastik ara');
            }
            var data = $(this).data();
            if (!$(this).hasClass('active')) {
                $('.main-group').find('a').removeClass('active');
                $(this).addClass('active');
                $('.main-detail').hide();
                $('.main-detail').eq(key).show();
                $('.main-detail').eq(key).find('.tab-links button').eq(0).trigger('click');
                self.nextPricePage = 2;
                $('#hdnGroupType').val(data.grouptype);
                $('#hdnSeasonCode').val(data.seasoncode);
                $('.download').attr("href", data.download);
            }
        });


        var item = $('.main-detail').eq(key);
        item.find('.list-detail').hide();
        if (key === 0) {
            item.eq(0).find('.list-detail').eq(1).show();
        } else if (key === 1) {
            item.eq(0).find('.list-detail').eq(0).show();
        }


        item.find('.tab-links button').each(function (a) {
            $(this).on('click', function (e) {
                e.preventDefault();
                if (a == 0) {
                    $('.price-list-filter').attr('placeholder', 'Ebat veya desen ile kış lastiği ara');
                }
                else if (a == 1) {
                    $('.price-list-filter').attr('placeholder', 'Ebat veya desen ile yaz lastiği ara');
                }
                var data = $(this).data();
                if (!$(this).hasClass('active')) {
                    $('.tab-links').find('button').removeClass('active');
                    $(this).addClass('active');
                    item.find('.list-detail').hide();
                    item.find('.list-detail').eq(a).show();
                    $('#hdnGroupType').val(data.grouptype);
                    $('#hdnSeasonCode').val(data.seasoncode);
                    $('.download').attr("href", data.download);
                }
                $('.price-list-filter').val('');
                $('.div-table-row, .div-table').show();
                $('.price-error-result').hide();
            });
        });
    });
}

//var currentUrl = location.pathname;

//var button = $('.consumer-selector .tab-links .pull-left button');

//if (button.filter('[data-seasoncode="02"]')) {
//    location = "/lastik-fiyatlari-yaz-lastigi"

//}
//const currentUrl = location.pathname;
//const button = $('.tyre-season-filter');

//button.on('click', function () {
//    const $this = $(this);
//    switch ($this.data('seasoncode')) {
//        case "02":
//            location.href = "/lastik-fiyatlari-kis-lastigi";
//            break;
//        case ""
//    }
//});

document.querySelectorAll('.tyre-season-filter').forEach((element) => {
    element.addEventListener('click', function (e) {
        const value = e.target.getAttribute('data-seasoncode');

        switch (value) {
            case "02":
                location.href = "/lastik-fiyatlari/kis-lastik-fiyatlari";
                break;
            case "01":
                location.href = "/lastik-fiyatlari/yaz-lastik-fiyatlari";
                break;
            case "03":
                location.href = "/lastik-fiyatlari/dort-mevsim-lastik-fiyatlari";
                break;
            case "04":
                location.href = "/lastik-fiyatlari";
                break;
            case "05":
                location.href = "/ticari-arac-lastik-fiyatlari";
                break;
        }
    });
});

UI.prototype.accordionMenuMobile = function () {
    var self = this;

}

UI.prototype.selectorAnimation = function (scene, type) {
    var self = this;
    var pageHeight = OGOO.Helper.getScreenSize().h;
    //$('.home-templates > div').show();
    if (type == "open") {
        if ($('.menu-icon a').hasClass('active')) {
            $('.menu-icon a').trigger('click');
        }
        $('.selectors, .selectors-mobile').stop().animate({
            top: 82
        }, {
            duration: 800,
            easing: "easeOutExpo"
        });
        $('.home-templates').find('div').removeClass('active');
        if (scene == "dealer") {
            OGOO.LassaMap.getClosestArea();
            $('.dealer-finder').addClass('active').stop().animate({
                top: OGOO.Helper.getScreenSize().w <= 768 ? 154 : 178
            }, {
                duration: 800,
                easing: "easeOutExpo"
            });
        } else {
            $('.tyre-search-mobile, .tyre-search').addClass('active').stop().animate({
                top: OGOO.Helper.getScreenSize().w <= 768 ? 70 : 178
            }, {
                duration: 800,
                easing: "easeOutExpo",
                complete: function () {
                    if (!clientData.fromHome) {
                        $('.home-templates, .selectors, .selectors-mobile').css('opacity', '1');
                        if (typeof clientData.tyreListRedirectionRule != "undefined") {
                            if (typeof clientData.tyreListRedirectionRule.tyregrouptype != "undefined") {

                                if (typeof clientData.tyreListRedirectionRule.tyrelistingtype != "undefined") {
                                    $('.tyre-big-text').remove();
                                    $('.main-selector').remove();
                                    $('.selectors').remove();
                                    $('.sub-selectors, .selectors-mobile').remove();
                                    $('.main-filter-for-tyre-selector, .tyre-text').removeClass('hidden');
                                    $('.tyre-search-mobile, .tyre-search').css({
                                        top: OGOO.Helper.getScreenSize().w <= 768 ? 210 : 145
                                    }).addClass('tyre-search-fix').css("min-height", $(window).height() - (OGOO.Helper.getScreenSize().w <= 768 ? 210 : 145))
                                }
                                else {
                                    $('.tyre-big-text').css('opacity', '0');
                                    $('.tyre-big-text').css('position', 'relative').stop().animate({
                                        marginTop: -156,
                                    }, {
                                        duration: 800,
                                        easing: "easeOutExpo",
                                        complete: function () {
                                            $('.tyre-big-text').remove();
                                        }
                                    });
                                }

                            }

                        }
                    }

                }
            });
            $('.filter-image').addClass('turn');
        }

    } else {
        $('.selectors, .selectors-mobile').stop().animate({
            top: pageHeight - (OGOO.Helper.getScreenSize().w <= 768 ? $('.selectors-mobile').height() : $('.selectors').height())
        }, {
            duration: 800,
            easing: "easeOutExpo"
        });
        $('.home-templates > div').stop().animate({
            top: "100%"
        }, {
            duration: 800,
            easing: "easeOutExpo"
        }, function () {
            $('.home-templates > div').hide();
        });
    }
}

UI.prototype.dealerSearch = function () {
    var self = this;
    var time;
    $('#dealer-form').on('submit', function (e) {
        return false;
    });
    $('#search-dealer').on('keyup', function () {
        clearTimeout(time);
        var t = $(this);
        time = setTimeout(function () {
            var query = t.val();
            clearTimeout(time);
            OGOO.LassaMap.getDealerData({ search: query }, true);
        }, 500);
    });
    $(document).on('click', function (e) {
        var target = e.target;
        if (!$(target).parent().hasClass('search-list') && !$(target).parents().hasClass('search-list')) {
            $('.auto-complete').remove();
            $('.search-list').hide();
        }
    });
}

UI.prototype.tyreFilter = function () {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    $('.filter-name').each(function () {
        var t = $(this);
        if (!t.hasClass('disabled')) {
            t.on('mouseenter', function () {
                t.addClass('active');
                t.siblings('.group-list').slideDown("fast");
            });
            t.parent().on('mouseleave', function () {
                t.removeClass('active');
                t.siblings('.group-list').slideUp("fast");
            });
        } else {
            t.off("mouseenter");
        }
    });

    var groupCount = $('.group-list').length;
    if ($(window).width() > 880) {
        $('.tyre-filters').removeClass('mobile');
        //$('.tyre-filters').css({
        //	"width": groupCount * 280,
        //	"margin-left": -(280 / 2) * groupCount
        //});
        var a;
        if (groupCount > 2) {
            a = 28;
        } else if (groupCount == 1) {
            a = 90;
            $('.tyre-filters').find(".row > div, .filter-template > div").addClass('single-filter-item');
        } else {
            a = 45;
        }
        $('.tyre-filters').find(".row > div, .filter-template > div").css("width", a + "%");
    } else {
        $('.tyre-filters').find(".row > div, .filter-template > div").css({
            "width": "100%",
            "margin-bottom": "50px"
        });
        $('.tyre-filters').addClass('mobile');
    }

    $('.group-list').find('a').off('click').on('click', function (e) {
        e.preventDefault();
        var data = $(this).data();
        var name = $(this).text();
        if (name.length > 15) {
            name = name.substr(0, 15) + "...";
        }
        $(this).parents('.group-list').slideUp("fast");
        $(this).parents(".group-list").siblings('a').find('span').html(name);
        $(this).parents(".group-list").siblings('a').find('em').removeClass().addClass(data.type).addClass("_" + data.id);
        $(this).parents(".group-list").siblings('a').addClass('selected');
        $('input[name="' + data.type + '"]').val(data.id).trigger('change');
        if (data.type == "group") {

            // Eğer İş Makinesi seçilirse pozisyon filtresini gizle
            if (data.id === "09" || data.id === "") {
                $("div#position").hide();
                $("div#masterProdGroup").css("width", "45%");
            } else {
                $("div#masterProdGroup").css("width", "28%");
                $("div#position").show();
            }
            self.groupId = data.id;
            self.getFilters(data);
            self.groupName = "SeasonAndUsage";

            //group seçildiğinde ilgili diğer filtreleri boşalt
            $('#position').find('input').val("");
            $('#position').find('span').html("POZİSYON");
            $('#position').find('a').removeClass('selected');

        } else if (data.type == "season") {
            OGOO.Tyre.tyreFilter["season"].selected = data.id;
            if (self.groupName == "SeasonAndUsage") {
                data.sublist = "SeasonAfterUsage";
                self.getFilters(data);
            } else {
                self.getFilters(data);
            }
        } else {
            OGOO.Tyre.tyreFilter[data.type].selected = data.id;
        }
    });

    $('body').off('click', '.filter-button a').on('click', '.filter-button a', function () {
        self.filterControl();
    });
}

UI.prototype.filterControl = function (data) {
    var self = this;
    var inputCount = 0;
    $('.filter-input').each(function () {
        if ($(this).val() != "") {
            inputCount++;
        }
    });
    self.redirectPage(true);
}

UI.prototype.redirectPage = function (isFilter) {
    var formFields = {
        "season": "tyreseason",
        "position": "tyreposition",
        "service": "tyreservice",
        "usage": "tyreusage",
        "group": "tyregroup"
    };
    var form = OGOO.Helper.queryStringToJSON($('#filter').serialize());
    var obj = {};
    Object.keys(form).forEach(function (u) {
        if (!OGOO.Helper.isNullOrEmpty(form[u])) {
            obj[formFields[u]] = form[u];
        }
    });

    if (isFilter) {
        var rule = clientData.tyreListRedirectionRule;
        if (typeof rule.tyreversion != "undefined" ? rule.tyreversion != 0 : false) {
            obj.tyreversion = rule.tyreversion;
        }
        if (typeof rule.tyrebrand != "undefined" ? rule.tyrebrand != 0 : false) {
            obj.tyrebrand = rule.tyrebrand;
        }
        if (typeof rule.tyreyear != "undefined" ? rule.tyreyear != 0 : false) {
            obj.tyreyear = rule.tyreyear;
        }
        if (typeof rule.tyremodel != "undefined" ? rule.tyremodel != 0 : false) {
            obj.tyremodel = rule.tyremodel;
        }
        if (typeof rule.tyregrouptype != "undefined") {
            obj.tyregrouptype = rule.tyregrouptype;
        }
        obj.tyrelistingtype = rule.tyrelistingtype == "TyreSize" ? "TyreCatalogue" : rule.tyrelistingtype;
        OGOO.Tyre.getFriendlyPath(obj, function (result) {
            if (result.status.code == '0') {
                if (clientData.filterType == "TyreSize") {
                    var searchObj = {};
                    if (rule.tyresectionwidth >= 0) {
                        searchObj.width = rule.tyresectionwidth;
                    }
                    if (rule.tyreaspectratio >= 0) {
                        searchObj.height = rule.tyreaspectratio;
                    }
                    if (rule.tyrejantcapı >= 0) {
                        searchObj.radius = rule.tyrejantcapı;
                    }
                    window.top.location.href = '/' + result.data.tyrecategorylink + '?' + $.param(searchObj);
                }
                else {
                    window.top.location.href = '/' + result.data.tyrecategorylink + window.location.search;
                }
            }
        });
    }
    else {
        //window.location.href = "/lastik-listeleme?" + $.param(obj);
    }

}

UI.prototype.getFilters = function (data, callback) {
    var self = this;
    if (data.type == "group") {
        $('.filter-template').empty();
    }
    var template = _.template(OGOO.Templates["TyreFilter"]);
    switch (data.sublist) {
        case "SeasonAndUsage":
        case "Season":
            $('#season').find('a').removeClass('disabled');
            self.getFilters({
                "sublist": "SeasonAfterUsage",
                "id": OGOO.Tyre.tyreFilter.season.selected
            });
            break;
        case "SeasonAfterUsage":
            $('#usage').remove();
            $('#season').find('a').removeClass('disabled');
            var vehicleversionId = '';
            var vehiclemodelId = '';
            var vehicleyear = '';
            if (typeof clientData.tyreListRedirectionRule != "undefined") {
                vehicleversionId = clientData.tyreListRedirectionRule.tyreversion <= 0 ? "" : clientData.tyreListRedirectionRule.tyreversion;
                vehiclemodelId = clientData.tyreListRedirectionRule.tyremodel == 0 ? "" : clientData.tyreListRedirectionRule.tyremodel;
                vehicleyear = clientData.tyreListRedirectionRule.tyreyear == 0 ? "" : clientData.tyreListRedirectionRule.tyreyear;
            }
            OGOO.Tyre.getUsage({
                anagrup: self.groupId,
                sezon: data.id,
                vehicleversionid: vehicleversionId,
                vehiclemodelid: vehiclemodelId,
                vehicleyear: vehicleyear
            }, function (result) {
                result.options = OGOO.Tyre.tyreFilter["usage"];
                $('.filter-template').append(template(result));
                self.redirect = true;
                self.tyreFilter();
                OGOO.Tyre.tyreFilter.usage.selected = null;
            });
            break;
        case "Position":
            $('#season').find('input').val("");
            $('#season').find('span').html("MEVSİM");
            $('#season').find('a').removeClass('selected').addClass('disabled');
            OGOO.Tyre.getPosition(data.id, function (result) {
                result.options = OGOO.Tyre.tyreFilter["position"];
                $('.filter-template').append(template(result));
                OGOO.Tyre.tyreFilter.position.selected = null;
                self.tyreFilter();
            });
            break;
        case "Service":
            $('#season').find('input').val("");
            $('#season').find('span').html("MEVSİM");
            $('#season').find('a').removeClass('selected').addClass('disabled');
            OGOO.Tyre.getService(data.id, function (result) {
                result.options = OGOO.Tyre.tyreFilter["service"];
                $('.filter-template').append(template(result));
                OGOO.Tyre.tyreFilter.service.selected = null;
                self.tyreFilter();
            });
            break;
        case "Usage":
            OGOO.Tyre.getUsage({ anagrup: data.id }, function (result) {
                result.options = OGOO.Tyre.tyreFilter["usage"];
                $('.filter-template').append(template(result));
                OGOO.Tyre.tyreFilter.usage.selected = null;
                self.tyreFilter();
            });
            break;
    }
}

UI.prototype.processDiv = function (_class, callback) {
    var divList = [];
    var uniqueDivList = [];
    var divCount = 0;
    var pageW = OGOO.Helper.getScreenSize().w;
    var len = $(_class).find('> div').length;
    $(_class).find('> div').each(function (key, value) {
        divList.push($(this)[0].outerHTML);
    });
    $.each(divList, function (i, el) {
        if ($.inArray(el, uniqueDivList) === -1) uniqueDivList.push(el);
    });
    $(_class).html('<div class="parent"><div class="row"></div></div>');
    $.each(uniqueDivList, function (key, value) {
        $(_class).find('.parent').eq(divCount).find('.row').append(value);
        if ((key + 1) % (pageW > 640 ? 24 : 6) == 0 && key < len - 1) {
            $(_class).append('<div class="parent"><div class="row"></div></div>');
            divCount++;
        }
    });
    callback();
}
UI.prototype.printData = function (result, temp) {
    var self = this;
    var template = _.template(OGOO.Templates[temp]);
    $('.tyre-template').html(template(result));

    if (result.data.length > 0) {
        self.processDiv(".tyre-search .slide", function () {
            $('.tyre-template').animate({ opacity: 1 }, "fast")
            $('.tyre-search .slide').bxSlider({
                auto: false,
                controls: true,
                pager: false
            });
        });

        self.processDiv(".tyre-search-mobile .slide", function () {
            $('.tyre-template').animate({ opacity: 1 }, "fast")
            $('.tyre-search-mobile .slide').bxSlider({
                auto: false,
                controls: false,
                pager: false
            });
        });
    }
}

UI.prototype.processSorting = function () {
    var self = this;
    if (typeof clientData.tyreListRedirectionRule != "undefined") {
        var isYear = typeof clientData.tyreListRedirectionRule.tyremodel != "undefined" && clientData.tyreListRedirectionRule.tyremodel != 0;
    }


    var name = (isYear ? "year" : "name");
    if (isYear) {
        if (typeof clientData.tyreListRedirectionRule.tyreyear == "undefined") {
            $('.sorting.year').removeClass('hidden');
        }
    }
    else {

        $('.sorting.alpha').removeClass('hidden');
    }
    $('.tyre-search .tyre-template .slide a').each(function () {
        if (!$(this).parents().hasClass('bx-clone')) {
            var obj = {}
            obj[name] = (isYear ? parseInt($(this).text()) : $(this).text());
            obj.tyrecategorylink = $(this).attr('href');
            if (!isYear) {
                obj.alpha = $(this).text().substr(0, 1).toLowerCase();
            }
            self.divArray.push(obj);
        }
    })
    self.dataSorting(self.divArray);
}

UI.prototype.dataSorting = function (result) {
    var self = this;
    $('a[data-sort]').each(function (key) {
        $(this).off('click').on('click', function (e) {
            e.preventDefault();
            var data = $(this).data();
            $('a[data-sort]').removeClass('active')
            $(this).addClass('active');
            var intersect = [];
            var isYear = typeof clientData.tyreListRedirectionRule.tyremodel != "undefined" && clientData.tyreListRedirectionRule.tyremodel != 0;
            data.sort.forEach(function (e) {
                var item;
                if (isYear) {
                    item = _.where(result, { year: e });
                }
                else {
                    item = _.where(result, { alpha: e });
                }
                if (item.length > 0) {
                    item.forEach(function (a) {
                        intersect.push(a);
                    });
                }
            });
            self.printData({ data: intersect }, data.type);
        });
    });
}

UI.prototype.processSponsoredImages = function () {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    $('.part-2').find('a').each(function () {
        $(this).height((pageSize.h - 67) / 3);
    });
    $('.part-1').find('img').each(function () {
        $(this).height(pageSize.h);
    });
    if (pageSize.w >= 1024) {
        $('.part-2').addClass('absolute');
        $('.part-2 .row').addClass('clip');
        $('.part-2 span.fix').css('left', '55px')
        self.hoverAnimation($('.sponsored .clip'));
        var right = $('.part-2').outerWidth();
        $('.part-1').css({
            width: pageSize.w - right
        });
        var left = ($('.part-1').outerWidth() - $('.part-1').find('img').width()) / 2 + 'px';
        $('.part-1').find('img').css({
            left: left,
            width: "auto"
        });
        $('.part-1').find('img').removeClass('img-responsive');
    } else {
        $('.part-2').removeClass('absolute');
        $('.clip-1').css('margin-top', '0');
        $('.part-2 .row').removeClass('clip');
        $('body').removeClass('scroll-hide');
        $('.part-2 span.fix').css('left', '20px')
        $('.part-1').css({
            width: "100%"
        });
        $('.part-1').find('img').addClass('img-responsive');
        $('.part-1').find('img').css({
            width: "100%",
            height: "auto",
            left: 0
        });
    }
}

UI.prototype.setMobileContent = function () {
    var self = this;
    var selectorButtons = _.template(OGOO.Templates["SelectorButtons"]);
    $('.selectors-mobile').html(selectorButtons);
    var tyreSelector = _.template(OGOO.Templates["TyreSelector"]);
    //$('.tyre-search-mobile').html(tyreSelector);
    if (typeof clientData.tyreListRedirectionRule != "undefined") {
        if (typeof clientData.tyreListRedirectionRule.tyrelistingtype != "undefined") {
            $('.sub-selectors').find('a[data-tab="' + clientData.tyreListRedirectionRule.tyrelistingtype + '"]').addClass('active');
        }
    }
    var select = new Select();
    select.init($("select"));
    $('.form-layout').find('span.select-icon').on('click', function () {
        $(this).siblings('.select').find('div.styledSelect').trigger('click');
    });
    self.pageListeners();
    self.tyreSearch();
    //self.selectGetData({
    //	next: "brand",
    //	value: null
    //});
    self.tyreSelectChange();
}

UI.prototype.mobileControl = function () {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    //mobile check
    $("input[maxlength]").each(function () {
        $(this).keyup(function (e) {
            var max = $(this).attr("maxlength");;
            if ($(this).val().length > max) {
                $(this).val($(this).val().substr(0, max));
            }
        });
    })
    if ($(window).width() <= 768) {
        if ($('body').hasClass('home')) {
            $('.page').css({
                overflow: 'hidden'
            })
        }

        $('.selectors-mobile, .tyre-search-mobile, .price-list-mobile').show();
        if ($('.price-list-mobile').length > 0) {
            $('.content').hide();
        }
        $('.selectors, .tyre-search, .price-list').hide();
        $('.tyre-search-mobile').height(pageSize.h - 154);
        $('.tyre-results').css('margin-top', '240px');
        if ($('.menu').css('left') > "-1") {
            $('.menu-icon a').removeClass('active');
        }

        if (typeof clientData.tyreListRedirectionRule != "undefined") {
            if (typeof clientData.tyreListRedirectionRule.tyrelistingtype != "undefined") {
                $('.tyre-search-mobile').find('.tyre-filter-types > div').addClass('hidden');
                $('.tyre-search-mobile').find('.tyre-filter-types > div[data-type=' + clientData.tyreListRedirectionRule.tyrelistingtype + ']').removeClass('hidden');
            }
        }
        $('.tyre-results').addClass('mobile-content').removeClass('nano').removeClass('has-scrollbar');
    } else {
        $('.selectors-mobile, .tyre-search-mobile, .price-list-mobile').hide();
        $('.selectors, .tyre-search, .price-list').show();
        if ($('.price-list-mobile').length > 0) {
            $('.content').show();
        }
        $('.tyre-results').css('margin-top', '50px');
        if ($('.menu').css('left') == "0") {
            $('.menu-icon a').addClass('active');
        }
        $('.tyre-results').removeClass('mobile-content').addClass('nano').addClass('has-scrollbar');
    }
}

UI.prototype.tyreDetailSlider = function () {
    var self = this;
    $('.image-list').find('a').on('click', function () {
        var data = $(this).data();
        $('.image').find('img').attr('src', data.url);
        $('.image-list').find('a').removeClass('active');
        $(this).addClass('active');
    });
}

UI.prototype.tyreLoader = function () {
    var self = this;
    var url = OGOO.Helper.queryStringToJSON(location.search);
    var obj = {
        "page": self.nextPage,
        "grouptype": clientData.tyreListRedirectionRule.tyregrouptype
    }
    if (typeof clientData.tyreListRedirectionRule != "undefined") {
        obj.vehiclebrandid = clientData.tyreListRedirectionRule.tyrebrand == 0 ? "" : clientData.tyreListRedirectionRule.tyrebrand;
        obj.vehiclemodelid = clientData.tyreListRedirectionRule.tyremodel == 0 ? "" : clientData.tyreListRedirectionRule.tyremodel;
        obj.vehicleversionid = clientData.tyreListRedirectionRule.tyreversion <= 0 ? "" : clientData.tyreListRedirectionRule.tyreversion;
        obj.year = clientData.tyreListRedirectionRule.tyreyear == 0 ? "" : clientData.tyreListRedirectionRule.tyreyear;
        obj.anagrup = clientData.tyreListRedirectionRule.tyregroup;
        obj.sezon = clientData.tyreListRedirectionRule.tyreseason;
        obj.ubykullanim = clientData.tyreListRedirectionRule.tyreusage;
        obj.pozisyon = clientData.tyreListRedirectionRule.tyreposition;
    }
    Object.keys(url).forEach(function (u) {
        var item = OGOO.Tyre.tyrePaging[u];
        if (typeof item != "undefined") {
            obj[item] = url[u];
        }
    });
    obj.toprow = 20;
    $('.tyre-loader').fadeIn('fast');
    if (clientData.filterType == "TyreCatalogue") {
        OGOO.Tyre.patternList(obj, function (result) {
            $('.tyre-loader').hide();
            if (result.data.length > 0) {
                var template = _.template(OGOO.Templates["Pattern"]);
                $('#tyre-list').append(template(result));
                //self.searchResultAnimation();
            } else {
                $('.tyre-loader').remove();
            }
        });
    }
    else {
        OGOO.Tyre.tyreList(obj, function (result) {
            $('.tyre-loader').hide();
            if (result.data.length > 0) {
                var template = _.template(OGOO.Templates["Tyre"]);
                $('#tyre-list').append(template(result));
                //self.searchResultAnimation();
            } else {
                $('.tyre-loader').remove();
            }
        });
    }


    self.nextPage++;
}

UI.prototype.tyreSearch = function () {
    var self = this;
    var pageSize = OGOO.Helper.getScreenSize();
    var order = pageSize.w <= 768 ? 1 : 0;

    $('.main-selector').find('a').on('click', function (e, trigger) {
        var data = $(this).data();
        $(this).addClass('active');
        $('input[name="tyregrouptype"]').val(data.selectortype);
        if (data.selecttext && typeof trigger == "undefined") {
            //if (history.pushState) {
            //    var obj = {}
            //    obj.tyregrouptype = data.selectortype;
            //    OGOO.Tyre.getFriendlyPath(obj, function (result) {
            //        if (result.status.code == '0') {
            //            window.top.location.href = '/' + result.data.tyrecategorylink + '';
            //            //_gaq.push(['_trackPageview', '/' + result.data.tyrecategorylink]);
            //        }
            //    });
            //}
        }
        else {
            $('.sub-selectors').removeClass('hidden');
        }

        $('.sub-selectors, .main-filter-for-tyre-selector').find('a').each(function () {
            var _data = JSON.parse($(this)[0].getAttribute("data-show"));
            var intersect = _.intersection(_data, [data.selectortype]);
            if (intersect.length == 0) {
                $(this).parent().remove();
                $('.selector-buttons .sub-selectors > div').css("float", "left");
                //$('.selector-buttons .sub-selectors').find('a.size').addClass('model').removeClass('size');
                var isCommercial = clientData.tyreListRedirectionRule.tyregrouptype;
                if (isCommercial) {
                    $('.tyre-search .selector-buttons .sub-selectors').find('a.size').addClass('fix');
                    $('.tyre-search .selector-buttons .sub-selectors').width(586);
                } else {
                    $('.tyre-search .selector-buttons .sub-selectors').width(864);
                }
            }
        });
    });

    if (typeof clientData.tyreListRedirectionRule != "undefined") {
        if (typeof clientData.tyreListRedirectionRule.tyregrouptype != "undefined") {
            $('.main-selector').find('a[data-selectortype=' + clientData.tyreListRedirectionRule.tyregrouptype + ']').trigger('click', true);
        }
    }

    $('.selector-buttons .sub-selectors').find('a').each(function (key) {
        $(this).on('click', function (e, trigger) {
            var data = $(this).data();
            $('input[name="tyrelistingtype"]').val(data.type);

            if (data.tab && typeof trigger == "undefined") {
                //if (history.pushState) {
                //    var obj = {
                //        "tyrelistingtype": data.type,
                //        "tyregrouptype": clientData.tyreListRedirectionRule.tyregrouptype
                //    }
                //    OGOO.Tyre.getFriendlyPath(obj, function (result) {
                //        if (result.status.code == '0') {
                //            window.top.location.href = result.data.tyrecategorylink;
                //        }
                //    });
                //}
            }
            if (data.type == "TyreCatalogue") {
                //var obj = {
                //    "tyrelistingtype": data.type,
                //    "tyregrouptype": clientData.tyreListRedirectionRule.tyregrouptype
                //}
                //OGOO.Tyre.getFriendlyPath(obj, function (result) {
                //    if (result.status.code == '0') {
                //        window.top.location.href = result.data.tyrecategorylink;
                //    }
                //});
            } else {
                if (typeof trigger != "undefined") {
                    $('.selector').addClass('hidden');
                    $('.tyre-selector').find('a').removeClass('active');
                    $(this).addClass('active');
                    $('.selector[data-selector="' + data.type + '"]').removeClass('hidden');
                    $('.tyre-image').removeClass('turn');
                    if (data.type == "TyreSize") {
                        setTimeout(function () {
                            $('.tyre-size-animate').fadeIn("slow");
                        }, 1000);
                        self.handleFilters("TyreSize");
                    } else {
                        $('.tyre-size-animate').fadeOut("slow");
                        self.handleFilters("VehicleModel");
                    }
                }
            }
        });
    });
    //$('.tyre-filter-types').height(pageSize.h - 300);
    //$('.catalogue').off('click').on('click', function (e) {
    //	e.preventDefault();
    //	var query = $.param(clientData.request.querystring);
    //	if (OGOO.Helper.getParams("filtre") != "lastik-katalogu" && OGOO.Helper.getParams("filtre") != "lastik-olcusu" && OGOO.Helper.getParams("filtre") != "arac-modeli") {
    //		window.location.href = "/lastik-listeleme?filtre=lastik-katalogu&" + query;
    //	}
    //	else {
    //		window.location.href = "/lastik-listeleme?" + query;
    //	}
    //})

    $(".tyre-img").each(function (index, element) {
        var imgUrl = $(this).attr("data-val");
        $(this).attr("src", imgUrl);
    });
}

UI.prototype.tyreSelectChange = function () {
    var self = this;
    $('#tyre-filter-form, #tyre-filter-form-mobile').find('select').each(function () {
        if ($(this).children().length <= 1) {
            $(this).attr('disabled', 'disabled').next().addClass('disabled');
        }
        else {
            $(this).removeAttr('disabled').next().removeClass('disabled');
        }
        $(this).off('change').on('change', function () {
            if ($(this).val() != "" && typeof $(this).val() != "undefined") {
                window.top.location.href = '/' + $(this).val() + '';
            }
            //
            //switch ($(this).attr("name")) {
            //	case "tyreversion":
            //		if ($(this).val() != "") {
            //			if ($(this).parents('form').attr('id') == "tyre-filter-form-mobile") {
            //				var form = $('#tyre-filter-form-mobile');
            //				//$('#tyre-filter-form-mobile').submit();
            //				var formData = OGOO.Helper.convertObjectWithoutNull(form);
            //				OGOO.Tyre.getFriendlyPath(formData, function (result) {
            //					if (result.status.code == '0') {
            //						window.top.location.href = '/' + result.data.tyrecategorylink + '';
            //						//_gaq.push(['_trackPageview', '/' + result.data.tyrecategorylink]);
            //					}
            //				});
            //			}
            //			else {
            //				var form = $('#tyre-filter-form');
            //				var formData = OGOO.Helper.convertObjectWithoutNull(form);
            //				OGOO.Tyre.getFriendlyPath(formData, function (result) {
            //					if (result.status.code == '0') {
            //						window.top.location.href = '/' + result.data.tyrecategorylink + '';
            //						//_gaq.push(['_trackPageview', '/' + result.data.tyrecategorylink]);
            //					}
            //				});
            //			}
            //		}
            //		break;
            //}
            //var form = OGOO.Helper.isMobile() ? $('#tyre-filter-form-mobile') : $('#tyre-filter-form');
            //var formData = OGOO.Helper.convertObjectWithoutNull(form);
            //OGOO.Tyre.getFriendlyPath(formData, function (result) {
            //	if (result.status.code == '0') {
            //		window.top.location.href = '/' + result.data.tyrecategorylink;
            //	}
            //});
        });
    });
}

UI.prototype.selectGetData = function (data) {
    var self = this;
    switch (data.template) {
        case "Year":
            OGOO.Tyre.getTyreYears({ vehiclemodel: OGOO.Tyre.tyreSelector["model"].id }, function (result) {
                $("select[name='tyreyear']").html('<option value="">YIL</option>');
                result.data.forEach(function (year) {
                    $("select[name='tyreyear']").append('<option value="' + year.tyrecategorylink + '"' + (year.year == OGOO.Tyre.tyreSelector["year"].id ? "selected=selected" : "") + '>' + year.year + '</option>')
                });
                var select = new Select();
                select.init($("select[name='tyreyear']"));
                self.tyreSelectChange();
            });
            break;
        case "Brand":
            OGOO.Tyre.vehicleBrand(function (result) {
                $("select[name='tyrebrand']").html('<option value="">MARKA</option>');
                result.data.forEach(function (brand) {
                    $("select[name='tyrebrand']").append('<option value="' + brand.tyrecategorylink + '"' + (brand.id == OGOO.Tyre.tyreSelector["brand"].id ? "selected=selected" : "") + '>' + brand.name + '</option>')
                });
                var select = new Select();
                select.init($("select[name='tyrebrand']"));
                self.tyreSelectChange();
            });
            break;
        case "Model":
            OGOO.Tyre.vehicleModel({
                vehiclebrandid: OGOO.Tyre.tyreSelector["brand"].id
            }, function (result) {
                $("select[name='tyremodel']").html('<option value="">MODEL</option>');
                result.data.forEach(function (model) {
                    $("select[name='tyremodel']").append('<option value="' + model.tyrecategorylink + '"' + (model.id == OGOO.Tyre.tyreSelector["model"].id ? "selected=selected" : "") + '>' + model.name + '</option>')
                });
                var select = new Select();
                select.init($("select[name='tyremodel']"));
                self.tyreSelectChange();
            });
            break;
        case "Engine":
            OGOO.Tyre.vehicleVersion({
                vehiclemodel: OGOO.Tyre.tyreSelector["model"].id,
                year: OGOO.Tyre.tyreSelector["year"].id
            }, function (result) {
                $("select[name='tyreversion']").html('<option value="">MOTOR</option>');
                result.data.forEach(function (engine) {
                    $("select[name='tyreversion']").append('<option value="' + engine.tyrecategorylink + '"' + (engine.id == OGOO.Tyre.tyreSelector["engine"].id ? "selected=selected" : "") + '>' + (engine.name.length > 20 ? engine.name.substr(0, 20) + "..." : engine.name) + '</option>')
                });
                var select = new Select();
                select.init($("select[name='tyreversion']"));
                self.tyreSelectChange();
            });
            break;
    }
}

UI.prototype.menuControl = function () {
    var self = this;
    $('.menu').find('a').each(function () {
        $(this).on('click', function () {
            var href = $(this).attr('href');
            if (href == "#lastik-listeleme") {
                $('.selectors').find('a[data-action="tyre"]').trigger('click');
                //$('.menu-icon').find('a').trigger('click');
            } else if (href == "#bayi-bulucu") {
                $('.selectors').find('a[data-action="dealer"]').trigger('click');
                //$('.menu-icon').find('a').trigger('click');
            }
        });
    });
}

UI.prototype.menuAnimate = function () {
    var self = this;
    var len = $('.menu').find('li').length;
    var count = 0;
    var time = null;
    time = setInterval(function () {
        if (count != len) {
            $('.menu').find('li').eq(count).show().addClass("animated").addClass("bounceInLeft");
            count++;
        } else {
            clearInterval(time);
        }
    }, 10);
}

UI.prototype.loaderAnimation = function () {
    var self = this;
    var t = 0;
    setTimeout(function () {
        $('.loader-shadow, .loader-logo').fadeOut("slow");
    }, 200);
    setTimeout(function () {
        $('.loader-overlay').addClass('loaded');
        var time = null;
        $('.loader-overlay').css({
            width: OGOO.Helper.getScreenSize().w,
            height: OGOO.Helper.getScreenSize().w,
            left: 0,
            top: (OGOO.Helper.getScreenSize().h - OGOO.Helper.getScreenSize().w) / 2 + "px"
        });
        time = setInterval(function () {
            $('.loader-overlay').css("background", '-webkit-radial-gradient(transparent ' + t + '%,#000 ' + t + '%)');
            if (t == 100) {
                clearInterval(time);
                $('.loader-overlay').remove();
                $('.loader').css('zIndex', '1')
            } else {
                t += 5;
            }
        }, 50);
    }, 600);
}

UI.prototype.hoverAnimation = function (selector) {
    var self = this;
    selector.find('a').each(function () {
        var t = $(this);
        var img = t.find('img');
        img.animate({
            opacity: 1
        }, "fast");
        img.css({
            "margin-top": -img.height() / 2
        });
        t.on('mouseenter', function () {
            var img = t.find('img');
            $(this).find('.hover').fadeIn("fast");
            //img.attr('data-height', img.height());
            //img.attr('data-width', img.width());
            //img.stop().animate({
            //	height: img.height() + (img.height() * 0.1),
            //	width: img.width() + (img.width() * 0.1),
            //	left: -img.width() * 0.1 / 2,
            //	top: -img.height() * 0.1 / 2
            //}, {
            //	duration: 800,
            //	easing: "easeOutExpo"
            //});
        });
        t.on('mouseleave', function () {
            var img = t.find('img');
            $(this).find('.hover').fadeOut("fast");
            //t.find('img').stop().animate({
            //	height: img.data("height"),
            //	width: img.data("width"),
            //	left: 0,
            //	top: 0
            //}, {
            //	duration: 800,
            //	easing: "easeOutExpo"
            //});
        });
    });
}

UI.prototype.setDropDownWidth = function () {
    if ($('.tyre-detail-header').length > 0) {
        var wrapWidth = $('.tyre-detail-header h2').parent().width();
        var elementWidth = $('.tyre-detail-header h2').width();
        var widthMargin = wrapWidth - elementWidth;
        var minWidth = 170;
        $('.tyre-detail-header').find('select').on("change", function () {
            var val = $(this).val();
            if (val != "") {
                window.location.href = "/lastik/" + val;
            }
        });
        $('.tyre-detail-header .select').ready(function () {
            if (widthMargin > minWidth) {
                $('.tyre-detail-header .select').removeAttr('style').css('width', widthMargin - 15);
            }
            else {
                $('.tyre-detail-header .select').css('width', '100%').css('float', 'none');
            }
        })
    }
}

UI.prototype.sectionWidth = function (selected) {
    var self = this;
    var isCommercial = OGOO.Helper.getParams("tip") == "ticari";
    OGOO.Tyre.sectionWidth({ "iscommercial": isCommercial }, function (result) {
        $('select[name="width"]').html('<option value="">Genişlik</option>');
        if (result.data.length > 0) {
            $('select[name="width"]').removeAttr("disabled");
        } else {
            $('select[name="width"]').prop("disabled", true);
        }
        result.data.forEach(function (item) {
            $('select[name="width"]').append('<option value="' + item + '" ' + ((selected != null ? selected : "") == item ? 'selected=selected' : '') + '>' + item + '</option>');
        });
        if ($('#road-assist-register').length == 0) {
            var select = new Select();
            select.init($('select'));
        }
        $('select[name="width"]').off('change').on("change", function () {
            $('select[name="height"]').html('<option value="">Yükseklik</option>').prop("disabled", true);
            $('select[name="radius"]').html('<option value="">Jant Çapı</option>').prop("disabled", true);
            $('select[name="loadindex"]').html('<option value="">Yük İndeksi</option>').prop("disabled", true);
            $('select[name="speedindex"]').html('<option value="">Hız İndeksi</option>').prop("disabled", true);

            var val = $(this).val();
            if (val != null) {
                self.aspectratio(val);
            }
        });
        //        OGOO.RoadAssistant.getTyreList();
    });
}

UI.prototype.aspectratio = function (val, selected) {
    var self = this;
    OGOO.Tyre.aspectRatio({ "sectionwidth": val }, function (result) {
        $('select[name="height"]').html('<option value="">Yükseklik</option>');
        if (result.data.length > 0) {
            $('select[name="height"]').removeAttr("disabled");
        } else {
            $('select[name="height"]').prop("disabled", true);
        }
        result.data.forEach(function (item) {
            $('select[name="height"]').append('<option value="' + item + '" ' + ((selected != null ? selected : "") == item ? 'selected=selected' : '') + '>' + item + '</option>');
        });
        if ($('#road-assist-register').length == 0) {
            var select = new Select();
            select.init($('select'));
        }
        $('select[name="height"]').off('change').on("change", function () {
            $('select[name="radius"]').html('<option value="">Jant Çapı</option>').prop("disabled", true);
            $('select[name="loadindex"]').html('<option value="">Yük İndeksi</option>').prop("disabled", true);
            $('select[name="speedindex"]').html('<option value="">Hız İndeksi</option>').prop("disabled", true);

            var val = $(this).val();
            if (val != null) {
                if ($(this).parents('form').attr('id') == "filter-form-mobile") {
                    self.tyreRadius({
                        "sectionwidth": $('#filter-form-mobile select[name="width"]').val(),
                        "aspectratio": val
                    }, "height");
                }
                else {
                    self.tyreRadius({
                        "sectionwidth": $('#filter-form select[name="width"]').val(),
                        "aspectratio": val
                    }, "height");
                }
            }
        });
        //        OGOO.RoadAssistant.getTyreList();
    });
}

UI.prototype.tyreRadius = function (obj, selected) {
    var self = this;
    OGOO.Tyre.radius(obj, function (result) {
        $('select[name="radius"]').html('<option value="">Jant Çapı</option>');
        if (result.data.length > 0) {
            $('select[name="radius"]').removeAttr("disabled");
        } else {
            $('select[name="radius"]').prop("disabled", true);
        }
        result.data.forEach(function (item) {
            $('select[name="radius"]').append('<option value="' + item + '" ' + ((selected != null ? selected : "") == item ? 'selected=selected' : '') + '>' + item + '</option>');
        });
        if ($('#road-assist-register').length == 0) {
            var select = new Select();
            select.init($('select'));
        }
        if ($('select[name="loadindex"]').length > 0) {
            $('select[name="radius"]').off('change').on("change", function () {
                $('select[name="loadindex"]').html('<option value="">Yük İndeksi</option>').prop("disabled", true);
                $('select[name="speedindex"]').html('<option value="">Hız İndeksi</option>').prop("disabled", true);

                var val = $(this).val();
                if (val != null) {
                    self.getLoadIndex({
                        "sectionwidth": $('select[name="width"]').val(),
                        "aspectratio": $('select[name="height"]').val(),
                        "jantcapı": val
                    }, "radius");
                }
            });
        }
        //       OGOO.RoadAssistant.getTyreList();
    });
}

UI.prototype.getLoadIndex = function (obj, selected) {
    var self = this;
    OGOO.Tyre.LoadIndex(obj, function (result) {
        $('select[name="loadindex"]').html('<option value="">Yük İndeksi</option>');
        if (result.data.length > 0) {
            $('select[name="loadindex"]').removeAttr("disabled");
        } else {
            $('select[name="loadindex"]').prop("disabled", true);
        }
        result.data.forEach(function (item) {
            $('select[name="loadindex"]').append('<option value="' + item + '" ' + ((selected != null ? selected : "") == item ? 'selected=selected' : '') + '>' + item + '</option>');
        });
        if ($('#road-assist-register').length == 0) {
            var select = new Select();
            select.init($('select'));
        }
        if ($('select[name="speedindex"]').length > 0) {
            $('select[name="loadindex"]').off('change').on("change", function () {
                $('select[name="speedindex"]').html('<option value="">Hız İndeksi</option>').prop("disabled", true);

                var val = $(this).val();
                if (val != null) {
                    self.getSpeedIndex({
                        "sectionwidth": $('select[name="width"]').val(),
                        "aspectratio": $('select[name="height"]').val(),
                        "jantcapı": $('select[name="radius"]').val(),
                        "loadindex": val
                    }, "loadindex");
                }
            });
        }
        //        OGOO.RoadAssistant.getTyreList();
    });
}

UI.prototype.getSpeedIndex = function (obj, selected) {
    OGOO.Tyre.SpeedIndex(obj, function (result) {
        $('select[name="speedindex"]').html('<option value="">Hız İndeksi</option>');
        if (result.data.length > 0) {
            $('select[name="speedindex"]').removeAttr("disabled");
        } else {
            $('select[name="speedindex"]').prop("disabled", true);
        }
        result.data.forEach(function (item) {
            $('select[name="speedindex"]').append('<option value="' + item + '" ' + ((selected != null ? selected : "") == item ? 'selected=selected' : '') + '>' + item + '</option>');
        });
        if ($('#road-assist-register').length == 0) {
            var select = new Select();
            select.init($('select'));
        }
        $('select[name="speedindex"]').off('change').on("change", function () {
            //            OGOO.RoadAssistant.getTyreList();
        });
        //        OGOO.RoadAssistant.getTyreList();
    });
}

UI.prototype.search = function (item) {
    var self = this;
    var data = item.data();
    item.off('click');
    item.text("YÜKLENİYOR..");
    if (data.type == "Product") {
        OGOO.Customized.searchtyre({ module: data.type }, function (result) {
            var template = _.template(OGOO.Templates["ProductinSearch"]);
            item.parents(".results").find(".row").html(template(result));
            item.remove();
            self.pageListeners();
        });
    }
    else {
        OGOO.Customized.search({ module: data.type }, function (result) {
            var template = _.template(OGOO.Templates["Search"]);
            item.parents(".results").find(".row").html(template(result));
            item.remove();
            self.pageListeners();
        });
    }

}

UI.prototype.getAllNews = function (item) {
    var self = this;
    item.off('click');
    item.text("YÜKLENİYOR...");
    OGOO.Customized.getNews(function (result) {
        var template = _.template(OGOO.Templates["News"]);
        item.parents(".results").find(".row").html(template(result));
        item.remove();
        self.pageListeners();
    });
}

UI.prototype.getAllCampaigns = function (item) {
    var self = this;
    item.off('click');
    item.text("YÜKLENİYOR...");
    OGOO.Customized.olderCampaign({ page: 1, toprow: 10000 }, function (result) {
        var template = _.template(OGOO.Templates["Campaigns"]);
        $(".campaign-holder").append(template(result));
        item.parent().remove();
        self.pageListeners();
    });
}

UI.prototype.getPricesList = function (parent) {
    var self = this;
    var obj = {
        page: self.nextPricePage,
        toprow: 50,
        grouptype: $('#hdnGroupType').val(),
        seasoncode: $('#hdnSeasonCode').val()
    }
    if (obj.grouptype != "Commercial") {
        $('.tyre-loader').fadeIn('fast');
        OGOO.Customized.priceListPaging(obj, function (result) {
            $('.tyre-loader').hide();
            if (result.data.length > 0) {
                var template = _.template(OGOO.Templates["PriceList"]);
                parent.find('.h-fix').before(template(result));
            } else {
                $('.tyre-loader').remove();
            }
        });
    }
}

UI.prototype.controlTyreFilters = function () {
    var self = this;
    var url = clientData.tyreListRedirectionRule;
    if (typeof url != "undefined") {
        Object.keys(url).forEach(function (q) {
            var prefix = q.replace("tyre", "");
            if (typeof OGOO.Tyre.tyreFilter[prefix] != "undefined") {
                OGOO.Tyre.tyreFilter[prefix].selected = url[q];
            }
        });
        $('.group-list').find('a[data-type="season"]').each(function () {
            var data = $(this).data();
            if (data.id == url.tyreseason) {
                $(this).trigger('click');
            }
        });
        $('.group-list').find('a[data-type="group"]').each(function () {
            var data = $(this).data();
            if (data.id == url.tyregroup) {
                $(this).trigger('click');
            }
        });
        $('.group-list').find('a[data-type="service"]').each(function () {
            var data = $(this).data();
            if (data.id == url.tyreservice) {
                $(this).trigger('click');
            }
        });
        $('.group-list').find('a[data-type="position"]').each(function () {
            var data = $(this).data();
            if (data.id == url.tyreposition) {
                $(this).trigger('click');
            }
        });

        setTimeout(function () {
            if (typeof clientData.tyreListRedirectionRule != "undefined") {
                if (clientData.tyreListRedirectionRule.tyrelistingtype == "VehicleModel") {
                    self.getFilters({ sublist: "SeasonAndUsage", type: "group" });
                }
            }
            $('.tyre-filters, .filter-button').animate({
                opacity: 1
            }, "fast");
            //
        }, 1000);
    } else {
        $('.tyre-filters, .filter-button').show();
    }
}

UI.prototype.resizeSponsoredPhotos = function () {
    var width = OGOO.Helper.getScreenSize().w;
    var itemHeight;
    if (width > 1200) {
        itemHeight = width / 4;
    }
    else {
        itemHeight = width / 2;
    }

    $('.sponsored-photos .row > div').each(function () {
        $(this).children('a').height(itemHeight);
    })
}


UI.prototype.handleFilters = function (filterType) {
    var self = this;
    if (filterType == "VehicleModel") {
        var queryObject = typeof clientData.tyreListRedirectionRule == "undefined" ? "" : clientData.tyreListRedirectionRule;
        OGOO.Tyre.tyreSelector["brand"].id = queryObject.tyrebrand == 0 ? "" : queryObject.tyrebrand;
        OGOO.Tyre.tyreSelector["model"].id = queryObject.tyremodel == 0 ? "" : queryObject.tyremodel;
        OGOO.Tyre.tyreSelector["year"].id = queryObject.tyreyear == 0 ? "" : queryObject.tyreyear;
        OGOO.Tyre.tyreSelector["engine"].id = queryObject.enginecode;
        if (queryObject.tyreyear != 0 && typeof queryObject.tyreyear != "undefined") {
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["brand"]);
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["model"]);
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["year"]);
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["engine"]);
        } else if (queryObject.tyremodel != 0 && typeof queryObject.tyremodel != "undefined") {
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["brand"]);
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["model"]);
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["year"]);
        } else if (queryObject.tyrebrand != 0 && typeof queryObject.tyrebrand != "undefined") {
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["brand"]);
            OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["model"]);
        } else {
            if ($('[name="tyregrouptype"]').val() != "" && typeof $('[name="tyregrouptype"]').val() != "undefined") {
                OGOO.UI.selectGetData(OGOO.Tyre.tyreSelector["brand"]);
            }
        }
        var type = typeof clientData.tyreListRedirectionRule == "undefined" ? "" : clientData.tyreListRedirectionRule;
        if (type != null) {
            setTimeout(function () {
                if (type == "lastik-olcusu") {
                    $('.selector-buttons .sub-selectors').find('a[data-tab="lastik-olcusu"]').trigger('click', true);
                } else {
                    $('.selector-buttons .sub-selectors').find('a[data-tab="arac-modeli"]').trigger('click', true);
                }
            }, 1000);
        }
    } else {
        var sizeObject = clientData.request.querystring;
        if (typeof sizeObject.width != "undefined") {
            self.sectionWidth(sizeObject.width);
            self.aspectratio(sizeObject.width, sizeObject.height);
        } else {
            self.sectionWidth();
        }
        if (typeof sizeObject.width != "undefined") {
            self.tyreRadius({ sectionwidth: sizeObject.width, aspectratio: sizeObject.height }, sizeObject.radius);
        }
    }
}

UI.prototype.homeSlider = function () {
    var self = this;
    //if ($('.home-slider').length > 0 && $('.home-slider > div').length > 1) {
    //    var slideCount = 0;
    //    var sliderLength = $('.home-slider > div').length - 1;
    //    setInterval(function () {
    //        $('.home-slider > div').fadeOut(500);
    //        setTimeout(function () {
    //            $('.home-slider > div:eq(' + slideCount + ')').fadeIn(500);
    //        }, 200)

    //        if (slideCount !== sliderLength) {
    //            slideCount++
    //        }
    //        else {
    //            slideCount = 0;
    //        }
    //    }, 9000);
    //}
    if ($('.home-slider > div').length > 0) {

        self.homeSliderD = $('.home-slider').bxSlider({
            auto: true,
            controls: false,
            pause: 10000,
            slideMargin: 0,
            mode: 'fade',
            onSliderLoad: function () {
                if ($(window).width() >= 1200) {
                    $('.scene').parallax();
                    $('.scene').width(window.innerWidth + 70);
                    $('.scene').height(window.innerHeight + 70);
                }
            }
        });
    }

}
var $window = $(window);

UI.prototype.checkIfInView = function () {
    if ($('.animation-element').length > 0) {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);

        if ($window.width() > 1024) {
            $('.animation-element').each(function () {
                var $element = $(this);
                var element_height = $element.outerHeight();
                var element_top_position = $element.offset().top;
                var element_bottom_position = (element_top_position + element_height);

                //check to see if this current container is within viewport
                if ((element_bottom_position >= window_top_position) &&
                    (element_top_position <= window_bottom_position)) {
                    $element.addClass('in-view');
                } else {
                    $element.removeClass('in-view');
                }
            });
        }
    }

}
$('#myvideoimage').on('click', function (e) {
    e.preventDefault();
    $('.show-video1').trigger('click');
})

/*
    width
*/
UI.prototype.getWidthListBySize = function (getCarTypeId) {
    var obj = {
        "GroupType": getCarTypeId,
    };
    var url = "/tyre/SectionWidth";
    var type = "POST";
    var select = $('#widthBySize');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">GENİŞLİK</option>');
        result.data.forEach(function (section) {
            if (section.size !== "-1") {
                select.append('<option value="' + section.size + '" data-url="' + section.tyrecategorylink + '">' + section.size + '</option>');
            } else {
                select.append('<option value="' + section.size + '" data-url="' + section.tyrecategorylink + '">BİLMİYORUM</option>');
            }
        });
        var _select = new Select();
        _select.init(select);
    });
}

/*
    height
*/
UI.prototype.getHeightListBySize = function (widthBySize) {
    var obj = {
        "GroupType": $("input[name='tyre-car-type']:checked").attr('data-vehiclegroup'),
        "SectionWidth": widthBySize
    };
    var url = "/tyre/AspectRatio";
    var type = "POST";
    var select = $('#heightBySize');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">YÜKSEKLİK</option>');
        result.data.forEach(function (height) {
            if (height.size !== "-1") {
                select.append('<option value="' + height.size + '" data-url="' + height.tyrecategorylink + '">' + height.size + '</option>');
            } else {
                select.append('<option value="' + height.size + '" data-url="' + height.tyrecategorylink + '">BİLMİYORUM</option>');
            }

        });
        var _select = new Select();
        _select.init(select);
    });
}

/*
    rim diameter
*/
UI.prototype.getRimDiameterListBySize = function (heightBySize) {
    var obj = {
        "GroupType": $("input[name='tyre-car-type']:checked").attr('data-vehiclegroup'),
        "SectionWidth": $("#widthBySize").find(":selected").val(),
        "AspectRatio": heightBySize
    };
    var url = "/tyre/JantCapı";
    var type = "POST";
    var select = $('#rimDiameterBySize');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">JANT ÇAPI</option>');
        result.data.forEach(function (rimDiameter) {
            if (rimDiameter.size !== "-1") {
                select.append('<option value="' + rimDiameter.size + '" data-url="' + rimDiameter.tyrecategorylink + '">' + rimDiameter.size + '</option>');
            } else {
                select.append('<option value="' + rimDiameter.size + '" data-url="' + rimDiameter.tyrecategorylink + '">BİLMİYORUM</option>');
            }

        });
        var _select = new Select();
        _select.init(select);
    });
}

/*
    brand
*/
UI.prototype.getBrandListByCar = function (getCarTypeId) {
    var obj = {
        "GroupType": getCarTypeId,
    };
    var url = "/tyre/VehicleBrand";
    var type = "POST";
    var select = $('#brandByCar');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">MARKA</option>');
        result.data.forEach(function (brand) {
            select.append('<option value="' + brand.id + '" data-url="' + brand.tyrecategorylink + '">' + brand.name + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });
}

/*
    model
*/
UI.prototype.getModelListByCar = function (brandByCar) {
    var obj = {
        "GroupType": $("input[name='tyre-car-type']:checked").attr('data-vehiclegroup'),
        "VehicleBrandID": brandByCar
    };
    var url = "/tyre/VehicleModel";
    var type = "POST";
    var select = $('#modelByCar');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">MODEL</option>');
        result.data.forEach(function (model) {
            select.append('<option value="' + model.id + '" data-url="' + model.tyrecategorylink + '">' + model.name + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });
}

/*
    year
*/
UI.prototype.getYearListByCar = function (modelByCar) {
    var obj = {
        "GroupType": $("input[name='tyre-car-type']:checked").attr('data-vehiclegroup'),
        "VehicleModel": modelByCar
    };
    var url = "/tyre/VehicleProductYear";
    var type = "POST";
    var select = $('#yearByCar');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">MODEL YILI</option>');
        result.data.forEach(function (year) {
            select.append('<option value="' + year.year + '" data-url="' + year.tyrecategorylink + '">' + year.year + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });
}

/*
    year
*/
UI.prototype.getMotorListByCar = function (yearByCar) {
    var obj = {
        "GroupType": $("input[name='tyre-car-type']:checked").attr('data-vehiclegroup'),
        "VehicleModel": $('#modelByCar').val(),
        "Year": yearByCar
    };
    var url = "/tyre/VehicleVersion";
    var type = "POST";
    var select = $('#motorByCar');

    OGOO.Service.tyreSearchForm(obj, url, type, function (result) {
        select.html('<option value="">MOTOR</option>');
        result.data.forEach(function (motor) {
            select.append('<option value="' + motor.id + '" data-url="' + motor.tyrecategorylink + '">' + motor.name + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });

}

UI.prototype.checkedDefaultCarType = function () {
    $('#car-1').attr('checked', true);
    UI.prototype.getBrandListByCar('Consumer');
    UI.prototype.getWidthListBySize('Consumer');
}

UI.prototype.resetSearchForm = function () {
    // reset motor
    var selectMotorByCar = $('#motorByCar')
    selectMotorByCar.html('<option value="">MOTOR</option>');
    var _selectMotorByCar = new Select();
    _selectMotorByCar.init(selectMotorByCar);

    // reset year
    var selectYearByCar = $('#yearByCar')
    selectYearByCar.html('<option value="">MODEL YILI</option>');
    var _selectYearByCar = new Select();
    _selectYearByCar.init(selectYearByCar);

    // reset model
    var selectModelByCar = $('#modelByCar')
    selectModelByCar.html('<option value="">MODEL</option>');
    var _selectModelByCar = new Select();
    _selectModelByCar.init(selectModelByCar);

    // reset brand
    var selectBrandByCar = $('#brandByCar')
    selectBrandByCar.html('<option value="">MARKA</option>');
    var _selectBrandByCar = new Select();
    _selectBrandByCar.init(selectBrandByCar);

    // reset rim diameter
    var selectRimDiameterBySize = $('#rimDiameterBySize')
    selectRimDiameterBySize.html('<option value="">JANT ÇAPI</option>');
    var _selectRimDiameterBySize = new Select();
    _selectRimDiameterBySize.init(selectRimDiameterBySize);

    // reset height
    var selectHeightBySize = $('#heightBySize')
    selectHeightBySize.html('<option value="">YÜKSEKLİK</option>');
    var _selectHeightBySize = new Select();
    _selectHeightBySize.init(selectHeightBySize);

    // reset width
    var selectWidthBySize = $('#widthBySize')
    selectWidthBySize.html('<option value="">YÜKSEKLİK</option>');
    var _selectWidthBySize = new Select();
    _selectWidthBySize.init(selectWidthBySize);

    $("input:radio[name='tyre-car-type']").each(function (i) {
        if (this.id === 'car-1') {
            this.checked = true;
        }
    });

    $("input:radio[name='seasonTyre']").each(function (i) {
        if (this.id === 'summerTyreSeason') {
            this.checked = true;
        }
    });

    // $('#car-1').attr('checked', true);

}

/**
** Tyre Insurance  
*/

// Upload File 
$(".c-panel-button").on("click", function () {
    $(this).toggleClass("c-panel-button-img-rotate");
});


// Upload File Read Value

$('.fileUpload .up1').change(function (e) {
    var file = e.target.files[0];
    var fileNamePhoto = e.target.files[0].name;

    $(".c-upload-1").val(fileNamePhoto);
    $(".c-upload-1").attr('data-file-size', file.size);
});


$('.fileUpload .up2').change(function (e) {
    var file = e.target.files[0];
    var fileNamePhoto = e.target.files[0].name;

    $(".c-upload-2").val(fileNamePhoto);
    $(".c-upload-2").attr('data-file-size', file.size);
});

// Bill Date Datepicker

// $('#billDate').datepicker();

//UI.prototype.GetInsuranceCity = function () {
//    var self = this;
//    var url = "customized/GetInsuranceCity";
//    var obj = {};
//    var type = "GET";

//    OGOO.Service.insuranceForm(obj, url, type, function (result) {
//        var select = $('#insuranceCity');
//        select.empty();
//        select.append('<option value="">İl Seçiniz</option>');
//        self.insuranceCityList = result.data;
//        result.data.forEach(function (result) {
//            select.append('<option value="' + result.CityId + '">' + result.CityName + '</option>');
//        });
//        var _select = new Select();
//        _select.init(select);

//        // get county
//        self.GetInsuranceCounty();

//    });
//}

UI.prototype.GetInsuranceCityByFilter = function (cityId, callback) {
    var self = this;
    var url = "customized/GetInsuranceCity";
    var obj = {};
    var type = "GET";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.insuranceCityList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(cityId, 'CityId', self.insuranceCityList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(cityId, 'CityId', self.insuranceCityList).CityName;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceDealerCity = function () {
    var self = this;
    var url = "customized/GetInsuranceCity";
    var obj = {
        "countryId": campaignCountryId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        var select = $('#insuranceDealerCity');
        select.empty();
        $('#insuranceDealer').empty();
        select.append('<option value="">İl Seçiniz</option>');
        self.insuranceDealerCityList = result.data;
        result.data.forEach(function (result) {
            select.append('<option value="' + result.cityid + '">' + result.cityname + '</option>');
        });
        var _select = new Select();
        _select.init(select);

        // get county
        self.GetInsuranceDealerCounty();

    });
}

//UI.prototype.GetInsuranceCounty = function (cityId) {
//    url = "customized/GetInsuranceCounty";
//    obj = {
//        "cityid": cityId
//    };
//    type = "POST";

//    if (typeof cityId !== 'undefined') {
//        if (!OGOO.Helper.isNullOrEmpty(cityId)) {
//            OGOO.Service.insuranceForm(obj, url, type, function (result) {
//                var select = $('#insuranceCounty');
//                select.empty();
//                select.append('<option value="">İlçe Seçiniz</option>');
//                result.data.forEach(function (result) {
//                    select.append('<option value="' + result.CountyId + '">' + result.CountyName + '</option>');
//                });
//                var _select = new Select();
//                _select.init(select);
//            });
//        }
//    }

//}

UI.prototype.GetInsuranceCountyByFilter = function (cityId, countyId, callback) {
    var self = this;
    var url = "customized/GetInsuranceCounty";
    obj = {
        "cityid": cityId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.insuranceCountyList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(countyId, 'CountyId', self.insuranceCountyList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(countyId, 'CountyId', self.insuranceCountyList).CountyName;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceDealerCounty = function (cityId) {
    var url = "customized/GetInsuranceCounty";
    var obj = {
        "cityid": cityId
    };
    var type = "POST";

    if (typeof cityId !== 'undefined') {
        if (cityId === '') {
            // empty
            var select = $('#insuranceDealerCounty');
            var selectDealer = $('#insuranceDealer');
            select.empty();
            selectDealer.empty();
            select.append('<option value="">İlçe Seçiniz</option>');
            selectDealer.append('<option value="">Yetkili Satıcı Seçiniz</option>');
            var _select = new Select();
            _select.init(select);
            var _selectDealer = new Select();
            _selectDealer.init(selectDealer);
        } else {
            // has value
            if (!OGOO.Helper.isNullOrEmpty(cityId)) {
                OGOO.Service.insuranceForm(obj, url, type, function (result) {
                    var select = $('#insuranceDealerCounty');
                    var selectDealer = $('#insuranceDealer');
                    select.empty();
                    selectDealer.empty();
                    select.append('<option value="">İlçe Seçiniz</option>');
                    selectDealer.append('<option value="">Yetkili Satıcı Seçiniz</option>');
                    result.data.forEach(function (result) {
                        select.append('<option value="' + result.countyid + '">' + result.countyname + '</option>');
                    });
                    var _select = new Select();
                    _select.init(select);
                    var _selectDealer = new Select();
                    _selectDealer.init(selectDealer);
                });
            }
        }
    }

}

UI.prototype.GetInsuranceProductBrands = function () {
    var self = this;
    var url = "customized/GetInsuranceProductBrands";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        var select = $('#insuranceProductBrandRegister');
        select.empty();
        result.data.forEach(function (result) {
            select.append('<option value="' + result.productbrandid + '">' + result.productbrandname + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });
}

UI.prototype.GetInsuranceProductBrandsByFilter = function (brandId, callback) {
    var self = this;
    var url = "customized/GetInsuranceProductBrands";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.productBrandList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(brandId, 'productbrandid', self.productBrandList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(brandId, 'productbrandid', self.productBrandList).productbrandname;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceRimDiameters = function () {
    var self = this;
    var url = "customized/GetInsuranceRimDiameters";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        var select = $('#insuranceRim');
        select.empty();
        select.append('<option value="">Jant Seçiniz</option>');
        result.data.forEach(function (result) {
            select.append('<option value="' + result.rimdiameterid + '">' + result.rimdiametername + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });
}

UI.prototype.GetInsuranceRimDiametersByFilter = function (rimdiameterid, callback) {
    var self = this;
    var url = "customized/GetInsuranceRimDiameters";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.rimDiameterList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(rimdiameterid, 'rimdiameterid', self.rimDiameterList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(rimdiameterid, 'rimdiameterid', self.rimDiameterList).rimdiametername;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceVehicleBrands = function () {
    var self = this;
    var url = "customized/GetInsuranceVehicleBrands";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        var select = $('#insuranceVehicleBrand');
        select.empty();
        select.append('<option value="">Marka Seçiniz</option>');
        result.data.forEach(function (result) {
            select.append('<option value="' + result.vehiclebrandid + '">' + result.vehiclebrandname + '</option>');
        });
        var _select = new Select();
        _select.init(select);
    });
}

UI.prototype.GetInsuranceVehicleBrandsByFilter = function (id, callback) {
    var self = this;
    var url = "customized/GetInsuranceVehicleBrands";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.vehicleBrandList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(id, 'vehiclebrandid', self.vehicleBrandList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(id, 'vehiclebrandid', self.vehicleBrandList).vehiclebrandname;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceVehicleModel = function (modelid) {
    var url = "customized/GetInsuranceVehicleModel";
    var obj = {
        "vehiclebrandid": modelid
    };
    var type = "POST";

    if (typeof modelid !== 'undefined') {
        if (modelid === '') {
            // if item value is empty
            var select = $('#insuranceVehicleModel');
            select.empty();
            select.append('<option value="">Model Seçiniz</option>');
            var _select = new Select();
            _select.init(select);
        } else {
            // if item has value
            if (!OGOO.Helper.isNullOrEmpty(modelid)) {
                OGOO.Service.insuranceForm(obj, url, type, function (result) {
                    var select = $('#insuranceVehicleModel');
                    select.empty();
                    select.append('<option value="">Model Seçiniz</option>');
                    result.data.forEach(function (result) {
                        select.append('<option value="' + result.vehiclemodelid + '">' + result.vehiclemodelname + '</option>');
                    });
                    var _select = new Select();
                    _select.init(select);
                });
            }
        }
    }

}

UI.prototype.GetInsuranceVehicleModelByFilter = function (brandId, modelId, callback) {
    var self = this;
    var url = "customized/GetInsuranceVehicleModel";
    obj = {
        "vehiclebrandid": brandId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.insuranceVehicleModelList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(modelId, 'vehiclemodelid', self.insuranceVehicleModelList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(modelId, 'vehiclemodelid', self.insuranceVehicleModelList).vehiclemodelname;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceDealers = function (countyId, cityId) {
    var self = this;
    var url = "customized/GetInsuranceDealers";
    var obj = {
        "countyId": countyId,
        "cityId": cityId,
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    if (typeof countyId !== 'undefined') {
        if (countyId === '') {
            // empty
            var dealerModalList = $('#dealerModalList');
            dealerModalList.empty();
            dealerModalList.append('<h3>Yetkili Satıcı Bulunamadı</h3>')
        } else {
            // has value
            OGOO.Service.insuranceForm(obj, url, type, function (result) {
                var dealerModalList = $('#dealerModalList');
                dealerModalList.empty();
                dealerModalList.append('<h3>Yetkili Satıcılar</h3>')

                if (result.data.length !== 0) {
                    $('#aboutLassaTRDealer').modal('show');

                    result.data.forEach(function (result) {
                        dealerModalList.append('<li data-value="' + result.dealerid + '">' + result.dealername + '</option>');
                    });
                } else {
                    $('#dealerModalList').empty();
                    $('#dealerModalList').append('<li>Bayi Listesi Bulunamadı</li>');
                    $('#aboutLassaTRDealer').modal('show');
                }
            });
        }
    }
}

UI.prototype.GetInsuranceDealersByFilter = function (id, callback) {
    var cityId = "";
    var countyId = "";
    var self = this;
    var url = "customized/GetInsuranceDealers";
    var obj = {
        "countyId": countyId,
        "cityId": cityId,
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.dealerList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(id, 'dealerid', self.dealerList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(id, 'dealerid', self.dealerList).dealername;
        }
        callback(result);
    });
}

UI.prototype.GetInsuranceDealersByCustomerTypeFilter = function (id, callback) {
    var cityId = $('#insuranceDealerCity').val();
    var countyId = $('#insuranceDealerCounty').val();
    var self = this;
    var url = "customized/GetInsuranceDealers";
    var obj = {
        "countyId": countyId,
        "cityId": cityId,
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        self.dealerList = result.data;
        var result = "";
        if (typeof OGOO.UI.FindItemByPropertyId(id, 'dealerid', self.dealerList) !== 'undefined') {
            result = OGOO.UI.FindItemByPropertyId(id, 'dealerid', self.dealerList).customertype;
        }
        callback(result);
    });
}

UI.prototype.FindItemByPropertyId = function (value, property, list) {
    var index = list.map(function (item) {
        return item[property];
    }).indexOf(value);
    var result = void 0;
    if (index !== -1) {
        result = list[index];
    }
    return result;
};

UI.prototype.GetInsurancePatterns = function () {
    var self = this;
    var url = "customized/GetInsurancePatterns";
    var obj = {
        "campaignSourceId": campaignSourceId
    };
    var type = "POST";

    OGOO.Service.insuranceForm(obj, url, type, function (result) {
        var tyreInsuranceDay = $('.tyre-insurance-day');
        var select = $('#insurancePattern');
        select.empty();
        select.append('<option value="">Desen Seçiniz</option>');

        // Data String Check
        if (result.data.length == 0) {
            select.parents('.c-select-group').addClass('d-none');
            select.prop("disabled", true);
            self.billMaxDate = 15;
            tyreInsuranceDay.text("15");
        } else {
            result.data.forEach(function (result) {
                select.append('<option value="' + result.patternid + '">' + result.patternname + '</option>');
            });
            self.billMaxDate = 7;
            tyreInsuranceDay.text("7");
        }

        self.billDateOperations();


        var _select = new Select();
        _select.init(select);
    });
}

function insuranceDownload(base64, fileName) {
    // get extension
    var fileNameParse = fileName.lastIndexOf('.');
    // var parseFileName = fileName.substring(0, fileNameParse);
    var getExtension = fileName.substring(fileNameParse + 1);

    if (getExtension === 'jpg' || getExtension === 'JPG' || getExtension === 'jpeg' || getExtension === 'JPEG') {
        var parseType = "image/jpeg";
    } else if (getExtension === 'png' || getExtension === 'PNG') {
        var parseType = "image/png";
    } else if (getExtension === 'pdf' || getExtension === 'PDF') {
        var parseType = "applicationd/pdf";
    }

    var getFullBase64 = base64;

    if (getFullBase64.indexOf(";base64") > -1) {
        var parseBase64 = getFullBase64.split(';')[1].split(',').pop();
    } else {
        var parseBase64 = getFullBase64;
    }

    var b64toBlob = function b64toBlob(b64Data) {
        var contentType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
        var sliceSize = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 512;
        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);
            var byteNumbers = new Array(slice.length);

            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }

        var blobResult = new Blob(byteArrays, {
            type: contentType
        });
        return blobResult;
    };

    var getContentType = parseType;
    var getB64Data = parseBase64;
    var blob = b64toBlob(getB64Data, getContentType);

    if (window.navigator.msSaveBlob) {
        window.navigator.msSaveOrOpenBlob(blob, 'file.' + getExtension);
    } else {
        var a = window.document.createElement('a');

        a.href = window.URL.createObjectURL(blob, {
            type: parseType
        });
        a.download = 'file';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
}

/**
* TC Identity Validation
*/

function tcCheck(tcno) {
    tcno = String(tcno);
    var hane_tek;
    var hane_cift;
    var j;

    if (tcno.substring(0, 1) === '0') {
        return false;
    }

    if (tcno.length !== 11) {
        return false;
    }

    var ilkon_array = tcno.substr(0, 10).split('');
    var ilkon_total = hane_tek = hane_cift = 0;

    for (var i = j = 0; i < 9; ++i) {
        j = parseInt(ilkon_array[i], 10);
        if (i & 1) {
            hane_cift += j;
        } else {
            hane_tek += j;
        }
        ilkon_total += j;
    }

    if ((hane_tek * 7 - hane_cift) % 10 !== parseInt(tcno.substr(-2, 1), 10)) {
        return false;
    }

    ilkon_total += parseInt(ilkon_array[9], 10);
    if (ilkon_total % 10 !== parseInt(tcno.substr(-1), 10)) {
        return false;
    }

    return true;
}

UI.prototype.preloader = function (type) {
    var self = this;
    // var bgList = ["#ed1c24", "#7f7f7f", "#a7cc45", "#3f4e78", "#28bfc6", "#faaf42", "#c9591c"];
    var bgList = ["#1e1e1e"];
    var random = Math.floor(Math.random() * bgList.length);
    $('.async-loader-overlay').css('background', bgList[random]);
    if (type == "start") {
        $('.async-loader').show();
    } else {
        $('.async-loader').fadeOut("fast");
    }
}


/**
*   bill date operations
*/
UI.prototype.billDateOperations = function () {
    var self = this;

    $('#billDate').on('change', function () {
        // check bill date
        var getSelectedDateInput = $(this).val();
        var selectedDate = moment(getSelectedDateInput, "DD-MM-YYYY").format();
        var offsetDate = moment().subtract(self.billMaxDate, 'days').format();

        if (selectedDate < offsetDate) {
            $('.content').append('<div class="message"></div>');
            $('.message').addClass('error').html("Fatura tarihi " + self.billMaxDate + " günden eski olamaz. <i></i>");
            setTimeout(function () {
                $('.message').fadeOut('fast');
            }, 5000);
        }
    });
};

// Jira BLT-33 | Tire Catalog Seasonal Filtering Problem Fix 
$(document).ready(function () {
    setTimeout(function () {
        OGOO.UI.tyreFilter();
    });


    $(".meezdy-chat-button").on("click", function () {
        let iframe = $('#meezdy-chat');
        let openChatbox = iframe.contents().find('#meezdy-chat-button-body');
        openChatbox.trigger("click")
    })


});
// Jira BLT-33 | End Tire Catalog Seasonal Filtering Problem Fix

UI.prototype.customPrint = function (clickEl, targetEl) {
    $('body').on('click', clickEl, function () {
        var printWindow = window.open('', '', 'height=500,width=800');
        var divContents = $(targetEl).html() +
            "<script>" +
            "window.onload = function() {" +
            "     window.print();" +
            "};" +
            "<" + "/script>";
        printWindow.document.write(divContents);
        printWindow.document.close();
    });
}

/**
 * @define tagInformationLightbox
 * @description tag information lightbox for sizes
 */
UI.prototype.tagInformationLightbox = function () {
    var self = this;

    // image lightbox
    self.customPrint('.print', '.chart-area');

    $(".image-lightbox").on('click', function (e) {
        e.preventDefault();

        var pdfLink = $(this).parent().find('.tyre-pattern-pdf').attr('href');
        var overlayheight = $(window).height();
        var overlayWidth = $(window).width();
        var thisPath = $(this).attr("href");
        var data = $(this).data();

        $("body").append("<div class='lightbox'><div class='lightbox-overlay'></div><div class='lightbox-image-content'><div class='product-lightbox-area'><div class='chart-area'><img src=" + thisPath + " class='chartimg' style='margin:20px auto;display:block;' /></div></div><a href='javascript:;' class='close'></a><a href='javascript:;' class='print'></a><a href= " + pdfLink + " target='_blank'  class='lightbox-pdf'>Ürün Bilgisi</a></div></div>");

        $(".indicator em, .sound").each(function () {
            if ($(this).text() == "") {
                $(this).parent().remove();
            }
        })

        $(".lightbox").height(overlayheight).show();
        $(".close, .lightbox-overlay").on('click', function () {
            $(".lightbox").fadeOut();
            $(".lightbox").remove();
        });

        $(document).on('keyup', function (e) {
            if (e.keyCode == 27) {
                $(".lightbox").fadeOut();
                $(".lightbox").remove();
            }
        });
    })


};

/**
 * @define tyreDetailPrintOperation
 * @description print opreation for detail page
 */
UI.prototype.tyreDetailPrintOperation = function () {
    var self = this;

    self.customPrint('.performance-grid-print', '.performance-grid');
}

$("#showModeto").on('click', function () {
    Modeto.showPreferences();
});
/**
 * Created by Uğur Uğurlu on 15.12.2015.
 * Uptaded by Mustafa Savul on 03.09.2018
 */
var Warranty = function () {

}

Warranty.prototype.init = function () {
    var self = this;
    //warranty form
    $('#warranty-form').bValidator()
    $('.send-warranty-form').on('click', function (e) {
        e.preventDefault();
        $('.contact-form').css('margin-bottom', 0);
        var form = $('#warranty-form');
        if (form.data('bValidator').validate()) {
            var obj = OGOO.Helper.convertObject(form);
            $('.send-warranty-form').text("Lütfen bekleyin...");
            self.accessWarrantyInfo(obj);
        }
    });
}

Warranty.prototype.accessWarrantyInfo = function (obj) {
    var self = this;
    OGOO.Customized.getWarrantyInfo(obj, function (result) {
        var template = _.template(OGOO.Templates["Warranty"]);
        $('.send-warranty-form').text("Gönder");
        if (result.status.message == "Succeed") {

            $('#warranty-form').hide();
            $('.services-form-result').show();
            $('.services-form-result .result-body').html("Durum: " + result.data.status)
            $('.services-form-result').append('<br><div class="warranty-result-pdf-title">Sonuç mektubu:<a class="warranty-result-pdf" href="' + result.data.pdfurl + '">PDF İndir</a></div>');
            $('.warranty-top-text').html('Garanti başvurunuz varsa; lastiğinizin inceleme ve değerlendirme durumunu size iletilen referans no ve şifresi ile aşağıdaki alanlara girerek takip edebilirsiniz.');
            if (typeof result.data.pdfurl == 'undefined') {
                $('.warranty-result-pdf').remove();
                $('.warranty-top-text').html('Garanti başvurunuzun İnceleme ve değerlendirme işlemleri devam etmekte olup, en kısa süre içerisinde tamamlanacaktır.');
                $('.warranty-result-pdf-title').hide();
                $('.result-title').hide();
            }
        }
        else {
            if (typeof result.data != "undefined") {
                $('.services-form-result').html("<div class='alert alert-danger'><strong>" + result.data.status + "<strong><div>")
            } else {
                $('.services-form-result').html("<div class='alert alert-danger'><strong>Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.<strong><div>")
            }
        }
    });
};