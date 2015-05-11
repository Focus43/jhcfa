<nav>
    <a trigger ng-click="toggle()" class="icon-menu"></a>
    <div class="level-1">
        <?php
            $blockTypeNav                                       = BlockType::getByHandle('autonav');
            $blockTypeNav->controller->orderBy                  = 'display_asc';
            $blockTypeNav->controller->displayPages             = 'top';
            $blockTypeNav->controller->displaySubPages          = 'all';
            $blockTypeNav->controller->displaySubPageLevels     = 'custom';
            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
            $blockTypeNav->render('templates/sidebar_nav');
        ?>

        <div class="bottom">
            <a class="btn btn-block btn-lg btn-primary">Donate</a>
            <div class="btn-group btn-group-justified">
                <a class="btn btn-dark" href="/box-office">Box Office</a>
                <a class="btn btn-dark" href="/contact">Contact</a>
            </div>
        </div>
    </div>
</nav>