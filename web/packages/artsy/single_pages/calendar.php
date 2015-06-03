<div ng-controller="CtrlCalendarPage">

    <form name="calendarForm" class="event-search" ng-submit="fetch()">
        <div class="search-wrapper">
            <div class="text-input-wrap">
                <input name="textSearch" type="text" class="form-control" placeholder="Search" ng-model="filters.keywords" ng-minlength="5" ng-model-options="{debounce:600}" ng-keyup="funcKeyup($event)" />
                <a class="clear-text" ng-click="clearSearch()" ng-show="uiState.showSearchExtras"><i class="icon-close"></i></a>
            </div>
            <div class="select-wrap">
                <select class="calendar-list form-control" ng-model="filters.calendars">
                    <option value="">All Calendars</option>
                    <?php foreach($calendarList AS $id => $label){ ?>
                        <option value="<?php echo $id; ?>"><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </div>
<!--            <div class="select-wrap">-->
<!--                <select class="tag-list form-control" ng-model="filters.tags">-->
<!--                    <option value="">Tags</option>-->
<!--                    --><?php //foreach($tagList AS $id => $label){ ?>
<!--                        <option value="--><?php //echo $id; ?><!--">--><?php //echo $label; ?><!--</option>-->
<!--                    --><?php //} ?>
<!--                </select>-->
<!--            </div>-->
            <div class="btn-group">
                <a class="btn btn-default" ng-click="setCategory(null)" ng-class="{active:!filters.categories}">All</a>
                <?php foreach($categoryList AS $id => $label){ ?>
                    <a class="btn btn-default" ng-click="setCategory(<?php echo $id; ?>)" ng-class="{active:filters.categories == <?php echo $id; ?>}" data-handle="<?php echo $label; ?>">
                        <?php echo $label; ?>
                    </a>
                <?php } ?>
            </div>
            <span class="filter-by-tags" ng-click="uiState.showTagList = !uiState.showTagList">Filter By Tags</span>
        </div>

        <span class="msg" ng-class="{viz:uiState.showSearchExtras}">Make sure your search contains at least 5 characters</span>

        <div class="search-tag-list text-left" ng-show="uiState.showTagList" ng-cloak>
            <?php foreach($tagList AS $id => $label){ ?>
                <span class="tag-item" ng-click="toggleTag(<?php echo $id; ?>)" ng-class="{active:selectedTags.indexOf(<?php echo $id; ?>) !== -1}"><?php echo $label; ?></span>
            <?php } ?>
        </div>
    </form>

    <div class="month-display">
        <div class="btn-group btn-group-justified" ng-cloak>
            <a class="btn btn-lg btn-dark" ng-repeat="moment in monthsToView" ng-class="{'active':moment._selected}" ng-click="selectMonth($index)">{{ moment.format('MMM') }}</a>
        </div>
    </div>

    <!-- Event results : items inside event-list are transcluded -->
    <div ng-hide="uiState.fetchInProgress || !uiState.initialFetchComplete" ng-cloak>
        <div event-list="eventData" ng-cloak ng-show="eventData.length >= 1">
            <div class="event-result">
                <a class="event-content" ng-style="{backgroundImage:'url({{eventObj.filePath}})'}" href="{{eventObj.pagePath}}">
                <span class="layer-1">
                    <div class="bottomize">
                        <span class="title">{{ eventObj.title }}</span>
                        <span class="date">{{ eventObj.date_display }}</span>
                    </div>
                </span>
                <span class="layer-2">
                    <span class="tabular">
                        <span class="cellular">
                            <small>Presented By</small>
                            <h5>{{ eventObj.presenting_organization }}</h5>
                        </span>
                    </span>
                </span>
                </a>
                <div class="tql">
                    <a class="to-event" ng-hide="eventObj.event_not_ticketed == 1 || eventObj.ticket_link == ''" href="{{eventObj.pagePath}}">Event Details</a>
                    <a class="direct-tickets" ng-hide="eventObj.event_not_ticketed != 1 && eventObj.ticket_link != ''" href="{{eventObj.ticket_link}}" target="_blank">Get Tickets</a>
                </div>
            </div>
        </div>

        <div ng-show="eventData.length == 0" class="text-center no-results">
            <h5 class="lead">Oh no! We couldn't find any results for your search.</h5>
        </div>
    </div>

    <div class="logo-load-progress working" ng-class="{working:uiState.fetchInProgress}">
        <?php $this->inc('../../images/logo-loader.svg'); ?>
    </div>
</div>