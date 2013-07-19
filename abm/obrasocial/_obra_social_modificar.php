<?php
$db = conectaDb();
$id_vie = $_GET['id'];
$consulta = 'SELECT * from os where (idos = "' . $id_vie . '")';
$result = $db->query($consulta);
$a = $result->fetch(PDO::FETCH_ASSOC);
$os_vie = $a['nombre'];
if (isset($_GET['ok'])) {
  $os_nue = $_GET['os_nue'];
  $activa = $_GET['activa'];
  $consulta2 = 'SELECT * from os where (nombre = "' . $os_nue . '")';
  $result2 = $db->query($consulta2);
  $a2 = $result2->fetch(PDO::FETCH_ASSOC);
  $id_nue = $a2['idos'];
  if ($id_nue == null || $id_nue == $id_vie) {
    $consulta = 'update os set nombre = "' . $os_nue . '", activo="' . $activa . '" where idos = "' . $id_vie . '"';
    if ($db->query($consulta)) {
      $fechita = date('Y-m-d H:i:s');
      $detalle = 'Modificacíon de la obra social "' . $os_nue . '"';
      $user = $_SESSION['usuario']['user'];
      $id = $db->lastInsertId("seq_name");
      $log = "INSERT INTO log ( fecha, usuario, detalle, tabla, idafectado)              
              VALUES ('$fechita', '$user', '$detalle', 'os', '$id' )";
      $db->query($log);
      echo '<div class="alert alert-success">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Muy Bien!</strong><br>
                    Se incerto correctamente la obra social: ' . $os_nue . '.</h4>  
                </div>';
    } else {
      echo '<div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    No pudo comunicarse con la base de datos.<br>
                    Comuniquese con su administrador.</h4>  
                </div>';
    }
  } else {
    echo ' <div class="alert alert-error">  
                    <a class="close" data-dismiss="alert">×</a>  
                    <h4><strong>Error!</strong><br>
                    La obra social: ' . $os_nue . ' ya se encuentra registrada.</h4>  
                </div>';
  }
}
$consulta = 'SELECT * from os where (idos = "' . $id_vie . '")';
$result = $db->query($consulta);
$a = $result->fetch(PDO::FETCH_ASSOC);
$os_vie = $a['nombre'];
?>

<form class="form-horizontal" name="formi" action="./obraSocial.php" method="GET">
  <fieldset>
    <legend>Modificar Obra social</legend>
    <div class="control-group">
      <?php echo '<h4>Usted esta editando la obra social: ' . $os_vie . '</h4>' ?>
      <br><br>
      <?php
      echo '<input value="' . $os_vie . '" type="text" class="input-xlarge" id="nombre" name="os_nue" onkeypress="return soloLetras(event);">';
      if ($a['activo'] == 1)
        echo '<label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" checked>
                <p>Activa</p>
                <input type="radio" name="activa" id="option2" value="0">
                <p>Inactiva</p>
            </label>  
        </div>';
      else
        echo '<label class="radio">
                <br>
                <input type="radio" name="activa" id="option1" value="1" >
                <p>Activa</p>
                <input type="radio" name="activa" id="option2" value="0" checked>
                <p>Inactiva</p>
            </label>  
        </div>';
      ?>
      <div class="form-actions">
        <input type="hidden" name="code" value="c"/>
        <p id="conf"></p>
        <input type="hidden" name="id" value="<?php echo "$id_vie" ?>"/>
        <button type="submit" onclick="veriMod()" class="btn btn-success">Guardar cambios</button>
        <button type="reset" class="btn btn-success">Borrar</button>
      </div>
  </fieldset>