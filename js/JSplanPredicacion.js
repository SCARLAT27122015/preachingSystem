var zona, territorio, zona_fin, territorio_fin,finicio,ftermino;

$(document).ready(function() {
	$("#EDIT_SALIDAS_COMENTARIO").keyup(function(event) {
		let comentario = $(this).val();
		nuevoComentario = capitalized(comentario);
		$(this).val(nuevoComentario);
	});

	$(".editadoPlan").click(function(){
		var id = $(this).attr('id');
		var newID = extractIDs(id);
		$("#EDIT_SALIDAS_ID").val(newID);
		$.ajax({
			url: 'data/fetch/fetch_plan.php',
			type: 'POST',
			dataType: 'json',
			data: {
				SALIDAS_ID: newID,
				fetch1:1
			},
			success: function(data, textStatus, xhr){
				var foto = data.USERS_FOTO;
				if (foto == '') {
					foto = 'unknown.png';
				}
				$("#EDIT_PLAN_FOTO img").attr('src', 'images/USERS/' + foto);
				$("#EDIT_USERS_NOMBRE").text(data.USERS_NOMBRE);
				$("#EDIT_SALIDAS_USUARIO_GRUPO").text(data.SALIDAS_USUARIO_GRUPO);
				$("#EDIT_USERS_TELEFONO").text(data.USERS_TELEFONO);
				$("#EDIT_SECCION_NOMBRE").text(data.SECCION_NOMBRE);
				$("#EDIT_NUMERO_SECCION").text(data.NUMERO_SECCION);
				$("#EDIT_SALIDAS_COMENTARIO").text(data.SALIDAS_COMENTARIO);
				$("#EDIT_SALIDAS_FORIGEN").val(data.SALIDAS_FORIGEN);
				$("#EDIT_SALIDAS_FFIN").val(data.SALIDAS_FFIN);
				var segmentoFin = data.SALIDAS_SEGMENTO_FIN;
				var subsegmentoFin = data.SALIDAS_SUBSEGMENTO_FIN;
				$.ajax({
					url: 'data/fetch/fetch_plan.php',
					type: 'POST',
					dataType: 'json',
					data: {
						fetch2: 1,
						segmentoFin: segmentoFin
					},
					success:function(data2, textStatus, xhr){
						$("#EDIT_SALIDAS_SEGMENTO_FIN").text(data2.SECCION_NOMBRE);	
					}
				});
				$.ajax({
					url: 'data/fetch/fetch_plan.php',
					type: 'POST',
					dataType: 'json',
					data: {
						fetch3: 1,
						subsegmentoFin: subsegmentoFin
					},success: function(data3, textStatus, xhr){
						$("#EDIT_SALIDAS_SUBSEGMENTO_FIN").text(data3.NUMERO_SECCION);
					}
				});
			}
		});	
	});

	$("#SALIDAS_SEGMENTO").change(function(){
		getSubSegmento();
		$("#INVALID_SALIDAS_SEGMENTO").fadeOut(1000);		
	});

	$("#SALIDAS_SEGMENTO_FIN").change(function(){
		getSubSegmentoFin();
		$("#INVALID_SALIDAS_SEGMENTO_FIN").fadeOut(1000);		
	});

	$("#opener > button").click(function(event) {
		$("#planescerrados").slideToggle(1000);
		texto = $("#opener > button").text();
		if (texto == 'Mostrar planes cerrados') {
			texto = 'Ocultar planes cerrados';
		}else if (texto == 'Ocultar planes cerrados') {
			texto = 'Mostrar planes cerrados';
		}
		$("#opener > button").text(texto);
	});

	$(".cerradoPlan").click(function(){
		var id = $(this).attr('id');
		var newID = extractIDs(id);
		$("#salida_id").val(newID);
	});

	
	$(".borradoPlan").click(function(){
		var id = $(this).attr('id');
		var newID = extractIDs(id);
		$("#planID").val(newID);
	});
	
	$("#confirmacion_borrado").click(function(event) {
		var id = $("#planID").val();
		var nivel = $("#nivel_"+ id).text();
		var miGrupo, grupoaComparar;
		miGrupo = $("#miGrupo").val();
		grupoaComparar = $("#grupo_" + id).text();

		$.post('data/delete/delete_planes.php', 
			{id: id}, 
			function(data, textStatus, xhr) {
				var agregarPlanBoton = $("#addSalida").length;
				$("#plan_" + id).remove();
				$("#borraPlan").modal('hide');
				if (nivel =='Grupal') {
					if ((miGrupo == grupoaComparar)) {
						$(".forbidden").hide();
						if (agregarPlanBoton == 0) {
							$("#agregando").append('<button class="btn btn-primary" data-toggle="modal" data-target="#insertarSalida" id="addSalida">Agregar plan de predicación</button>');	
						}
					}
				}else {
					$(".forbidden").hide();
					if (agregarPlanBoton == 0) {
						$("#agregando").append('<button class="btn btn-primary" data-toggle="modal" data-target="#insertarSalida" id="addSalida">Agregar plan de predicación</button>');					
					}
				}
				
				$("#planBorrado").show();
      		setTimeout(function(){$("#planBorrado").fadeOut(1000)}, 3000);
		});
	});


	$("#SALIDAS_SUBSEGMENTO").change(function(){
		$("#INVALID_SALIDAS_SUBSEGMENTO").fadeOut(1000);
	});

	$("#SALIDAS_SUBSEGMENTO_FIN").change(function(event) {
		$("#INVALID_SALIDAS_SUBSEGMENTO_FIN").fadeOut(1000);
	});

	$("#SALIDAS_FORIGEN").change(function(event) {
		$("#INVALID_SALIDAS_FORIGEN").fadeOut(1000);
		$("#INVALID_INCONGRUENCIA_FECHAS").fadeOut(1000);
	});

	$("#SALIDAS_FFIN").change(function(event) {
		$("#INVALID_SALIDAS_FFIN").fadeOut(1000);
		$("#INVALID_INCONGRUENCIA_FECHAS").fadeOut(1000);
	});

	$("#SALIDAS_COMENTARIO").keyup(function(event) {
		var comentarios = $(this).val();
		var nuevoComentario = capitalized(comentarios);
		$("#SALIDAS_COMENTARIO").val(nuevoComentario);
	});

	$("#agregarNuevoPlan").submit(function(){
		zona = $("#SALIDAS_SEGMENTO").val();
		territorio = $("#SALIDAS_SUBSEGMENTO").val();
		zona_fin = $("#SALIDAS_SEGMENTO_FIN").val();
		territorio_fin = $("#SALIDAS_SUBSEGMENTO_FIN").val();
		finicio = $("#SALIDAS_FORIGEN").val();
		ftermino = $("#SALIDAS_FFIN").val();

		if (zona == 0) {
			$("#INVALID_SALIDAS_SEGMENTO").show();
			$("#SALIDAS_SEGMENTO").focus();
		}

		if (territorio == 0) {
			$("#INVALID_SALIDAS_SUBSEGMENTO").show();
			$("#SALIDAS_SUBSEGMENTO").focus();
		}

		if (zona_fin == 0) {
			$("#INVALID_SALIDAS_SEGMENTO_FIN").show();
			$("#SALIDAS_SEGMENTO_FIN").focus();
		}

		if (territorio_fin == 0) {
			$("#INVALID_SALIDAS_SUBSEGMENTO_FIN").show();
			$("#SALIDAS_SUBSEGMENTO_FIN").focus();
		}

		if (finicio > ftermino) {
			$("#INVALID_INCONGRUENCIA_FECHAS").show();
			$("#SALIDAS_FORIGEN").focus();
		}

		if (finicio == '') {
			$("#INVALID_SALIDAS_FORIGEN").show();
			$("#SALIDAS_FORIGEN").focus();
		}

		if (ftermino == '') {
			$("#INVALID_SALIDAS_FFIN").show();
			$("#SALIDAS_FFIN").focus();
		}

		if (zona == 0
			|| territorio == 0
			|| zona_fin == 0
			|| territorio_fin == 0
			|| (finicio > ftermino)
			|| finicio == ''
			|| ftermino == '') {
			return false;
		}
	});

	$('#insertarSalida').on('hidden.bs.modal', function () {
	    $(this).find('form').trigger('reset');
	    $(".invalid").hide();
	});
});

getSubSegmento();
getSubSegmentoFin();

function getSubSegmento(){
	var NUMERO_MAIN_SECCION = $("#SALIDAS_SEGMENTO").val();
	$.post('data/loads/loadSubSegmentos.php', {
		NUMERO_MAIN_SECCION: NUMERO_MAIN_SECCION,
		INICIO:1
	}, function(data, textStatus, xhr) {
		$("#SALIDAS_SUBSEGMENTO").html(data);
	});	
}

function getSubSegmentoFin(){
	var NUMERO_MAIN_SECCION = $("#SALIDAS_SEGMENTO_FIN").val();
	$.post('data/loads/loadSubSegmentos.php', {
		NUMERO_MAIN_SECCION: NUMERO_MAIN_SECCION,
		FIN:1
	}, function(data, textStatus, xhr) {
		$("#SALIDAS_SUBSEGMENTO_FIN").html(data);
	});	
}