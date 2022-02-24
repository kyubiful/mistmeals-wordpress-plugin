<?php
  global $wpdb;
  $prefix = $wpdb->prefix;
  $table = $prefix . 'posts';
  $nutrients_table = $prefix.'mm_nutrientes';

  /* $query = "SELECT ID, post_title, post_status FROM $table 
    WHERE ( post_type LIKE 'product_variation')
    AND (post_status LIKE 'publish' OR post_status LIKE 'private') ORDER BY ID;"; */

  $query = "SELECT wp_posts.ID, wp_posts.post_title, wp_posts.post_status, wp_posts.post_type, wp_mm_nutrientes.energia, wp_mm_nutrientes.calorias, wp_mm_nutrientes.proteinas, wp_mm_nutrientes.grasas, wp_mm_nutrientes.saturadas, wp_mm_nutrientes.carbohidratos, wp_mm_nutrientes.azucar, wp_mm_nutrientes.fibra, wp_mm_nutrientes.tamano, wp_mm_nutrientes.codigo FROM $table
  LEFT JOIN $nutrients_table ON $table.ID = $nutrients_table.plato_id
  WHERE ( wp_posts.post_type LIKE 'product_variation')
  AND (wp_posts.post_status LIKE 'publish' OR wp_posts.post_status LIKE 'draft' OR wp_posts.post_status LIKE 'private') ORDER BY ID;";

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
    $product_mm_energia = $product['energia'] ?? 0;
    $product_mm_calorias = $product['calorias'] ?? 0;
    $product_mm_proteinas = $product['proteinas'] ?? 0;
    $product_mm_grasas = $product['grasas'] ?? 0;
    $product_mm_saturadas = $product['saturadas'] ?? 0;
    $product_mm_carbohidratos = $product['carbohidratos'] ?? 0;
    $product_mm_azucar = $product['azucar'] ?? 0;
    $product_mm_fibra = $product['fibra'] ?? 0;
    $product_mm_tamano = $product['tamano'] ?? 'M';
    $product_mm_codigo = $product['codigo'] ?? '1A';


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
            <form id='form_mm_$product_variations_id'>
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Energía</label>
                <input class='form-control' type='number' name='energia' placeholder='Energía' value='$product_mm_energia'/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Calorías</label>
                <input class='form-control' type='number' name='calorias' placeholder='Calorías' value='$product_mm_calorias'/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Proteínas</label>
                <input class='form-control' type='number' name='proteinas' placeholder='Proteínas' value='$product_mm_proteinas'/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Grasas</label>
                <input class='form-control' type='number' name='grasas' placeholder='Grasas' value='$product_mm_grasas'/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Saturadas</label>
                <input class='form-control' type='number' name='saturadas' placeholder='Saturadas' value='$product_mm_saturadas'/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Carbohidratos</label>
                <input class='form-control' type='number' name='carbohidratos' placeholder='Carbohidratos' value='$product_mm_carbohidratos'/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='energia'>Azucar</label>
                <input class='form-control' type='number' name='azucar' placeholder='Azucar' value='$product_mm_azucar'/>
              </div> 
              <div class='form-group col-6'> 
                <label for='energia'>Fibra</label>
                <input class='form-control' type='number' name='fibra' placeholder='Fibra' value='$product_mm_fibra'/>
              </div> 
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <label for='tamano'>Tamaño</label>
                <select class='form-control' name='tamano' placeholder='Tamaño' value='$product_mm_tamano'/>
                  <option>M</option>
                  <option>L</option>
                </select>
              </div>
              <div class='form-group col-6'> 
                <label for='codigo'>Código</label>
                <select class='form-control' name='codigo' placeholder='Código' value='$product_mm_codigo'/>
                  <option>1A</option>
                  <option>2A</option>
                  <option>1B</option>
                  <option>2B</option>
                </select>
              </div>  
            </div> 
            <div class='row'>
              <div class='form-group col-6'> 
                <input class='form-control' type='hidden' name='product_id' value='$product_variations_id'/>
              </div> 
            </div> 
            <div class='d-flex justify-content-end mt-2'>
              <button class='btn btn-primary mm-submit-nutrition_$product_variations_id mm-submit-nutrition' type='submit' value='$product_variations_id'>Guardar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>";
  }
?>