<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Producto;
use App\ProductoVendido;
use App\Venta;
use App\Configuracion;
use Illuminate\Http\Request;
use Auth;
class VenderController extends Controller
{

    public function terminarOCancelarVenta(Request $request)
    {
        if ($request->input("accion") == "terminar") {
            return $this->terminarVenta($request);
        } else {
            return $this->cancelarVenta();
        }
    }

    public function terminarVenta(Request $request)
    {
        // Crear una venta
        $venta = new Venta();

        //Validar que exista el registro que contenga este id
        $venta->id_cliente = $request->input("id_cliente");
        $venta->id_user = Auth::user()->id;
        
        $venta->saveOrFail();
        $idVenta = $venta->id;
        $productos = $this->obtenerProductos();

        $total = 0;
        // Recorrer carrito de compras
        foreach ($productos as $producto) {
            $total += $producto->cantidad * $producto->precio_venta;
            // El producto que se vende...
            $productoVendido = new ProductoVendido();
            $productoVendido->fill([
                "id_venta" => $idVenta,
                "descripcion" => $producto->descripcion,
                "codigo_barras" => $producto->codigo_barras,
                "precio" => $producto->precio_venta,
                "cantidad" => $producto->cantidad,
            ]);
            // Lo guardamos
            $productoVendido->saveOrFail();
            // Y restamos la existencia del original
           /*  $productoActualizado = Producto::find($producto->id);
            $productoActualizado->existencia -= $productoVendido->cantidad;
            $productoActualizado->saveOrFail(); */
        }
        $configuracion_iva = Configuracion::where("nombre", "=", "iva")->first();
              
        $iva = $total * $configuracion_iva->valor;

        $venta->precio_bruto = $total;
        $venta->iva = $iva;
        $venta->precio_neto = $iva + $total;

        $venta->saveOrFail();

        $this->vaciarProductos();
        return redirect()
            ->route("vender.index")
            ->with("mensaje", "Venta terminada");
    }

    private function obtenerProductos()
    {
        $productos = session("productos");
        if (!$productos) {
            $productos = [];
        }
        return $productos;
    }

    private function vaciarProductos()
    {
        $this->guardarProductos(null);
    }

    private function guardarProductos($productos)
    {
        session(["productos" => $productos,
        ]);
    }

    public function cancelarVenta()
    {
        $this->vaciarProductos();
        return redirect()
            ->route("vender.index")
            ->with("mensaje", "Venta cancelada");
    }

    public function quitarProductoDeVenta(Request $request)
    {
        $indice = $request->post("indice");
        $productos = $this->obtenerProductos();
        array_splice($productos, $indice, 1);
        $this->guardarProductos($productos);
        return redirect()
            ->route("vender.index");
    }

    public function agregarProductoVenta(Request $request)
    {
        $codigo = $request->post("codigo");
        $producto = Producto::where("codigo_barras", "=", $codigo)->first();
        if (!$producto) {
            return redirect()
                ->route("vender.index")
                ->with("mensaje", "Producto no encontrado");
        }
        $this->agregarProductoACarrito($producto);
        return redirect()
            ->route("vender.index");
    }

    private function agregarProductoACarrito($producto)
    {
        
        $productos = $this->obtenerProductos();
        $posibleIndice = $this->buscarIndiceDeProducto($producto->codigo_barras, $productos);
        // Es decir, producto no fue encontrado
        if ($posibleIndice === -1) {
            $producto->cantidad = 1;
            array_push($productos, $producto);
            
        } else {
            
            $productos[$posibleIndice]->cantidad++;
        }
        
        $this->guardarProductos($productos);
    }

    private function buscarIndiceDeProducto(string $codigo, array &$productos)
    {
        foreach ($productos as $indice => $producto) {
            if ($producto->codigo_barras === $codigo) {
                return $indice;
            }
        }
        return -1;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $total = 0;
        $iva = 0;
        
        foreach ($this->obtenerProductos() as $producto) {
            $total += $producto->cantidad * $producto->precio_venta;
            $configuracion_iva = Configuracion::where("nombre", "=", "iva")->first();
              
            $iva = $total * $configuracion_iva->valor;
        
        }

        return view("vender.vender",
            [
                "total"    => $total,
                "iva"      => $iva,
                "clientes" => Cliente::all(),
            ]
        );
    }
}
