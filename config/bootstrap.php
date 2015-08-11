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
use Cake\Core\Configure;
use Settings\Core\Setting;
use Cake\ORM\TableRegistry;
use Cake\Cache\Cache;
use Cms\Utility\PathManager;

Configure::write('Settings.Prefixes.CMS', 'Cake CMS');

Setting::register('CMS.Pages', true, [
    'type' => 'checkbox'
]);

Setting::register('CMS.Blogs', true, [
    'type' => 'checkbox'
]);

Setting::register('CMS.Index', false, [
    'type' => 'select',
    'options' => function () {
        return [false => 'None'] + TableRegistry::get('Cms.Pages')->find('list')->toArray();
    }
]);

Setting::register('CMS.BlogsUrl', '/:category_slug/:blog_slug');

if (Setting::read('CMS.Pages')) {
    Configure::write('CA.Models.pages', 'Cms.Pages');
    PathManager::instance()->register('pages', 'Cms.Pages');
}

if (Setting::read('CMS.Blogs')) {
    Configure::write('CA.Models.categories', 'Cms.Categories');
    Configure::write('CA.Models.blogs', 'Cms.Blogs');

    PathManager::instance()->register('blogs', 'Cms.Blogs');
    PathManager::instance()->register('categories', 'Cms.Categories');
}

# Notification Templates
Configure::write('Notifier.templates.blog_post', [
    'title' => 'A new blog has been posted',
    'body' => 'The blog :title has been posted by :creator'
]);

# AdminBar
Configure::write('AdminBar.edit_blog', [
    'on' => [
        'plugin' => 'Cms',
        'controller' => 'Blogs',
        'action' => 'view'
    ],
    'label' => 'Edit Blog',
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'CakeAdmin',
        'controller' => 'PostTypes',
        'action' => 'edit',
        ':pass.0',
        'type' => 'blogs'
    ]
]);

Configure::write('AdminBar.read_blog', [
    'on' => [
        'prefix' => 'admin',
        'plugin' => 'CakeAdmin',
        'controller' => 'PostTypes',
        'action' => ['edit', 'view'],
        'type' => 'blogs',
    ],
    'label' => 'Read Blog',
    'url' => [
        'prefix' => false,
        'plugin' => 'Cms',
        'controller' => 'Blogs',
        'action' => 'view',
        ':pass.1'
    ]
]);