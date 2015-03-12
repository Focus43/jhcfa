<?php namespace Concrete\Package\Artsy\Block\PhotoWall\Toools;
defined('C5_EXECUTE') or die("Access Denied.");
use FileSet;

    /** @var $fileSetObj \Concrete\Core\File\Set\Set */
    $fileSetObj = FileSet::getByID((int) $_REQUEST['fsID']);

    if( is_object($fileSetObj) ){
        $filesInSet = $fileSetObj->getFiles();
        if(!empty($filesInSet)): foreach($filesInSet AS $fileObj): /** @var $fileObj \Concrete\Core\File\File */
            echo '<div class="node" style="background-image:url(\''.$fileObj->getThumbnailURL('file_manager_listing').'\');"></div>';
        endforeach; endif;
    }
