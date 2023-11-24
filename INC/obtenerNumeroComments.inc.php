<?php
/**
 * @author Ivan Torres Marcos
 * @version 1.1
 * @description Pequeña función la cual estaba el tablon.inc.php para poder obtener el numero de comentarios.
 *
 */

function obtenerNumeroComentarios($revelId, $conexion)
{
    // Consultar la cantidad de comentarios para la revelación con el ID proporcionado
    $stmt = $conexion->prepare('SELECT COUNT(id) AS cantidad FROM comments WHERE revelid = :revelId');
    $stmt->bindParam(':revelId', $revelId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Devolver la cantidad de comentarios
    return $result['cantidad'];
}
