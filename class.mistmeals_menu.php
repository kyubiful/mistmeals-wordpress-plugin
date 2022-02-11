<?php

Class MistMealsMenu {
  public static function add_mistmeals_to_menu () {
    add_menu_page(
        'MistMeals', // Titulo de la página
        'MistMeals', // Titulo del menú
        'manage_options', // Capability
        plugin_dir_path(__FILE__).'views/view.mistmeals.php', // Slug
        null, // Function del contenido
        plugins_url( 'mistmeals-wordpress-plugin/img/mistmeals_icon.png' ), // Icono
        56, //Priority
    );
  }
}