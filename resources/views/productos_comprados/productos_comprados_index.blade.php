@extends("maestra")
@section("titulo", "Productos comprados")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Productos comprados <i class="fa fa-users"></i></h1>
            <a href="{{route("productos_comprados.create")}}" class="btn btn-success mb-2">Agregar</a>
            @include("notificacion")
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unidad</th>
                        <th>Fecha</th>

                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productos_comprados as $producto_comprado)
                        <tr>
                            <td>{{$producto_comprado->producto->descripcion}}</td>
                            <td>{{$producto_comprado->cantidad}}</td>
                            <td>{{$producto_comprado->precio_unidad}}</td>
                            <td>{{$producto_comprado->created_at}}</td>
                            <td>
                                <a class="btn btn-warning" href="{{route("productos_comprados.edit",[$producto_comprado])}}">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="{{route("productos_comprados.destroy", [$producto_comprado])}}" method="post">
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
