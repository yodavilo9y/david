<?php 
include 'conexion.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Boletos</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Rutas</div>
        </a>
        <hr class="sidebar-divider my-0">
        <!-- Nav Items -->
        <li class="nav-item">
            <a class="nav-link btn btn-outline-light text-left text-white w-100 my-1" href="index.php">
                <i class="fas fa-route"></i>
                <span class="ml-2">Panel</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-light text-left text-white w-100 my-1" href="rutas.php">
                <i class="fas fa-route"></i>
                <span class="ml-2">Rutas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-light text-left text-white w-100 my-1" href="vehiculos.php">
                <i class="fas fa-bus"></i>
                <span class="ml-2">Vehículos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-light text-left text-white w-100 my-1" href="conductores.php">
                <i class="fas fa-user-tie"></i>
                <span class="ml-2">Conductores</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-light text-left text-white w-100 my-1" href="viajes.php">
                <i class="fas fa-calendar-alt"></i>
                <span class="ml-2">Viajes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-light text-left text-white w-100 my-1" href="boletos.php">
                <i class="fas fa-ticket-alt"></i>
                <span class="ml-2">Boletos</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link btn btn-danger text-left text-white w-100 my-1" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i>
                <span class="ml-2">Cerrar Sesión</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <div class="container-fluid">

            <div class="container mt-5">
                <h1 class="mb-4">Ruta</h1>

                <?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>¡Ruta eliminada!</strong> La ruta se eliminó correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                    <!-- boton de agregar-->
                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalAgregarRuta">
            <i class="fa fa-plus"></i> Agregar Ruta
        </button>
                <!-- Tabla de rutas -->
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>ORIGEN</th>
                            <th>DESTINO</th>
                            <th>DISTANCIA</th>
                            <th>OPERACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM rutas";
                        $resultado = mysqli_query($conn, $query);
						while ($row = mysqli_fetch_assoc($resultado)) {
							echo "<tr>
									<td>{$row['id_ruta']}</td>
									<td>{$row['origen']}</td>
									<td>{$row['destino']}</td>
									<td>{$row['distancia']}</td>
									<td>
										<a href='#' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#confirmDeleteModal' data-id='{$row['id_ruta']}'>
                                            <i class='fas fa-trash-alt'></i>
                                        </a>
									</td>
								</tr>";
						}
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal para agregar ruta -->
            <div class="modal fade" id="modalAgregarRuta" tabindex="-1" role="dialog" aria-labelledby="modalRutaLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="guardarRuta.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalRutaLabel">Agregar Nueva Ruta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="origen">Origen</label>
                                    <input type="text" class="form-control" name="origen" required>
                                </div>
                                <div class="form-group">
                                    <label for="destino">Destino</label>
                                    <textarea class="form-control" name="destino" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="distancia">Distancia (km)</label>
                                    <input type="number" class="form-control" name="distancia" min="0" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Ruta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de confirmación para eliminar -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar esta ruta?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal de Cerrar Sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Selecciona "Cerrar sesión" si estás listo para finalizar tu sesión actual.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="login.php">Cerrar sesión</a>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que abrió el modal
        var id_ruta = button.data('id'); // Extrae el ID de la ruta del atributo `data-id`
        var modal = $(this);
        
        // Establecer la URL de eliminación en el botón de confirmación
        modal.find('#confirmDeleteBtn').attr('href', 'eliminar_ruta.php?id=' + id_ruta);
    });
</script>

</body>
</html>
