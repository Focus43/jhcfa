<? defined('C5_EXECUTE') or die("Access Denied.");
if( Page::getCurrentPage()->isEditMode() ){ ?>
<style type="text/css">
    video {max-width:100%;height:auto;max-height:auto;}
</style>
<?php } ?>


<video class="fullscreen" autoplay loop style="background-image:url('<?php echo $posterURL; ?>');"> <?php //echo $posterURL ? ' poster="'.$posterURL.'"' : ''; ?>
    <?php if($webmURL): ?>
        <source src="<?php echo $webmURL ?>" type="video/webm" />
    <?php endif; ?>
    <?php if($mp4URL): ?>
        <source src="<?php echo $mp4URL ?>" type="video/mp4" />
    <?php endif; ?>
</video>