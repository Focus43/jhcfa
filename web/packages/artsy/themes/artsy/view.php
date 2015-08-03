<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>" data-handle="<?php echo Page::getCurrentPage()->getCollectionHandle(); ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/nav.php'); ?>

    <main revealing>
        <?php
        if( is_object($mastheadHelper) ){
            $mastheadImg = $mastheadHelper->getSingleImageSrc();
            if( is_array($mastheadImg) ){
                $mastheadSrc = $mastheadImg->src;
                $mastheadCredit = $mastheadImg->credit;
            }
        }

        $this->inc('elements/header.php', array(
            'expanded'          => true,
            'titleOverride'     => $titleOverride ? !empty($titleOverride) : false,
            // @todo: good default image, and auto-include theme assets not via contoller methods
            'mastheadImageSrc'      => $mastheadImg->src,
            'mastheadImageCredit'   => $mastheadImg->credit
        )); ?>

        <div class="area-main">
            <?php echo $innerContent; ?>
        </div>

        <?php $this->inc('elements/footer.php'); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>