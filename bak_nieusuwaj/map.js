var map = L.map('map').setView([52.237049, 21.017532], 5); // Default location
var wmsLayers = {}; // Object to store WMS layers

// Adding OpenStreetMap base layer
var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Function to add WMS layer
function addWMSLayer(layerName) {
    var wmsLayer = L.tileLayer.wms("https://mapserver.bdl.lasy.gov.pl/ArcGIS/services/WMS_BDL/mapserver/WMSServer", {
        layers: layerName,
        format: 'image/png',
        transparent: true,
        version: '1.3.0'
    });
    wmsLayers[layerName] = wmsLayer; // Add layer to global object
    wmsLayer.addTo(map);
}

// Function to fetch and add WMS layers
function fetchAndAddWMSLayers() {
    var wmsGetCapabilitiesUrl = "https://mapserver.bdl.lasy.gov.pl/ArcGIS/services/WMS_BDL/mapserver/WMSServer?request=GetCapabilities&service=WMS";

    $.ajax({
        url: wmsGetCapabilitiesUrl,
        success: function (xml) {
            $(xml).find('Layer > Name').each(function () {
                var layerName = $(this).text();
                addWMSLayer(layerName);
            });
        },
        error: function() {
            console.error("Error fetching WMS layers.");
        }
    });
}

// Function to handle click event and show popup
function onMapClick(e) {
    Object.keys(wmsLayers).forEach(function(layerName) {
        var layer = wmsLayers[layerName];
        if (map.hasLayer(layer)) {
            var url = getFeatureInfoUrl(layer, e.latlng);
            if (url) {
                $.ajax({
                    url: url,
                    success: function (data) {
                        if (data && typeof data === 'string') {
                            L.popup()
                                .setLatLng(e.latlng)
                                .setContent(data) // Directly use the string data
                                .openOn(map);
                        }
                    },
                    error: function() {
                        console.error("Error fetching feature info.");
                    }
                });
            }
        }
    });
}

function getFeatureInfoUrl(layer, latlng) {
    var point = map.latLngToContainerPoint(latlng, map.getZoom()),
        size = map.getSize(),
        bounds = map.getBounds(),
        crs = map.options.crs,
        sw = crs.project(bounds.getSouthWest()),
        ne = crs.project(bounds.getNorthEast()),
        obj = {
            service: 'WMS',
            version: layer.options.version,
            request: 'GetFeatureInfo',
            layers: layer.options.layers,
            styles: layer.options.styles,
            bbox: [sw.x, sw.y, ne.x, ne.y].join(','),
            width: size.x,
            height: size.y,
            query_layers: layer.options.layers,
            info_format: 'text/html'
        };

    obj[crs === L.CRS.EPSG4326 ? 'i' : 'x'] = point.x;
    obj[crs === L.CRS.EPSG4326 ? 'j' : 'y'] = point.y;

    return layer._url + L.Util.getParamString(obj, layer._url, true);
}

map.on('click', onMapClick);

// Layer control
var baseMaps = {
    "OpenStreetMap": osmLayer
};
var overlayMaps = wmsLayers;

L.control.layers(baseMaps, overlayMaps).addTo(map);

// Fetch and add WMS layers
fetchAndAddWMSLayers();
