<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de compra #{{ $compra->id }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .order-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .order-header {
            border-bottom: 3px solid #0d6efd;
            margin-bottom: 25px;
            padding-bottom: 10px;
        }

        .order-header h1 {
            font-size: 1.8rem;
            color: #0d6efd;
        }

        .table th {
            background-color: #0d6efd;
            color: #fff;
        }

        .footer-text {
            margin-top: 30px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="order-container">
        <div class="order-header text-center">
            <h1>Orden de Compra #{{ $compra->id }}</h1>
            <p class="text-muted mb-0">Fecha: {{ $compra->fecha }}</p>
        </div>

        <div class="mb-4">
            <p><strong>Proveedor:</strong> {{ $proveedor->nombre }}</p>
            <p>Estimado/a {{ $proveedor->nombre }}, adjuntamos los detalles de la orden de compra realizada en la fecha
                indicada.</p>
        </div>

        <div class="card-body table-responsive" style="display: block;">
            <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="footer-text">Saludos cordiales,<br>Esperando su pronta respuesta.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
