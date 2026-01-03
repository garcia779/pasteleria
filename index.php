<?php
// CONEXIÓN
$conexion = new mysqli("sql202.infinityfree.com", "if0_40818078", "destructor0222", "if0_40818078_pasteleria");
if ($conexion->connect_error) {
    die("Error de conexión");
}

// INSERTAR PEDIDO
if (isset($_POST['guardar'])) {
    $cliente = $_POST['cliente'];
    $basico = $_POST['basico'];
    $mediano = $_POST['mediano'];
    $grande = $_POST['grande'];

    $sql = "INSERT INTO pedidos 
            (nombre_cliente, pastel_basico, pastel_mediano, pastel_grande)
            VALUES ('$cliente', $basico, $mediano, $grande)";
    $conexion->query($sql);
}

// CAMBIAR ESTADO
if (isset($_GET['despachar'])) {
    $id = $_GET['despachar'];
    $conexion->query("UPDATE pedidos SET estado='despachado' WHERE id=$id");
}

// CONSULTA
$pedidos = $conexion->query("SELECT * FROM pedidos ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pastelería - Pedidos ggg</title>
    <style>
        body { font-family: Arial; background:#f7f7f7; padding:20px; }
        table { border-collapse: collapse; width:100%; background:white; }
        th, td { border:1px solid #ccc; padding:8px; text-align:center; }
        th { background:#f2a1c7; }
        form { background:white; padding:15px; margin-bottom:20px; }
        button { padding:8px 12px; }
    </style>
</head>
<body>

<h2>📦 Registrar Pedido</h2>
<form method="POST">
    Cliente:
    <input type="text" name="cliente" required><br><br>

    Pastel Básico:
    <input type="number" name="basico" value="0" min="0"><br><br>

    Pastel Mediano:
    <input type="number" name="mediano" value="0" min="0"><br><br>

    Pastel Grande:
    <input type="number" name="grande" value="0" min="0"><br><br>

    <button type="submit" name="guardar">Guardar Pedido</button>
</form>

<h2>📋 Lista de Pedidos</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Básico</th>
        <th>Mediano</th>
        <th>Grande</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>

    <?php while ($p = $pedidos->fetch_assoc()) { ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['nombre_cliente'] ?></td>
        <td><?= $p['pastel_basico'] ?></td>
        <td><?= $p['pastel_mediano'] ?></td>
        <td><?= $p['pastel_grande'] ?></td>
        <td><?= $p['estado'] ?></td>
        <td>
            <?php if ($p['estado'] == 'recepcionado') { ?>
                <a href="?despachar=<?= $p['id'] ?>">Despachar</a>
            <?php } else { ?>
                ✔
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
