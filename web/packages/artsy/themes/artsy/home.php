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
                    <?php $a = new Area('Main'); $a->display($c); ?>
                    <div class="intro-text">
                        <div class="tagline">
                            <span class="top">We are a</span>
                            <span class="mid">Hub</span>
                            <span class="bot">for the artistic, cultural and creative activity in jackson hole</span>
                        </div>
                        <b><i class="icon-angle-down"></i></b>
                    </div>
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
                                <!--<div calendar>
                                    <div calendar-header>
                                        <h1>Current &amp; Coming Up @ The Center</h1>
                                        <ul class="list-inline">
                                            <li><a class="btn btn-transparent btn-lg">Events</a></li>
                                            <li><a class="btn btn-transparent btn-lg">Classes</a></li>
                                            <li><a class="btn btn-transparent btn-lg">Exhibits</a></li>
                                        </ul>
                                    </div>
                                    <div calendar-body>
                                        <div column>
                                            <h5>Mon 1/12</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');">
                                                    <a>Bruce Hornsby<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div column>
                                            <h5>Tue 1/13</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                            </ul>
                                        </div>
                                        <div column>
                                            <h5>Wed 1/14</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                            </ul>
                                        </div>
                                        <div column>
                                            <h5>Thu 1/15</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                            </ul>
                                        </div>
                                        <div column>
                                            <h5>Fri 1/16</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                            </ul>
                                        </div>
                                        <div column>
                                            <h5>Sat 1/17</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                            </ul>
                                        </div>
                                        <div column>
                                            <h5>Sun 1/18</h5>
                                            <ul>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/emmylou.jpg');"><a>EmmyLou Harris<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hoot.jpg');"><a>EmmyLou Harris<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>w/ Dan Ackroyd : 7:30 PM : Main Room : $35</span></a></li>
                                                <li style="background-image:url('<?php echo ARTSY_IMAGE_PATH; ?>_scratch/hornsby.jpg');"><a>Bruce Hornsby<span>And The Range : 9:00 PM : Tickets Available 4/17/15</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>-->
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
                        <div class="row">
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
                        </div>
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