<?php

define( 'ZERO', 0x00, true );

define( 'INVALID_CONTROLLER',  'Invalid controller requested.', true );
define( 'INVALID_REST',  'Invalid rest requested.', true );
define( 'INVALID_MODEL',  'Invalid model requested.', true );
define( 'INVALID_LIBRARY',  'Invalid library requested.', true );
define( 'INVALID_VIEW',  'Invalid view requested.', true );
define( 'INVALID_HELPER', 'Invalid helper requested.', true );

define( 'INVALID_ATTRIBUTES', 'Invalid Attributed Passed', true );

define( 'CONTROLLER_NOT_EXIST', 'Controller class `%s` has thrown an error.', true );
define( 'REST_NOT_EXIST', 'Rest class `%s` has thrown an error.', true );
define( 'MODEL_NOT_EXIST', 'Model class `%s` has thrown an error.', true );
define( 'LIBRARY_NOT_EXIST', 'Library class `%s` has thrown an error.', true );
define( 'DRIVER_NOT_EXIST', 'Driver class `%s` has thrown an error.', true );


define( 'DRIVER_DB_DIR', '%sdrivers/connection/%s.php', true );
define( 'DRIVER_RES_DIR', '%sdrivers/results/%s.php', true );
define( 'DRIVER_SES_DIR', '%sdrivers/session/%s.php', true );
define( 'DRIVER_CACHE_DIR', '%sdrivers/cache/%s.php', true );

define( 'INVALID_DB_ATTRIBUTES', 'Invalid databse attributes.', true );
define( 'INVALID_DB_DRIVER', 'Invalid driver attribute.', true );
define( 'INVALID_DB_USER', 'Invalid username attribute.', true );
define( 'INVALID_DB_PASS', 'Invalid password attribute.', true );
define( 'INVALID_DB_HOST', 'Invalid hostname attribute.', true );
define( 'INVALID_DB_PORT', 'Invalid port attribute.', true );
define( 'INVALID_DB_DATA', 'Invalid database attribute.', true );
define( 'INVALID_DB_TEST', 'Invalid test attribute.', true );
define( 'INVALID_DB_EXTRAS', 'Invalid extras attribute.', true );

define( 'MYSQLI_NOT_INSTALLED', 'MySQLi is not installed.', true );
define( 'MONGO_DB_NOT_INSTALLED', 'MongoDB is not installed.', true );

define( 'DATABASE_NOT_EXISTS', 'The database specified does not exist.', true );

define( 'INVALID_CACHE_DRIVER', 'Invalid cache attribute.', true );
define( 'INVALID_MEMCACHED', 'Memcached not installed.', true );
define( 'INVALID_MEMCACHE', 'Memcache not installed.', true );
define( 'INVALID_CACHE_HOST', 'Invalid cache hostname attribute.', true );
define( 'INVALID_CACHE_PORT', 'Invalid cache port attribute.', true );

define( 'INVALID_DB_CREDENTIALS', 'Invalid database credentials have been provided.', true );

define( 'RESULT_DEFAULT', 			RESULT_ASSOC, true );

define( 'INVALID_FILE_REQUESTED',	'Invalid file requested.' );

define( 'REGEXP_SIGNED', 			'/^-?[0-9]+$/', true );
define( 'REGEXP_UNSIGNED', 			'/^[0-9]+$/', true );
define( 'REGEXP_ALPHABETIC',		'/^[a-zA-Z]+$/', true );
define( 'REGEXP_ALPHANUMERIC',		'/^[0-9a-zA-Z]+$/', true );
define( 'REGEXP_DECIMAL',			'/^[0-9]+(\.[0-9]+)?$/', true );
define( 'REGEXP_EMAIL',				'/^[a-zA-Z0-9\._%-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z]{2,4}$/', true );
define( 'REGEXP_USERNAME',			'/^[a-zA-Z0-9_-]+$/', true );
define( 'REGEXP_ANYTHING',			'/^.*$/', true );

define( 'VALIDATION_BLANK_FAIL',	0x01, true );
define( 'VALIDATION_MIN_FAIL',		0x02, true );
define( 'VALIDATION_MAX_FAIL',		0x04, true );
define( 'VALIDATION_REGEXP_FAIL',	0x08, true );
define( 'VALIDATION_COMPARE_FAIL',	0x10, true );

define( 'HOUR',							3600, true );
define( 'DAY',								86400, true );

define( 'LIBRARY_PREFIX', '\\n3tw0rk\\phpfeather\\libraries\\', true );
define( 'CACHE_DRIVER_PREFIX', '\\n3tw0rk\\phpfeather\\drivers\\cache\\', true );
define( 'CONNECTION_DRIVER_PREFIX', '\\n3tw0rk\\phpfeather\\drivers\\connection\\', true );
define( 'RESULTS_DRIVER_PREFIX', '\\n3tw0rk\\phpfeather\\drivers\\results\\', true );