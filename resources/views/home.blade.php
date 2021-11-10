@extends('maestra')
@section("titulo", "Inicio")
@section('contenido')
    <div class="col-12 text-center">
        <h1>Bienvenido, {{Auth::user()->name}}</h1>
    </div>
    @foreach([
    ["productos", "ventas", "vender", "clientes"],
    ["usuarios","proveedores","configuraciones"]
    ] as $modulos)
        <div class="col-12 pb-2">
            <div class="row">
                @foreach($modulos as $modulo)
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="{{url("/img/$modulo.png")}}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{$modulo === "acerca_de" ? "Acerca de" : ucwords($modulo)}}
                                </h5>
                                <a href="{{route("$modulo.index")}}" class="btn btn-success">
                                    Ir a&nbsp;{{$modulo === "acerca_de" ? "Acerca de" : ucwords($modulo)}}
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
