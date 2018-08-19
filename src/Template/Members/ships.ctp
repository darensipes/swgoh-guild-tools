<div class="card">
    <div class="card-header">
        <?= $member->name ?>: Ships
    </div>
    <?php if (!empty($member->member_ships)): ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="member-ships-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Stars') ?></th>
                        <th scope="col"><?= __('Level') ?></th>
                        <th scope="col"><?= __('Side') ?></th>
                        <th scope="col"><?= __('Factions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($member->member_ships as $memberShip): ?>
                    <tr>
                        <td><?= $this->Html->link($memberShip->ship->name, ['controller' => 'MemberShips', 'action' => 'ship', 'ship_id' => $memberShip->ship->id, 'guild' => $member->guild->slug, 'slug' => $memberShip->ship->slug]) ?></td>
                        <td><?= h($memberShip->stars) ?></td>
                        <td><?= h($memberShip->level) ?></td>
                        <td><?= !empty($memberShip->ship->light_side) ? '<i class="fab fa-rebel text-primary"></i><span style="display:none">Light</span>' : '<i class="fab fa-empire text-danger"></i><span style="display:none">Dark</span>' ?></td>
                        <td><?= h($memberShip->ship->faction_list) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php $this->append('script'); ?>
        <script>
            $(function(){
                $('#member-ships-table').DataTable({
                    paging: false,
                    columnDefs: [
                        { orderable: false, targets: -1 }
                    ]
                });
            });
        </script>
    <?php $this->end(); ?>
    <?php else: ?>
        <div class="alert alert-warning">
            <?= $member->name ?> currently has no ships. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $member->guild->name, 'guildSlug' => $member->guild->slug, 'guildUrl' => $member->guild->url])); ?>
