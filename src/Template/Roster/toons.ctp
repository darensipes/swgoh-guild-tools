<div class="row">
    <div class="col-12">
        <h3 class="text-primary">Toons</h3>
        <ol>
            <?php foreach ($toons as $toon) : ?>
                <li><?= $this->Html->link($toon, ['controller' => 'Roster', 'action' => 'toon', $toon]) ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
