<?php
// OK es una variable de flag que se activa cuando se guarda el formulario

$db = conectaDb();
$id = $_GET['id'];
$consulta = 'SELECT * from medico where (idmedico = "' . $id . '") ';
$result = $db->query($consulta);
$a = $result->fetch(PDO::FETCH_ASSOC);

// Consulta para conocer la especialidad del medico

$consulta = 'SELECT especialidad.nombre FROM medico INNER JOIN med_esp ON idmedico = id_med
INNER JOIN especialidad ON idespecialidad = id_esp WHERE idmedico = ' . $a['idmedico'] . '';
$conidesp = $db->query($consulta);
$arridesp = $conidesp->fetch(PDO::FETCH_ASSOC);
$esp = $arridesp['nombre'];
// Fin de la consulta

if (isset($_GET['ok'])) {
    $dni = $_GET['dni'];
    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];
    $mail = $_GET['mail'];
    $matricula = $_GET['matricula'];
    $tel = $_GET['tel'];
    $esp = $_GET['esp_selec'];
    $consulta = 'SELECT * from medico where (dni = "' . $dni . '") and idmedico != "' . $id . '" ';
    $result = $db->query($consulta);
    if (($result->rowCount() == 0)) {
        $consulta = 'UPDATE medico SET dni = "' . $dni . '", nombre="' . $nombre . '", apellido="' . $apellido . '", mail="' . $mail . '", telefono="' . $tel . '", matricula="' . $matricula . '" where idmedico = "' . $id . '"';
        $consulta2 = 'SELECT idespecialidad FROM especialidad WHERE nombre = "' . $esp . '" ';
        $re = $db->query($consulta2);
        $b = $re->fetch(PDO::FETCH_ASSOC);
        $up = 'UPDATE med_esp SET id_esp = ' . $b['idespecialidad'] . ' WHERE id_med =' . $id . '';
        if ($db->query($consulta) && ($db->query($up))) {
            $id = $db->lastInsertId("seq_name");
            $fechita = date('Y-m-d H:i:s');
            $detalle = 'Modificacion del Médico  "' . $dni . '"';
            $user = $_SESSION['usuario']['user'];
            $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'medico', '$id' )";
            $db->query($log);
            echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Muy Bien! Se modificó correctamente el Médico: ' . $nombre . '</h4></strong>  
            </div>';
            //reconsulta para actualizar los valores del formulario al modificar algo
            $id = $_GET['id'];
            $consulta = 'SELECT * from medico where (idmedico = "' . $id . '") ';
            $result = $db->query($consulta);
            $a = $result->fetch(PDO::FETCH_ASSOC);

// Consulta para conocer la especialidad del medico

            $consulta = 'SELECT especialidad.nombre FROM medico INNER JOIN med_esp ON idmedico = id_med
INNER JOIN especialidad ON idespecialidad = id_esp WHERE idmedico = ' . $a['idmedico'] . '';
            $conidesp = $db->query($consulta);
            $arridesp = $conidesp->fetch(PDO::FETCH_ASSOC);
            $esp = $arridesp['nombre'];
// Fin de la consulta
        } else {
            echo '<div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Ocurrio un error al conectarse con la base de datos.</h4>Por favor comuniquese con su administrador.</strong>  
                 </div>';
        }
    } else {
        echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> Ya existe un medico con este DNI</strong>.  
             </div>';
    }
}
?>
<form class="form-horizontal" name="formi" action="./medico.php" method="GET">
    <fieldset>
        <legend>Modificación de Médico</legend>
        <div class="control-group">
            <div class="controls">
                <?php echo '<h4>Usted está modificando el Médico: ' . $a['nombre'] . '</h4>' ?>
                <br>
                <label>Nuevo nombre</label>
                <input value="<?php echo $a['nombre'] ?>" type="text" class="input-xlarge" id="nombre" name="nombre" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el nombre del Médico" data-content="Ingrese el nuevo nombre del Médico para modificarlo. No se permite ingresar números. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo apellido</label>
                <input value="<?php echo $a['apellido'] ?>" type="text" class="input-xlarge" id="apellido" name="apellido" onkeypress="return soloLetras(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el apellido del Médico" data-content="Ingrese el nuevo apellido del Médico para modificarlo. No se permite ingresar números. La cantidad máxima de caracteres es 20.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo DNI</label>
                <input value="<?php echo $a['dni'] ?>" type="text" class="input-xlarge" id="dni" name="dni" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el DNI del Médico" data-content="Ingrese el nuevo DNI del Médico para modificarlo. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 8.">
                    <i class="icon-question-sign"></i>
                </button> 
                <label>Nueva matrícula</label>
                <input value="<?php echo $a['matricula'] ?>" type="text" class="input-xlarge" id="matricula" name="matricula" maxlength="8" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar la matrícula del Médico" data-content="Ingrese la nueva matrícula del Médico para modificarla. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 8.">
                    <i class="icon-question-sign"></i>
                </button> 
                <label>Nuevo mail</label>
                <input value="<?php echo $a['mail'] ?>" type="text" class="input-xlarge" id="mail" name="mail">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el e-mail del Médico" data-content="Ingrese el nuevo e-mail del Médico para modificarlo. Por ejemplo: 'cuenta@gmail.com'.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nuevo teléfono</label>
                <input value="<?php echo $a['telefono'] ?>" type="text" class="input-xlarge" id="tel" name="tel" maxlength="10" onkeypress="return justNumbers(event);">
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar el teléfono del Médico" data-content="Ingrese el nuevo teléfono del Médico para modificarlo. Solo se permiten caracteres numéricos. La cantidad máxima de dígitos es 10.">
                    <i class="icon-question-sign"></i>
                </button>
                <label>Nueva especialidad</label>

                <?php
                $datab = conectaDb();
                $consulta = "SELECT * FROM especialidad where activa = 1";
                $result = $datab->query($consulta);
                if (!$result)
                    print ("<p>error en la consulta<p>");
                else
                    
                    ?>
                <select class="select-xlarge" id="esp_selec" name="esp_selec" >
                    <?php
                    foreach ($result as $valor)
                        if ($valor['nombre'] == $esp) {
                            echo '<option selected="selected">' . $valor['nombre'] . '</option>';
                        } else {
                            echo '<option>' . $valor['nombre'] . '</option>';
                        }
                    ?>
                </select>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar la especialidad del Médico" data-content="Oprima sobre la nueva especialidad del Médico. Para abrir la lista de especialidades oprima sobre el campo que está a la izquierda o sobre la flecha hacia abajo. Una vez desplegada seleccione la nueva especialidad para modificarla.">
                    <i class="icon-question-sign"></i>
                </button>

                <br><br><br>
                <a href="./medico.php?code=osmod&id=<?php echo $id ?>" class="btn btn-success">Obras Sociales</a>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar Obra/s social/es del Médico" data-content="Oprima sobre el botón 'Obras Sociales' para modificar las Obras Sociales con las que trabaja el Médico. Se abrirá en una nueva sección. Dentro de la nueva sección deberá regresar a ésta página (Modificar Médico) para continuar.">
                    <i class="icon-question-sign"></i>
                </button>
                
                <br><br>

                <a href="./medico.php?code=hsmod&id=<?php echo $id ?>" class="btn btn-success">Horarios</a>
                <button class="btn btn-mini" onclick="return false;" data-original-title="Modificar Horarios del Médico" data-content="Oprima sobre el botón 'Horarios' para modificar los Horarios en los que trabaja el Médico. Se abrirá en una nueva sección. Dentro de la nueva sección deberá regresar a ésta página (Modificar Médico) para continuar.">
                    <i class="icon-question-sign"></i>
                </button>


                <br><br><br>
                <input type="hidden" name="code" value="m"/>
                <input type="hidden" name="ok" value="1"/>
                <input type="hidden" name="id" value="<?php echo "$id" ?>"/>
                <button type="submit"  class="btn btn-success" onClick="return veriformuMed();">Guardar cambios</button>
            </div>
        </div>
    </fieldset>
</form>
