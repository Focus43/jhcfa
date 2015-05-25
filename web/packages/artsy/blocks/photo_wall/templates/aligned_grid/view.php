<div class="aligned-grid">
    <?php foreach((array)$fileListResults AS $fileObj){ if( is_object($fileObj) ){
        $imgPath = $fileObj->getThumbnailURL('file_manager_detail');
        ?>
        <div class="item" style="background-image:url('<?php echo $imgPath; ?>');">
            <img src="<?php echo $imgPath; ?>" />
        </div>
    <?php } } ?>
</div>