@extends('adminlte::page')

@section('title', 'Lotes')

@section('content_header')
    <nav aria-label="breadcrumb" style="font-size: 18pt;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/lotes') }}">Lotes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Listado de lotes</li>
        </ol>
    </nav>
    <hr>
@stop

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Filtrado de datos</b></h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive" style="display: block;">
                    <form action="{{ url('/admin/lotes') }}" method="GET">

                        <div class="row">


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Desde: </label>
                                    <input type="date" class="form-control" name="fecha_desde">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Hasta: </label>
                                    <input type="date" class="form-control" name="fecha_hasta">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 32px;">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Lotes registrados</b></h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive" style="display: block;">
                    <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Código Lote</th>
                                <th>Producto</th>
                                <th>Proveedor</th>
                                <th>Fecha de entrada</th>
                                <th>Fecha de vencimiento</th>
                                <th>Días restantes</th>
                                <th>Cantidad actual</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotes as $lote)
                                <!-- Esta variable viene del controller -->
                                <tr class="{{ $lote->is_expired ? 'table-danger' : '' }}">
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <!-- Muestra un contador en lugar del ID real -->
                                    <td>{{ $lote->codigo_lote }}</td>
                                    <td>{{ $lote->producto->nombre }}</td>
                                    <td>{{ $lote->proveedor->nombre }}</td>
                                    <td>{{ $lote->fecha_entrada }}</td>
                                    <td>{{ $lote->fecha_vencimiento }}</td>
                                    <td>{{ $lote->days_to_expire }} días</td>
                                    <td>{{ $lote->cantidad_actual }}</td>
                                    <td>
                                        @if ($lote->is_expired)
                                            <span class="badge badge-danger">Vencido</span>
                                        @elseif ($lote->days_to_expire <= 10)
                                            <span class="badge badge-warning">Por caducar</span>
                                        @else
                                            <span class="badge badge-success">Vigente</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Fondo transparente y sin borde en el contenedor */
        #example1_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            /* Centrar los botones */
            gap: 10px;
            /* Espaciado entre botones */
            margin-bottom: 15px;
            /* Separar botones de la tabla */
        }

        /* Estilo personalizado para los botones */
        #example1_wrapper .btn {
            color: #fff;
            /* Color del texto en blanco */
            border-radius: 4px;
            /* Bordes redondeados */
            padding: 5px 15px;
            /* Espaciado interno */
            font-size: 14px;
            /* TamaÃ±o de fuente */
        }

        /* Colores por tipo de botÃ³n */
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            border: none;
        }

        .btn-default {
            background-color: #6e7176;
            color: #212529;
            border: none;
        }
    </style>
@stop

@section('js')
    <script>
        $(function() {
            $("#example1").DataTable({
                "pageLength": 10,
                "language": {
                    "emptyTable": "No hay informaciÃ³n",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Lotes",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Lotes",
                    "infoFiltered": "(Filtrado de _MAX_ total Lotes)",
                    "lengthMenu": "Mostrar _MENU_ Lotes",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ãšltimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                buttons: [{
                        text: '<i class="fas fa-copy"></i> COPIAR',
                        extend: 'copy',
                        className: 'btn btn-default'
                    },
                    {
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        extend: 'pdf',
                        className: 'btn btn-danger'
                    },
                    {
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        extend: 'csv',
                        className: 'btn btn-info'
                    },
                    {
                        text: '<i class="fas fa-file-excel"></i> EXCEL',
                        extend: 'excel',
                        className: 'btn btn-success'
                    },
                    {
                        text: '<i class="fas fa-print"></i> IMPRIMIR',
                        extend: 'print',
                        className: 'btn btn-warning'
                    }
                ]
            }).buttons().container().appendTo('#example1_wrapper .row:eq(0)');
        });
    </script>
@stop
