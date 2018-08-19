<div class="row">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="card">
            <?= $this->Html->image('gotw.jpg', ['class' => 'card-img-top']) ?>
            <div class="card-header">
                Alliance Guilds
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($guilds as $guild): ?>
                    <li class="list-group-item">
                        <?= $this->Html->link($guild->name . ' <i class="fas fa-arrow-alt-circle-right"></i>', ['action' => 'members', 'guild' => $guild->slug], ['escape' => false, 'class' => 'text-secondary', 'title' => 'Load ' . $guild->name]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

