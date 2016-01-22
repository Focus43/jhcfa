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
            'vagrant-ubuntu-vivid-64'
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
 * Override Concrete5's config persistence method.
 */
\Application\Src\Config\Ephemeral::bindToApp($app);

return $app;