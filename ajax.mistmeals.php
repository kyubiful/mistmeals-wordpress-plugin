<?php

Class MistMealsAjax {
  public static function mm_form_ajax() {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $table = $prefix . 'mm_nutrientes';
    $post_product_id = $_POST['product_id'];

    $query = "SELECT ID FROM $table WHERE ID LIKE $post_product_id";

    $queryResult = $wpdb->get_results($query, ARRAY_A);

    $plato_id = $_POST['product_id'];
    $plato_energia = $_POST['energia'];
    $plato_calorias = $_POST['calorias'];
    $plato_proteinas = $_POST['proteinas'];
    $plato_grasas = $_POST['grasas'];
    $plato_saturadas = $_POST['saturadas'];
    $plato_carbohidratos = $_POST['carbohidratos'];
    $plato_azucar = $_POST['azucar'];
    $plato_fibra = $_POST['fibra'];

    if($queryResult != []) {
      $query = "INSERT INTO $table (plato_id,energia,calorias,proteinas,grasas,saturadas,carbohidratos,azucar,fibra) VALUES ($plato_id, $plato_energia, $plato_calorias, $plato_proteinas, $plato_grasas, $plato_saturadas, $plato_carbohidratos, $plato_azucar, $plato_fibra)";
      $wpdb->query($query);
    } else {
      $query = "UPDATE $table SET (
        energia = $plato_energia, 
        calorias = $plato_calorias,
        proteinas = $plato_proteinas,
        grasas = $plato_grasas, 
        saturadas = $plato_saturadas, 
        carbohidratos = $plato_carbohidratos, 
        azucar = $plato_azucar, 
        fibra = $plato_fibra
      ) WHERE plato_id = $plato_id";
      $wpdb->query($query);
    }

    print_r($_POST);

    // print_r($_POST);
    die();
  }

}