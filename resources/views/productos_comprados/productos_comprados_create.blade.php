@extends("maestra")
@section("titulo", "Agregar producto comprado")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Agregar producto comprado</h1>
            <form method="POST" action="{{route("productos_comprados.store")}}">
                @csrf
                <div class="form-group">
                    @error("id_producto")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Producto</label>
                    <select name="id_producto" class="form-control">
                        @foreach($productos as $producto)
                            <option value="{{$producto->id}}">{{$producto->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    @error("id_proveedor")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Proveedor</label>
                    <select name="id_proveedor" class="form-control">
                        @foreach($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    @error("cantidad")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Cantidad</label>
                    <input required autocomplete="off" name="cantidad" class="form-control"
                           type="text" placeholder="Cantidad">
                </div>
                <div class="form-group">
                    @error("precio_unidad")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Precio unidad</label>
                    <input required  autocomplete="off" name="precio_unidad"
                           class="form-control"
                           type="text" placeholder="Precio unidad">
                </div>

                @include("notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route("productos_comprados.index")}}">Volver al listado</a>
            </form>
        </div>
    </div>
@endsection
