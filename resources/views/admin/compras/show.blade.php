@extends('adminlte::page')

@section('content_header')
    <nav aria-label="breadcrumb" style="font-size: 18pt;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/compras') }}">Compras</a></li>
            <li class="breadcrumb-item active" aria-current="page">Datos de la Compra # {{ $compra->id }}</li>

        </ol>
    </nav>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"> <b>Detalle de la compra</b> </h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="proveedor_id">Proveedores</label>
                                <p>{{ $compra->proveedor->nombre }}</p>
                            </div>

                            @error('proveedor_id')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha">Fecha de la compra </label>
                                <p>{{ $compra->fecha }}</p>

                                @error('fecha')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <p>{{ $compra->observaciones }}</p>

                                @error('observaciones')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estado">Estado de la compra </label>
                                <p>{{ $compra->estado }}</p>

                                @error('estado')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="total">Total de la compra </label>
                                <p>{{ $compra->total }}</p>

                                @error('total')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Sucursal de destino </label>
                                <p>{{ $sucursal_destino->nombre }}</p>
                            </div>
                        </div>





                        <div class="col-md-2">

                        </div>


                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Detalle de productos de la compra </b></h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">

                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producto</th>
                                <th>Lote</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>SubTotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($compra->detalles as $detalle)
                                <tr>
                                    <td style="text-align: center ">{{ $loop->iteration }}</td>
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>{{ $detalle->lote->codigo_lote }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ $detalle->precio_unitario }}</td>
                                    <td>{{ $detalle->subtotal }}</td>
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


@stop


@section('js')

@stop
