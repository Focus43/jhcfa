<div ng-controller="CtrlCalendarPage">

    <form class="event-search container-fluid" ng-submit="fetch()">
        <div class="row">
            <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="Search" ng-model="filters.keywords" />
                <div class="select-wrap">
                    <select class="calendar-list form-control" ng-model="filters.calendars">
                        <option value="<?php echo join(',', array_keys($calendarList)); ?>">All Calendars</option>
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
                <!--<div class="btn-group">
                    <button type="button" class="btn btn-default active">All Types</button>
                    <?php foreach($categoryList AS $optObj){ ?>
                        <button type="button" class="btn btn-default"><?php echo $optObj; ?></button>
                    <?php } ?>
                </div>-->
                <button type="submit" class="btn btn-search">Search</button>
            </div>
        </div>
    </form>

    <!-- Event results : items inside event-list are transcluded -->
    <div event-list="eventData" ng-cloak>
        <a class="event-result" href="{{eventObj.pagePath}}">
            <span class="date">{{ moment.format('MMM D, YYYY') }} (&plus; {{ eventObj.occurrences }} more)</span>
            <div class="event-content" ng-style="{backgroundImage:'url({{eventObj.filePath}})'}">
            <span class="layer-1">
                <span class="title">{{ eventObj.title }}</span>
            </span>
            <span class="layer-2">
                <span class="tabular">
                    <span class="cellular">
                        <small>Presented By</small>
                        <h5>{{ eventObj.presenting_organization }}</h5>
                        <span class="btn btn-primary btn-">Event Details</span>
                    </span>
                </span>
            </span>
            </div>
        </a>
    </div>
</div>