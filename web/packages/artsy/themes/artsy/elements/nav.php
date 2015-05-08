<nav>
    <a trigger ng-click="toggle()"><i class="icon-menu"></i></a>
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

        <a box-office>Box Office</a>
        <a contact>Contact</a>
    </div>
</nav>