<?php

if (!function_exists('createFolder')) {
  /**
   * Create Folder if not exist
   *
   */
  function createFolder($path, $folder_name)
  {
      if(!file_exists($path.'/'.$folder_name)) {
          mkdir($path . $folder_name, 0777, true);
          return $path . $folder_name;
      }
      return false;
  }
}

if (!function_exists('createFile')) {
  /**
   * Create Files if not exist
   *
   */
  function createFile($path, $file_name)
  {
      if(!file_exists($path.'/'.$file_name)) {
          $file = fopen($path . $file_name . '.php', 'w');
          fclose($file);
          return $path . $file_name . '.php';
      }
      return false;
  }
}

if (!function_exists('getCamelCaseName')) {
  /**
   * Create Files name with CamelCase
   *
   */
  function getCamelCaseName($name)
  {
    $name = ucwords($name, '\ \_\-');
    return str_replace([' ', '_', '-'], '', $name);
  }
}
