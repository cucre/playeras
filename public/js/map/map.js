$(document).ready(function () {
    var contentHeigh = $("body").height() - 343;        //alert('contentheight = ' + contentHeigh)
    //mapa original
    
    $('#map').css("height", contentHeigh);
  
    map = L.map('map', {
      maxZoom: 18,
    }).setView([19.402187, -99.127482], 10);
    L.tileLayer('https://{s}.tile.jawg.io/jawg-light/{z}/{x}/{y}{r}.png?access-token={accessToken}', {
      attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank">&copy; <b>Jawg</b>Maps</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      minZoom: 0,
      maxZoom: 22,
      subdomains: 'abcd',
      accessToken: '2vg21n4bnodY71T5X4k1zG4CUq8YH4AIQpHgY8Ugsa0KQq46Yr1Jr6uohKsfIprk'
    }).addTo(map);
  
    //legend.addTo(mymap);
  
    // map = L.map('map', {
    //   zoomControl: false
    // });
  
    // L.control.zoom({
    //   position: 'topright'
    // }).addTo(map);
  
    L.control.scale({
      position: 'bottomright'
    }).addTo(map)

    nivel.addTo(map);

    map.on('zoomend', function () {
        const zoomActual = map.getZoom();
        $('.nivelZoom').text(zoomActual);
        //fnLegends(zoomActual);
    });

    
    //const prediosLayer = new carto.layer.Layer(prediosSource, prediosStyle);
    const queryManzanas = "select * from mza_zona5";
    manzanasSource.setQuery(queryManzanas);

    const manzanasLayer = new carto.layer.Layer(manzanasSource, manzanasStyle,{
      featureClickColumns: ['id_status_manzana','manzana','id_censador']
    });

    client.addLayers([manzanasLayer]);
    client.getLeafletLayer().addTo(map);

    manzanasLayer.on('featureClicked', modalManzana);

    actualizaIndicadores();
    zoomManzana();    
    resetModal();
  });