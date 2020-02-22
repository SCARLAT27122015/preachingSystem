$(document).ready(function(){
  cargaUsuarios();
  
  $("#buscarUsuario").keyup(function(event) {
    cargaUsuarios();
  });

  $("#EDICION_USERS_NIVEL").change(function(event) {
    nivel = $(this).val();
    $("#EDIT_USERS_NIVEL").val(nivel);
    $("#INVALID_EDIT_USERS_NIVEL").fadeOut(1000);
  });

  $("#confirmacion_borrado").click(function() {
    $('#borraUsuario').modal('hide');
    id_borrar = $("#id2remove").val();
    $.post('data/delete/delete_usuarios.php', {
      NUMERO_ID: id_borrar
    }, function(data, textStatus, xhr) {
      $("#fila_" + id_borrar).remove();
      $("#usuarioBorrado").show();
      setTimeout(function(){$("#usuarioBorrado").fadeOut(1000)}, 3000);
    }); 
  });

  $("#levelEdition").submit(function(event) {
    var nivel = $("#EDIT_USERS_NIVEL").val();
    if (nivel == 0) {
      $("#INVALID_EDIT_USERS_NIVEL").show();
      $("#EDICION_USERS_NIVEL").focus();
      return false;
    }
  });

});

function cargaUsuarios(){
  var congregacion = $("#congregacionID").val();
  var busqueda = $("#buscarUsuario").val();
  $.post('data/loads/load_users.php', {
      NUMERO_CONGREGACION: congregacion,
      busqueda: busqueda
  }, function(data, textStatus, xhr) {
    $("#insercionUsuarios").html(data);
    $(".profileImage").click(function(){
      source = $(this).attr('src');
      nombre = $(this).attr('alt');
      $("#largeProfilePic").attr('src',source);
      $("#nombreProfile").text(nombre);
    });

    $(".borradoUsuarios").click(function(){
      var idtoExtract = $(this).attr('id');
      idtoExtract = extractIDs(idtoExtract);
      $("#id2remove").val(idtoExtract);
    });

    $(".editadoUsuarios").click(function(){
      var idtoExtract = $(this).attr('id');
      idtoExtract = extractIDs(idtoExtract);
      $.ajax({
        url: 'data/fetch/fetch_usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: {NUMERO_ID: idtoExtract},
        success: function(data, textStatus, xhr){
          $("#INVALID_EDIT_USERS_NIVEL").hide();
          $(".nombreCompleto").text(data.USERS_NOMBRE);
          $("#usuarioGrupo").text(data.USERS_GRUPO);
          var fotoUsuario = data.USERS_FOTO;
          if (fotoUsuario == '') {
            fotoUsuario = 'unknown.png'
          }

          $("#usersPhoto").attr('src','images/USERS/' + fotoUsuario);
          var privilegio = data.USERS_PRIVILEGIO;
          if (privilegio == 1) {
            privilegio = 'Publicador';
          }else if(privilegio == 2){
            privilegio = 'Precursor Auxiliar';
          }else{
            privilegio = 'Precursor Regular';
          }

          $("#usuarioPrivilegio").text(privilegio);

          var telefonoUsuario = data.USERS_TELEFONO;
          if (telefonoUsuario == '') {
            telefonoUsuario = 'No registrado';
          }
          $("#usuarioTelefono").text(telefonoUsuario);

          var correo = data.USERS_CORREO;
          if (correo == '') {
            correo = 'No registrado';
          }

          $("#usuarioCorreo").text(correo);
          $("#EDICION_USERS_NIVEL").val(data.USERS_NIVEL);
          $("#EDIT_USERS_NIVEL").val(data.USERS_NIVEL);
        }
      });

      $("#EDIT_NUMERO_ID").val(idtoExtract);
      $('#ediciondeUsuarios').modal('show');
    }); 
  });
}