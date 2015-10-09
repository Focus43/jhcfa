<?php namespace Concrete\Package\Artsy\Controller {

    use Request;
    use \Concrete\Core\Page\PageList;
    use \Concrete\Core\Page\Search\Result\Result AS PageSearchResult;
    use \Concrete\Package\Schedulizer\Src\EventList;

    class SiteSearch extends \Concrete\Core\Controller\Controller {

        /**
         * Pass an existing or new event obj to the view on render
         * @param null $id
         */
        public function search(){
            $term = $_REQUEST['_s'];
            if( !empty($term) ){
                $pageList = new PageList();
                $pageList->filterByFulltextKeywords($term);
                $results = $pageList->getResults();
                $pageResults = array();
                foreach($results AS $pageObj){
                    array_push($pageResults, (object)array(
                        'name'  => $pageObj->getCollectionName(),
                        'descr' => $pageObj->getCollectionDescription(),
                        'path'  => $pageObj->getCollectionPath()
                    ));
                }

                echo json_encode((object)array(
                    'pages' => $pageResults
                ));
            }
        }

    }

}