$(document).on("click", "[data-accion=accion]", function() {
    var id = "";
    id = $(this).attr("id");
    
    switch(id) {
    case "asignar":
        fnAsignarCensador();
        break;
    default:
        console.log("error", "ocurrio un error con la acción");
        return false;
    }
    
});