<?php include("../templates/header.php"); ?>
<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$imagenPlato = (isset($_FILES['imagenPlato']['name'])) ? $_FILES['imagenPlato']['name'] : "";
$txtProteinas = (isset($_POST['txtProteinas'])) ? $_POST['txtProteinas'] : "";
$txtCarbohidratos = (isset($_POST['txtCarbohidratos'])) ? $_POST['txtCarbohidratos'] : "";
$txtGrasas = (isset($_POST['txtGrasas'])) ? $_POST['txtGrasas'] : "";
$txtCalorias = (isset($_POST['txtCalorias'])) ? $_POST['txtCalorias'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$action = (isset($_POST['action'])) ? $_POST['action'] : "";

include("../config/db.php");

switch ($action) {
    case "Agregar":
        $sentenceSQL = $conection->prepare("INSERT INTO platos (nombre, imagen, calorias, proteinas, carbohidratos, grasas, descripcion, precio) VALUES (:nombre, :imagen, :calorias, :proteinas, :carbohidratos, :grasas, :descripcion, :precio);");

        $sentenceSQL->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($imagenPlato != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagenPlato"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES["imagenPlato"]["tmp_name"];

        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../images/platosdb/" . $nombreArchivo);
        }

        $sentenceSQL->bindParam(':imagen', $nombreArchivo);
        $sentenceSQL->bindParam(':calorias', $txtCalorias);
        $sentenceSQL->bindParam(':proteinas', $txtProteinas);
        $sentenceSQL->bindParam(':carbohidratos', $txtCarbohidratos);
        $sentenceSQL->bindParam(':grasas', $txtGrasas);
        $sentenceSQL->bindParam(':precio', $txtPrecio);
        $sentenceSQL->bindParam(':descripcion', $txtDescripcion);

        $sentenceSQL->execute();

        header("Location:platosdb.php");
        break;
    case "Modificar":

        $sentenceSQL = $conection->prepare("UPDATE platos SET nombre=:nombre, calorias=:calorias, proteinas=:proteinas, carbohidratos=:carbohidratos, grasas=:grasas, descripcion=:descripcion, precio=:precio WHERE id=:id");
        $sentenceSQL->bindParam(':id', $txtID);
        $sentenceSQL->bindParam(':nombre', $txtNombre);
        $sentenceSQL->bindParam(':calorias', $txtCalorias);
        $sentenceSQL->bindParam(':proteinas', $txtProteinas);
        $sentenceSQL->bindParam(':carbohidratos', $txtCarbohidratos);
        $sentenceSQL->bindParam(':grasas', $txtGrasas);
        $sentenceSQL->bindParam(':precio', $txtPrecio);
        $sentenceSQL->bindParam(':descripcion', $txtDescripcion);
        $sentenceSQL->execute();

        if ($imagenPlato != "") {
            $fecha = new DateTime();
            $nombreArchivo = ($imagenPlato != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagenPlato"]["name"] : "imagen.jpg";

            $tmpImagen = $_FILES["imagenPlato"]["tmp_name"];
            move_uploaded_file($tmpImagen, "../../images/platosdb/" . $nombreArchivo);

            $sentenceSQL = $conection->prepare("SELECT imagen FROM platos WHERE id=:id");
            $sentenceSQL->bindParam(':id', $txtID);
            $sentenceSQL->execute();
            $plato = $sentenceSQL->fetch(PDO::FETCH_LAZY);

            if (isset($plato["imagen"]) && ($plato["imagen"] != "imagen.png")) {
                if (file_exists("../../images/platosdb/" . $plato["imagen"])) {
                    unlink("../../images/platosdb/" . $plato["imagen"]);
                }
            }

            $sentenceSQL = $conection->prepare("UPDATE platos SET imagen=:imagen WHERE id=:id");
            $sentenceSQL->bindParam(':imagen', $nombreArchivo);
            $sentenceSQL->bindParam(':id', $txtID);
            $sentenceSQL->execute();
        }
        header("Location:platosdb.php");

        break;
    case "Cancelar":
        header("Location:platosdb.php");

        break;
    case "Elegir":
        $sentenceSQL = $conection->prepare("SELECT * FROM platos WHERE id=:id");
        $sentenceSQL->bindParam(':id', $txtID);
        $sentenceSQL->execute();
        $plato = $sentenceSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre = $plato['nombre'];
        $imagenPlato = $plato['imagen'];
        $txtProteinas = $plato['proteinas'];
        $txtCarbohidratos = $plato['carbohidratos'];
        $txtGrasas = $plato['grasas'];
        $txtCalorias = $plato['calorias'];
        $txtPrecio = $plato['precio'];
        $txtDescripcion = $plato['descripcion'];
        break;
    case "Borrar":
        $sentenceSQL = $conection->prepare("SELECT imagen FROM platos WHERE id=:id");
        $sentenceSQL->bindParam(':id', $txtID);
        $sentenceSQL->execute();
        $plato = $sentenceSQL->fetch(PDO::FETCH_LAZY);

        if (isset($plato["imagen"]) && ($plato["imagen"] != "imagen.png")) {
            if (file_exists("../../images/platosdb/" . $plato["imagen"])) {
                unlink("../../images/platosdb/" . $plato["imagen"]);
            }
        }

        $sentenceSQL = $conection->prepare("DELETE FROM platos WHERE id=:id");
        $sentenceSQL->bindParam(':id', $txtID);
        $sentenceSQL->execute();
        header("Location:platosdb.php");
        break;
}

$sentenceSQL = $conection->prepare("SELECT * FROM platos");
$sentenceSQL->execute();
$platoList = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            Platos:
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtName" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label>Proteínas:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtProteinas; ?>" name="txtProteinas" id="txtProteinas" placeholder="Proteínas">
                </div>
                <div class="form-group">
                    <label>Carbohidratos:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtCarbohidratos; ?>" name="txtCarbohidratos" id="txtCarbohidratos" placeholder="Carbohidratos">
                </div>
                <div class="form-group">
                    <label>Grasas:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtGrasas; ?>" name="txtGrasas" id="txtGrasas" placeholder="Grasas">
                </div>
                <div class="form-group">
                    <label>Calorías:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtCalorias; ?>" name="txtCalorias" id="txtCalorias" placeholder="Calorías">
                </div>
                <div class="form-group">
                    <label>Precio:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" id="txtPrecio" placeholder="Precio">
                </div>
                <div class="form-group">
                    <label>Descripción:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtDescripcion; ?>" name="txtDescripcion" id="txtName" placeholder="Descripción">
                </div>
                <div class="form-group">
                    <label>Imagen:</label>
                    <br />

                    <?php if ($imagenPlato != "") { ?>
                        <img class="img-thumbnail rounded" src="../../images/platosdb/<?php echo $imagenPlato; ?>" width="50" alt="">


                    <?php } ?>

                    <input type="file" required class="form-control" name="imagenPlato" id="imagenPlato" placeholder="ID">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" <?php echo ($action == "Elegir") ? "disabled" : ""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="action" <?php echo ($action != "Elegir") ? "disabled" : ""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="action" <?php echo ($action != "Elegir") ? "disabled" : ""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Proteínas</th>
                <th>Carbohidratos</th>
                <th>Grasas</th>
                <th>Calorías</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($platoList as $plato) { ?>
                <tr>
                    <td><?php echo $plato['id']; ?></td>
                    <td><?php echo $plato['nombre']; ?></td>
                    <td><?php echo $plato['proteinas']; ?></td>
                    <td><?php echo $plato['carbohidratos']; ?></td>
                    <td><?php echo $plato['grasas']; ?></td>
                    <td><?php echo $plato['calorias']; ?></td>
                    <td><?php echo $plato['precio']; ?></td>
                    <td><?php echo $plato['descripcion']; ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="../../images/platosdb/<?php echo $plato['imagen']; ?>" width="50" alt="">

                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $plato['id']; ?>">
                            <input type="submit" name="action" value="Elegir" class="btn btn-primary">

                            <input type="submit" name="action" value="Borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include("../templates/footer.php"); ?>