<div class="row">
    <div class="col-12">
        <h3 class="text-primary">Guild Members</h3>
        <ol>
            <?php foreach ($members as $member) : ?>
                <li><?= $this->Html->link($member, ['controller' => 'Roster', 'action' => 'member', $member]) ?></li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
