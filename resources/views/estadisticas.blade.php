@extends("maestra")
@section("titulo", "Estadisticas")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Productos vendidos por cliente</h1>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Codigo de barras</th>
                        <th>Descripcion</th>
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productos_vendidos as $producto_vendido)
                        <tr>
                            <td>{{$producto_vendido->codigo_barras}}</td>
                            <td>{{$producto_vendido->descripcion}}</td>
                            <td>{{$producto_vendido->venta->cliente->nombre}}</td>
                            <td>{{$producto_vendido->venta->user->name}}</td>
                            <td>{{$producto_vendido->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-12">
                <h1>Productos vendidos semanales : {{count($productos_vendidos_semanales)}}</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Codigo de barras</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productos_vendidos_semanales as $producto_vendido)
                            <tr>
                                <td>{{$producto_vendido->codigo_barras}}</td>
                                <td>{{$producto_vendido->descripcion}}</td>
                                <td>{{$producto_vendido->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1>Productos vendidos mensuales : {{count($productos_vendidos_mensuales)}}</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Codigo de barras</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productos_vendidos_mensuales as $producto_vendido)
                            <tr>
                                <td>{{$producto_vendido->codigo_barras}}</td>
                                <td>{{$producto_vendido->descripcion}}</td>
                                <td>{{$producto_vendido->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1>Productos vendidos anuales : {{count($productos_vendidos_anuales)}}</h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Codigo de barras</th>
                            <th>Descripcion</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productos_vendidos_anuales as $producto_vendido)
                            <tr>
                                <td>{{$producto_vendido->codigo_barras}}</td>
                                <td>{{$producto_vendido->descripcion}}</td>
                                <td>{{$producto_vendido->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection
