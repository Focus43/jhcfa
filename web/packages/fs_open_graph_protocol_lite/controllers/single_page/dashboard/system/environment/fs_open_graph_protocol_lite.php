<?php   
namespace Concrete\Package\FsOpenGraphProtocolLite\Controller\SinglePage\Dashboard\System\Environment;

/**
 * Support code
 *
 * @package     FS Open Graph Protocol Lite
 * @author      Fagan Systems
 * @copyright   Copyright (c) 2015. (http://www.fagan-systems.com)
 * @license     http://www.fagan-systems.com/faqhelp/commercial-license  Commercial License
 *
 */

use \Concrete\Core\Page\Controller\DashboardPageController;

class FsOpenGraphProtocolLite extends DashboardPageController {

    public function view()
    {
        $this->redirect('/dashboard/system/environment/fs_open_graph_protocol_lite/settings');
    }

}