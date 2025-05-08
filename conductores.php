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
            <div class="sidebar-brand-text mx-3">Conductores</div>
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
                <h1 class="mb-4">Conductor</h1>

                <?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Conductor eliminado!</strong> El Conductor se eliminó correctamente.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error']) && $_GET['error'] == 'viajes_asociados'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>¡Advertencia!</strong> El conductor no puede ser eliminado porque tiene viajes asociados.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>


                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalAgregarConductor">+ Agregar Conductor</button>

                <!-- Tabla de vehículos -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>TELEFONO</th>
                            <th>LICENCIA</th>
                            <th>OPERACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM conductores");
                        $resultado = mysqli_num_rows($sql);

                        if ($resultado > 0) {
                            while ($fila = mysqli_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td><?= $fila["id_conductor"]; ?></td>
                            <td><?= $fila['nombre']; ?></td>
                            <td><?= $fila['teléfono']; ?></td>
                            <td><?= $fila['licencia']; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" data-id="<?= $fila['id_conductor']; ?>" data-toggle="modal" data-target="#DeleteConductor">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='7'>No hay registros en la tabla</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Agregar Vehículo -->
            <div class="modal fade" id="modalAgregarConductor" tabindex="-1" role="dialog" aria-labelledby="modalConductorLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="guardarconductor.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalConductorLabel">Agregar Nuevo Conductor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input type="text" class="form-control" name="telefono" required>
                                </div>
                                <div class="form-group">
                                    <label for="licencia">Licencia</label>
                                    <input type="text" class="form-control" name="licencia" required>
                                </div>
                                
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Conductor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Confirmar Eliminación -->
            <div class="modal fade" id="DeleteConductor" tabindex="-1" role="dialog" aria-labelledby="DeleteConductorLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="DeleteConductorLabel">Confirmar Eliminación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de que deseas eliminar este Conductor?</p>
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

<!-- Scripts Bootstrap y dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script para el modal de eliminar -->
<script>
    $('#DeleteConductor').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id_conductor = button.data('id'); // Obtiene el ID
        var modal = $(this);
        modal.find('#confirmDeleteBtn').attr('href', 'eliminar_conductor.php?id=' + id_conductor);
    });
</script>

</body>
</html>
