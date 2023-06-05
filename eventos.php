<?php

header('Content-Type: application/json');
require('conexion.php');
$conexion=conexion();

switch($_GET['accion']){

    case 'listar':
        $listar="SELECT id,
        concepto as title,
        fecha as start,
        confirmada,
        estado,
        donde,
        contacto,
        nombre,
        telefono,
        colortexto as textColor,
        colorfondo as backgroundColor from avisos order by id desc";
        $datos=mysqli_query($conexion,$listar);
        $resultado=mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        
        break;
    case 'agregar':
        $agregar="INSERT INTO avisos (fecha,concepto, confirmada,estado,donde,contacto,nombre,telefono, colortexto, colorfondo) VALUES
        ('$_POST[fecha]','$_POST[concepto]','$_POST[confirmada]','$_POST[estado]','$_POST[donde]','$_POST[contacto]','$_POST[nombre]','$_POST[telefono]','$_POST[colortexto]','$_POST[colorfondo]')"; 
        $respuesta=mysqli_query($conexion,$agregar);
     
        // $resultado=mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
        echo json_encode($respuesta);
        break;
    case 'modificar':
        $modificar="UPDATE avisos set fecha='$_POST[fecha]',
                            concepto='$_POST[concepto]',
                            confirmada='$_POST[confirmada]',
                            estado='$_POST[estado]',
                            donde='$_POST[donde]',
                            contacto='$_POST[contacto]',
                            nombre='$_POST[nombre]',
                            telefono='$_POST[telefono]',
                            colortexto='$_POST[colortexto]',
                            colorfondo='$_POST[colorfondo]'
                            where id=$_POST[id]";
        $respuesta=mysqli_query($conexion,$modificar);
        echo json_encode($respuesta);
        break;
    case 'borrar':
        $borrar="DELETE FROM avisos where id='$_POST[id]'";
        $respuesta=mysqli_query($conexion,$borrar);
        echo json_encode($respuesta);
        break;
    default:
        break;
}
