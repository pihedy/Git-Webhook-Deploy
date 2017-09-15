<?php

/* NOTE: Public dir */
define('DP_PATH', __DIR__);

/* NOTE: Project root */
define('DP_PATH_ROOT', DP_PATH . '/..');

/* NOTE: App resource dir */
define('DP_PATH_SRC', DP_PATH_ROOT . '/src');

/* NOTE: The App Soul! */
define('DP_PATH_APP', DP_PATH_SRC . '/app');

require_once DP_PATH_APP . '/app.php';
