<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Listado de productos</h1>
    <a href="?controller=producto&action=create">Crear productos</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Talla</th>
                <th>Precio</th>
                <th>Action</th>
            </tr>
        <?php
    
        foreach($productos as $producto) {
        ?>
            <tr>
                <td><?=$producto->getId()?></td>
                <td><?=$producto->getNombre()?></td>
                <td><?=$producto->getTalla()?></td>
                <td><?=$producto->getPrecio()?></td>
                <td><a href="?controller=producto&action=destroy&id=<?=$producto->getId();?>">Eliminar</a></td>
            </tr>
        <?php
        }
        ?>
        </table>
        <?

    ?>
</body>
</html>