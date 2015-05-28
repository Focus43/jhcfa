<div masonry class="supporters">
    <?php foreach((array)$fileListResults AS $fileObj): ?>
        <div node>
            <div nest>
                <div nester style="background-image:url(<?php echo $fileObj->getThumbnailURL('event_thumb'); ?>);">
                    <span class="title"><?php echo $fileObj->getTitle(); ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>