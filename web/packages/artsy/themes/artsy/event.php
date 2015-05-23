<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <?php $this->inc('elements/nav.php'); ?>

    <main revealing>
        <?php if(!is_object($eventObj)): ?>

            <header style="background:#d1d1d1;">
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
                            <h3>Sorry, the event you were looking for no longer exists...</h3>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <header>
                <a class="logo">
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
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
                                <div class="headline-inner">
                                    <h1><?php echo $eventObj; ?></h1>
                                    <div class="presenter">
                                        <i class="icon-circle"></i>
                                        <span>Presented by <a><?php echo $eventObj->getAttribute('presenting_organization'); ?></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="area-main">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 col-md-8">
                            <?php
                            echo $eventObj->getDescription();
                            /** @var $a \Concrete\Core\Area\Area */
                            //                        $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
                            //                        $a->display($c);
                            ?>
                        </div>
                        <div class="col-sm-5 col-md-4">
                            <div class="sidebar-box">
                                <label>Price</label>
                                <?php $ticketPrice = (int)$eventObj->getAttribute('ticket_price');
                                if( $ticketPrice > 0 ){ ?>
                                    <p class="price">$<?php echo $ticketPrice; ?></p>
                                    <small>(includes processing fee)</small>
                                <?php }else{ ?>
                                    <p class="price">Free</p>
                                <?php }?>
                            </div>
                            <div class="sidebar-box">
                                <label>Event Time(s)</label>
                                <ul class="event-times list-unstyled">
                                    <?php foreach($eventTimes AS $row): ?>
                                        <li>
                                            <?php
                                            $dtObj = new \DateTime($row['computedStartLocal']);
                                            echo sprintf("%s - <strong>%s</strong>", $dtObj->format('D M j, Y'), $dtObj->format('g:i A'));
                                            ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <a class="btn btn-lg btn-block btn-primary tickets-btn" target="_blank" href="<?php echo $eventObj->getAttribute('ticket_link'); ?>">Get Tickets</a>
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