<?php
function calcularTotalProducto($precio, $cantidad, $aplicaIVA) {
    $subtotal = $precio * $cantidad;
    $iva = $aplicaIVA ? $subtotal * 0.15 : 0;
    $total = $subtotal + $iva;
    return [$subtotal, $iva, $total];
}

$nombre_cliente = $_POST["nombre_cliente"];
$correo = $_POST["correo"];
$fecha = $_POST["fecha"];
$comentarios = $_POST["comentarios"];

$productos = $_POST["producto"];
$precios = $_POST["precio"];
$cantidades = $_POST["cantidad"];
$categorias = $_POST["categoria"];
$ivaSeleccionados = isset($_POST["iva"]) ? $_POST["iva"] : [];

$subtotal_general = 0;
$iva_total = 0;
$total_general = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura Generada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <div class="container mt-5 p-4 bg-white rounded shadow">
    <h3 class="text-center mb-4">Factura</h3>
    <div class="mb-4">
      <strong>Cliente:</strong> <?= htmlspecialchars($nombre_cliente) ?><br>
      <strong>Correo:</strong> <?= htmlspecialchars($correo) ?><br>
      <strong>Fecha:</strong> <?= htmlspecialchars($fecha) ?><br>
      <strong>Comentarios:</strong> <?= nl2br(htmlspecialchars($comentarios)) ?>
    </div>

    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
          <th>IVA</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        for ($i = 0; $i < count($productos); $i++) {
            $nombre = $productos[$i];
            $precio = floatval($precios[$i]);
            $cantidad = intval($cantidades[$i]);
            $categoria = $categorias[$i];
            $aplicaIVA = in_array((string)$i, $ivaSeleccionados);

            list($subtotal, $iva, $total) = calcularTotalProducto($precio, $cantidad, $aplicaIVA);

            $subtotal_general += $subtotal;
            $iva_total += $iva;
            $total_general += $total;

            echo "<tr>
                    <td>$nombre</td>
                    <td>$categoria</td>
                    <td>$$precio</td>
                    <td>$cantidad</td>
                    <td>$" . number_format($subtotal, 2) . "</td>
                    <td>$" . number_format($iva, 2) . "</td>
                    <td>$" . number_format($total, 2) . "</td>
                  </tr>";
        }
        ?>
      </tbody>
    </table>

    <div class="text-end">
      <p><strong>Subtotal general:</strong> $<?= number_format($subtotal_general, 2) ?></p>
      <p><strong>Total IVA:</strong> $<?= number_format($iva_total, 2) ?></p>
      <p class="fs-5"><strong>Total a pagar:</strong> $<?= number_format($total_general, 2) ?></p>
    </div>
  </div>
</body>
</html>
