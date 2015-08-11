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
namespace Cms\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cms\Utility\PathManager;

/**
 * CmsData Entity.
 */
class Page extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'title' => true,
        'slug' => true,
        'body' => true,
        'state' => true,
        'created_by' => true,
        'modified_by' => true,
    ];

    protected function _setTitle($title)
    {
        if ($this->get('slug') === Inflector::slug($this->getOriginal('title'))) {
            $this->set('slug', Inflector::slug($title));
        }
        return $title;
    }

    protected function _setSlug($slug)
    {
        $slug = Inflector::slug($slug);
        return $slug;
    }

    protected function _getPath()
    {
        if(array_key_exists('id', $this->_properties)) {
            return PathManager::instance()->getPath('pages', $this->_properties['id']);
        }
        return null;
    }

    protected $_virtual = ['path'];
}
