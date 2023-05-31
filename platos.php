<?php include("templates/header.php"); ?>

<?php
include("admin/config/db.php");
$sentenceSQL = $conection->prepare("SELECT * FROM platos");
$sentenceSQL->execute();
$platoList = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="platos-title">Disfruta de nuestros Platos</h2>

<div class="container">
   <div class="products-container">
      <?php foreach ($platoList as $plato) { ?>



         <div class="product" data-name="<?php echo $plato['id'] ?>">
            <img src="images/platosdb/<?php echo $plato['imagen'] ?>" alt="" width="300">
            <h3><?php echo $plato['nombre'] ?></h3>
            <div class="price">$<?php echo $plato['precio'] ?></div>
         </div>


      <?php } ?>
   </div>
</div>

<div class="products-preview">

   <?php foreach ($platoList as $plato) { ?>

      <div class="preview" data-target="<?php echo $plato['id'] ?>">

         <i class="fas fa-times"></i>
         <img src="images/platosdb/<?php echo $plato['imagen'] ?>" alt="" width="350">
         <h3><?php echo $plato['nombre'] ?></h3>
         <div class="stars">
            <p class="calorias"><?php echo $plato['calorias'] ?> Calorías</p>
            <p>Proteinas: <?php echo $plato['proteinas'] ?></p>
            <p>Carbohidratos: <?php echo $plato['carbohidratos'] ?></p>
            <p>Grasas: <?php echo $plato['grasas'] ?></p>
            <!-- <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <span>( 250 )</span> -->
         </div>
         <p><?php echo $plato['descripcion'] ?></p>
         <div class="price">$<?php echo $plato['precio'] ?></div>
         <div class="buttons">
         <a href="pagar.php?id=<?php echo $plato['id'] ?>" class="buy">Comprar</a>
            <a href="#" class="cart">Añadir al carrito</a>
         </div>
      </div>
   <?php } ?>



</div>

<?php include("templates/footer.php"); ?>