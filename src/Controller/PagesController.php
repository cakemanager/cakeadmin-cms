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
class PagesController extends AppController
{

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $page = $this->Pages
            ->find('active')
            ->where(['Pages.Id' => $id])
            ->contain(['CreatedBy', 'ModifiedBy'])
            ->first();
        $this->set('page', $page);
    }

}
