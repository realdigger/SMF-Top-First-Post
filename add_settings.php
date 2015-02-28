<?php

global $modSettings, $smcFunc;

$install_request = $smcFunc['db_query']('','
	SELECT * from {db_prefix}settings WHERE variable={string:variable}',
	array(
		'variable' => 'TopFirstPost',
	)
);
if ($smcFunc['db_num_rows']($install_request) == 0) {
   $smcFunc['db_query']('','
      INSERT INTO {db_prefix}settings (variable, value)
      VALUES ({string:variable}, {string:value})',
	      array(
		    'variable' => 'TopFirstPost',
		    'value' => '',
	      )
	);
}
?>