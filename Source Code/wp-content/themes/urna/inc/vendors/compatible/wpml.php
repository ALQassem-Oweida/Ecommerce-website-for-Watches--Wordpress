<?php

if (! function_exists('urna_add_language_to_storage_key')) {
    function urna_add_language_to_storage_key( $storage_key )
    {
      global $sitepress;

      return $storage_key . '-' . $sitepress->get_current_language();
    }
}
add_filter( 'urna_storage_key', 'urna_add_language_to_storage_key', 10, 1 );