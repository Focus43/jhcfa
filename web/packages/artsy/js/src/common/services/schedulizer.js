angular.module('artsy.common').

    service('Schedulizer', ['$http', function( $http ){

        var eventRoute      = '/_schedulizer/event_list',
            defaultParams   = {
                fields:     ['computedStartLocal', 'computedStartUTC', 'title'],
                pagepath:   true,
                grouping:   true
            };

        /**
         * Joins the alwaysFields with custom fields and ensures no duplication.
         * @param _fields
         * @returns {*}
         * @private
         */
        function mergeFields( a, b ){
            var joined = a.concat(b);
            return joined.filter(function( item, pos ){
                return joined.indexOf(item) === pos;
            });
        }

        /**
         * @param fields array
         * @param filters object
         * @param cache bool
         */
        this.fetch = function( _filters, _cache ){
            // Merge array fields passed in filters w/ defaults, then join as a string "a,b,c"
            _filters['fields'] = mergeFields(_filters.fields || [], defaultParams.fields).join(',');
            // Issue request and return promise
            return $http.get(eventRoute, {
                cache:  (_cache === false) ? false : true,
                params: angular.extend(defaultParams, _filters)
            });
        };

    }]);