<div class="resident-logo-list">
    <?php foreach((array)$fileListResults AS $fileObj): if( is_object($fileObj) ){
        $pageObj = Page::getByID($fileObj->getAttribute('link'));
        if( is_object($pageObj) ){
            $link = $pageObj->getCollectionPath();
        } ?>

        <a class="resident-item" href="<?php echo $link; ?>">
            <div class="res-logo" style="background-image:url('<?php echo $fileObj->getThumbnailURL('file_manager_detail');  ?>');"></div>
            <!--<span><?php echo $fileObj->getTitle(); ?></span>-->
        </a>

    <?php } endforeach; ?>
</div>
