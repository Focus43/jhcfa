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
<!--                        <h1>The Center Blog</h1>-->
                        <h1><?php echo Page::getCurrentPage()->getCollectionName(); ?></h1>
                        <p><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></p>
                    </div>
                </div>
            </div>
            <div class="date-and-tags">
                <div class="inner">
                    <span class="date"><strong><?php echo \Core::make('helper/date')->formatDate(Page::getCurrentPage()->getCollectionDatePublic(), true); ?></strong> in </span>
                    <?php
                        $bt = BlockType::getByHandle('tags');
                        $bt->controller->displayMode = 'page';
                        $bt->controller->targetCID = Page::getByPath('/blog')->getCollectionID();
                        $bt->render('templates/custom');
                    ?>
                </div>
            </div>
        </header>

        <div class="area-main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="avatar" style="background-image:url('<?php echo Loader::helper('concrete/avatar')->getImagePath($pageOwnerUser);?>');"></span>
                                <div class="auth">by <span><?php echo $pageOwnerUser->getAttribute('display_name'); ?></span></div>
                            </div>
                            <div class="col-sm-6 text-right">
                                <div class="share-icons">
                                    <span>Share on</span>
                                    <a class="icon-circle-facebook share" target="_blank" href="http://facebook.com/jhcenterforthearts"></a>
                                    <a class="icon-circle-twitter share" target="_blank" href="http://twitter.com/jhcenterforarts"></a>
                                    <a class="icon-circle-google-plus share" target="_blank" href="https://plus.google.com/113085364394299174338"></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <hr/>
                            </div>
                        </div>
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
                    <div class="col-sm-4">
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