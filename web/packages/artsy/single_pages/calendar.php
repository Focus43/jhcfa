<div ng-controller="CtrlCalendarPage">

    <form class="event-search container-fluid" ng-submit="fetch()">
        <div class="row">
            <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="Search" ng-model="filters.keywords" />
                <div class="select-wrap">
                    <select class="calendar-list form-control" ng-model="filters.calendars">
                        <option value="">All Calendars</option>
                        <?php foreach($calendarList AS $id => $label){ ?>
                            <option value="<?php echo $id; ?>"><?php echo $label; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="select-wrap">
                    <select class="tag-list form-control" ng-model="filters.tags">
                        <option value="">Tags</option>
                        <?php foreach($tagList AS $id => $label){ ?>
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
                <button type="submit" class="btn btn-search">Search</button>
            </div>
        </div>
    </form>

    <div class="month-display">

    </div>

    <!-- Event results : items inside event-list are transcluded -->
    <div event-list="eventData" ng-cloak>
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
</div>