<div>

    <div class="row">


        <div class="col-md-4">
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nombre">Producto</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>

                            <select name="" id="" wire:model.live='productoId' class="form-control ">
                                <!-- productoId traido desde el controlador -->
                                <option value="">Seleccione un producto...</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">
                                        {{ $producto->codigo . ' - ' . $producto->nombre }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        @error('productoId')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lote">Lote</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>

                            <input type="text" wire:model='codigoLote' class="form-control"
                                style="text-align: center">

                        </div>
                        @error('codigoLote')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>

                            <input type="number" wire:model='cantidad' class="form-control" style="text-align: center">

                        </div>
                        @error('cantidad')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precio_compra">Precio Compra (unitario)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>

                            <input type="number" wire:model='precioCompra' class="form-control"
                                style="text-align: center">
                            <!-- precioCompra traido desde el controlador -->

                        </div>
                        @error('precioCompra')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precio_venta">Precio Venta</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>

                            <input type="number" wire:model='precioVenta' class="form-control"
                                style="text-align: center">
                            <!-- precioVenta traido desde el controlador -->

                        </div>
                        @error('precioVenta')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_vencimiento">Fecha de vencimiento</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>

                            <input type="date" wire:model='fechaVencimiento' class="form-control">

                        </div>
                        @error('fechaVencimiento')
                            <small style="color: red">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div style="height:33px"></div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" wire:click="agregarItems">Agregar</button>
                    </div>
                </div>

                </div>
            </div>



            <div class="col-md-8">

                <div class="row">
                    <div class="col-md-12">

                        @if ($compra->detalles->count() > 0)


                            <h3>Productos de la compra</h3>
                            <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombre</th>
                                        <th>Lote</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($compra->detalles as $detalle)
                                        <tr>
                                            <td style="text-align: center">{{ $loop->iteration }}</td>
                                            <td>{{ $detalle->producto->nombre }}</td>
                                            <td>{{ $detalle->lote->codigo_lote }}</td>
                                            <td>{{ $detalle->cantidad }}</td>
                                            <td>{{ $detalle->precio_unitario }}</td>
                                            <td>{{ $detalle->subtotal }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm"
                                                    wire:click="borrarItem({{ $detalle->id }})"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No hay productos en esta compra.</p>
                        @endif

                        <hr>

                        <h4><b>Total de la compra: </b> {{ $totalCompra }}</h4>
                    </div>
                </div>

            </div>


        </div>



        <div x-data
            x-on:mostrar-alerta.window = 
            "Swal.fire({
                    icon: $event.detail.icono,
                    title: $event.detail.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                    })">
        </div>

    </div>

