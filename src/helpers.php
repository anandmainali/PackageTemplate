<?php

/**
 * Create Folder if not exist
 *
 */
function createFolder($path, $folder_name)
{
  mkdir($path . $folder_name, 0777, true);
  return $path . $folder_name;
}

/**
 * Create Files if not exist
 *
 */
function createFile($path, $file_name)
{
  $file = fopen($path . $file_name . '.php', 'w');
  fclose($file);
  return $path . $file_name . '.php';
}

/**
 * Create Files name with CamelCase
 *
 */
function getCamelCaseName($name)
{
  $name = ucwords($name, '\ \_\-');
  return str_replace([' ', '_', '-'], '', $name);
}
