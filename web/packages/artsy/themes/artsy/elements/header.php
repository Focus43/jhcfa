<header<?php if(!empty($mastheadImageSrc)){echo ' style="background-image:url('.$mastheadImageSrc.');"';} ?>>
    <a class="logo">
        <?php $this->inc('../../images/logo-breakup-small.svg'); ?>
    </a>

    <?php if($expanded === true): ?>
        <?php
        $blockTypeNav                                       = BlockType::getByHandle('autonav');
        $blockTypeNav->controller->orderBy                  = 'display_asc';
        $blockTypeNav->controller->displayPages             = 'top';
        $blockTypeNav->controller->displaySubPages          = 'relevant_breadcrumb';
        $blockTypeNav->controller->displaySubPageLevels     = 'all';
        $blockTypeNav->render('templates/breadcrumbs');
        ?>

        <div class="container-fluid">
            <h1><?php echo Page::getCurrentPage()->getCollectionName(); ?></h1>
            <p><?php echo Page::getCurrentPage()->getCollectionDescription(); ?></p>
        </div>
    <?php endif; ?>
</header>