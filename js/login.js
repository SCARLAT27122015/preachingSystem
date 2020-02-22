var correo, contrasena;

$(document).ready(function(){
	$("#USERS_CORREO").keyup(function(event) {
		$("#INVALID_USERS_CORREO").fadeOut(1000);
	});

	$("#USERS_CONTRASENA").keyup(function(event) {
		contrasena = $(this).val();
		if (contrasena != '') {
			$("#INVALID_USERS_CONTRASENA").fadeOut(1000);
		}
	});
	
	$("#access").submit(function(event) {
		correo = $("#USERS_CORREO").val();
		contrasena = $("#USERS_CONTRASENA").val();

		if (correo == '') {
			$("#INVALID_USERS_CORREO").show();
			$("#USERS_CORREO").focus();	
		}

		if (contrasena == '') {
			$("#INVALID_USERS_CONTRASENA").show();
			$("#USERS_CONTRASENA").focus();
		}

		if ((correo == '') || (contrasena == '')) {
			return false;
		}
	});
});