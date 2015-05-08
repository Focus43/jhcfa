<?php
$count = 0;

foreach((array)$fileListResults AS $fileObj):
    $fileVersionObj = $fileObj->getApprovedVersion();
    $linkToPageObj  = Page::getByID($fileObj->getAttribute('link'));
    if( is_object($linkToPageObj) ){
        $link = $linkToPageObj->getCollectionPath();
    }
    if($count === 0){
        echo "\n" . '<div class="row">' . "\n";
    }
    ?>
    <div class="col-xs-6 col-sm-3">
        <a class="resident-list" href="<?php echo $link; ?>">
            <div class="circ">
                <img src="<?php echo $fileObj->getRelativePath();  ?>" />
            </div>
            <span><?php echo $fileVersionObj->getTitle(); ?></span>
        </a>
    </div>
    <?php
    $count = $count < 4 ? $count + 1 : 0;
    if( $count === 4 ){echo "\n" . '</div>' . "\n"; $count = 0;}
endforeach;

// final </div>
if( $count > 0 ){
    echo '</div>';
}