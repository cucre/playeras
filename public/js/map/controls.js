var nivel = L.control({ position: 'topright' });
nivel.onAdd = function (map) {
    this._div2 = L.DomUtil.create('div', 'leaflet-bar'); // create a div with a class "info"
    this._filtro2 = L.DomUtil.create('a', '', this._div2);
    
    this._i_filtro2 = L.DomUtil.create('span', 'nivelZoom font-weight-bold', this._filtro2);
    return this._div2;
};