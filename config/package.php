<?php

return [
  /**
   * Main folder to holds all the packages. Contains packages with VendorName.
   */
  'path' => 'packages',

  /**
   * The VendorName will be generated inside the main folder.
   */
  'vendorName' => "vendor",

  /**
   * These are the folders that will be generated while creating package.
   */
  'folders' => [
      'resources/views', 'routes'
  ],

  /**
   * These are the files that will be generated while creating package.
   */
  'files' => ['routes/web']

];
