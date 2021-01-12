var map = AmCharts.makeChart("mapdiv", {
    type: "map",
    dataProvider: {
        mapURL:
        "../../public/images/mapa/LocalidadesBogota.svg",
        getAreasFromMap: true,
        zoomLevel: 0.95,
        areas: [
        {
            title: "USAQUÉN",
            id: "CO-BO1",
            color: "#00547b",
            class: "localidad",
            id_localidad: 1
            /*customData:
            "<b>Nidos:</b> 1 <br><b>Crea:</b> <div id='USAQUEN' name='USAQUEN'>1005</div>"*/
        },
        {
            title: "CHAPINERO",
            id: "CO-BO2",
            color: "#29abe2",
            id_localidad: 2
        },
        {
            title: "BARRIOS UNIDOS",
            id: "CO-BO3",
            color: "#00547b",
            id_localidad: 12
        },
        {
            title: "TEUSAQUILLO",
            id: "CO-BO4",
            color: "#00a99d",
            id_localidad: 13
        },
        {
            title: "SUBA",
            id: "CO-BO5",
            color: "#00a99d",
            id_localidad: 11
        },
        {
            title: "ENGATIVÁ",
            id: "CO-BO6",
            color: "#2e3192",
            id_localidad: 10
        },
        {
            title: "FONTIBÓN",
            id: "CO-BO7",
            color: "#00547b",
            id_localidad: 9
        },
        {
            title: "LA CANDELARIA",
            id: "CO-BO8",
            color: "#5e6c68",
            id_localidad: 17
        },
        {
            title: "SANTA FE",
            id: "CO-BO9",
            color: "#2e3192",
            id_localidad: 3
        },
        {
            title: "LOS MARTIRES",
            id: "CO-BO10",
            color: "#00547b",
            id_localidad: 14
        },
        {
            title: "ANTONIO NARIÑO",
            id: "CO-BO11",
            color: "#29abe2",
            id_localidad: 15
        },
        {
            title: "PUENTE ARANDA",
            id: "CO-BO12",
            color: "#5e6c68",
            id_localidad: 16
        },
        {
            title: "RAFAEL URIBE URIBE",
            id: "CO-BO13",
            color: "#00547b",
            id_localidad: 18
        },
        {
            title: "SAN CRISTÓBAL",
            id: "CO-BO14",
            color: "#00a99d",
            id_localidad: 4
        },
        {
            title: "SUMAPAZ",
            id: "CO-BO15",
            color: "#01937c",
            id_localidad: 20
        },
        {
            title: "USME",
            id: "CO-BO16",
            color: "#89ddaf",
            id_localidad: 5
        },
        {
            title: "TUNJUELITO",
            id: "CO-BO17",
            color: "#00547b",
            id_localidad: 6
        },
        {
            title: "CIUDAD BOLIVAR",
            id: "CO-BO18",
            color: "#01937c",
            id_localidad: 19
        },
        {
            title: "KENNEDY",
            id: "CO-BO19",
            color: "#29abe2",
            id_localidad: 8
        },
        {
            title: "BOSA",
            id: "CO-BO20",
            color: "#00547b",
            id_localidad: 7
        }
        ]
    },
    areasSettings: {
        autoRotateAngle: 90,
        //autoZoom: true,
        unlistedAreasColor: "#357566",
        rollOverOutlineColor: "#eeeeee",
        rollOverColor: "#357566",
        rollOutlineAlpha: 3,
        rollOutlineColor: "#eeeeee",
        rollOutlineThickness: 5,
        selectedColor: "#115f3e",
        balloonText: "<b>[[title]]</b><br> [[customData]]"
    },
    imagesSettings: {
        labelPosition: "top",
        labelFontSize: 9,
        labelColor: "#000000",
        labelRollOverColor: "#000000"
    },
    zoomControl: {
        minZoomLevel: 0.9
    },
    titles: "Bogotá"
});

map.addListener("init", () => {
    map.dataProvider.images = [];
    for (var x in map.dataProvider.areas) {
        var area = map.dataProvider.areas[x];
        var image = new AmCharts.MapImage();
        image.latitude = map.getAreaCenterLatitude(area);
        image.longitude = map.getAreaCenterLongitude(area);
        image.width = 30;
        image.height = 17;
        image.label = area.title;
        image.linkToObject = area;
        map.dataProvider.images.push(image);
    }
    map.validateData();
});

var tabla_config = {
    autoWidth: false,
    responsive: true,
    pageLength: 100,
    paging: false,
    info: false,
    "language": {
        "lengthMenu": "Ver _MENU_ registros por página",
        "zeroRecords": "No hay información, lo sentimos.",
        "info": "Mostrando pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtered from _MAX_ total records)",
        "search": "Filtrar"
    }
};

var tabla_colegios_estudiantes = $("#tabla-colegios-estudiantes").DataTable(tabla_config);
var tabla_grupos_estudiantes = $("#tabla-grupos-estudiantes").DataTable(tabla_config);
var tabla_estudiantes = $("#tabla-estudiantes").DataTable(tabla_config);
// var tabla_reporte_asistencias = $("#tabla-reporte-asistencias").DataTable(tabla_config);


map.addListener("clickMapObject", function(event){
    var id_localidad = "";
    var titulo_modal = "";

    titulo_modal = event.mapObject.linkToObject["title"];
    id_localidad = event.mapObject.linkToObject["id_localidad"];

    $("#modal-colegios-estudiantes").modal("show");
    $("#title-colegios-estudiantes").html("").html("<strong>INSTITUCIONES EDUCATIVAS LOCALIDAD DE "+titulo_modal+"</strong>");

    $.ajax({
        url: "getInfoColegiosEstudiantes",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id_localidad: id_localidad
        },
        success: function(data) {
            tabla_colegios_estudiantes.clear().draw();
            data.forEach((value, index) => {
                rowNode = tabla_colegios_estudiantes.row.add([
                    "<a href='#' class='colegio' data-id-colegio='"+data[index]["id_colegio"]+"'>"+data[index]["Colegio"]+"</a>",
                    data[index]["Tipo_Institucion"],
                    data[index]["Upz"],
                    "<strong><center>"+data[index]["Atendidos"]+"</center></strong>",
                    ]).draw().node();
            });
        },
        error: function(data){

            swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
        },
        async: false
    });
});

$("#modal-colegios-estudiantes").on("click", ".colegio", function(){
    let id_colegio = $(this).attr("data-id-colegio");
    let nombre_colegio = $(this).text();
    $.ajax({
        url: "getInfoGruposEstudiantes",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id_colegio: id_colegio
        },
        success: function(data) {
            $("#modal-colegios-estudiantes").modal("hide");
            $("#title-grupos-estudiantes").html("").html("<strong>GRUPOS DE LA INSTITUCION "+nombre_colegio+"</strong>");
            $("#modal-grupos-estudiantes").modal("show");
            tabla_grupos_estudiantes.clear().draw();
            data.forEach((value, index) => {
                rowNode = tabla_grupos_estudiantes.row.add([
                    "<a href='#' class='estudiantes' data-id-grupo='"+data[index]["id_grupo"]+"' data-nombre-grupo='"+data[index]["Grupo"]+"'>"+data[index]["Grupo"]+"</a>",
                    data[index]["P_Nombre"]+" "+data[index]["S_Nombre"]+" "+data[index]["P_Apellido"],
                    data[index]["Docente"],
                    "<center>"+data[index]["Atendidos"]+"</center>"
                    ]).draw().node();
            });
        },
        error: function(data){
            swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
        },
        async: false
    });
});

$("#modal-grupos-estudiantes").on("click", ".estudiantes", function(){
    let id_grupo = $(this).attr("data-id-grupo");
    let nombre_grupo = $(this).attr("data-nombre-grupo");
    $.ajax({
        url: "getInfoEstudiantes",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id_grupo: id_grupo
        },
        success: function(data) {
            $("#modal-grupos-estudiantes").modal("hide");
            $("#title-estudiantes").html("").html(nombre_grupo);
            $("#modal-estudiantes").modal("show");
            tabla_estudiantes.clear().draw();
            data.forEach((value, index) => {
                rowNode = tabla_estudiantes.row.add([
                    data[index]["Identificacion"],
                    "<a href='#' class='estudiante' data-id-estudiante='"+data[index]["id_estudiante"]+"'>"+data[index]["Estudiante"]+"</a>",
                    data[index]["GENERO"]
                    ]).draw().node();
            });
        },
        error: function(data){
            swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
        },
        async: false
    });
});

$("#modal-estudiantes").on("click", ".estudiante", function(){
    let id_estudiante = $(this).attr("data-id-estudiante");
    let nombre_estudiante = $(this).text();
    $.ajax({
        url: "getInfoEstudiante",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            id_estudiante: id_estudiante
        },
        success: function(data) {
            $("#modal-estudiantes").modal("hide");
            $("#title-estudiante").html("").html(nombre_estudiante);
            $("#modal-estudiante").modal("show");

            $("#numero-documento").val(data[0]["IN_Identificacion"]);
            $("#tipo-documento").val(data[0]["tipo_documento"]["descripcion"]);
            $("#primer-nombre").val(data[0]["VC_Primer_Nombre"]);
            $("#segundo-nombre").val(data[0]["VC_Segundo_Nombre"]);
            $("#primer-apellido").val(data[0]["VC_Primer_Apellido"]);
            $("#segundo-apellido").val(data[0]["VC_Segundo_Apellido"]);
            $("#fecha-nacimiento").val(data[0]["fecha_nacimiento"]);
            $("#genero").val(data[0]["genero"]);
            $("#estrato").val(data[0]["IN_Estrato"]);
            $("#enfoque").val(data[0]["enfoque"]["descripcion"]);
            $("#correo").val(data[0]["VC_Correo"]);
            $("#celular").val(data[0]["VC_Celular"]);
            $("#direccion").val(data[0]["VC_Direccion"]);
        },
        error: function(data){
            swal("Error", "No se pudo obtener la información, por favor inténtelo nuevamente", "error");
        },
        async: false
    });
});


