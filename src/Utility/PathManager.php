<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Cms\Utility;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use Settings\Core\Setting;

class PathManager
{

    protected static $_generalManager = null;

    protected $_types = [];

    protected static $_runnable = false;

    /**
     * instance
     *
     * @param \CMS\Utility\PathManager $manager
     * @return \CMS\Utility\PathManager
     */
    public static function instance($manager = null)
    {
        self::_validate();

        if ($manager instanceof PathManager) {
            static::$_generalManager = $manager;
        }
        if (empty(static::$_generalManager)) {
            static::$_generalManager = new PathManager();
        }
        return static::$_generalManager;
    }

    protected static function _validate()
    {
        if(self::$_runnable) {
            return;
        }

        $db = ConnectionManager::get('default');
        $collection = $db->schemaCollection();
        $tables = $collection->listTables();

        if (!in_array('cms_blogs', $tables)) {
            return false;
        }
        if (!in_array('cms_categories', $tables)) {
            return false;
        }
        if (!in_array('cms_pages', $tables)) {
            return false;
        }
    }

    public function register($type, $model)
    {
        if (self::$_runnable) {
            return;
        }

        $this->_types[$type] = $model;

        $this->buildRoutes($type);
    }

    public function buildRoutes($type)
    {
        $model = $this->_types[$type];

        if (($pages = $this->readCache($type) === false)) {
            $pages = TableRegistry::get($model)->getRoutes();

            $routes = [];

            foreach ($pages as $id => $slug) {
                $routes[$id] = $slug;
            }
            $this->writeCache($type, $routes);
        }
        return $this->readCache($type);
    }

    public function removeRoutes($type)
    {
        $this->deleteCache($type);
    }

    public function getPath($type, $id)
    {
        $data = $this->readCache($type);

        if (array_key_exists($id, $data)) {
            return $data[$id];
        }
        return false;
    }

    public function pathExists($path)
    {
        foreach ($this->_types as $type) {
            if (in_array($path, $this->readCache($type))) {
                return true;
            }
        }
        return false;
    }

    public function readCache($type)
    {
        return Cache::read('Routes.' . $type);
    }

    public function writeCache($type, $data)
    {
        return Cache::write('Routes.' . $type, $data);
    }

    public function deleteCache($type)
    {
        return Cache::delete('Routes.' . $type);
    }

}
