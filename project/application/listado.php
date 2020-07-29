<?php
require_once("usuarios.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

$optPaginado = paginado();
$totalPages = $optPaginado['total_pages'];
$numResultsPages = $optPaginado['num_results_on_page'];
$page = $optPaginado['page'];
$result = $optPaginado['result'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Listado</title>
		<link href="../public/css/styles.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://kit.fontawesome.com/83a0b726f7.js" crossorigin="anonymous"></script>
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<a href="inicio.php"><i class="fas fa-house-user"></i> Inicio </a>
				<a href="crearUsuario.php"><i class="fas fa-user"></i> Crear Usuario</a>
				<a href="perfil.php"><i class="fas fa-user-circle"></i> Perfil </a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión </a>
			</div>
		</nav>
		<div class="content content-listado ">
			<h2>Listado de usuarios</h2>
			<div id="mensaje-eliminar" class="alert mensaje-eliminar" hidden="hidden"></div>
			<?php while ($row = $result->fetch_assoc()) { ?>
				<div class="listado" id="<?php echo $row['id'];?>">
	    			<p> 
	    				<?=$row['usuario'];?> 
	    			</p>
	    			<a class="parent-btn" href="modificarUsuario.php?id=<?php echo $row['id'];?>"> 
	    				<input id="modificar" class="btn btn-dark btn-listado" type="button" value="Modificar" /> 
	    			</a>
	    			<input id="eliminar" class="eliminar btn btn-danger btn-listado" type="button" value="Eliminar" />
    			</div>
			<?php } ?> 
		</div>
		<div class="paginado text-center">
			<input type="hidden" id="totalPages" name="" value="<?=ceil($totalPages / $numResultsPages);?>">
			<?php if (ceil($totalPages / $numResultsPages) > 0) { ?>
		  		<ul class="pagination">
					<?php if ($page > 1) { ?>
					<li class="prev">
						<a href="listado.php?page=<?php echo $page-1; ?>">
							Prev
						</a>
					</li>

					<?php } ?>

					<?php if ($page > 3) { ?>
						<li class="start"><a href="listado.php?page=1">1</a></li>
						<li class="dots">...</li>
					<?php } ?>

					<?php if ($page-2 > 0) { ?>
						<li class="page">
							<a href="listado.php?page=<?php echo $page-2; ?>">
								<?php echo $page-2; ?>
							</a>
						</li>
					<?php } ?>
					<?php if ($page-1 > 0) { ?>
						<li class="page">
							<a href="listado.php?page=<?php echo $page-1; ?>">
								<?php echo $page-1; ?>
							</a>
						</li>
					<?php } ?>

					<li class="currentpage">
						<a href="listado.php?page=<?php echo $page; ?>">
							<?php echo $page; ?>
						</a>
					</li>

					<?php if ($page+1 < ceil($totalPages / $numResultsPages)+1) { ?>
						<li class="page">
							<a href="listado.php?page=<?php echo $page+1; ?>">
								<?php echo $page+1; ?>
							</a>
						</li>
					<?php } ?>
					<?php if ($page+2 < ceil($totalPages / $numResultsPages)+1) { ?>
						<li class="page">
							<a href="listado.php?page=<?php echo $page+2; ?>">
								<?php echo $page+2; ?>
							</a>
						</li>
					<?php } ?>

					<?php if ($page < ceil($totalPages / $numResultsPages)-2) { ?>
						<li class="dots">...</li>
						<li class="end">
							<a href="listado.php?page=<?php echo ceil($totalPages / $numResultsPages) ?>">
								<?php echo ceil($totalPages / $numResultsPages); ?>
							</a>
						</li>
					<?php } ?>

					<?php if ($page < ceil($totalPages / $numResultsPages)) { ?>
						<li class="next">
							<a href="listado.php?page=<?php echo $page+1; ?>">
								Next
							</a>
						</li>
					<?php } ?>
				</ul>
		  	<?php } ?>
		</div>
		<div id="myModal" class="modal">
		  	<div class="modal-content">
		  		<div class="modal-header">
		    		<span class="close">&times;</span>
		  		</div>
		  		<div class="modal-body">
		    		<p class="mensaje"></p>
		    	</div>
		    	<div class="modal-footer">
		    		<button id="cancelar" class="btn btn-light" type="button"> No </button>
		    		<button id="aceptar" class="btn btn-success" type="button"> Sí </button>
		    	</div>
		  	</div>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="../public/js/main.js"></script>
	</body>
</html>