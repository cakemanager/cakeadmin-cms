<?php
namespace Cms\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cms\Utility\PathManager;

/**
 * Cms helper
 */
class CmsHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getUrl($type, $id)
    {
        return PathManager::instance()->getPath($type, $id);
    }

}
