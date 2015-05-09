<div class="resident-details">
    <div class="resident-logo"><?php $f = File::getByID((int)$logoFileID); if ($f) { echo $f->getListingThumbnailImage(); }?></div>
    <div class="resident-info">
        <a href="tel:+1<?php echo preg_replace('/\W/', '', $phone) ?>"><span class="icon-phone"></span>&nbsp;<?php echo $phone ?></a><br>
        <a href="mailto:<?php echo $email ?>"><span class="icon-paperplane"></span>&nbsp;<?php echo $email ?></a><br>
        <a href="<?php echo $url ?>"><span class="icon-world"></span>&nbsp;<?php echo str_replace("http://", "", $url); ?></a><br><br>
        <span><?php echo $mailingAddress ?></span>
    </div>
</div>
