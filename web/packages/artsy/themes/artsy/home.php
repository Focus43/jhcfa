<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<?php
    /** @var $stack \Concrete\Core\Page\Stack\Stack */
    $stack = Stack::getByName(Concrete\Package\Artsy\Controller::STACK_HOMEPAGE_VIDEO); // Should only contain one block, being the video
    if( is_object($stack) ){
        $stack->display();
    }
?>

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/nav.php'); ?>

    <main revealing>
        <a class="logo" href="/">
            <?php $this->inc('../../images/logo-breakup-small.svg'); ?>
        </a>

        <div scroll-navs>
            <span><i class="icon-circle"></i></span>
            <span><i class="icon-circle"></i></span>
            <span><i class="icon-circle"></i></span>
        </div>

        <section class="intro">
            <div class="tabular">
                <div class="cellular">
<!--                    <svg spoke-to=".svg-circle" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20" style="position:absolute;top:20%;left:20%;">-->
<!--                        <circle fill="#000" cx="10" cy="10" r="10" />-->
<!--                    </svg>-->
<!---->
<!--                    <svg spoke-to=".svg-circle" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20" style="position:absolute;top:20%;left:50%;">-->
<!--                        <circle fill="#000" cx="10" cy="10" r="10" />-->
<!--                    </svg>-->
<!---->
<!--                    <svg spoke-to=".svg-circle" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20" style="position:absolute;top:90%;left:90%;">-->
<!--                        <circle fill="#000" cx="10" cy="10" r="10" />-->
<!--                    </svg>-->

                    <div class="tagline">
                        <div class="tabular">
                            <div class="cellular">
                                <div class="text">
                                    <span>We Are A</span>
                                    <span>Hub</span>
                                    <span>For the Artistic, Cultural And</span>
                                    <span>Creative Activity In Jackson Hole</span>
                                    <svg class="svg-circle" spoke-to=".svg-logo" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">
                                        <circle fill="#000" cx="10" cy="10" r="10" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-events" ng-controller="CtrlFeaturedEvents">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div style="display:inline-block;">
                            <span class="hubber" style="display:inline-block;position:relative;top:-10px;left:8px;">
                                <i class="icon-circle" style="color:#000;font-size:130px;"></i>
                            </span>
                            <h2 style="margin-bottom:2rem;position:absolute;z-index:1;top:13px;left:50%;transform:translateX(-50%);">Upcoming Events</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="clearfix" event-list="eventData" ng-cloak>
                            <a class="event" href="{{eventObj.pagePath}}" ng-style="{backgroundImage:'url({{eventObj.filePath}})'}">
                                <div class="inner">
                                    <div class="tabular">
                                        <div class="cellular">
                                            <span class="title">{{ eventObj.title }}</span>
                                            <span class="date">{{ eventObj.date_display }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="/calendar" class="btn btn-primary view-all pull-right">View All Events <i class="icon-angle-right-circle"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="homepage-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        /** @var $a \Concrete\Core\Area\Area */
                        $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN_2);
                        $a->display($c);
                        ?>
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