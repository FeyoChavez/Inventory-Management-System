@extends('adminlte::page')

@section('content_header')
    <nav aria-label="breadcrumb" style="font-size: 18pt;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/sucursales') }}">Sucursales</a></li>
            <li class="breadcrumb-item active" aria-current="page">Creación de sucursales</li>

        </ol>
    </nav>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los datos del formulario</h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body" style="display: block;">
                    <form action="{{ url('/admin/sucursales/create') }}" method="POST">
                        @csrf <!-- TOKEN DE SEGURIDAD OBLIGATORIO EN LARAVEL -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la sucursal <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        </div>
                                        <input type="text" value="{{ old('nombre') }}" class="form-control" id="nombre" name="nombre"
                                        placeholder="Ingrese el nombre de la sucursal" required>
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
                                        <input type="text" value="{{ old('direccion') }}" class="form-control" id="direccion" name="direccion"
                                        placeholder="Ingrese la dirección de la sucursal" required>
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
                                        <input type="text" value="{{ old('telefono') }}" class="form-control" id="telefono" name="telefono"
                                        placeholder="Ingrese el número de teléfono" required>
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
                                        <select name="activa" class="form-control" id="activa" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="1" {{ old('activa') == '1' ? 'selected' : '' }}>Activo</option>
                                            <option value="0" {{ old('activa') == '0' ? 'selected' : '' }}>Inactivo</option>
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
                                    <a href="{{ url('/admin/sucursales') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
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
@stop

@section('css')

@stop

@section('js')

@stop
