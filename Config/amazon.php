<?php
  /**
   * Get a key and secret from AWS and fill in this content.
   */
  $config = array(
  	'Aws' => array(
  		'key' => Configure::read('Amazonsdk.key'),
  		'secret' => Configure::read('Amazonsdk.secret'),
  		'certificate_authority' => true,  // false by default
    )
  );
?>