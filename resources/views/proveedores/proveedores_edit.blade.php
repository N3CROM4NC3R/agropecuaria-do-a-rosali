@extends("maestra")
@section("titulo", "Editar proveedor")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Editar proveedor</h1>
            <form method="POST" action="{{route("proveedores.update", [$proveedor])}}">
                @method("PUT")
                @csrf
                <div class="form-group">
                    @error("cedula")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Cedula</label>
                    <input required value="{{$proveedor->cedula}}" autocomplete="off" name="cedula"
                           class="form-control"
                           type="text" placeholder="Cedula">
                </div>
                <div class="form-group">
                    @error("nombre")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Nombre</label>
                    <input required value="{{$proveedor->nombre}}" autocomplete="off" name="nombre" class="form-control"
                           type="text" placeholder="Nombre">
                </div>
                <div class="form-group">
                    @error("apellido")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Apellido</label>
                    <input required value="{{$proveedor->apellido}}" autocomplete="off" name="apellido"
                           class="form-control"
                           type="text" placeholder="Apellido">
                </div>
                <div class="form-group">
                    @error("email")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Email</label>
                    <input value="{{$proveedor->email}}" autocomplete="off" name="cedula"
                           class="form-control"
                           type="email" placeholder="Email">
                </div>
                <div class="form-group">
                    @error("direccion")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Direccion</label>
                    <input value="{{$proveedor->direccion}}" autocomplete="off" name="direccion"
                           class="form-control"
                           type="text" placeholder="Direccion">
                </div>
                <div class="form-group">
                    @error("telefono")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Teléfono</label>
                    <input value="{{$proveedor->telefono}}" autocomplete="off" name="telefono"
                           class="form-control"
                           type="text" placeholder="Teléfono">
                </div>

                @include("notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route("proveedores.index")}}">Volver</a>
            </form>
        </div>
    </div>
@endsection
