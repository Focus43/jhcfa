<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/nav.php'); ?>

    <main revealing>
        <?php
        $mastheadImg = $mastheadHelper->getSingleImageSrc();
        $this->inc('elements/header.php', array(
            'expanded'              => true,
            'mastheadImageSrc'      => $mastheadImg->src,
            'mastheadImageCredit'   => $mastheadImg->credit
        )); ?>

        <div class="area-main">
            <?php
                /** @var $a \Concrete\Core\Area\Area */
                $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
                $a->enableGridContainer();
                //$a->setAreaGridMaximumColumns(12);
                $a->display($c);
            ?>
        </div>

        <?php $this->inc('elements/footer.php'); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>