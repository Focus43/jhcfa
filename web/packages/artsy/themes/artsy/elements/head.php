<head data-image-path="<?php echo ARTSY_IMAGE_PATH; ?>">
<base href="/" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="google-site-verification" content="CBBLQn2GZkXqX0QOx3KvR6w5UhxzbT-jdVQZAmbUJdo" />
<?php Loader::element('header_required'); // REQUIRED BY C5 // ?>
<?php
    if( ! $this->controller instanceof \Concrete\Package\Artsy\Controller\ArtsyPageController ){
        \Concrete\Package\Artsy\Controller\ArtsyPageController::attachThemeAssets($this->controller);
    }
//echo $html->css($view->getStylesheet('theme.less'));
?>
</head>
