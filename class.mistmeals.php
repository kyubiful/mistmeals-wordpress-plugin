<?php

Class MistMeals {
  public static function activation () {

    global $wpdb;

    $table_name = $wpdb->prefix . 'mm_nutrientes';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      `ID` BIGINT UNSIGNED NOT NULL auto_increment,
      `plato_id` BIGINT UNSIGNED NOT NULL UNIQUE ,
      `energia` FLOAT,
      `calorias` FLOAT,
      `proteinas` FLOAT,
      `grasas` FLOAT,
      `saturadas` FLOAT,
      `carbohidratos` FLOAT,
      `azucar` FLOAT,
      `fibra` FLOAT,
      PRIMARY KEY (`ID`),
      FOREIGN KEY (`plato_id`) REFERENCES wp_posts(`ID`)
    );";

    $wpdb->query($sql);

  }

  public static function disable () {

  }
}