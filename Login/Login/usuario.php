<?php
session_start(); // Iniciar la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista de productos</title>
    <!-- Incluir jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .container-fluid{
            margin-bottom: 10px;
        }
        .encabezado{
            font-size: 40px;
            padding-top: 40px;
        }
        footer{
        color: black;
        padding: 10px;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
}
        /* Estilo para la tabla de productos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Estilo para los botones de comprar */
        .comprar-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }

        .comprar-btn:hover {
            background-color: #45a049;
        }

        /* Estilo para los botones de modo oscuro y claro */
        .modo-btn {
            background: none;
            border: none;
            margin-right: 10px;
        }

        .modo-btn img {
            width: 30px;
            height: 30px;
        }

        /* Modo oscuro */
        body.dark-mode {
            background-color: black;
            color: white;

        }
        

        

        .navbar.dark-mode {
            background-color: black !important;
            border-bottom: 1px solid #FFFFFF;
            color: white;
            
        }

        .navbar-brand.dark-mode {
            color: white !important;
        }
        
        footer.dark-mode {
            color: white;
        }
        .navbar-toggler-icon.dark-mode {
            background-color: #FFFFFF;
        }

        
        .navbar-nav .nav-link.dark-mode {
            color: #FFFFFF !important;
        }

        .container.dark-mode {
            background-color: #121212;
            color: black;
        }

        .table.dark-mode th {
            background-color: #363636;
            color: #FFFFFF;
        }

        .table.dark-mode tr {
            background-color: #1F1F1F;
            color: #FFFFFF;
        }
        .encabezado.dark-mode  {
            color: black;
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand">Vista de productos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <button id="miBoton2" class="modo-btn" style="display:none;"><img
                                src="https://cdn-icons-png.flaticon.com/512/2698/2698194.png" alt="Light Mode"></button>
                    </li>
                    <li class="nav-item">
                        <button id="miBoton" class="modo-btn"><img src="https://cdn-icons-png.flaticon.com/512/702/702471.png"
                                alt="Dark Mode"></button>
                    </li>
                </ul>
            </div>
            <div>
                <h5>
                    Usuario: 
                    <?php 
                    if (isset($_SESSION['usuario'])) {
                        echo htmlspecialchars($_SESSION['usuario']);
                    } else {
                        echo "Invitado";
                    }
                    ?>
                </h5>
            </div>
        </div>
    </nav>

    <h2>Lista de productos</h2>
    <div style="padding-top: 100px;" id="lista-productos"></div>

    <script>
        // Esperar a que el DOM esté listo
        $(document).ready(function() {
            // Función para cargar la lista de productos al cargar la página
            function cargarProductos() {
                $.ajax({
                    url: 'controllers/listar_productos_usuario.php', 
                    type: 'GET',
                    success: function(response) {
                        // Agregar la lista de productos al contenedor deseado en la página
                        $('#lista-productos').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Cargar los productos al cargar la página
            cargarProductos();

            // Manejar el evento de clic en el botón de comprar uno por uno
            $('#lista-productos').on('click', '.comprar-uno', function() {
                var productoDiv = $(this).closest('tr'); 
                var productoId = $(this).data('id');
                var cantidadCell = productoDiv.find('.cantidad'); 
                var cantidad = parseInt(cantidadCell.text());

                if (cantidad > 0) {
                    cantidad -= 1;
                    cantidadCell.text(cantidad);

                    // Solicitud AJAX para actualizar la cantidad en la base de datos
                    actualizarCantidad(productoId, cantidad);
                } else {
                    alert('No hay suficiente cantidad.');
                }
            });

            // Manejar el evento de clic en el botón de comprar en cantidad
            $('#lista-productos').on('click', '.comprar-masivo', function() {
                var productoDiv = $(this).closest('tr'); 
                var productoId = $(this).data('id');
                var cantidadInput = productoDiv.find('.cantidad-comprar-masivo'); 
                var cantidad = parseInt(cantidadInput.val());

                // Validar que la cantidad a comprar sea válida
                if (cantidad > 0) {
                    var stock = parseInt(productoDiv.find('.cantidad').text());

                    if (cantidad > stock) {
                        alert('No hay suficiente cantidad disponible.');
                    } else {
                        // Solicitud AJAX para actualizar la cantidad en la base de datos
                        actualizarCantidad(productoId, stock - cantidad); // Restar la cantidad a comprar del stock
                    }
                } else {
                    alert('Ingrese una cantidad válida.');
                }
            });

            // Función para actualizar la cantidad en la base de datos
            function actualizarCantidad(id, cantidad) {
                $.ajax({
                    url: 'controllers/comprar.php',
                    type: 'POST',
                    data: {
                        id: id,
                        cantidad: cantidad
                    },
                    success: function(response) {
                        alert('Compra realizada con éxito.');
                        // Recargar la lista de productos después de la compra
                        cargarProductos();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error al realizar la compra.');
                    }
                });
            }

            // Manejar el evento de clic en el botón de modo oscuro
            $('#miBoton').click(function() {
                $('body').addClass('dark-mode');
                $('footer').addClass('dark-mode');
                $('tr').addClass('dark-mode');
                $('nav').addClass('dark-mode');
                $('a').addClass('dark-mode');
                $('#miBoton').hide();
                $('#miBoton2').show();
            });

            // Manejar el evento de clic en el botón de modo claro
            $('#miBoton2').click(function() {
                $('body').removeClass('dark-mode');
                $('footer').removeClass('dark-mode');
                $('tr').removeClass('dark-mode');
                $('nav').removeClass('dark-mode');
                $('a').removeClass('dark-mode');
                $('#miBoton2').hide();
                $('#miBoton').show();
            });
        });
    </script>
    <footer >
     2024 Sistemas y Gestión de Datos - Todos los derechos reservados
</footer>

<section> 
        <div class="historial">
            <h1>Historial de compra de: <?php 
                    if (isset($_SESSION['usuario'])) {
                        echo htmlspecialchars($_SESSION['usuario']);
                    } else {
                        echo "Invitado";
                    }
                    ?> </h1>

            
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Producto : </h5>
                    <p class="card-text">Detalle</p>
                    <p class="card-text">Precio</p>
                    
                </div>
            </div>
        </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
