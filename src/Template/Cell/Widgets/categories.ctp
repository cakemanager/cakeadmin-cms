<div class="row">
    <h4>Categories</h4>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li><a href="<?= $category->get('path') ?>"><?= $category->get('title') ?></a></li>
        <?php endforeach ?>
    </ul>
</div>