<script type="text/ng-template" id="/search-form-tpl">
    <form name="searchForm" search-box ng-class="{open:status.open}">
        <a closer ng-click="status.open = false"><i class="icon-close"></i></a>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <input name="search" type="text" placeholder="Search" ng-model="status.value" ng-minlength="5" ng-model-options="{debounce:700}" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="results">
                        <a ng-repeat="hit in pageHits" href="{{hit.path}}">
                            <h4>{{hit.name}}</h4>
                            <span>{{hit.descr}}</span>
                            <small>{{hit.path}}</small>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="results">
                        <a ng-repeat="hit in eventHits" href="{{hit.pagePath}}">
                            <h4>{{hit.title}}</h4>
                            <small>{{ hit.computedStartLocal }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>

<nav>
    <a trigger ng-click="toggle()" class="icon-menu"></a>
    <div class="level-1">
        <!--<a search="<?php echo Router::route(array('site_search', 'artsy')); ?>"><i class="icon-search"></i></a>-->

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
                <a class="btn btn-dark" href="/box_office">Box Office</a>
                <a class="btn btn-dark" href="/contact">Contact</a>
            </div>
        </div>
    </div>
</nav>