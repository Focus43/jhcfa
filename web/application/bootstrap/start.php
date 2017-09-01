<?php

use Concrete\Core\Application\Application;

/**
 * ----------------------------------------------------------------------------
 * Instantiate concrete5
 * ----------------------------------------------------------------------------
 */
$app = new Application();


/**
 * ----------------------------------------------------------------------------
 * Detect the environment based on the hostname of the server
 * ----------------------------------------------------------------------------
 */
$app->detectEnvironment(
    array(
        'local' => array(
            'dockerlocal'
        ),
        'stage' => array(
            'stage01.focusfortythree.com'
        ),
        'production' => array(
            'prod01.focusfortythree.com'
        )
    )
);

/**
* Sam disabled 01/27/16
 * Override Concrete5's config persistence method.
 */
// \Application\Src\Config\Ephemeral::bindToApp($app);

return $app;