angular.module('artsy.common').

    directive('eventCalendar', ['$http', 'moment', function( $http, moment ){

        function _link( scope, $elem, attrs, Controller, transcludeFn ){

            var transcludeTarget    = angular.element($elem[0].querySelector('.event-list')),
                transcludedNodes    = [],
                transcludedScopes   = [];

            // Initialize with values...
            //scope.filters.calendars = $elem[0].querySelector('.calendar-list').children[0].value;
            //scope.filters.tags = $elem[0].querySelector('.tag-list').children[0].value;
            scope.$watch('eventResults', function( list ){
                if( list ){
                    // @todo: do a check in here to see if we're appending but keeping the existing
                    // results, or replacing the existing ones, and cleanup old nodes/scopes if
                    // need be (https://docs.angularjs.org/api/ng/service/$compile see section on cleanup)
                    var _node;
                    while(_node = transcludedNodes.pop()){
                        _node.remove();
                    }

                    var _scope;
                    while(_scope = transcludedScopes.pop()){
                        _scope.$destroy();
                    }

                    list.forEach(function( eventObj ){
                        var $newScope = scope.$new();
                        $newScope.eventObj = eventObj;
                        $newScope.moment   = moment(eventObj.computedStartLocal);
                        transcludeFn($newScope, function( $cloned, $scope ){
                            transcludeTarget.append($cloned);
                            transcludedNodes.push($cloned);
                            transcludedScopes.push($scope);
                        });
                    });
                }
            }, true);
        }


        return {
            scope:      {_route: '=route'},
            link:       _link,
            transclude: true,
            templateUrl:   '/calendar-form',
            controller: ['$scope', function( $scope ){
                var _fields = [
                    'eventID',
                    'pageID',
                    'calendarID',
                    'title',
                    'description',
                    'isSynthetic',
                    'computedStartUTC',
                    'computedStartLocal'
                ];

                $scope.eventResults = [];

                $scope.filters = {
                    keywords:  null,
                    calendars: null,
                    tags:      null,
                    category:  null,
                    filepath:  true,
                    pagepath:  true
                };

                /**
                 * Call and update...
                 * @returns {HttpPromise}
                 * @private
                 */
                function _fetch(){
                    return $http.get($scope._route, {
                        cache: true,
                        params: angular.extend({
                            fields: _fields.join(',')
                        }, $scope.filters)
                    });
                }

                /**
                 * Search...
                 */
                $scope.formHandler = function(){
                    _fetch().success(function( resp ){
                        $scope.eventResults = resp;
                    }).error(function( data, status, headers, config ){
                        console.log(data);
                    });
                };

                _fetch();
            }]
        };
    }]);