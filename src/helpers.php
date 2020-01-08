<?php
/**
* Create Folder if not exist
*
*/
function createFolder($path, $folder_name)
{
mkdir($path . $folder_name, 0777, true);
return $path.$folder_name;
}

/**
* Create Files if not exist
*
* @param string $folder_name
*/
function createFile($path, $file_name)
{
$file = fopen($path . $file_name . '.php', 'w');
fclose($file);
return $path . $file_name . '.php';
}
