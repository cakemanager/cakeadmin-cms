<div class="row">
    <h4>Recent blogs</h4>
    <ul>
        <?php foreach ($blogs as $blog): ?>
            <li><a href="<?= $blog->get('path') ?>"><?= $blog->get('title') ?></a></li>
        <?php endforeach ?>
    </ul>
</div>