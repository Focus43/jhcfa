<div ng-controller="CtrlCalendarPage">

    <form name="calendarForm" class="event-search" ng-submit="fetch()">
        <div class="pseudo-container">
            <div class="tabular">
                <div class="cellular">
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
                    <div class="btn-group">
                        <a class="btn btn-default" ng-click="setCategory(null)" ng-class="{active:!filters.categories}">All</a>
                        <?php foreach($categoryList AS $id => $label){ ?>
                            <a class="btn btn-default" ng-click="setCategory(<?php echo $id; ?>)" ng-class="{active:filters.categories == <?php echo $id; ?>}" data-handle="<?php echo $label; ?>">
                                <?php echo $label; ?>
                            </a>
                        <?php } ?>
                    </div>
                    <span class="filter-by-tags" ng-click="uiState.showTagList = !uiState.showTagList">Filter By Tags</span>
                    <span class="clear-all" ng-click="clearAll()" ng-class="{viz:uiState.clearAllViz}">Clear All</span>
                </div>
            </div>
        </div>

        <span class="msg" ng-class="{viz:uiState.showSearchExtras}">Make sure your search contains at least 5 characters</span>

        <div class="search-tag-list text-left pseudo-container" ng-show="uiState.showTagList" ng-cloak>
            <?php foreach($tagList AS $id => $label){ ?>
                <span class="tag-item" ng-click="toggleTag(<?php echo $id; ?>)" ng-class="{active:selectedTags.indexOf(<?php echo $id; ?>) !== -1}"><?php echo $label; ?></span>
            <?php } ?>
        </div>
    </form>

    <div class="pseudo-container month-display" ng-cloak>
        <div class="btn-group btn-group-justified" ng-show="!isTextSearch && !uiState.showSearchExtras">
            <a class="btn btn-lg" ng-repeat="moment in monthsToView" ng-class="{'active':moment._selected}" ng-click="selectMonth($index)">{{ moment.format('MMM') }}</a>
        </div>
        <div class="text-center lead range-msg" ng-show="isTextSearch || uiState.showSearchExtras">
            Text Search Looks Through {{ overrideDateRange.end.format('MMM YY') }}
        </div>
    </div>

    <!-- Event results : items inside event-list are transcluded -->
    <div class="pseudo-container" ng-hide="uiState.fetchInProgress || !uiState.initialFetchComplete" ng-cloak>
        <div ng-cloak ng-show="eventData.length >= 1">
            <div event-list="eventData">
                <div class="event-result">
                    <a class="event-content" ng-style="{backgroundImage:'url({{eventObj.filePath}})'}" href="{{eventObj.pagePath}}">
                        <div class="layer-1">
                            <div class="bottomize">
                                <span class="title">{{ eventObj.title }}</span>
                                <span class="date">{{ eventObj.date_display }}</span>
                            </div>
                        </div>
                        <div class="layer-2">
                            <div class="tabular">
                                <div class="cellular">
                                    <small>Presented By</small>
                                    <h5>{{ eventObj.presenting_organization }}</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="tql">
                        <a class="to-event" ng-show="eventObj.event_not_ticketed == 1 || eventObj.ticket_link == ''" href="{{eventObj.pagePath}}">Event Details</a>
                        <a class="direct-tickets" ng-show="eventObj.event_not_ticketed != 1 && eventObj.ticket_link != ''" href="{{eventObj.ticket_link}}" target="_blank">Get Tickets</a>
                    </div>
                </div>
            </div>

            <div class="prev-next clearfix" ng-show="!isTextSearch">
                <a class="btn-prev btn btn-lg btn-primary pull-left" ng-click="prevMonth()" ng-hide="selectedMonthIndex == 0"><i class="icon-angle-left"></i>Prev Month</a>
                <a class="btn-next btn btn-lg btn-primary pull-right" ng-click="nextMonth()" ng-hide="selectedMonthIndex == (monthsToView.length - 1)">Next Month <i class="icon-angle-right"></i></a>
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