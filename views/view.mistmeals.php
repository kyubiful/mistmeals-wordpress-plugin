<?php
  global $wpdb;
  $prefix = $wpdb->prefix;
  $table = $prefix . 'posts';

  $query = "SELECT ID, post_title, post_status FROM $table 
    WHERE ( post_type LIKE 'product_variation')
    AND (post_status LIKE 'publish' OR post_status LIKE 'private') ORDER BY ID;";
  $product_variations_list = $wpdb->get_results($query, ARRAY_A);

  $query = "SELECT ID, post_title, post_status FROM $table 
    WHERE ( post_type LIKE 'product')
    AND (post_status LIKE 'publish' OR post_status LIKE 'draft' OR post_status LIKE 'private') ORDER BY ID;";
  $product_list = $wpdb->get_results($query, ARRAY_A);
  
?>
<div class="wrap">
  <?php echo "<h1 class='wp-heading-inline'>" . get_admin_page_title() . "</h1>"; ?>

  <h2>Platos</h2>

  <table class="wp-list-table widefat fixed striped pages">
    <thead>
      <th>ID</th>
      <th>Nombre del plato</th>
      <th>Activo</th>
      <th>Acciones</th>
    </thead>
    <tbody id="the-list">
      <?php
        foreach($product_list as $key => $product) {
        $product_id = $product['ID'];
        $product_name = $product['post_title'];
        $product_status = $product['post_status'];
        echo "<tr>
          <td>$product_id</td>
          <td>$product_name</td>";

        if($product_status == 'publish') { echo "<td>Activo</td>"; } 
        if($product_status == 'private' OR $product_status == 'draft') { echo "<td>Inactivo</td>"; }

        echo "<td>
          <a href='post.php?post=".$product_id."&action=edit' class='page-title-action'>Editar plato</a>
          </td>
          </tr>";
        }
      ?>
    </tbody>
  </table>

  <h2> Variaciones </h2>
  <table class="wp-list-table widefat fixed striped pages">
    <thead>
      <th>ID</th>
      <th>Nombre del plato</th>
      <th>Activo</th>
      <th>Acciones</th>
    </thead>
    <tbody id="the-list">
      <?php
        foreach($product_variations_list as $key => $product) {
        $product_variations_id = $product['ID'];
        $product_variations_name = $product['post_title'];
        $product_variations_status = $product['post_status'];
        echo "<tr>
          <td>$product_variations_id</td>
          <td>$product_variations_name</td>";

        if($product_variations_status == 'publish') { echo "<td>Activo</td>"; } 
        if($product_variations_status == 'private') { echo "<td>Inactivo</td>"; }

        echo "<td>
          <button class='page-title-action variations-btn-modal' id='variations-btn-modal-$product_variations_id' data-toggle='modal-$product_variations_id' data-target='#addNutrientsModal-$product_variations_id' data-close='modal-close-$product_variations_id'>Añadir nutrientes</button>
          </td>
          </tr>";
        }
      ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<?php

  foreach($product_variations_list as $key => $product) {
   
    $product_variations_id = $product['ID'];
    $product_name = $product['post_title'];
    $table = $prefix . 'mm_nutrientes';
    $query = "SELECT * FROM $table WHERE id LIKE $product_variations_id";
    $product = $wpdb->get_results($query, ARRAY_A);

    echo "
    <div class='modal modal-$product_variations_id fade' id='addNutrientsModal-$product_variations_id' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
      <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLongTitle'>Nutrientes</h5>
            <button type='button' class='btn-close' id='modal-close-$product_variations_id' aria-label='Close'>
            </button>
          </div>
          <div class='modal-body'>
            <p>$product_name</p>
            <table>
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Energía</label>
                <input class='form-control' type='number' name='energia' placeholder='Energía' value=''/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Calorías</label>
                <input class='form-control' type='number' name='calorias' placeholder='Calorías' value=''/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Proteínas</label>
                <input class='form-control' type='number' name='proteinas' placeholder='Proteínas' value=''/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Grasas</label>
                <input class='form-control' type='number' name='grasas' placeholder='Grasas' value=''/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Saturadas</label>
                <input class='form-control' type='number' name='saturadas' placeholder='Saturadas' value=''/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Carbohidratos</label>
                <input class='form-control' type='number' name='carbohidratos' placeholder='Carbohidratos' value=''/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Azucar</label>
                <input class='form-control' type='number' name='azucar' placeholder='Azucar' value=''/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Fibra</label>
                <input class='form-control' type='number' name='fibra' placeholder='Fibra' value=''/>
              </div> 
            </div> 
            <div class='d-flex justify-content-end mt-2'>
              <button class='btn btn-primary' type='submit' value='$product_variations_id'>Guardar</button>
            </div>
            </table>
          </div>
        </div>
      </div>
    </div>";
  }
?>