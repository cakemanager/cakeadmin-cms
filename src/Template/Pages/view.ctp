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

//debug($page);
?>
<div class="row">
    <div class="column large-12">
        <h1>
            <?= $page->title ?>
        </h1>
    </div>
    <div class="column large-8">
        <div>
            <?= (new Parsedown())->text($page->body) ?>
        </div>
    </div>
    <div class="column large-4">
        <?= $this->element('Sidebar') ?>
    </div>
</div>


