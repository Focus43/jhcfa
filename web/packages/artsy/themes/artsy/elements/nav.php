<nav>
    <div class="level-1">
        <!--<ul>
            <li><a>Home</a></li>
            <li><a>Calendar</a></li>
            <li><a>Residents</a></li>
            <li><a>Supporters</a></li>
            <li><a>Center Info.</a></li>
            <li><a>Contact</a></li>
        </ul>-->
        <?php
            $blockTypeNav                                       = BlockType::getByHandle('autonav');
            $blockTypeNav->controller->orderBy                  = 'display_asc';
            $blockTypeNav->controller->displayPages             = 'top';
            $blockTypeNav->controller->displaySubPages          = 'all';
            $blockTypeNav->controller->displaySubPageLevels     = 'custom';
            $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
            $blockTypeNav->render('templates/sidebar_nav');
        ?>
    </div>
</nav>