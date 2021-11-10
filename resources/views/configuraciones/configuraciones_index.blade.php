@extends("maestra")
@section("titulo", "Configuraciones")
@section("contenido")
    <div class="row">
        <div class="col-6">
            <h1>Configuraciones</h1>
            <form method="POST" action="{{route("configuraciones.update")}}">
                @method("PUT")
                @csrf
                <div class="form-group">
                    @error("iva")
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                    <label class="label">Porcentaje IVA</label>
                    <input required value="{{$configuracion_iva->valor * 100}}" autocomplete="off" name="iva"
                           class="form-control"
                           type="text" placeholder="Porcentaje IVA">
                </div>
                

                @include("notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route("home")}}">Volver</a>
            </form>
        </div>
    </div>
@endsection
