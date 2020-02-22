var division, subdivision;
$(document).ready(function() {
	$("#nonExistentTerritorio").click(function(event) {
		$("#newTerrAdd").slideToggle(1000);
		$("#NUMERO_TERRITORIO").val('');
		$("#INVALID_NUMERO_TERRITORIO").hide();
		$("#EXISTENTE_NUMERO_TERRITORIO").val(0);
	});

	$("#displayerSegments").click(function(){
		$(".invalid").hide();
		$(".segmentos").slideToggle(1000);
		var congregacion = $("#NUMERO_CONGREGACION").val();
		$.ajax({
			url: 'data/fetch/fetch_segmentos.php',
			type: 'POST',
			dataType: 'json',
			data: {NUMERO_CONGREGACION: congregacion},
			success: function(data, textStatus, xhr){
				$("#EDITAR_CONGREGACION_SEGMENTO").val(data.CONGREGACION_SEGMENTO);
				$("#EDITAR_CONGREGACION_SUBSEGMENTO").val(data.CONGREGACION_SUBSEGMENTO);
				$("#EDITAR_CONG").val(congregacion);
			}
		});
		
	});

	$("#EDITAR_CONGREGACION_SEGMENTO").keyup(function(event) {
		$("#INVALID_EDITAR_CONGREGACION_SEGMENTO").fadeOut(1000);
		division = $(this).val();
		nuevaDivision = properCase(division);
		$(this).val(nuevaDivision);	
	});
	
	$("#EDITAR_CONGREGACION_SUBSEGMENTO").keyup(function(event) {
		$("#INVALID_EDITAR_CONGREGACION_SUBSEGMENTO").fadeOut(1000);
		division = $(this).val();
		nuevaDivision = properCase(division);
		$(this).val(nuevaDivision);
	});

	$("#editandoSegmentosFormulario").submit(function(event) {
		division = $("#EDITAR_CONGREGACION_SEGMENTO").val();
		subdivision = $("#EDITAR_CONGREGACION_SUBSEGMENTO").val();
		
		
		if (division == '') {
			$("#INVALID_EDITAR_CONGREGACION_SEGMENTO").show();
			
		}

		if (subdivision == '') {
			$("#INVALID_EDITAR_CONGREGACION_SUBSEGMENTO").show();
			
		}

		if ((division == '') || (subdivision == '')) {
			return false;
		}
	});


	$("#ingresar_division").click(function(event) {
		division = $("#CONGREGACION_SEGMENTO").val();
		subdivision = $("#CONGREGACION_SUBSEGMENTO").val();
		var congregacion = $("#CONGREGACION").text();
		
		if (division == '') {
			$("#INVALID_CONGREGACION_SEGMENTO").show();
			
		}

		if (subdivision == '') {
			$("#INVALID_CONGREGACION_SUBSEGMENTO").show();
			
		}

		if ((division == '') || (subdivision == '')) {
			return false;
		}else{
			configSegmentos(division, subdivision, congregacion);			
		}
	});

	$("#NUMERO_CALLES").keyup(function(event) {
		var calles = $(this).val();
		calles = capitalized(calles);
		$(this).val(calles);
	});

	$("#NUMERO_COMENTARIOS").keyup(function(event) {
		var comentarios = $(this).val();
		comentarios = capitalized(comentarios);
		$(this).val(comentarios);
	});

	$("#EDIT_NUMERO_CALLES").keyup(function(event) {
		var calles = $(this).val();
		calles = capitalized(calles);
		$(this).val(calles);
	});

	$("#EDIT_NUMERO_COMENTARIOS").keyup(function(event) {
		var comentarios = $(this).val();
		comentarios = capitalized(comentarios);
		$(this).val(comentarios);
	});

	$("#CONGREGACION_SEGMENTO").keyup(function(event) {
		$("#INVALID_CONGREGACION_SEGMENTO").fadeOut(1000);
		division = $(this).val();
		nuevaDivision = properCase(division);
		$(this).val(nuevaDivision);
	});

	$("#CONGREGACION_SUBSEGMENTO").keyup(function(event) {
		$("#INVALID_CONGREGACION_SUBSEGMENTO").fadeOut(1000);
		subdivision = $(this).val();
		nuevaSubDivision = properCase(subdivision);
		$(this).val(nuevaSubDivision);
	});

	$('#listaTerritorios').on('hidden.bs.modal', function () {
	    $(this).find('form').trigger('reset');
	    $(".invalid").hide();
	});

	$("#agregarNuevoTerritorio").submit(function() {
		var territorio_existente = $("#EXISTENTE_NUMERO_TERRITORIO").val();
		division = $("#NUMERO_TERRITORIO").val();
		subdivision = $("#NUMERO_SECCION").val();

		if ($('#nonExistentTerritorio').is(':checked')){
			if (division == '') {
				$("#INVALID_NUMERO_TERRITORIO").show();
			}
		}else{
			if (territorio_existente == 0) {
				$("#INVALID_EXISTENTE_NUMERO_TERRITORIO").show();	
			}
		}

		if (subdivision == '') {
			$("#INVALID_NUMERO_SECCION").show();
			
		}

		if ((territorio_existente == 0) && !($('#nonExistentTerritorio').is(':checked'))
			||((division == '') && ($('#nonExistentTerritorio').is(':checked'))) 
			|| (subdivision == '')) {
			return false;
		}
	});

	$("#EXISTENTE_NUMERO_TERRITORIO").change(function(event) {
		$("#newTerrAdd").slideUp(1000);
		$("#INVALID_EXISTENTE_NUMERO_TERRITORIO").fadeOut(1000);
		$("#NUMERO_TERRITORIO").val('');
		$("#INVALID_NUMERO_TERRITORIO").fadeOut(1000);
	});

	$("#NUMERO_TERRITORIO").keyup(function(event) {
		$("#INVALID_NUMERO_TERRITORIO").fadeOut(1000);
		division = $(this).val();
		var nuevaDivision =  properCase(division);
		$(this).val(nuevaDivision);
	});

	$("#NUMERO_SECCION").keyup(function(event) {
		$("#INVALID_NUMERO_SECCION").fadeOut(1000);
		subdivision = $(this).val();
		var nuevaSubDivision = properCase(subdivision);
		$(this).val(nuevaSubDivision);
	});

	$("#confirmacion_borrado").click(function() {
		$('#borraTerritorio').modal('hide');
		id_borrar = $("#id2remove").val();
		$.post('data/delete/delete_territorios.php', {
			NUMERO_ID: id_borrar
		}, function(data, textStatus, xhr) {
			$("#fila_" + id_borrar).remove();
			$("#territorioBorrado").show();
			setTimeout(function(){$("#territorioBorrado").fadeOut(1000)}, 3000);
		});	
	});

	$("#buscarTerritorio").keyup(function(event) {
		cargaTerritorios();		
	});
	cargaTerritorios();
});

function cargaTerritorios(){
	var congregacion = $("#NUMERO_CONGREGACION").val();
	var busqueda = $("#buscarTerritorio").val();
	$.post('data/loads/load_territorios.php', {
			NUMERO_CONGREGACION: congregacion,
			busqueda: busqueda
	}, function(data, textStatus, xhr) {
		$("#insercionRegistros").html(data);
		
		$(".borradoTerritorios").click(function(){
			var idtoExtract = $(this).attr('id');
			idtoExtract = extractIDs(idtoExtract);
			$("#id2remove").val(idtoExtract);
		});

		$(".editadoTerritorios").click(function(){
			var idtoExtract = $(this).attr('id');
			idtoExtract = extractIDs(idtoExtract);
			$.ajax({
				url: 'data/fetch/fetch_territorios.php',
				type: 'POST',
				dataType: 'json',
				data: {NUMERO_ID: idtoExtract},
				success: function(data, textStatus, xhr){
					$("#EDIT_NUMERO_TERRITORIO").val(data.SECCION_NOMBRE);
					$("#EDIT_NUMERO_SECCION").val(data.NUMERO_SECCION);
					$("#EDIT_NUMERO_CALLES").val(data.NUMERO_CALLES);
					$("#EDIT_NUMERO_COMENTARIOS").val(data.NUMERO_COMENTARIOS);
				}
			});
			$("#EDIT_NUMERO_ID").val(idtoExtract);
			$('#ediciondeTerritorios').modal('show');
		});	
	});
}

function hideAddTerritorio() {
	$("#addTerritorio").show();
}

function configSegmentos(division, subdivision, congregacion){
	$.post('data/insert/insert_territorios.php', {
				division: division,
				subdivision: subdivision,
				congregacion: congregacion,
				insDivisiones: 1
	}, function(data, textStatus, xhr) {
		if (data == 'success') {
			$("#etiquetaDiv").text(division);
			$("#etiquetaSub").text(subdivision);
			$("#division-success").show();
			$("#segmentacionPrimeraVez").slideUp(1000);
			setTimeout(function(){$("#division-success").fadeOut(1000)},3000);
			$("#CONGREGACION_SEGMENTO").val('');
			$("#CONGREGACION_SUBSEGMENTO").val('');
			var phDivision = $("#NUMERO_TERRITORIO").attr('placeholder');
			var phsubDivision = $("#NUMERO_SECCION").attr('placeholder');

			if (phDivision == 'Ingrese el/la ') {
				$("#NUMERO_TERRITORIO").attr('placeholder', 'Ingrese el/la ' + division);
			}

			if (phsubDivision == 'Ingrese el/la ') {
				$("#NUMERO_SECCION").attr('placeholder', 'Ingrese el/la ' + subdivision);
			}
			
			hideAddTerritorio();
		}
	});
}