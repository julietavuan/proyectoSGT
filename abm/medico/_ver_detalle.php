<?php
//detalle de medico

include_once('../../sesion/login.php');
include_once('../../fragmentos/_conectDb.php');
if ($_SESSION['usuario']['admin'] == '1') {
    
}
else
    header('Location: /index.php?er=2');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SGT2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="Sudo Soft" content="">
        <link href="./../../css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="./../../datatables/css/bootstrap.css" rel="stylesheet">
        <link href="./../../datatables/css/jquery.dataTables_themeroller.css" rel="stylesheet">
        <link href="./../../css/propio.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="./../../css/menu.css" />
        <link rel="shortcut icon" href="./../../img/favicon.ico" type="image/x-icon"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

        <script type="text/javascript" src="./../../js/validacion.js"></script>
        <script type="text/javascript" src="./../../datatables/js/jquery.js"></script>
        <script type="text/javascript" src="./../../datatables/js/jquery.dataTables.js"></script>   
        <script type="text/javascript" src="./../../js/bootstrap-alert.js"></script>
    </head>
    <body>
        <div class="row-fluid">
            <div class="span12">
                <img SRC="./../../img/imagenSuper.png" id="cabe1">
            </div>
        </div>        
        <div class="row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <div class="span10 offset1">
                        <?php
                        $db = conectaDb();
                        $id = $_GET['id'];
                        $consulta = "SELECT * FROM medico WHERE idmedico =' $id '";
                        $result = $db->query($consulta);
                        $campos = $result->fetch(PDO::FETCH_ASSOC);
                        // COnsulta aparte para las obras sociales
                        $consulta2 = "SELECT * FROM med_os INNER JOIN os ON med_os.id_med =' $id ' AND med_os.id_os = os.idos";
                        $result2 = $db->query($consulta2);
                        //$campos2 = $result2->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <label><strong>Nombre: </strong><?php echo ($campos['nombre']) ?></label>
                        <br>
                        <label><strong>Apellido: </strong><?php echo ($campos['apellido']) ?></label>
                        <br>
                        <label><strong>DNI: </strong><?php echo ($campos['dni']) ?></label>
                        <br>
                        <?php
                        foreach ($result2 as $valor) {
                            echo "<label><strong>Obra Social: </strong>";
                            if ($valor['activo'] == 1)
                                echo '<td>' . $valor['nombre'] . '</td>';
                            else
                                echo '<td><p style="color: #FF0000">' . $valor['nombre'] . '</p></td>';
                            echo "</label><br>";
                        }
                        ?>
                        <label><strong>Teléfono: </strong><?php echo ($campos['telefono']) ?></label>
                        <br>
                        <label><strong>Matrícula: </strong><?php echo ($campos['matricula']) ?></label>
                        <br>  
                        <label><strong>Mail: </strong><?php echo ($campos['mail']) ?></label>
                        <br>
                        <label><strong>Ingreso: </strong><?php echo ($campos['ingreso']) ?></label>
                        <br>


                        <!--Tabla de horarios-->
                        <?php
                        
                        $conhorarios = "select dia, min(desde) desde, max(hasta) hasta, id_med from horario inner join medico on (id_med = '$id') group by id_med, dia";
                        $result2 = $db->query($conhorarios);
                                
                        ?>;
                        
                        <legend>Horarios</legend>
                        <table id="tabla1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result2 as $valor2) {
                                    echo '<tr>
                                        <td>' . $valor2['dia'] . '</td>
                                        <td>' . $valor2['desde'] . '</td>
                                        <td>' . $valor2['hasta'] . '</td>    
                </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <br><br>
                        <a href="./medico_edit.php?id=<?php echo ($campos['idmedico']) ?>" class="btn btn-success">Modificar</a>
                    </div>                
                </div>
            </div>
        </div>
    </body>
</html>

