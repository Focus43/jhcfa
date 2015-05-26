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

    <div class="scroll-navs">
<!--        <span class="hub-node marker-1">-->
<!--            <svg spoke-to=".marker-2" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">-->
<!--                <circle fill="#000" cx="10" cy="10" r="10" />-->
<!--            </svg>-->
<!--        </span>-->
<!--        <span class="hub-node marker-2">-->
<!--            <svg spoke-to=".marker-3" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">-->
<!--                <circle fill="#000" cx="10" cy="10" r="10" />-->
<!--            </svg>-->
<!--        </span>-->
<!--        <span class="hub-node marker-3">-->
<!--            <svg version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">-->
<!--                <circle fill="#000" cx="10" cy="10" r="10" />-->
<!--            </svg>-->
<!--        </span>-->
        <span class="active" scroll-to=".intro"><i class="icon-circle"></i></span>
        <span scroll-to=".featured-events"><i class="icon-circle"></i></span>
        <span scroll-to=".homepage-content"><i class="icon-circle"></i></span>
    </div>

    <main revealing>
        <a class="logo" href="/">
            <svg spoke-to=".svg-tagline-hub" class="svg-logo" x="0px" y="0px" width="305.032px" height="75.403px" viewBox="0 0 305.032 75.403" style="enable-background:new 0 0 305.032 75.403;" xml:space="preserve">
                <g class="logo-stroke">
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M103.308,21.457v5.49h-7.245v26.999h-6.21V26.947h-7.245v-5.49
                H103.308z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M105.199,53.945V21.457h6.21v12.959h8.774V21.457h6.21v32.488
                h-6.21V39.906h-8.774v14.039H105.199z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M130.174,53.945V21.457h17.009v5.49h-10.799v7.47h8.234v5.49
                h-8.234v8.55h11.249v5.489H130.174z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M168.694,44.316c0,3.6,1.574,4.59,4.05,4.59
                c2.475,0,4.05-0.99,4.05-4.59v-2.16h6.21v1.35c0,8.01-4.23,10.89-10.26,10.89c-6.03,0-10.26-2.88-10.26-10.89V31.896
                c0-8.009,4.229-10.889,10.26-10.889c6.029,0,10.26,2.88,10.26,10.889v0.09h-6.21v-0.9c0-3.6-1.575-4.59-4.05-4.59
                c-2.476,0-4.05,0.99-4.05,4.59V44.316z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M188.044,53.945V21.457h17.009v5.49h-10.799v7.47h8.234v5.49
                h-8.234v8.55h11.249v5.489H188.044z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M210.903,53.945V21.457h6.795l8.64,19.259h0.09V21.457h5.67
                v32.488h-5.939l-9.495-20.969h-0.09v20.969H210.903z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M256.848,21.457v5.49h-7.245v26.999h-6.21V26.947h-7.244v-5.49
                H256.848z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M260.539,53.945V21.457h17.009v5.49h-10.799v7.47h8.234v5.49
                h-8.234v8.55h11.249v5.489H260.539z"/>
                    <path style="fill:none;stroke:#ffffff;stroke-miterlimit:10;" d="M297.618,53.945l-5.399-13.229h-2.97v13.229h-6.21V21.457h8.999
                c7.47,0,11.025,3.6,11.025,9.72c0,4.05-1.44,6.975-4.905,8.279l6.12,14.489H297.618z M289.249,35.586h3.194
                c2.745,0,4.41-1.35,4.41-4.5s-1.665-4.5-4.41-4.5h-3.194V35.586z"/>
                </g>

                <g class="logo-fill">
                    <path style="fill:#F1F2F2;"
                          d="M103.308,21.457v5.49h-7.245v26.999h-6.21V26.947h-7.245v-5.49H103.308z"/>
                    <path style="fill:#F1F2F2;"
                          d="M105.199,53.945V21.457h6.21v12.959h8.774V21.457h6.21v32.488h-6.21V39.906h-8.774v14.039H105.199z"
                        />
                    <path style="fill:#F1F2F2;"
                          d="M130.174,53.945V21.457h17.009v5.49h-10.799v7.47h8.234v5.49h-8.234v8.55h11.249v5.489H130.174z"/>
                    <path style="fill:#F1F2F2;" d="M168.694,44.317c0,3.6,1.574,4.59,4.05,4.59c2.475,0,4.05-0.99,4.05-4.59v-2.16h6.21v1.35
c0,8.01-4.23,10.89-10.26,10.89c-6.03,0-10.26-2.88-10.26-10.89V31.897c0-8.009,4.229-10.889,10.26-10.889
c6.029,0,10.26,2.88,10.26,10.889v0.09h-6.21v-0.9c0-3.6-1.575-4.59-4.05-4.59c-2.476,0-4.05,0.99-4.05,4.59V44.317z"/>
                    <path style="fill:#F1F2F2;"
                          d="M188.044,53.945V21.457h17.009v5.49h-10.799v7.47h8.234v5.49h-8.234v8.55h11.249v5.489H188.044z"/>
                    <path style="fill:#F1F2F2;" d="M210.903,53.945V21.457h6.795l8.64,19.259h0.09V21.457h5.67v32.488h-5.939l-9.495-20.969h-0.09
v20.969H210.903z"/>
                    <path style="fill:#F1F2F2;"
                          d="M256.848,21.457v5.49h-7.245v26.999h-6.21V26.947h-7.244v-5.49H256.848z"/>
                    <path style="fill:#F1F2F2;"
                          d="M260.539,53.945V21.457h17.009v5.49h-10.799v7.47h8.234v5.49h-8.234v8.55h11.249v5.489H260.539z"/>
                    <path style="fill:#F1F2F2;" d="M297.618,53.945l-5.399-13.229h-2.97v13.229h-6.21V21.457h8.999c7.47,0,11.025,3.6,11.025,9.72
c0,4.05-1.44,6.975-4.905,8.279l6.12,14.489H297.618z M289.249,35.587h3.194c2.745,0,4.41-1.35,4.41-4.5s-1.665-4.5-4.41-4.5
h-3.194V35.587z"/>
                </g>

                <circle class="logo-circle-hub" style="fill:#6FB844;" cx="37.702" cy="37.702" r="37.702"/>
            </svg>
        </a>

        <section class="intro" intro-anim>
            <div class="tabular">
                <div class="cellular">

                    <!--<svg spoke-to=".svg-tagline-hub" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20" style="position:absolute;top:20%;left:20%;">
                        <circle fill="#000" cx="10" cy="10" r="10" />
                    </svg>
                    <svg spoke-to=".svg-tagline-hub" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20" style="position:absolute;top:20%;left:50%;">
                        <circle fill="#000" cx="10" cy="10" r="10" />
                    </svg>
                    <svg spoke-to=".svg-tagline-hub" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20" style="position:absolute;top:90%;left:90%;">
                        <circle fill="#000" cx="10" cy="10" r="10" />
                    </svg>-->

                    <div class="tagline hub-node">
                        <div class="tabular">
                            <div class="cellular">
                                <div class="text">
                                    <span>We Are A</span>
                                    <span>Hub</span>
                                    <span>For the Artistic, Cultural And</span>
                                    <span>Creative Activity In Jackson Hole</span>
                                    <svg class="svg-tagline-hub" spoke-to=".upcoming" spoke-animation-delay="700" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">
                                        <circle fill="#000" cx="10" cy="10" r="10" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-events" ng-controller="CtrlFeaturedEvents" ng-init="featuredTagID = '<?php echo (int)$featuredTagID; ?>'">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="hub-node upcoming hub-green">
                            <h2>Upcoming Events</h2>
                            <svg version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">
                                <circle fill="#000" cx="10" cy="10" r="10" />
                            </svg>
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

        <section class="homepage-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="hub-node hub-green">
                        <h2>Our Mission</h2>
                        <svg spoke-to=".upcoming" version="1.1" viewBox="0 0 20 20" preserveAspectRatio="xMinYMid meet" height="20">
                            <circle fill="#000" cx="10" cy="10" r="10" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    /** @var $a \Concrete\Core\Area\Area */
                    $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN_2);
                    $a->display($c);
                    ?>
                </div>
            </div>
        </section>

        <?php $this->inc('elements/footer.php', array('logowhite' => true)); ?>
    </main>
</div>

<?php Loader::element('footer_required'); // REQUIRED BY C5 // ?>
</body>
</html>