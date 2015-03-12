<?php foreach((array)$fileListResults AS $fileObj): ?>
    <img src="<?php echo $fileObj->getRelativePath(); ?>" style="max-width:600px;max-height:425px;" />
<?php endforeach; ?>