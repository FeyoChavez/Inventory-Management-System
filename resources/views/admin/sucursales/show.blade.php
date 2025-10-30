@extends('adminlte::page')

@section('content_header')
    <nav aria-label="breadcrumb" style="font-size: 18pt;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/sucursales') }}">Sucursales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Datos de la sucursal</li>

        </ol>
    </nav>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Datos registrados</h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                     
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la sucursal</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <input type="text" value="{{ $sucursal->nombre }}" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ingrese el nombre de la sucursal" readonly>
                                    </div>
                                    @error('nombre')
                                        <small style="color: red">{{ $message }}</small>   
                                    @enderror
                                </div>
                            </div>

                             <div class="col-md-12">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map"></i></span>
                                        </div>
                                        <input type="text" value="{{ $sucursal->direccion }}" class="form-control" id="direccion" name="direccion"
                                        placeholder="Ingrese la dirección de la sucursal" readonly>
                                    </div>
                                    @error('direccion')
                                        <small style="color: red">{{ $message }}</small>   
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <input type="text" value="{{ $sucursal->telefono }}" class="form-control" id="telefono" name="telefono"
                                        placeholder="Ingrese el número de teléfono" readonly>
                                    </div>
                                    @error('telefono')
                                        <small style="color: red">{{ $message }}</small>   
                                    @enderror
                                </div>
                                </div>

                                <div class="col-md-12">
                                <div class="form-group">
                                    <label for="activa">Estado</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                        </div>
                                        <select name="activa" class="form-control" id="activa" disabled>
                                            <option value="">Seleccione una opción</option>
                                            <option value="1" {{ $sucursal->activa == '1' ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ $sucursal->activa == '0' ? 'selected' : '' }}>Inactivo</option>
                                     </select>
                                    </div>
                                    @error('telefono')
                                        <small style="color: red">{{ $message }}</small>   
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{ url('/admin/sucursales') }}" class="btn btn-secondary">Volver</a>
                                    
                                </div>
                            </div>
                        </div>
                    
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
