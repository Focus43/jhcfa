<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-9">
            <div class="post-results">
                <?php foreach($pageResults AS $page): /** @var $page \Concrete\Core\Page\Page */
                    $title      = $textHelper->entities($page->getCollectionName());
                    $descr      = $textHelper->wordSafeShortText($page->getCollectionDescription(), 255);
                    $descr      = $textHelper->entities($descr);
                    $dateObj    = new \DateTime($page->getCollectionDatePublic());
                    $url        = $navHelper->getLinkToCollection($page);
                    $tags       = $page->getAttribute('tags');
                    $pageImage  = $page->getAttribute('page_image');
                    if( $pageImage instanceof \Concrete\Core\File\File ){
                        $pageImageSRC = $pageImage->getThumbnailURL('event_image');
                    }
                    ?>
                    <article class="blog-post">
                        <a href="<?php echo $url; ?>">
                            <div class="page-img" style="background-image:url('<?php echo $pageImageSRC; ?>');"></div>
                            <div class="content">
                                <div date>
                                    <span ordinal><?php echo $dateObj->format('D, M d'); ?></span>
                                    <span year><?php echo $dateObj->format('Y'); ?></span>
                                </div>
                                <h3><?php echo $title; ?></h3>
                                <p><?php echo $descr; ?></p>
                                <label tags>
                                    <?php if(!empty($tags)): foreach($tags AS $optTag): ?>
                                        <span class="tag-item dark"><?php echo $optTag; ?></span>
                                    <?php endforeach; else: echo '<i>None</i>'; endif; ?>
                                </label>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php echo $paginationView; ?>
        </div>
        <div class="col-sm-4 col-md-3">
            <?php Loader::packageElement('tag_list', 'artsy', array('selectedTag' => $selectedTag)); ?>
        </div>
    </div>
</div>