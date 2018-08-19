<div class="card">
    <div class="card-header">
        <?= $guild->name ?>: Ships
    </div>
    <?php if (!empty($ships)): ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="guild-ships-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Side') ?></th>
                        <th scope="col"><?= __('Factions') ?></th>
                        <th scope="col"><?= __('Star Average') ?></th>
                        <th scope="col"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($ships as $ship): ?>
                    <tr>
                        <td><?= $this->Html->link($ship->name, ['controller' => 'MemberShips', 'action' => 'ship', 'ship_id' => $ship->id, 'guild' => $guild->slug, 'slug' => $ship->slug]) ?></td>
                        <td><?= !empty($ship->light_side) ? '<i class="fab fa-rebel text-primary"></i><span style="display:none">Light</span>' : '<i class="fab fa-empire text-danger"></i><span style="display:none">Dark</span>' ?></td>
                        <td><?= h($ship->faction_list) ?></td>
                        <td><?= number_format($ship->average, 1) ?></td>
                        <td><?= $this->Html->link('View Members', ['controller' => 'MemberShips', 'action' => 'ship', 'ship_id' => $ship->id, 'guild' => $guild->slug, 'slug' => $ship->slug], ['class' => 'btn btn-outline-success btn-xs']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php $this->append('script'); ?>
        <script>
            $(function(){
                $('#guild-ships-table').DataTable({
                    paging: false,
                    columnDefs: [
                        { orderable: false, targets: [-1, -3] }
                    ]
                });
            });
        </script>
    <?php $this->end(); ?>
    <?php else: ?>
        <div class="alert alert-warning">
            <?= $guild->name ?> currently has no ships. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
