<?php include("templates/header.php"); ?>
<?php
include("admin/config/db.php");
$sentenceSQL = $conection->prepare("SELECT * FROM platos");
$sentenceSQL->execute();
$platoList = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="terminos-condiciones-title">Pagar</h2>
<div class="terminos-condiciones">
    <?php
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $idPlato = $_GET['id'];

        // Realizar acciones relacionadas con el pago y los detalles del plato
        // Aquí puedes incluir tu lógica personalizada

        // Obtener los detalles del plato desde la base de datos
        // Suponiendo que tienes una conexión a la base de datos establecida

        // Consulta SQL para obtener el nombre y el precio del plato
        $sql = "SELECT nombre, precio FROM platos WHERE id = $idPlato";
        $resultado = mysqli_query($conexion, $sql);

        // Verificar si se obtuvo un resultado válido
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            // Obtener los datos del plato
            $row = mysqli_fetch_assoc($resultado);
            $nombrePlato = $row['nombre'];
            $precioPlato = $row['precio'];




            // Mostrar los detalles del plato o realizar el proceso de pago
            echo "Detalles del plato:";
            echo "<br>";
            echo "<br>";
            echo "Nombre del plato: " . $nombrePlato;
            echo "<br>";
            echo "Precio del plato: $" . $precioPlato;
        } else {
            // Manejar el caso en que no se encuentre el plato
            echo "El plato no existe";
        }
    } else {
        // Redirigir si no se proporciona un ID de plato válido
        header("Location: lista_platos.php");
        exit();
    }
    ?>
    <br><br>
    <img src="images/yape.jpg" alt="yape" width="300px" height="400px">
</div>


<?php include("templates/footer.php"); ?>