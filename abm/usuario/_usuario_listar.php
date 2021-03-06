<?php
$db = conectaDb();
$consulta = "SELECT * from usuario";
$result = $db->query($consulta);
?>

<legend>Listado de Obras Sociales</legend>
<form class="form-horizontal" name="form" action="./usuario/_usuario_imprimir.php" method="GET" target="_blank">

    <table id="tabla1" class="table table-striped">
        <thead>
            <tr>
                <th>Elegir <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Elegir para impresión" data-content="Oprima sobre cada u para seleccionarlo, o utilice los botones de Marcar/Desmarcar todos.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                <th>User <button class="btn btn-mini" onclick="return false;" data-original-title="Campo User" data-content="Oprima sobre este campo para ordenar la lista por el atributo User (o nombre de usuario). Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                <th>DNI <button class="btn btn-mini" onclick="return false;" data-original-title="Campo DNI" data-content="Oprima sobre este campo para ordenar la lista por el atributo DNI. Cada vez que se oprime cambiará entre forma ascendente y descendente.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                <th>Modificar <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Modificar" data-content="Oprima sobre el ícono del engranaje correspondiente al usuario para ver y modificar la información del mismo.">
                            <i class="icon-question-sign"></i>
                        </button></th>
                <th>Detalle <button class="btn btn-mini" onclick="return false;" data-original-title="Campo Detalle" data-content="Oprima sobre el ícono del ojo correspondiente al usuario que desee ver toda la información del mismo. Se abrirá en una pequeña ventana.">
                            <i class="icon-question-sign"></i>
                        </button></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $valor): ?>
                <tr>
                    <td><input type="checkbox" name="<?php echo $valor['idusuario'] ?>" value="<?php echo $valor['idusuario'] ?>" id="<?php echo $valor['idusuario'] ?>"></td>              
                    <td><?php echo $valor['user'] ?></td>
                    <td><?php echo $valor['dni'] ?></td>
                    <td><a href="./usuario.php?code=m&id=<?php echo $valor['idusuario'] ?>"><i class="icon-cog"></i></a></td>
                    <td><a href="javascript:abrir('./usuario/_ver_detalle.php?id=<?php echo $valor['idusuario'] ?>')"><i class=" icon-eye-open"></i></a></td>
                <?php endforeach; ?>
        </tbody>    
    </table>
    <br><br><br> 
    <a href="javascript:seleccionar_todo()">Marcar todos</a> | 
    <a href="javascript:deseleccionar_todo()">Desmarcar todos</a>
    <button class="btn btn-mini" id='ayuda' onclick="return false;" data-original-title="Opciones de marcado" data-content="Oprima 'Marcar todos' para seleccionar todos los usuarios visualizados u oprima 'Desmarcar todos' para desmarcar todos los usuarios que estén visualizados.">
        <i class="icon-question-sign"></i>
    </button>
    <button type="submit" class="btn btn-success offset1">Imprimir</button>
    <button class="btn btn-mini" onclick="return false;" data-original-title="Imprimir" data-content="Seleccione los usuarios que desee imprimir haciendo click sobre el campo 'Elegir' de cada uno o utilizando el botón de 'Marcar todos'. Una vez hecho esto oprima el botón 'Imprimir' y se abrirá una nueva ventana con un documento pdf, el cual podrá imprimir utilizando las opciones del navegador que esté usando.">
        <i class="icon-question-sign"></i>
    </button>
</form>

<script>
    function seleccionar_todo() {
        for (i = 0; i < document.form.elements.length; i++)
            if (document.form.elements[i].type == "checkbox")
                document.form.elements[i].checked = 1
    }

    function deseleccionar_todo() {
        for (i = 0; i < document.form.elements.length; i++)
            if (document.form.elements[i].type == "checkbox")
                document.form.elements[i].checked = 0
    }
    
        function abrir(url) {
        open(url, '', 'top=100,left=100,width=800,height=600');
    }
</script>
