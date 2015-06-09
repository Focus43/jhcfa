<!DOCTYPE HTML>
<html lang="<?php echo LANGUAGE; ?>" class="<?php echo $documentClasses; ?>">
<?php $this->inc('elements/head.php'); ?>
<body class="<?php echo $templateHandle; ?>">

<div id="c-level-1" class="<?php echo $c->getPageWrapperClass(); ?>">

    <?php $this->inc('elements/nav.php'); ?>

    <main revealing>
        <?php $mastheadImageSrc = $mastheadHelper->getSingleImageSrc(); ?>
        <header<?php if(!empty($mastheadImageSrc)){echo ' style="background-image:url('.$mastheadImageSrc.');"';} ?>>
            <a class="logo" href="/">
                <?php $this->inc('../../images/logo-breakup-small.svg'); ?>
            </a>

            <?php
                $blockTypeNav                                       = BlockType::getByHandle('autonav');
                $blockTypeNav->controller->orderBy                  = 'display_asc';
                $blockTypeNav->controller->displayPages             = 'top';
                $blockTypeNav->controller->displaySubPages          = 'relevant_breadcrumb';
                $blockTypeNav->controller->displaySubPageLevels     = 'all';
                $blockTypeNav->render('templates/breadcrumbs');
            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <h1><?php echo Page::getCurrentPage()->getCollectionName(); ?></h1>
                        <p><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></p>
                    </div>
                </div>
            </div>
        </header>

        <div class="area-main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-9">
                        <div class="clearfix">
                            <div class="pull-left">
                                <span class="avatar" style="background-image:url('<?php echo Loader::helper('concrete/avatar')->getImagePath($pageOwnerUser);?>');"></span>
                                <div class="date-and-auth"><strong><?php echo \Core::make('helper/date')->formatDate(Page::getCurrentPage()->getCollectionDatePublic(), true); ?></strong> by <span><?php echo $pageOwnerUser->getAttribute('display_name'); ?></span></div>
                            </div>
                            <?php Loader::packageElement('custom_share_icons', 'artsy'); ?>
                        </div>

                        <hr class="topless" />

                        <?php
                            /** @var $a \Concrete\Core\Area\Area */
                            $a = new Area(Concrete\Package\Artsy\Controller::AREA_MAIN);
                            $a->display($c);
                        ?>

                        <hr />

                        <?php
                            $blockNextPrev                              = BlockType::getByHandle('next_previous');
                            $blockNextPrev->controller->nextLabel       = 'Next';
                            $blockNextPrev->controller->previousLabel   = 'Previous';
                            $blockNextPrev->controller->parentLabel     = 'Blog Home';
                            $blockNextPrev->controller->loopSequence    = 1;
                            $blockNextPrev->controller->orderBy         = 'chrono_desc';
                            $blockNextPrev->render('templates/blog_page');
                        ?>

                        <!-- FACEBOOK COMMENTS -->
                        <div fb-sdk class="fb-comments" data-href="<?php echo BASE_URL . Page::getCurrentPage()->getCollectionPath(); ?>" data-numposts="5" data-colorscheme="light" data-width="100%" data-order-by="reverse_time"></div>
                    </div>

                    <div class="col-sm-4 col-md-3">
                        <?php Loader::packageElement('tag_list', 'artsy', array('selectedTag' => $selectedTag)); ?>
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