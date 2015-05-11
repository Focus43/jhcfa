<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/nav.php'); ?>

    <main>
        <?php
            $this->inc('elements/header.php');
            /** @var $stack \Concrete\Core\Page\Stack\Stack */
            $stack = Stack::getByName(Concrete\Package\Artsy\Controller::STACK_HOMEPAGE_VIDEO); // Should only contain one block, being the video
            if( is_object($stack) ){
                $stack->display();
            }
        ?>
        <section class="sxn-1">
            <div class="tabular">
                <div class="cellular">
                    <svg svgize></svg>
                </div>
            </div>
        </section>

        <section class="sxn-3">
            <div class="tabular">
                <div class="cellular">
                    <div class="container-fluid" style="max-width:1300px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                    /** @var $a \Concrete\Core\Area\Area */
                                    $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
                                    $a->display($c);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sxn-2">
            <div class="tabular">
                <div class="cellular">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1>The Center is home to over 20 <a href="">residents</a>, providing a wide array of expertise in different artistic endeavors.</h1>
                            </div>
                        </div>
                        <!--<div class="row">
                            <div class="col-sm-4">
                                <a class="feature">
                                    <div class="circ" style="background-image:url('/packages/artsy/images/_scratch/hoot2.jpg');"></div>
                                    <span>Events</span>
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <a class="feature">
                                    <div class="circ" style="background-image:url('/packages/artsy/images/_scratch/hornsby.jpg');"></div>
                                    <span>Classes</span>
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <a class="feature">
                                    <div class="circ" style="background-image:url('/packages/artsy/images/_scratch/emmylou.jpg');"></div>
                                    <span>Exhibits</span>
                                </a>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </section>

        <?php $this->inc('elements/footer.php', array('logowhite' => true)); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>