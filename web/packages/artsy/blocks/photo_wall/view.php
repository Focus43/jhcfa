<div masonry>
    <?php foreach((array)$fileListResults AS $fileObj): ?>
        <div node>
            <div nest>
                <div nester style="background-image:url(<?php echo $fileObj->getThumbnailURL('event_thumb'); ?>);"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>