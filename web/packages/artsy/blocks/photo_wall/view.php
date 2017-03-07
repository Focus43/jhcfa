<div class="aligned-grid">
    <?php foreach( (array)$fileListResults AS $fileObj ){
        if( is_object($fileObj) ){
            $imgPath = $fileObj->getThumbnailURL('file_manager_detail');
            $pageObj = Page::getByID( $fileObj->getAttribute('link') );
            // var_dump( $pageObj );
            $link = '';
            if( is_object($pageObj) && $pageObj->getCollectionID() >= 1 ){
                $link = sprintf('href="%s"', $pageObj->getCollectionPath());
            }
            if( is_object($pageObj) && $pageObj->isExternalLink() ){
                $link = sprintf('href="%s"', $pageObj->getCollectionPointerExternalLink());
            }
    ?>
            <a class="item" <?php echo $link; ?> style="background-image:url('<?php echo $imgPath; ?>');">
                <img src="<?php echo $imgPath; ?>" />
            </a>
    <?php } } ?>
</div>