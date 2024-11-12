<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <h1>Listado de productos</h1>
    <form action="?controller=producto&action=store" method="POST">
        <input type="text" value="Nombre" name="nombre" id="nombre">
        <select name="talla">
            <option value="XXL">XXL</option>
            <option value="XL">XL</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="S">S</option>
        </select>
        <input type="float" value="Precio" name="precio" id="precio">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>