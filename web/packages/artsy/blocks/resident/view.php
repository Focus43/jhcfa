<div class="resident-details">
    <div class="resident-logo">
        <img src="<?php $f = File::getByID((int)$logoFileID); if ($f) { echo $f->getThumbnailURL('file_manager_detail'); }?>" />
    </div>
    <div class="resident-info">
        <address>
            <?php echo !empty($mailingAddress) ? $mailingAddress : ''; ?>
            <?php if( !empty($phone) ): ?>
                <a href="tel:+1<?php echo preg_replace('/\W/', '', $phone) ?>">
                    <abbr title="Phone">P:</abbr> <?php echo $phone ?>
                </a>
            <?php endif; ?>
            <?php if( !empty($email) ): ?>
                <a href="mailto:<?php echo $email ?>">
                    <abbr title="Email">E:</abbr> <?php echo $email ?>
                </a>
            <?php endif; ?>
        </address>
        <?php if( !empty($url) ): ?>
            <a href="<?php echo $url ?>">
                <abbr title="Web">W:</abbr> <?php echo str_replace("http://", "", $url); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
