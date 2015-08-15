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
use Cake\Routing\Router;
use Settings\Core\Setting;
use Cake\Core\Configure;
use Cake\Cache\Cache;

Router::plugin('Cms', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

if (Setting::read('CMS.Pages')) {
    $list = Cache::read('Routes.pages');
    if (!is_array($list)) {
        $list = [];
    }
    foreach ($list as $id => $slug) {
        Router::connect(
            $slug,
            ['plugin' => 'Cms', 'controller' => 'Pages', 'action' => 'view', $id],
            ['_name' => 'page.' . $slug]
        );
    }
}

if (Setting::read('CMS.Index')) {
    $value = Setting::read('CMS.Index');
    if (array_key_exists($value, $list)) {
        Router::scope('/', function ($routes) use ($value) {
            $routes->connect(
                '/',
                ['plugin' => 'Cms', 'controller' => 'Pages', 'action' => 'view', $value]
            );
            $routes->fallbacks('InflectedRoute');
        });
    }
} else {
    Router::connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
}

if (Setting::read('CMS.Blogs')) {
    $list = Cache::read('Routes.blogs');
    if (!is_array($list)) {
        $list = [];
    }
    foreach ($list as $id => $slug) {
        Router::connect(
            $slug,
            ['plugin' => 'Cms', 'controller' => 'Blogs', 'action' => 'view', $id],
            ['_name' => 'blog.' . $slug]
        );
    }

    $list = Cache::read('Routes.categories');
    if (!is_array($list)) {
        $list = [];
    }
    foreach ($list as $id => $slug) {
        Router::connect(
            $slug,
            ['plugin' => 'Cms', 'controller' => 'Categories', 'action' => 'view', $id],
            ['_name' => 'category.' . $slug]
        );
    }
}

