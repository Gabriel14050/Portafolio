<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de administrador</title>
    <!-- Incluir jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Incluir el script para el CRUD -->
    <script src="js/admin_script.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        #miBoton, #miBoton2 {
            background: none;
            border: none;
            margin-right: 10px;
        }
        #miBoton img, #miBoton2 img, #carritoBoton img {
            width: 30px;
            height: 30px;
        }
        .table-container {
            margin-top: 20px;
        }
        .table th {
            background-color: #0dcaf0;
            color: white;
        }
        
        #modal-actualizar {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        .modal-close {
            float: right;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }
        
        body.modo-oscuro {
            background-color: black;
            color: #e0e0e0;
        }
        body.modo-oscuro .navbar-light {
            background-color: #1c1c1c;
        }
        body.modo-oscuro .table th {
            background-color: black;
            color: #e0e0e0;
        }
        body.modo-oscuro .table {
            background-color: black;
            color: #e0e0e0;
        }
        
        body.modo-oscuro .btn-primary {
            background-color: #4a90e2;
            border-color: #4a90e2;
        }
        body.modo-oscuro .btn-primary:hover {
            background-color: #357abd;
        }
        body.modo-oscuro #modal-actualizar {
            background-color: #2c2c2c;
            color: #e0e0e0;
        }
        body.modo-oscuro input, body.modo-oscuro textarea, body.modo-oscuro select {
            background-color: #3a3a3a;
            color: #e0e0e0;
            border: 1px solid #4a4a4a;
        }
        body.modo-oscuro .navbar-light {
    background-color: #1c1c1c; /* Cambiar color de fondo de la barra de navegación */
    color: #e0e0e0; /* Cambiar color del texto en la barra de navegación */
}
            
    </style>
</head>

<body>
<nav  class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand">Panel de administrador</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav"> <!-- Añadir la clase justify-content-end para alinear los elementos a la derecha -->

        <ul class="navbar-nav">
                <li class="nav-item">
                    <button id="miBoton2" class="btn btn-link p-0" style="display:none;"><img src="https://cdn-icons-png.flaticon.com/512/6661/6661565.png" alt="Light Mode"></button>
                </li>
                <li class="nav-item">
                    <button id="miBoton" class="btn btn-link p-0"><img src="https://cdn-icons-png.flaticon.com/512/702/702471.png" alt="Dark Mode"></button>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Ver Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="agrepro.php">Agregar Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Salir</a>
                </li>
           
        </div>
        
    </div>
    
</ul>
  </div>
</nav>


    
<!-- Contenedor para la lista de productos --> 
<div  id="lista-productos" class="mt-5"></div>
 <!-- Formulario de actualización en un modal -->
 <div  id="modal-actualizar" style="display:none;">
        <h2>Actualizar producto</h2>
        <form id="form-actualizar">
                <input type="hidden" id="id_prod_actualizar" name="id_prod">
                <div class="form-group">
                    <label for="nom_prod_actualizar">Nombre del producto:</label>
                    <input type="text" class="form-control" id="nom_prod_actualizar" name="nom_prod">
                </div>
                <div class="form-group">
                    <label for="pvp_prod_actualizar">Precio:</label>
                    <input type="number" class="form-control" id="pvp_prod_actualizar" name="pvp_prod" required min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="det_prod_actualizar">Detalles:</label>
                    <input type="text" class="form-control" id="det_prod_actualizar" name="det_prod">
                </div>
                <div class="form-group">
                    <label for="cantidad_prod_actualizar">Cantidad:</label>
                    <input type="number" class="form-control" id="cantidad_prod_actualizar" name="cantidad" required min="0" step="1"><br>
                </div>
                <div class="form-group">
                <label for="imagen_actualizar">Imagen:</label>
                <input type="file" id="imagen_actualizar" name="imagen"><br><br>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar producto</button>
                <button type="button" class="btn btn-danger" id="cancelar-actualizacion">Cancelar</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonModoOscuro = document.getElementById('miBoton');
            const botonModoClaro = document.getElementById('miBoton2');

            botonModoOscuro.addEventListener('click', function() {
                document.body.classList.add('modo-oscuro');
                botonModoOscuro.style.display = 'none';
                botonModoClaro.style.display = 'block';
            });

            botonModoClaro.addEventListener('click', function() {
                document.body.classList.remove('modo-oscuro');
                botonModoOscuro.style.display = 'block';
                botonModoClaro.style.display = 'none';
            });
        });

    
    

        // Función para editar un producto
        $('#form-actualizar').submit(function(event) {
            event.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: 'controllers/actualizar_producto.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#modal-actualizar').hide(); // Ocultar el modal después de editar
                    alert('Producto actualizado exitosamente');
                    cargarProductos(); // Recargar la lista de productos
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al actualizar el producto.');
                }
            });
        });
        $(document).ready(function() {
        // Cerrar el modal de actualización al hacer clic en el botón de cancelar
        $('#cancelar-actualizacion').click(function() {
            $('#modal-actualizar').hide(); // Ocultar el modal de actualización
        });
    });

        // Abrir el modal de actualización al hacer clic en el botón de editar
        $('#lista-productos').on('click', '.actualizar-producto', function() {
            var id = $(this).data('id');

            // Obtener los detalles del producto y mostrarlos en el formulario de actualización
            $.ajax({
                url: 'controllers/obtener_producto.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    var producto = JSON.parse(response);
                    $('#id_prod_actualizar').val(producto.id_prod);
                    $('#nom_prod_actualizar').val(producto.nom_prod);
                    $('#pvp_prod_actualizar').val(producto.pvp_prod);
                    $('#det_prod_actualizar').val(producto.det_prod);
                    $('#cantidad_prod_actualizar').val(producto.cantidad);
                    $('#modal-actualizar').show(); // Mostrar el modal de actualización
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al obtener los detalles del producto.');
                }
            });
        });

        // Cerrar el modal de actualización al hacer clic en el botón de cancelar
        $('#modal-actualizar').on('click', '.modal-close', function() {
            $('#modal-actualizar').hide(); // Ocultar el modal de actualización
        });

        // Función para cargar los productos al cargar la página
        $(document).ready(function() {
            cargarProductos();
        });

        // Función para cargar los productos
        function cargarProductos() {
            $.ajax({
                url: 'controllers/listar_productos.php',
                type: 'GET',
                success: function(response) {
                    $('#lista-productos').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error al cargar los productos.');
                }
            });
        }


    </script>
</body>

</html>
