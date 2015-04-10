<?php
    /** @var $eventListObj \Concrete\Package\Schedulizer\Src\EventList */
    $resultsGroupedByDay = $eventListObj->getGroupedByDay();
    if( empty($resultsGroupedByDay) ){
        echo 'No events available'; return;
    }
?>

<div id="schedulizer-list-<?php echo $this->controller->bID; ?>" calendar>
    <div calendar-header>
        <h1>Current &amp; Coming Up @ The Center</h1>
        <ul class="list-inline">
            <li><a class="btn btn-transparent btn-lg">Events</a></li>
            <li><a class="btn btn-transparent btn-lg">Classes</a></li>
            <li><a class="btn btn-transparent btn-lg">Exhibits</a></li>
        </ul>
    </div>
    <div calendar-body>
        <?php foreach($resultsGroupedByDay AS $dateKey => $items): ?>
            <div column>
                <h5><?php echo (new \DateTime($dateKey))->format('M d, Y'); ?></h5>
                <ul>
                    <?php foreach($items AS $row){ ?>
                        <li event="<?php echo $row['eventID'] ?>"<?php if($row['fileID']){ echo sprintf(' style="background-image:url(\'%s\');"', \Concrete\Core\File\File::getRelativePathFromID($row['fileID'])); } ?>>
                            <a><?php echo $row['title']; ?><span><?php echo (new \DateTime($row['startLocal']))->format('g:i a'); ?></span></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>