<script type="text/ng-template" id="/search-form-tpl">
    <div search-results>
        <a closer ng-click="clear()"><i class="icon-close"></i></a>
        <div class="term-display">
            <small>Search Term:</small>
            <div class="lead">{{ status.displayValue }}</div>
        </div>
        <div class="results" ng-show="!status.loading">
            <div ng-show="pageHits.length">
                <a ng-repeat="hit in pageHits" href="{{hit.path}}">
                    <h4>{{hit.name}}</h4>
                    <span>{{hit.descr}}</span>
                    <small>{{hit.path}}</small>
                </a>
            </div>
            <div ng-show="!pageHits.length">
                <h3 class="lead no-results">Shux, nothing matched your search :(</h3>
            </div>
        </div>
        <div class="loading" ng-show="status.loading">
            <?php $this->inc('../../images/logo-breakup-small.svg'); ?>
        </div>
    </div>
</script>

<nav primary revealing>
    <a trigger ng-click="toggle()">
        <i class="icon-bars" ng-class="{'icon-tasks':status.open,'icon-bars':!status.open}"></i>
    </a>
    <div class="inner-1">
        <?php
        $blockTypeNav                                       = BlockType::getByHandle('autonav');
        $blockTypeNav->controller->orderBy                  = 'display_asc';
        $blockTypeNav->controller->displayPages             = 'top';
        $blockTypeNav->controller->displaySubPages          = 'all';
        $blockTypeNav->controller->displaySubPageLevels     = 'custom';
        $blockTypeNav->controller->displaySubPageLevelsNum  = 1;
        $blockTypeNav->render('templates/sidebar_nav');
        ?>

        <div class="bottom" slideable>
            <a class="btn btn-block btn-lg btn-primary">Donate</a>
            <div class="btn-group btn-group-justified">
                <a class="btn btn-dark" href="/box_office">Box Office</a>
                <a class="btn btn-dark" href="/contact">Contact</a>
            </div>
            <div searchable="<?php echo Router::route(array('site_search', 'artsy')); ?>">
                <form name="searchForm">
                    <i class="icon-search"></i>
                    <input name="search" type="text" placeholder="Search" ng-model="status.value" ng-minlength="5" ng-model-options="{debounce:600}" ng-keyup="funcKeyup($event)" />
                </form>
            </div>
        </div>
    </div>
</nav>