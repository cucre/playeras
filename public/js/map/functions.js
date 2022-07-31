$(function(){

    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');          //alert('token = ' + token);
    let url = '/map/modal';    
    

    fetch(url,{
        method: 'post',
        headers: {
            "X-CSRF-TOKEN": token
        }
    })
    .then(function(response){
        return response.text();
    })
    .then(function(html){
        document.querySelector('#modal').innerHTML = html;
    })
    

})

function zoomManzana() {
    const query = `SELECT * FROM ${manzanaLayer}`;
    cadena = `https://${username}.carto.com/api/v2/sql/?format=geojson&q=${query}`;
    cadena += `&api_key=${apiKey}`;

    return fetch(cadena)
        .then((resp) => resp.json())
        .then((response) => {
            geojsonLayer = L.geoJson(response)
            map.fitBounds(geojsonLayer.getBounds());
            // const zoom = map.getZoom();
            // map.setZoom(zoom + 1);
        })
}

function actualizaIndicadores(){
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');          //alert('token = ' + token);
    let url = '/map/indicadores';    

    fetch(url,{
        method: 'get',
        headers: {
            "X-CSRF-TOKEN": token
        }
    })
    .then(function(resp){
        return resp.json();
    })
    .then(function(res){

        let total = res[0] + res[1];
        let totalPorAsignar = total - res[1]
      $('#totalm').text(total);
      $('#totala').text(res[1]);
      //let xxx = res[0] - res[1];
      $('#totalpa').text(totalPorAsignar);
    })
}

function modalManzana(featureEvent){
    resetModal();
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');          //alert('token = ' + token);
    console.log(featureEvent);
    map.setView(featureEvent.latLng,17);
    const idStatusManzana = featureEvent.data.id_status_manzana;
    const manzana = featureEvent.data.manzana;
    const id_censador = featureEvent.data.id_censador;
    let url = '/map/asigna_manzana';

    
    $('[data-accion=accion]').attr('id','asignar');
    $('.modal-title').text('Asignar manzana');
    $('[data-accion=accion]').text('Asignar');
    

    $('#manzana_id').val(manzana);
    $('#cerrar_modal').text('Cancelar');
    
    const datitos = new FormData();
    datitos.append('id_status_manzana',idStatusManzana);
    
    fetch(url,{
        method: 'post',
        body: datitos,
        headers: {
            "X-CSRF-TOKEN": token
        }
    })
    .then(function(response){
        return response.text();
    })
    .then(function(html){
        let detalle = "<div class='row my-3'>"
                     +"<div class='col'>"
                     +"<h4 class='d-inline-flex'>Manzana:</h4>"
                     +"<h4 class='ml-2 d-inline-flex'>"+manzana+"</h4>"
                     +"</div>"
                     +"</div>";
        $('#modal_detalle').html(detalle);
        document.querySelector('#modal_content').innerHTML = html;
        $('#censador_id').val(id_censador);
        $('#modal-dialog').modal('show');
    })

    
}

function resetModal(){
    $('#modal_detalle').empty()
    $('#modal_content').empty()
    $('.modal-title').text('');
    $('#cerrar_modal').text('');
    $('[data-accion=accion]').text('');
    $('#manzana_id').val();
    $('#censador_id').val('');
}

function fnAsignarCensador(){    
    let censador = $('#censador_id').val();    
    let manzana = $('#manzana_id').val();    
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');          //alert('token = ' + token);
    let url = '/map/actualiza_manzana';    
    const datitos = new FormData();
    datitos.append('id_censador',censador);
    datitos.append('id_manzana',manzana);

    fetch(url,{
        method: 'post',
        body: datitos,
        headers: {
            "X-CSRF-TOKEN": token
        }
    })
    .then(function(resp){
        return resp.json();
    })
    .then(function(res){
      if(res.codigo == 1){
          $('#modal-dialog').modal('hide');
          const queryManzanas = "select * from mza_zona5";
          manzanasSource.setQuery(queryManzanas);
          actualizaIndicadores();
          console.log(res.mensaje);
      }else{
        $('#modal-dialog').modal('hide');
        console.log(res.mensaje);
      }
    })

}