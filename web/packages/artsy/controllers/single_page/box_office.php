<?php namespace Concrete\Package\Artsy\Controller\SinglePage {

    use \Concrete\Package\Schedulizer\Src\Calendar AS SchedulizerCalendar;
    use \Concrete\Package\Schedulizer\Src\EventTag AS SchedulizerTag;
    use \Concrete\Package\Schedulizer\Src\EventCategory AS SchedulizerCategory;
    use \Concrete\Package\Schedulizer\Src\Attribute\Key\SchedulizerEventKey;
    use \Concrete\Package\Artsy\Controller\ArtsyPageController;

    class BoxOffice extends ArtsyPageController {

        protected $_includeThemeAssets = true;

    }
}