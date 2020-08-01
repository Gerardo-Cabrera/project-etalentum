$(function() {
	$("body").keypress(function(event) {
		if (event.keyCode == 13) {
			$("#ingresar, #registrar, #modificar, #guardar-perfil").click();
		}
	});

	$("#registrar").on("click", function(event) {
		if (validaciones()) {
			registrarUsuario();
		}
	});

	removerErrores();

	$("#modificar").on("click", function(event) {
		var mod = true;

		if (validaciones(mod)) {
			modificarUsuario();
		}
	});

	$("#cancelar-perfil").on("click", function(event) {
		$("#usuario").attr("readonly", "readonly");
		$("#div-password").hide();
		$("#password").attr("readonly", "readonly");
		$("#email").attr("readonly", "readonly");
	});

	$("#modificar-perfil").on("click", function(event) {
		$("#usuario").removeAttr("readonly");
		$("#div-password").show();
		$("#password").removeAttr("readonly");
		$("#email").removeAttr("readonly");

		$("#guardar-perfil").on("click", function(event) {
			var mod = true;

			if (validaciones(mod)) {
				modificarUsuario();
			}
		});
	});

	$(".eliminar").on("click", function(event) {
		var datos = {
			id: $(this).parent().get(0).id,
			usuario: $(this).parent().get(0).innerText,
		};

		eliminarUsuario(datos);
	});

	$(".close, #cancelar").on("click", function() {
		$(".mensaje").contents().remove();
		$("#myModal").hide();
	});

	$("#ingresar").on("click", function(event) {
		if (validacionesLogin()) {
			login();
		}
	});

	if ($("#totalPages").val() < 2) {
		$(".pagination").hide();
		$(".currentPage").hide();
	}
});

function validaciones(mod = false) {
	var usuario = "#usuario";
	var password = "#password";
	var email = "#email";
	var user = false;
	var pass = false;
	var correo = false;
	var result = false;

	if ($(".error-message").length > 0) {
		$(".error-message").hide();
	}
	
	if ($(usuario).val().length < 3) {
		var mensaje = "Debe ingresar un usuario de mínimo 3 caracteres";
		$(usuario).addClass("input-error");
		$("#error-usuario").contents().remove();
		$("#error-usuario").append(mensaje);
		$("#error-usuario").show();
	} else if ($(usuario).val().length >= 3) {
		$("#error-usuario").hide();
		$("#error-usuario").contents().remove();
		$(usuario).removeClass("input-error");
		user = true;
	}
	
	if (mod) {
		if ($("#password").val().length > 0 && $("#password").val().length < 6) {
			var mensaje = "Debe ingresar una contraseña de mínimo 6 caracteres";
			$(password).addClass("input-error");
			$("#error-password").contents().remove();
			$("#error-password").append(mensaje);
			$("#error-password").show();
		} else {
			$("#error-password").contents().remove();
			$(password).removeClass("input-error");
			pass = true;
		}
	} else if ($(password).val().length < 6) {
		var mensaje = "Debe ingresar una contraseña de mínimo 6 caracteres";
		$(password).addClass("input-error");
		$("#error-password").contents().remove();
		$("#error-password").append(mensaje);
		$("#error-password").show();
	} else if ($(password).val().length >= 6) {
		$("#error-password").hide();
		$("#error-password").contents().remove();
		$(password).removeClass("input-error");
		pass = true;
	}

	var mailformat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	if ($(email).val().length == "") {
		var mensaje = "Debe ingresar un correo";
		$(email).addClass("input-error");
		$("#error-email").contents().remove();
		$("#error-email").append(mensaje);
		$("#error-email").show();
	} else if (!mailformat.test($(email).val())) {
		var mensaje = "El correo ingresado no es válido";
		$(email).addClass("input-error");
		$("#error-email").contents().remove();
		$("#error-email").append(mensaje);
		$("#error-email").show();
	} else {
		correo = true;
	}

	if (user && pass && correo) {
		result = true;
	}

	return result;
}

function validacionesLogin() {
	var usuario = "#usuario-login";
	var password = "#password-login";
	var user = false;
	var pass = false;
	var result = false;

	if ($(".error-message").length > 0) {
		$(".error-message").hide();
	}

	if ($(usuario).val().length < 3) {
		var mensaje = "Debe ingresar su usuario o correo con el cual se registró";
		$(usuario).addClass("input-error");
		$("#error-usuario-login").contents().remove();
		$("#error-usuario-login").append(mensaje);
		$("#error-usuario-login").show();
	} else if ($(usuario).val().length >= 3) {
		$("#error-usuario-login").hide();
		$("#error-usuario-login").contents().remove();
		$(usuario).removeClass("input-error");
		user = true;
	}

	if ($(password).val().length < 6) {
		var mensaje = "Debe ingresar su contraseña";
		$(password).addClass("input-error");
		$("#error-password-login").contents().remove();
		$("#error-password-login").append(mensaje);
		$("#error-password-login").show();
	} else if ($(password).val().length >= 6) {
		$("#error-password-login").hide();
		$("#error-password-login").contents().remove();
		$(password).removeClass("input-error");
		pass = true;
	}

	if (user && pass) {
		result = true;
	}

	return result;
}

function caracteresPermitidos(char) {
	if ((char.keyCode >= 65 && char.which <= 90) || (char.keyCode >= 97 && char.which <= 122) || 
		(char.keyCode >= 48 && char.which <= 57) || (char.keyCode == 8 || char.which == 8)) {
		return true;
	} else {
		char.preventDefault();
	}
}

function caracteresPermitidosEmail(char) {
	if ((char.keyCode >= 65 && char.which <= 90) || (char.keyCode >= 97 && char.which <= 122) || 
		(char.keyCode >= 48 && char.which <= 57) || (char.keyCode == 8 || char.which == 8) || 
		(char.keyCode == 45 || char.which == 45) || (char.keyCode == 46 || char.which == 46) || 
		(char.keyCode == 64 || char.which == 64) || (char.keyCode == 95 || char.which == 95)) {
		return true;
	} else {
		char.preventDefault();
	}
}

function removerErrores() {
	var usuario = "#usuario";
	var password = "#password";
	var email = "#email";
	var usuarioLogin = "#usuario-login";
	var passwordLogin = "#password-login";

	$(usuario).keypress(function(e) {
		caracteresPermitidos(e);

		if ($(usuario).val().length >= 2) {
			$("#error-usuario").hide();
			$(usuario).removeClass("input-error");
		}
	});

	$(password).keypress(function(e) {
		caracteresPermitidos(e);

		if ($(password).val().length >= 5) {
			$("#error-password").hide();
			$(password).removeClass("input-error");
		}
	});

	$(email).keypress(function(e) {
		caracteresPermitidosEmail(e);

		if ($(email).val().length >= 0) {
			$("#error-email").hide();
			$(email).removeClass("input-error");
		}
	});

	$(usuarioLogin).keypress(function(e) {
		caracteresPermitidosEmail(e);

		if ($(usuarioLogin).val().length >= 2) {
			$("#error-usuario-login").hide();
			$(usuarioLogin).removeClass("input-error");
		}
	});

	$(passwordLogin).keypress(function(e) {
		caracteresPermitidos(e);

		if ($(passwordLogin).val().length >= 5) {
			$("#error-password-login").hide();
			$(passwordLogin).removeClass("input-error");
		}
	});
}

function registrarUsuario() {
	var logueado = $("#logueado").val();
	var datosRegistrar = {
		usuario: $("#usuario").val(),
		password: $("#password").val(),
		email: $("#email").val()
	};
	var datosEnviar = {
		funcion: "registrarUsuario",
		datos: datosRegistrar
	};

	if (logueado == "true") {
		var url = "usuarios.php";
	} else {
		var url = "application/usuarios.php";
	}

	$.post(url, {data: datosEnviar}).done(function(data) {
		data = JSON.parse(data);

		if (data.estatus == 1) {
			$("#mensaje-registrar").contents().remove();
			$("#mensaje-registrar").append(data.mensaje);
			$("#mensaje-registrar").addClass("alert-success");
			$("#mensaje-registrar").show();

			if (logueado == "false") {
				var pagina = "index.php";
				$("#usuario").val("");
				$("#password").val("");
				$("#email").val("");

				setTimeout(function() {
					window.location.replace(pagina);
				}, 3000);
			} else {
				$("#mensaje-registrar").addClass("alert-logged-success");
				$("#usuario").val("");
				$("#password").val("");
				$("#email").val("");

				setTimeout(function() {
					$("#mensaje-registrar").hide();
					$("#mensaje-registrar").removeClass("alert-success alert-logged-success");
					$("#mensaje-registrar").contents().remove();
				}, 3000);
			}
		} else {
			$("#mensaje-registrar").contents().remove();
			$("#mensaje-registrar").append(data.mensaje);
			$("#mensaje-registrar").addClass("alert-danger");
			$("#mensaje-registrar").show();

			if (logueado == "true") {
				$("#mensaje-registrar").addClass("alert-logged");

				setTimeout(function() {
					$("#mensaje-registrar").hide();
					$("#mensaje-registrar").removeClass("alert-danger alert-logged");
					$("#mensaje-registrar").contents().remove();
				}, 3000);
			} else {
				setTimeout(function() {
					$("#mensaje-registrar").hide();
					$("#mensaje-registrar").removeClass("alert-danger");
					$("#mensaje-registrar").contents().remove();
				}, 3000);
			}
		}
	});
}

function login() {
	var url = "application/usuarios.php";
	var datosLogin = {
		usuario: $("#usuario-login").val(),
		password: $("#password-login").val()
	};
	var datosEnviar = {
		funcion: "login",
		datos: datosLogin
	};

	$.post(url, {data: datosEnviar}).done(function(data) {
		data = JSON.parse(data);

		if (data.estatus == 1) {
			var pagina = "application/" + data.mensaje;
			window.location.replace(pagina);
		} else {
			$("#mensaje-login").contents().remove();
			$("#mensaje-login").append(data.mensaje);
			$("#mensaje-login").addClass("alert-danger");
			$("#mensaje-login").show();

			setTimeout(function() {
				$("#mensaje-login").hide();
				$("#mensaje-login").contents().remove();
			}, 3000);
		}
	});
}

function modificarUsuario() {
	var url = "usuarios.php";
	var datosModificar = {
		idUsuario: $("#idUsuario").val(),
		usuario: $("#usuario").val(),
		password: $("#password").val(),
		email: $("#email").val()
	}
	var datosEnviar = {
		funcion: "modificarUsuario",
		datos: datosModificar		
	};

	$.post(url, {data: datosEnviar}).done(function(data) {
		data = JSON.parse(data);

		if (data.estatus == 1) {
			$("#mensaje-modificar").contents().remove();
			$("#mensaje-modificar").append(data.mensaje);
			$("#mensaje-modificar").addClass("alert-success");
			$("#mensaje-modificar").show();
			$("#mensaje-modificar").addClass("alert-logged-success");
			$("#password").val("");

			setTimeout(function() {
				$("#mensaje-modificar").hide();
				$("#mensaje-modificar").removeClass("alert-success alert-logged-success");
				$("#mensaje-modificar").contents().remove();
			}, 3000);
		} else {
			$("#mensaje-modificar").contents().remove();
			$("#mensaje-modificar").append(data.mensaje);
			$("#mensaje-modificar").addClass("alert-danger alert-logged");
			$("#mensaje-modificar").show();

			setTimeout(function() {
				$("#mensaje-modificar").hide();
				$("#mensaje-modificar").removeClass("alert-danger alert-logged");
				$("#mensaje-modificar").contents().remove();
			}, 3000);
		}
	});
}

function eliminarUsuario(datos) {
	$("#myModal").show();
	var idUsuario = datos.id;
	var usuario = datos.usuario;
	var mensaje = "¿Esta seguro que desea eliminar al usuario: " + usuario + "?";
	$(".mensaje").append(mensaje);

	$("#aceptar").on("click", function() {
		var url = "usuarios.php";
		var datosEnviar = {
			funcion: "eliminarUsuario",
			datos: {
				id: idUsuario
			}
		};

		$.post(url, {data: datosEnviar}).done(function(data) {
			data = JSON.parse(data);

			if (data.estatus == 1) {
				$("#mensaje-eliminar").contents().remove();
				$("#mensaje-eliminar").append(data.mensaje).addClass("alert-success");
				$("#mensaje-eliminar").show();
				setTimeout(function() {
					$("#mensaje-eliminar").hide();
					$("#mensaje-eliminar").contents().remove();
				}, 2000);
			} else {
				$("#mensaje-eliminar").contents().remove();
				$("#mensaje-eliminar").append(data.mensaje).addClass("alert-danger");
				$("#mensaje-eliminar").show();
				setTimeout(function() {
					$("#mensaje-eliminar").hide();
					$("#mensaje-eliminar").contents().remove();
				}, 2000);
			}
		});

		$("#" + idUsuario).remove();
		$("#myModal").hide();
		$(".mensaje").contents().remove();
	});
}