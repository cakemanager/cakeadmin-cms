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
namespace Cms\View\Cell;

use Cake\View\Cell;

class WidgetsCell extends Cell
{

    public function categories($limit = 5)
    {
        $this->loadModel('Cms.Categories');

        $categories = $this->Categories
            ->find()
            ->toArray();

        $this->set(compact('categories'));
    }

    public function blogs($limit = 5)
    {
        $this->loadModel('Cms.Blogs');

        $blogs = $this->Blogs
            ->find('active')
            ->order(['Blogs.id' => 'DESC'])
            ->toArray();

        $this->set(compact('blogs'));
    }

}