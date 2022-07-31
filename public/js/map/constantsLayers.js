const manzanasStyle0 = `
#layer[zoom >=12][zoom < 19]{    
  line-color: #000000;
  line-width: 2;  
  line-opacity: 1;
  [id_status_manzana = 1] {
    polygon-fill: #00acac;
    polygon-opacity: 1;
  }
  [id_status_manzana = 0] {
    polygon-fill: #b6c2c9;
    polygon-opacity: 1;
  }
}
#layer::labels[zoom>=17] {
  text-name: [manzana];
  text-face-name: 'DejaVu Sans Book';
  text-size: 11;
  text-label-position-tolerance: 0;
  text-fill: #000;
  text-halo-fill: #FFF;
  text-halo-radius: 1;
  text-dy: -10;
  text-allow-overlap: true;
  text-placement: point;
  text-placement-type: dummy;    
}`;

const prediosStyle0 = `
  #layer[zoom >=17]{
  polygon-fill:${predioFill};
  polygon-opacity: 1;
  line-color: ${lineColorPredio};
  line-width: 1;
  line-opacity: 0.9;
}`;

client = new carto.Client({
    apiKey: apiKey,
    username: username
});

//CAPA MANZANAS
const manzanasStyle = new carto.style.CartoCSS(manzanasStyle0);
//const manzanasSource = new carto.source.Dataset(manzanaLayer);
const manzanasSource = new carto.source.SQL(manzanasSource0);

//CAPA PREDIOS
const prediosSource = new carto.source.Dataset(predioLayer);
const prediosStyle = new carto.style.CartoCSS(prediosStyle0);
//const prediosLayer = new carto.layer.Layer(prediosSource, prediosStyle);