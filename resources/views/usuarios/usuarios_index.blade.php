@extends("maestra")
@section("titulo", "Usuarios")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Usuarios <i class="fa fa-users"></i></h1>
            <a href="{{route("usuarios.create")}}" class="btn btn-success mb-2">Agregar</a>
            @include("notificacion")
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Correo electrónico</th>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->email}}</td>
                            <td>{{$usuario->name}}</td>
                            <td>
                                <a class="btn btn-warning" href="{{route("usuarios.edit",[$usuario])}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{route("usuarios.destroy", [$usuario])}}" method="post">
                                    @method("delete")
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
