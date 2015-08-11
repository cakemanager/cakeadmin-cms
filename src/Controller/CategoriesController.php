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
namespace Cms\Controller;

use Cms\Controller\AppController;

/**
 * Pages Controller
 *
 * @property \Cms\Model\Table\PagesTable $Pages
 */
class CategoriesController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
    }

    public $helpers = [
        'Cms.Cms'
    ];

    public $paginate = [
        'limit' => 25,
        'order' => [
            'Blogs.id' => 'asc'
        ]
    ];

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories
            ->find()
            ->where(['Categories.Id' => $id])
            ->first();

        $this->loadModel('Cms.Blogs');

        $query = $this->Blogs->find()
            ->find('active')
            ->where(['Blogs.category_id' => $category->get('id')]);

        $blogs = $this->paginate($query);

        $this->set(compact('blogs', 'category'));
    }

}
