<?php   
namespace Concrete\Package\FsOpenGraphProtocolLite;

/**
 * Install Controller
 *
 * @package     FS Open Graph Protocol Lite
 * @author      Fagan Systems
 * @copyright   Copyright (c) 2015. (http://www.fagan-systems.com)
 * @license     http://www.fagan-systems.com/faqhelp/commercial-license Commercial License
 *
 */

use SinglePage;
use Page;
use CollectionAttributeKey;
use \Concrete\Core\Attribute\Type as AttributeType;
use Events;
use \Concrete\Package\FsOpenGraphProtocolLite\Src\Generate\FsOpenGraphProtocol;
use Config;
use Package;

class Controller extends \Concrete\Core\Package\Package {
    protected $pkgHandle = 'fs_open_graph_protocol_lite';
    protected $appVersionRequired = '5.7.3.1';
    protected $pkgVersion = '1.0.3';
    
    public function getPackageDescription()
    {
        return t("Adding Social Media Meta Tags the easy way");
    }
    
    public function getPackageName()
    {
        return t("Social Media Meta Tags");
    }
    
    public function install()
    {
        $pkg = parent::install();

        $sp = SinglePage::add('/dashboard/system/environment/fs_open_graph_protocol_lite', $pkg);
        if (is_object($sp)) {
            $sp->update(array('cName'=>t('Social Media Meta Tags'), 'cDescription'=>t('Manage your Social Media Meta Tags settings')));
        }

        $sp = SinglePage::add('/dashboard/system/environment/fs_open_graph_protocol_lite/settings', $pkg);
        if (is_object($sp)) {
            $sp->update(array('cName'=>t('Social Media Meta Tags Settings'), 'cDescription'=>t('Manage your Social Media Meta Tags settings')));
        }

        //Add og:image attribute
        $cak = CollectionAttributeKey::getByHandle('og_image');
        if (!is_object($cak)) {
            $at = AttributeType::getByHandle('image_file');
            CollectionAttributeKey::add($at, array('akHandle' => 'og_image', 'akName' => t('og:image')));
        }

        //Add og:title attribute
        $cak = CollectionAttributeKey::getByHandle('og_title');
        if (!is_object($cak)) {
            $at = AttributeType::getByHandle('text');
            CollectionAttributeKey::add($at, array('akHandle' => 'og_title', 'akName' => t('og:title')));
        }

        //Add og:description attribute
        $cak = CollectionAttributeKey::getByHandle('og_description');
        if (!is_object($cak)) {
            $at = AttributeType::getByHandle('text');
            CollectionAttributeKey::add($at, array('akHandle' => 'og_description', 'akName' => t('og:description')));
        }

        $pkg = Package::getByHandle('fs_open_graph_protocol_lite');
        $fb_admin = $pkg->getConfig()->save('concrete.ogp.fb_admin_id', '');
        $fb_admin = $pkg->getConfig()->save('concrete.ogp.fb_app_id', '');
        $fb_admin = $pkg->getConfig()->save('concrete.ogp.og_thumbnail_id', '');
        $fb_admin = $pkg->getConfig()->save('concrete.ogp.default_title', '');
        $fb_admin = $pkg->getConfig()->save('concrete.ogp.default_description', '');
        $fb_admin = $pkg->getConfig()->save('concrete.ogp.seo_select', '');

    }

    public function uninstall() {

        $pkg = Package::getByHandle('fs_open_graph_protocol_lite');
        $fb_admin = $pkg->getConfig()->clear('concrete.ogp.fb_admin_id');
        $fb_admin = $pkg->getConfig()->clear('concrete.ogp.fb_app_id');
        $fb_admin = $pkg->getConfig()->clear('concrete.ogp.og_thumbnail_id');
        $fb_admin = $pkg->getConfig()->clear('concrete.ogp.default_title');
        $fb_admin = $pkg->getConfig()->clear('concrete.ogp.default_description');
        $fb_admin = $pkg->getConfig()->clear('concrete.ogp.seo_select');

        $pkg = parent::uninstall();
    }

    public function update()
    {
        $pkg = parent::update();

        $sp = SinglePage::add('/dashboard/system/environment/fs_open_graph_protocol_lite/settings', $pkg);
        if (is_object($sp)) {
            $sp->update(array('cName'=>t('Social Media Meta Tags'), 'cDescription'=>t('Manage your Social Media Meta Tags settings')));
        }

        //Add og:image attribute
        $cak = CollectionAttributeKey::getByHandle('og_image');
        if (!is_object($cak)) {
            $at = AttributeType::getByHandle('image_file');
            CollectionAttributeKey::add($at, array('akHandle' => 'og_image', 'akName' => t('og:image')));
        }

        //Add og:title attribute
        $cak = CollectionAttributeKey::getByHandle('og_title');
        if (!is_object($cak)) {
            $at = AttributeType::getByHandle('text');
            CollectionAttributeKey::add($at, array('akHandle' => 'og_title', 'akName' => t('og:title')));
        }

        //Add og:description attribute
        $cak = CollectionAttributeKey::getByHandle('og_description');
        if (!is_object($cak)) {
            $at = AttributeType::getByHandle('text');
            CollectionAttributeKey::add($at, array('akHandle' => 'og_description', 'akName' => t('og:description')));
        }
    }

    public function on_start()
    {
        $ogp = new FsOpenGraphProtocol();
        Events::addListener('on_start', array($ogp,'writeogp'));
    }

}