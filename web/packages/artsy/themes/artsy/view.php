<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/nav.php'); ?>

    <main>
        <?php $this->inc('elements/header.php', array(
            'expanded'          => true,
            'mastheadImageSrc'  => $mastheadHelper->getSingleImageSrc()
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