var mapaBase = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

const username = 'cdmx-partner';
const apiKey = '55a0b774e323959cd74d3e6fabbc59bd95357230';

var manzanaFill = '#EEEEEE'
var manzanaLayer = 'mza_zona5'
manzanasSource0 = `SELECT * FROM mza_zona5`;

var predioFill = '#00FF00'
var predioLayer = 'predio_zona5'
var lineColorPredio = '#000000'