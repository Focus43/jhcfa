<script type="text/ng-template" id="/calendar-form">
    <!-- search form -->
    <form class="event-search container-fluid" ng-submit="formHandler()">
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
                <!--                <div class="btn-group">-->
                <!--                    <button type="button" class="btn btn-default active">All Types</button>-->
                <!--                    --><?php //foreach($categoryList AS $optObj){ ?>
                <!--                        <button type="button" class="btn btn-default">--><?php //echo $optObj; ?><!--</button>-->
                <!--                    --><?php //} ?>
                <!--                </div>-->
                <button type="submit" class="btn btn-search">Search</button>
            </div>
        </div>
    </form>

    <!-- event results -->
    <div class="event-list">
        <!-- transcluded here -->
    </div>
</script>

<div event-calendar data-route="'/_schedulizer/event_list'" ng-cloak>
    <a class="event-result" href="{{eventObj.pagePath}}" ng-style="{backgroundImage:'url({{eventObj.filePath}})'}">
        <span class="layer-1">
            <span class="date">{{ moment.format('MMM D,YYYY / h:mm a') }}</span>
            <span class="title">{{ eventObj.title }}</span>
        </span>
        <span class="layer-2">
            <span class="tabular">
                <span class="cellular">
                    <!--<div ng-bind-html="eventObj.description"></div>-->
                    <h4>$22</h4>
                    <span class="btn btn-primary btn-lg">Event Page</span>
                </span>
            </span>
        </span>
    </a>
</div>