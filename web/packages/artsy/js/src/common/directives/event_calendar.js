angular.module('artsy.common').

    /**
     * Event rendering directive. This should be used inside a parent Controller or something
     * that can control the scope and pass event list data.
     * @usage: <div event-list="listData" />, whereas the parent controller can
     * set the listData on the scope.
     */
    directive('eventList', ['moment', function( moment ){

        function _link( scope, $elem, attrs, Controller, transcludeFn ){

            var transcludedNodes    = [],
                transcludedScopes   = [];

            scope.$watch('_data', function( list ){
                if( list ){
                    // @todo: do a check in here to see if we're appending but keeping the existing
                    // results, or replacing the existing ones, and cleanup old nodes/scopes if
                    // need be (https://docs.angularjs.org/api/ng/service/$compile see section on cleanup)
                    var _node; while(_node = transcludedNodes.pop()){
                        _node.remove();
                    }

                    var _scope; while(_scope = transcludedScopes.pop()){
                        _scope.$destroy();
                    }

                    list.forEach(function( eventObj ){
                        var $newScope = scope.$new();
                        $newScope.eventObj = eventObj;
                        $newScope.moment   = moment(eventObj.computedStartLocal);
                        transcludeFn($newScope, function( $cloned, $scope ){
                            $elem.append($cloned);
                            transcludedNodes.push($cloned);
                            transcludedScopes.push($scope);
                        });
                    });
                }
            }, true);

        }

        return {
            link:       _link,
            transclude: true,
            scope:      {_data: '=eventList'},
            controller: [function(){}]
        };
    }]);
