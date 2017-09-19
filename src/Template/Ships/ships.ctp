<div class="row">
    <div class="col-12">
        <h3 class="text-primary">Ships</h3>
        <ol>
            <?php foreach ($ships as $ship) : ?>
                <li><?= $this->Html->link($ship, ['controller' => 'Ships', 'action' => 'ship', $ship]) ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
