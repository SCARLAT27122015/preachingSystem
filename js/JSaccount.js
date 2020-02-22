'use strict'

$(document).ready(function() {
	$("#editingwholeaccount").click(function() {
		var NUMERO_ID = $("#EDIT_USER_ID").val();
		$.ajax({
				url: 'data/fetch/fetch_usuarios.php',
				type: 'POST',
				dataType: 'json',
				data: {
					NUMERO_ID: NUMERO_ID,
					fethWholeUser: 1
				},
				success: function(data, status){
					var foto = data.USERS_FOTO;
					var ext = 'images/USERS/';
					var fullSrc = '';
					if (foto == '') {
						fullSrc = ext + 'unknown.png';
					}else{
						fullSrc = ext + foto;
					}
					$("#usersPhoto").prop('src', fullSrc); 
					$("#EDIT_USERS_NOMBRE").val(data.USERS_NOMBRE);
					$("#EDIT_USERS_GRUPO").val(data.USERS_GRUPO);
					$("#EDIT_USERS_PRIVILEGIO").val(data.USERS_PRIVILEGIO);
					$("#EDIT_USERS_TELEFONO").val(data.USERS_TELEFONO);
					$("#EDIT_USERS_CORREO").val(data.USERS_CORREO);
					$("#EDIT_USERS_USUARIO").val(data.USERS_USUARIO);
				}
			});
	});

	$("#password_edit").click(function(event) {
		$(".contrasena").slideToggle(500);
		return false;
	});
});