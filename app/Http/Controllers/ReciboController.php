<?php
namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class ReciboController extends Controller
{
    public function imprimir($id_user, $id)
    {
        // Encuentra al usuario (cliente) por su ID
        $cliente = User::findOrFail($id_user);

        // Obtiene los detalles de la venta por el ID de la venta
        $detallesVenta = DetalleVenta::where('venta_id', $id)->with('producto')->get();
        
        // Definir las variables necesarias
        $fecha = now()->format('d-m-Y');
        $tienda = 'COMIDAS TIPICAS LECH';
        $razon_social = 'Razón Social';
        $nit = '1234567890';
        $sucursal = 'Sucursal Principal';
        $direccion = 'Av. Guabinal';
        $ciudad = 'Ibagué-Tolima';
        $telefono = '2666444';
        $pedido = '1';
        $fecha_venta = $cliente->created_at->format('d-m-Y');
        $vendedor = $cliente->name;
        $nombre_cliente = 'CC 222222222222 Consumid...';

        // Inicializa la variable items como un array vacío
        $items = [];

        // Inicializa la variable para el total a pagar
        $total_pagar = 0;
        $total_descuentos = 0; // Reemplaza con el cálculo correcto

        // Recorre los detalles de la venta para poblar los items y calcular el total a pagar
        foreach ($detallesVenta as $detalle) {
            $items[] = [
                
                'name' => $detalle->producto->nombre, // Obtener el nombre del producto desde la relación
                'quantity' => $detalle->cantidad,
                'price' => $detalle->precio_unitario,
                'total' => $detalle->subtotal,
            ];
            // Suma el subtotal de cada detalle al total a pagar
            $total_pagar += $detalle->subtotal;
        }

        // Calcula el impuesto al consumo (3%)
        $impuesto_consumo = $total_pagar * 0.03;

        // Suma el impuesto al consumo al total a pagar
        $total_pagar_con_impuesto = $total_pagar + $impuesto_consumo;

        // Estas variables no están definidas en tu código original,
        // asegúrate de definirlas o eliminarlas si no las necesitas
        $total_iva = 0; // Reemplaza con el cálculo correcto
        $observaciones = ''; // Reemplaza con las observaciones correctas si las hay

        // Crea el PDF utilizando la vista 'recibo' y las variables definidas
        $pdf = PDF::loadView('recibo', compact(
            'fecha', 'tienda', 'razon_social', 'nit', 'sucursal', 'direccion', 'ciudad', 
            'telefono', 'pedido', 'fecha_venta', 'vendedor', 'nombre_cliente', 'items', 'total_pagar', 
            'total_pagar_con_impuesto', 'total_descuentos', 'impuesto_consumo', 'total_iva', 'observaciones', 'cliente'
        ));

        // Devuelve el PDF descargable
        return $pdf->download('invoice.pdf');
    }
}
