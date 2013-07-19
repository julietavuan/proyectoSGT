<?php
if (isset($_GET['nombre'])) {
  $db = conectaDb();
  $nombre = $_GET['nombre'];
  $apellido = $_GET['apellido'];
  $dni = $_GET['dni'];
  $fechaNac = $_GET['fechaNac'];
  $localidad = $_GET['localidad'];
  $calle = $_GET['calle'];
  $altura = $_GET['altura'];
  $depto = $_GET['departamento'];
  $piso = $_GET['piso'];
  $mail = $_GET['mail'];
  $tel = $_GET['tel'];
  $os_select = $_GET['os_select'];
  $consulta = "SELECT * from paciente where (dni = '$dni')";
  $result = $db->query($consulta);
  if ($result->rowCount() > 0) {
    echo '<div class="alert alert-error">  
                <a class="close" data-dismiss="alert">×</a>  
                <strong><h4>Error!</h4> Ya existe un paciente con este DNI</strong>.  
             </div>';
  } else {
    $consulta = "INSERT INTO paciente (dni, nacimiento, nombre, apellido, localidad, calle, altura, mail, piso, depto, telefono)
                    VALUES ('$dni', '$fechaNac', '$nombre', '$apellido', '$localidad', '$calle', '$altura', '$mail', '$piso', '$depto', '$tel')";

    if ($db->query($consulta)) {
      $consulta2 = "SELECT idos, idpaciente from os, paciente where paciente.dni = '$dni' and os.nombre = '$os_select'";
      $tmp = $db->query($consulta2);
      $id = $db->lastInsertId("seq_name");
      $res = $tmp->fetch(PDO::FETCH_ASSOC);
      $idos = $res['idos'];
      $idpac = $res['idpaciente'];
      $consulta3 = "INSERT INTO pac_os (id_paciente, id_os) VALUES ('$idpac', '$idos')";
      if ($db->query($consulta3)) {
        $fechita = date('Y-m-d H:i:s');
        $detalle = 'Alta de paciente  "' . $dni . '"';
        $user = $_SESSION['usuario']['user'];
        $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'Paciente', '$id' )";
        $db->query($log);
        echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Muy Bien! Se inserto correctamente el paciente: ' . $nombre . '</h4>.</strong>  
                 </div>';
      } else {
        echo 'fallo la os valores $idpac =' . $idpac . ' y $idos = ' . $idos . ' consulta= ' . $consulta3 . '';
      }
    } else {
      echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <strong><h4>Ocurrio un error al conectarse con la base de datos.</h4>Por favor comuniquese con su administrador.</strong>  
                 </div>';
    }
  }
}
?>
<form class="form-horizontal" name="formi" action="/abm/paciente.php" method="GET">
  <fieldset>
    <legend>Agregar una nuevo paciente.</legend>
    <div class="control-group">
      <div class="controls">
        <label>Nombre*</label>
        <input type="text" tabindex="1" class="input-xlarge" id="nombre" name="nombre" placeholder="Nombre" maxlength="20" onkeypress="return soloLetras(event);">
        <label>Apellido*</label>
        <input type="text" tabindex="2" class="input-xlarge" id="apellido" name="apellido" placeholder="Apellido" maxlength="20" onkeypress="return soloLetras(event);">
        <label>DNI*</label>
        <input type="text" tabindex="3" class="input-xlarge" id="dni" name="dni" placeholder="DNI" maxlength="8" onkeypress="return justNumbers(event);">
        <label>Fecha de nacimiento*</label>
        <input type="date" tabindex="4" class="input-xlarge" id="fechaNac" name="fechaNac" onkeypress="return justFecha(event);">
        <label>Localidad*</label>
        <input type="text" tabindex="5" class="input-xlarge" id="localidad" name="localidad" placeholder="Localidad"  maxlength="20">
        <label>Calle*</label>
        <input type="text" tabindex="6" class="input-xlarge" id="calle" name="calle" placeholder="Calle" maxlength="20">
        <label>Altura</label>
        <input type="text" tabindex="7" class="input-xlarge" id="altura" name="altura"  placeholder="Número" maxlength="20" onkeypress="return justNumbers(event);">
        <label>Piso</label>
        <input type="text" tabindex="8" class="input-xlarge" id="piso" name="piso"  placeholder="Piso" maxlength="2" onkeypress="return justNumbers(event);">
        <label>Departamento</label>
        <input type="text" tabindex="9" class="input-xlarge" id="depto" name="departamento"  placeholder="Departamento">
        <label>Correo electrónico*</label>
        <input type="text" tabindex="10" class="input-xlarge" id="mail" name="mail" placeholder="nombre@servidor.com" maxlength="50">
        <label>Teléfono*</label>
        <input type="text" tabindex="11" class="input-xlarge" id="tel" name="tel" placeholder="Teléfono" maxlength="10" onkeypress="return justNumbers(event);">
        <label>Obra social</label>
        <?php
        $datab = conectaDb();
        $consulta = "SELECT * FROM os where activo = 1";
        $result = $datab->query($consulta);
        if (!$result)
          print ("<p>error en la consulta<p>");
        else
          ?>
        <select tabindex="12" class="select-xlarge" name="os_select" >
          <?php
          foreach ($result as $valor)
            if ($valor['nombre'] == 'Ninguna')
              echo '<option Selected="Selected">' . $valor['nombre'] . '</option>';
            else
              echo '<option>' . $valor['nombre'] . '</option>';
          ?>
        </select>
        <input type="hidden" name="code" value="a"/><br><br> 
        <button tabindex="13" type="submit" onclick="return veriformuPaciente()" class="btn btn-success">Guardar</button>
        <button tabindex="14" type="reset" class="btn btn-success">Borrar</button>

      </div>
    </div>
  </fieldset>
</form>
