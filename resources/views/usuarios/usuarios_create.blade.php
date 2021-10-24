@extends("maestra")
@section("titulo", "Agregar usuario")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Agregar usuario</h1>
            <form method="POST" action="{{route("usuarios.store")}}">
                @csrf
                <div class="form-group">
                    <label class="label">Nombre</label>
                    <input required autocomplete="off" name="name" class="form-control"
                           type="text" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label class="label">Correo electrónico</label>
                    <input required autocomplete="off" name="email" class="form-control"
                           type="email" placeholder="Correo electrónico">
                </div>
                <div class="form-group">
                    <label class="label">Contraseña</label>
                    <input required autocomplete="off" name="password" class="form-control"
                           type="password" placeholder="Contraseña">
                </div>

                @include("notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route("usuarios.index")}}">Volver al listado</a>
            </form>
        </div>
    </div>
@endsection
