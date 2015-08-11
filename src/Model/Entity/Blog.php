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
use Cake\Utility\Text;
use Cms\Utility\PathManager;

/**
 * CmsData Entity.
 */
class Blog extends Entity
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
        $original = Inflector::slug($this->getOriginal('title'));
        if (($this->get('slug') === $original) OR $original === '') {
            $this->set('slug', Inflector::slug($title));
        }
        return $title;
    }

    protected function _setSlug($slug)
    {
        if ($slug !== '') {
            $slug = Inflector::slug($slug);
            return $slug;
        }
        return $this->get('slug');
    }

    protected function _getPath()
    {
        if (array_key_exists('id', $this->_properties)) {
            return PathManager::instance()->getPath('blogs', $this->_properties['id']);
        }
        return null;
    }

    protected function _getExcerpt()
    {
        if (array_key_exists('body', $this->_properties)) {
            return Text::excerpt($this->_properties['body'], 'method', 400);
        }
        return null;
    }

    protected $_virtual = ['path', 'excerpt'];
}
