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
?>
<div class="row">
    <h1>
        <?= $category->title ?>
    </h1>
    <div class="column large-8">

        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <a href="<?= $this->Cms->geturl('blogs', $blog->get('id')) ?>">
                    <div class="column large-6">
                        <h4><?= $blog->get('title') ?></h4>
                        <hr>
                        <?= h($blog->get('excerpt')) ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="column large-4">
        <?= $this->element('Sidebar') ?>
    </div>
</div>
