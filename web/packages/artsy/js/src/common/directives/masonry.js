angular.module("artsy.common").

    directive('masonry', ['Masonry', 'imagesLoaded',
        function( Masonry, imagesLoaded ){

            function _link(scope, $elem, attrs){
                var element = $elem[0];

                scope.masonry = new Masonry(element, {
                    //columnWidth:  '.grid-sizer',
                    itemSelector: '[node]',
                    percentPosition: true
                });
            }

            return {
                restrict:   'A',
                scope:      true,
                link:       _link
            };
        }
    ]);