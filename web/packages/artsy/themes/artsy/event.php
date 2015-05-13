<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">
    <?php $this->inc('elements/nav.php'); ?>

    <main>
        <?php $mastheadImageSrc = $mastheadHelper->getSingleImageSrc(); ?>
        <header<?php if(!empty($mastheadImageSrc)){echo ' style="background-image:url('.$mastheadImageSrc.');"';} ?>>
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
            <div class="tabular">
                <div class="cellular">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                /** @var $fileObj \Concrete\Core\File\File */
                                $fileID = $eventObj->getFileID();
                                if( !empty($fileID) ){
                                    $fileObj = File::getByID($eventObj->getFileID());
                                }
                                if( is_object($fileObj) ){ ?>
                                    <img event-img src="<?php echo $fileObj->getRelativePath(); ?>" />
                                <?php } ?>
                                <!--                        <div style="padding-left:350px;text-align:left;padding-bottom:6%;">-->
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
                </div>
            </div>
        </header>

        <div class="area-main">
            <div class="container">
                <div class="col-sm-8">
                    <?php
                        echo $eventObj->getDescription();
                        /** @var $a \Concrete\Core\Area\Area */
//                        $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
//                        $a->display($c);
                    ?>
                </div>
                <div class="col-sm-4">
                    <div class="sidebar-box">
                        <label>Price</label>
                        <?php $ticketPrice = (int)$eventObj->getAttribute('ticket_price');
                        if( $ticketPrice > 0 ){ ?>
                            <p class="price">$<?php echo $ticketPrice; ?></p>
                            <small>(includes processing fee)</small>
                        <?php }else{ ?>
                            <p>This is a <strong>free</strong> event.</p>
                        <?php }?>
                    </div>
                    <div class="sidebar-box">
                        <label>Event Time(s)</label>
                        <ul class="list-unstyled">
                            <?php foreach($eventTimes AS $row): ?>
                                <li>
                                    <?php
                                        $dtObj = new \DateTime($row['computedStartLocal']);
                                        echo sprintf("%s - <strong>%s</strong>", $dtObj->format('M j, Y'), $dtObj->format('g:i A'));
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="btn btn-lg btn-block btn-primary" target="_blank" href="<?php echo $eventObj->getAttribute('ticket_link'); ?>">Buy Tickets</a>
                    </div>
                </div>
            </div>

        </div>

        <?php $this->inc('elements/footer.php'); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>