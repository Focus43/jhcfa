<div class="staff-list">
    <?php foreach((array)$fileListResults AS $fileObj): ?>
        <div class="staff-member" style="background-image:url('<?php echo $fileObj->getThumbnailURL('event_thumb'); ?>');">
            <span class="details">
                <span class="name"><?php echo $fileObj->getTitle(); ?></span>
                <span class="descr"><?php echo $fileObj->getDescription(); ?></span>
            </span>
            <a class="mail" href="mailto:loremipsum@test.com"><i class="icon-mail2"></i></a>
        </div>
    <?php endforeach; ?>
</div>