<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

    <?php echo $innerContent; ?>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>