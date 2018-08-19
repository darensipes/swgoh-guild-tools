<div class="card">
    <div class="card-header">
        <?= $guild->name ?>: Characters
    </div>
    <?php if (!empty($characters)): ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="guild-characters-table" class="table table-striped table-bordered table-sm">
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
                <?php foreach ($characters as $character): ?>
                    <tr>
                        <td><?= $this->Html->link($character->name, ['controller' => 'MemberCharacters', 'action' => 'character', 'character_id' => $character->id, 'guild' => $guild->slug, 'slug' => $character->slug]) ?></td>
                        <td><?= !empty($character->light_side) ? '<i class="fab fa-rebel text-primary"></i><span style="display:none">Light</span>' : '<i class="fab fa-empire text-danger"></i><span style="display:none">Dark</span>' ?></td>
                        <td><?= h($character->faction_list) ?></td>
                        <td><?= number_format($character->average, 1) ?></td>
                        <td><?= $this->Html->link('Show Members', ['controller' => 'MemberCharacters', 'action' => 'character', 'character_id' => $character->id, 'guild' => $guild->slug, 'slug' => $character->slug], ['class' => 'btn btn-outline-success btn-xs']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php $this->append('script'); ?>
        <script>
            $(function(){
                $('#guild-characters-table').DataTable({
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
            <?= $guild->name ?> currently has no characters. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
