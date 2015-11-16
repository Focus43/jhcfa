<div class="aligned-grid">
    <?php foreach((array)$fileListResults AS $fileObj){ if( is_object($fileObj) ){
        $imgPath = $fileObj->getThumbnailURL('file_manager_detail');
        ?>
        <a class="item" href="<?php echo $fileObj->getForceDownloadURL(); ?>" style="background-image:url('<?php echo $imgPath; ?>');">
            <img src="<?php echo $imgPath; ?>" />
        </a>
    <?php } } ?>
</div>