var nombre, congregacion, usuario, contrasena, email, telefono, grupo, privilegio;
var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

$(document).ready(function(){
	$("#USERS_GRUPO").change(function(event) {
		grupo = $(this).val();
		$("#INVALID_USERS_GRUPO").fadeOut(1000);
		
	});

	
	$("#USERS_PRIVILEGIO").change(function(){
		privilegio = $(this).val();
		if (privilegio != 0) {
			$("#INVALID_USERS_PRIVILEGIO").fadeOut(1000);
		}
	});

	$("#USERS_CORREO").keyup(function(event) {
		$("#INVALID_USERS_CORREO").fadeOut(1000);
	});

	$("#USERS_TELEFONO").attr('maxlength',10).keyup(function(event) {
		telefono = $(this).val();
		if ((telefono.length == 10) || (telefono == '')) {
			$("#INVALID_USERS_TELEFONO").fadeOut(1000);
		}
	});

	$("#USERS_NOMBRE").keyup(function(event) {
		nombre = $(this).val();
		if (nombre != ''){
			$("#INVALID_USERS_NOMBRE").fadeOut(1000);	
		}
	});

	$("#USERS_CONGREGACION").change(function(event) {
		congregacion = $(this).val();
		if (congregacion != 0) {
			$("#INVALID_USERS_CONGREGACION").fadeOut(1000);
			$(".noCongregation").slideUp(500);
		}else{
			$(".noCongregation").slideDown(500);
		}
	});

	$("#USERS_NUEVA_CONGREGACION").keyup(function(event) {
		var nuevaCongregacion = $(this).val();
		if (nuevaCongregacion != '') {
			$("#INVALID_USERS_NUEVA_CONGREGACION").fadeOut(1000);
		}
	});

	$("#USERS_USUARIO").keyup(function(event) {
		usuario = $(this).val();
		if (usuario != '') {
			$("#INVALID_USERS_USUARIO").fadeOut(1000);
		}
	});

	$("#USERS_CONTRASENA").keyup(function(event) {
		contrasena = $(this).val();
		if (contrasena != '') {
			$("#INVALID_USERS_CONTRASENA").fadeOut(1000);
		}
	});

	$(".texto").keyup(function() {
		var valor = $(this).val();
		var nuevo_valor = properCase(valor);
		$(this).val(nuevo_valor);
	});

	$(".minuscula").keyup(function() {
		var valor = $(this).val();
		var nuevo_valor = lowerCase(valor);
		$(this).val(nuevo_valor);
	});

	$(".numerico").keyup(function() {
		var valor = $(this).val();
		var nuevo_valor = numericOnly(valor);
		$(this).val(nuevo_valor);
	});

	$("#CHECK_ADD_CONGREGATION").click(function() {
	    $("#ADD_CONGREGACION").slideToggle(500);
	    $("#USERS_NUEVA_CONGREGACION").val('');
	    $("#INVALID_USERS_CONGREGACION").hide();
	    $("#INVALID_USERS_NUEVA_CONGREGACION").hide();
	});

	$("#registration").submit(function() {
		nombre = $("#USERS_NOMBRE").val();
		congregacion = $("#USERS_CONGREGACION").val();
		usuario = $("#USERS_USUARIO").val();
		contrasena = $("#USERS_CONTRASENA").val();
		telefono = $("#USERS_TELEFONO").val();
		correo = $("#USERS_CORREO").val();
		grupo = $("#USERS_GRUPO").val();
		privilegio = $("#USERS_PRIVILEGIO").val();

		if (nombre == '') {
			$("#INVALID_USERS_NOMBRE").show();
			$("#USERS_NOMBRE").focus();
		}

		if (congregacion == 0) {
			if ($('#CHECK_ADD_CONGREGATION').is(':checked')) {
				var nuevaCongregacion = $("#USERS_NUEVA_CONGREGACION").val();
				if (nuevaCongregacion == '') {
					$("#INVALID_USERS_NUEVA_CONGREGACION").show();
					$("#USERS_NUEVA_CONGREGACION").focus();
				}
			}else{
				$("#INVALID_USERS_CONGREGACION").show();
				$("#USERS_CONGREGACION").focus();
			}	
		}


		if (grupo == 0) {
			$("#INVALID_USERS_GRUPO").show();
			$("#USERS_GRUPO").focus();
		}

		if (privilegio == 0){
			$("#INVALID_USERS_PRIVILEGIO").show();
			$("#USERS_PRIVILEGIO").focus();
		}

		if ((telefono != '') && (telefono.length < 10)) {
			$("#INVALID_USERS_TELEFONO").show();
			$("#USERS_TELEFONO").focus();
		}

		if ((correo != '') && !(regex.test(correo))) {
			$("#INVALID_USERS_CORREO").show();
			$("#USERS_CORREO").focus();
		}

		if (usuario == '') {
			$("#INVALID_USERS_USUARIO").show();
			$("#USERS_USUARIO").focus();	
		}

		if (contrasena == '') {
			$("#INVALID_USERS_CONTRASENA").show()
			$("#USERS_CONTRASENA").focus();
		}

		if ((nombre == '') 
			|| (usuario == '') 
			|| (contrasena == '')
			|| ((congregacion == 0) && ($('#CHECK_ADD_CONGREGATION').is(':checked')) && (nuevaCongregacion == ''))
			|| ((congregacion == 0)) && !($('#CHECK_ADD_CONGREGATION').is(':checked'))
			|| ((telefono != '') && (telefono.length <10))
			|| ((correo != '') && !(regex.test(correo)))
			|| (grupo == 0)
			|| (privilegio == 0)) {
			return false;
		}
	});
});