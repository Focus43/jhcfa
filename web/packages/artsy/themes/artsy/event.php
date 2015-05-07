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
                    <div class="col-sm-12">
                        <h1><?php echo $eventObj; ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6 event-info">
                        <div class="event-info-inner">
                            <?php
                                /** @var $fileObj \Concrete\Core\File\File */
                                $fileObj = File::getByID($eventObj->getFileID());
                                if( is_object($fileObj) ){ ?>
                                    <img event-img src="<?php echo $fileObj->getRelativePath(); ?>" />
                                <?php } ?>
                            <p>Presented by <a><?php echo $calendarObj->getTitle(); ?></a></p>
                            <p>May 8, 2015 - May 9, 2015<br/>8:00 - 10:00 pm</p>
<!--                            <p><br/><br/></p>-->
                        </div>
                    </div>
                </div>
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
                    <p><strong>General Admission</strong><br/>$10 (includes processing fee)</p>
                    <p><strong>Show Times</strong></p>
                    <ul>
                        <?php foreach($eventTimes AS $row): ?>
                            <li><?php echo (new \DateTime($row['computedStartLocal']))->format('g:i a (n/j/y)'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a class="btn btn-lg btn-block btn-primary">Buy Tickets</a>
                </div>
            </div>

        </div>

        <?php $this->inc('elements/footer.php'); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>