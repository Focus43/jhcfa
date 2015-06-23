<? defined('C5_EXECUTE') or die("Access Denied.");
$posterFileObj = $this->controller->getPosterFileObject();
if( is_object($posterFileObj) ){
    $posterURL = $posterFileObj->getRelativePath();
} ?>

<style type="text/css">
<?php if( ! Page::getCurrentPage()->isEditMode() ){ ?>
    .video-fs {position:fixed;top:0;left:0;width:100%;height:100%;z-index:-100;overflow:hidden;background-size:cover;background-position:50% 50%;background-repeat:no-repeat;}
    .video-fs::after {background:rgba(35,25,32, 0.3);content:'';display:block;position:fixed;top:0;left:0;right:0;bottom:0;width:100%;height:100%;}
    .video-fs video {display:none;visibility:hidden;}
    @media screen and (min-width:768px){
        .video-fs video {display:block;visibility:visible;position:fixed;top:0;left:50%;min-width:100%;min-height:100%;width:auto;height:auto;-moz-transform:translateX(-50%);-webkit-transform:translateX(-50%);transform:translateX(-50%);}
        html.touch .video-fs video {display:none;visibility:hidden;}
    }
<?php }else{ ?>
    .video-fs video {max-width:100%;height:auto;max-height:none;width:auto;}
<?php } ?>
</style>

<div revealing class="video-fs" style="background-image:url('<?php echo $posterURL; ?>');">
    <video autoplay loop<?php echo $posterURL ? ' poster="'.$posterURL.'"' : '' ?>>
        <?php if($webmURL): ?>
            <source src="<?php echo $webmURL ?>" type="video/webm" />
        <?php endif; ?>
        <?php if($mp4URL): ?>
            <source src="<?php echo $mp4URL ?>" type="video/mp4" />
        <?php endif; ?>
    </video>
</div>