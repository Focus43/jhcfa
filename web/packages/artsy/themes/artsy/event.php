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

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12" style="position:relative;">
                        <?php
                        /** @var $fileObj \Concrete\Core\File\File */
                        $fileID = $eventObj->getFileID();
                        if( !empty($fileID) ){
                            $fileObj = File::getByID($eventObj->getFileID());
                        }
                        if( is_object($fileObj) ){ ?>
                            <img class="pull-left" event-img src="<?php echo $fileObj->getRelativePath(); ?>" />
                        <?php } ?>
                        <div style="padding-left:350px;text-align:left;padding-bottom:6%;">
                            <h2><?php echo $eventObj; ?></h2>
                            <p>Presented by <a><?php echo $eventObj->getAttribute('presenting_organization'); ?></a></p>
                        </div>
                    </div>
                </div>

                <!--<div class="row">
                    <div class="col-sm-12">
                        <h1><?php echo $eventObj; ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6 event-info">
                        <div class="event-info-inner">
                            <?php
                                /** @var $fileObj \Concrete\Core\File\File */
                                $fileID = $eventObj->getFileID();
                                if( !empty($fileID) ){
                                    $fileObj = File::getByID($eventObj->getFileID());
                                }
                                if( is_object($fileObj) ){ ?>
                                    <img event-img src="<?php echo $fileObj->getRelativePath(); ?>" />
                                <?php } ?>
                            <p>Presented by <a><?php echo $eventObj->getAttribute('presenting_organization'); ?></a></p>
                        </div>
                    </div>
                </div>-->

            </div>
        </header>

        <div class="area-main">
            <div class="container">
                <div class="col-sm-9">
                    <?php
                        echo $eventObj->getDescription();
                        /** @var $a \Concrete\Core\Area\Area */
//                        $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
//                        $a->display($c);
                    ?>
                </div>
                <div class="col-sm-3">
                    <div style="background:#e1e1e1;margin-bottom:1rem;padding:0.5rem;">
                        <?php
                        $ticketPrice = (int)$eventObj->getAttribute('ticket_price');
                        if( $ticketPrice > 0 ){ ?>
                            <p><strong>$<?php echo $ticketPrice; ?></strong><br/> (includes processing fee)</p>
                        <?php }else{ ?>
                            <p>This is a <strong>free</strong> event.</p>
                        <?php }?>
                    </div>
                    <p><strong>Times</strong></p>
                    <ul class="list-unstyled">
                        <?php foreach($eventTimes AS $row): ?>
                            <li><?php echo (new \DateTime($row['computedStartLocal']))->format('g:i a (n/j/y)'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="btn btn-lg btn-block btn-primary" target="_blank" href="<?php echo $eventObj->getAttribute('ticket_link'); ?>">Buy Tickets</a>
                </div>
            </div>

        </div>

        <?php $this->inc('elements/footer.php'); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>