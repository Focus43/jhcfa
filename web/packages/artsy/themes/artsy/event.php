<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>

<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <?php $this->inc('elements/nav.php'); ?>

    <main revealing>
        <?php if(!is_object($eventObj)): ?>

            <header class="clearfix">
                <a class="logo">
                    <?php $this->inc('../../images/logo-breakup-small.svg'); ?>
                </a>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1>Event Not Found!</h1>
                        </div>
                    </div>
                </div>
            </header>

            <div class="area-main">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 style="text-align:center;">Sorry, the event you were looking for no longer exists...</h3>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <header class="clearfix">
                <a class="logo" href="/">
                    <?php $this->inc('../../images/logo-breakup-small.svg'); ?>
                </a>
                <?php
                    $blockTypeNav                                   = BlockType::getByHandle('autonav');
                    $blockTypeNav->controller->orderBy              = 'display_asc';
                    $blockTypeNav->controller->displayPages         = 'top';
                    $blockTypeNav->controller->displaySubPages      = 'relevant_breadcrumb';
                    $blockTypeNav->controller->displaySubPageLevels = 'all';
                    $blockTypeNav->render('templates/breadcrumbs');
                ?>
                <div class="pseudo-container">
                    <?php if( !empty($eventThumbnailPath) ){ ?>
                        <div class="event-img" style="background-image:url('<?php echo $eventThumbnailPath; ?>');"></div>
                    <?php }else{ ?>
                        <div class="event-img unavailable">
                            <div class="tabular">
                                <div class="cellular">Image Unavailable :(</div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="headline">
                        <h1><?php echo $eventObj; ?></h1>
                    </div>
                </div>
            </header>

            <div class="pseudo-container">
                <div class="presenter">
                    <div class="hub-node hub-green">
                        <h4>Presented by <span><?php echo $eventObj->getAttribute('presenting_organization'); ?></span></h4>
                        <svg version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">
                            <circle fill="#000" cx="10" cy="10" r="10" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="area-main">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 col-md-8">
                            <?php
                                echo $eventObj->getDescription();
                                /** @var $a \Concrete\Core\Area\Area */
                                $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
                                $a->display($c);
                            ?>
                        </div>
                        <div class="col-sm-5 col-md-4">
                            <?php Loader::packageElement('custom_share_icons', 'artsy'); ?>
                            <div class="sidebar-box">
                                <label>Price &amp; Location</label>
                                <p class="price"><?php echo $eventObj->getAttribute('display_price');?></p>
                                <small><?php echo $eventObj->getAttribute('processing_fee_details'); ?></small>
                                <?php $location = $eventObj->getAttribute('location');
                                if( method_exists($location, '__toString') && !empty($location->__toString()) ){ ?>
                                    <hr/>
                                    <p><?php echo $location; ?></p>
                                <?php } ?>
                            </div>
                            <div class="sidebar-box">
                                <label>Event Time(s)</label>
                                <?php if(empty($first10EventTimes)){ ?>
                                    <p><strong>This event occurred in the past.</strong></p>
                                <?php }else{ ?>
                                    <ul class="event-times list-unstyled">
                                        <?php foreach($first10EventTimes AS $row): ?>
                                            <li>
                                                <?php
                                                $dtObj = new \DateTime($row['computedStartLocal']);
                                                echo sprintf("<strong>%s</strong> - %s", $dtObj->format('g:i A'), $dtObj->format('D M j, Y'));
                                                ?>
                                            </li>
                                        <?php endforeach; ?>
                                        <?php if( !empty($moreEventTimes) ): ?>
                                            <li more-event-times><a>View <?php echo count($moreEventTimes); ?> More <i class="icon-plus"></i></a></li>
                                            <?php foreach($moreEventTimes AS $row): ?>
                                                <li class="more-hidden">
                                                    <?php
                                                    $dtObj = new \DateTime($row['computedStartLocal']);
                                                    echo sprintf("<strong>%s</strong> - %s", $dtObj->format('g:i A'), $dtObj->format('D M j, Y'));
                                                    ?>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <?php if( ! (bool)$eventObj->getAttribute('event_not_ticketed') ): ?>
                                        <a class="btn btn-lg btn-block btn-primary tickets-btn" target="_blank" href="<?php echo $eventObj->getAttribute('ticket_link'); ?>">
                                            Get Tickets
                                        </a>
                                    <?php endif; ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php $this->inc('elements/footer.php'); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>
