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
namespace Cms\Model\Table;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cms\Model\Entity\CmsData;
use Cms\Utility\PathManager;
use Notifier\Utility\NotificationManager;
use Settings\Core\Setting;

/**
 * CmsData Model
 *
 */
class BlogsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('cms_blogs');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior('Utils.Stateable', [
            'field' => 'state',
        ]);

        $this->addBehavior('Utils.WhoDidIt', [
            'fields' => [
                'id',
                'email'
            ]
        ]);

        $this->addBehavior('Utils.Uploadable', [
            'image'
        ]);

        $this->belongsTo('Cms.Categories');

    }

    public function postType()
    {
        return [
            'menuWeight' => 26,
            'tableColumns' => [
                'id',
                'title',
                'path',
                'view' => [
                    'before' => '<a target="_blank" href="' . Configure::read('App.fullBaseUrl') . '/',
                    'get' => 'path',
                    'after' => '">View blog</a>',
                ],
                'created'
            ],
            'filters' => [
                'category_id' => [
                    'options' => $this->Categories->find('list')->toArray()
                ]
            ],
            'formFields' => [
                '_create' => [
                    'type' => 'file'
                ],
                'id',
                'title',
                'category_id',
                'slug',
                'body' => [
                     'rows' => 20,
                ],
                'image' => [
                    'type' => 'file'
                ],
                'state' => [
                    'type' => 'select',
                    'options' => $this->stateList()
                ]
            ]
        ];
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('body');

        $validator
            ->allowEmpty('image');

        $validator
            ->add('state', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('state');

        return $validator;
    }

    /**
     * beforeFind event
     *
     * @param $event
     * @param $query
     * @param $options
     * @param $primary
     */
    public function beforeFind($event, $query, $options, $primary)
    {
    }

    /**
     * beforeSave event
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Entity $entity Entity.
     * @param array $options Options.
     * @return void
     */
    public function beforeSave($event, $entity, $options)
    {
        PathManager::instance()->removeRoutes('blogs');
    }

    /**
     * afterSave event
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Entity $entity Entity.
     * @param array $options Options.
     * @return void
     */
    public function afterSave($event, $entity, $options)
    {
        PathManager::instance()->buildRoutes('blogs');

        NotificationManager::instance()->notify([
            'users' => [1],
            'template' => 'blog_post',
            'vars' => [
                'title' => $entity->title,
                'creator' => $entity->created_by,
            ]
        ]);
    }

    public function getRoutes()
    {
        $blogs = $this->find('all')
            ->select(['id', 'slug'])
            ->contain(['Categories' => function ($q) {
                return $q->select(['id', 'slug']);
            }])
            ->toArray();

        $routes = [];

        foreach ($blogs as $blog) {
            $id = $blog->id;
            $replacements = [
                'category_slug' => $blog->category->slug,
                'blog_slug' => $blog->slug,
            ];
            $slug = Text::insert(Setting::read('CMS.BlogsUrl'), $replacements);
            $routes[$id] = $slug;
        }

        return $routes;
    }
}
