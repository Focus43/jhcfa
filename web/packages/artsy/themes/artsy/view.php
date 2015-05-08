<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $cmsClasses; ?>">
<?php Loader::packageElement('theme/head', \Concrete\Package\Artsy\Controller::PACKAGE_HANDLE); ?>

<body>

    <?php echo $innerContent; ?>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>