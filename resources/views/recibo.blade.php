<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .receipt {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #000;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header, .footer {
            text-align: center;
            font-size: 12px;
        }
        .details {
            margin-bottom: 10px;
            text-align: left;
            font-size: 12px;
            line-height: 1.5;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .items th, .items td {
            padding: 5px;
            font-size: 12px;
            text-align: left;
        }
        .totals {
            width: 100%;
            margin-top: 10px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
        .totals .total {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            padding: 5px 0;
        }
        .totals .total div:first-child {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div>{{ $fecha }}</div>
            <div>{{ $tienda }}</div>
            <div>{{ $razon_social }}</div>
            <div>{{ $nit }}</div>
            <div>{{ $sucursal }}</div>
            <div>{{ $direccion }}</div>
            <div>{{ $ciudad }}</div>
            <div>{{ $telefono }}</div>
        </div>
        <div class="details">
            <div><strong>Pedido de Venta:</strong> {{ $pedido }}</div>
            <div><strong>Fecha Venta:</strong> {{ $fecha_venta }}</div>
            <div><strong>Vendedor:</strong> {{ $vendedor }}</div>
            <div><strong>Cliente:</strong> {{ $cliente->name }}</div>
        </div>
        <table class="items">
            <thead>
                <tr>
                    <th>Ítem</th>
                    <th>Cant.</th>
                    <th>Pr. Un.</th>
                    <th>Vlr. Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="totals">
            <div class="total">
                <div>Total a Pagar</div>
                <div>{{ $total_pagar_con_impuesto }}</div>
            </div>
            <div class="total">
                <div>Total Descuentos</div>
                <div>{{ $total_descuentos }}</div>
            </div>
            <div class="total">
                <div>Impuesto al consumo</div>
                <div>{{ $impuesto_consumo }}</div>
            </div>
            <div class="total">
                <div>Total IVA</div>
                <div>{{ $total_iva }}</div>
            </div>
        </div>
        <div class="footer">
            <div>Observaciones:</div>
            <div>{{ $observaciones }}</div>
        </div>
    </div>
</body>
</html>
