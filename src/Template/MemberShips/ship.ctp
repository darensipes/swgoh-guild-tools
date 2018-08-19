<div class="card">
    <div class="card-header">
        Ship: <?= $ship->name ?> <?= !empty($ship->light_side) ? '<i class="fab fa-rebel text-primary"></i>' : '<i class="fab fa-empire text-danger"></i>' ?>
        <em class="card-text float-right"><small><?= $ship->faction_list ?></small></em>
    </div>
    <?php if (!empty($memberShips)): ?>
    <div class="card-body clearfix">
        <div class="table-responsive">
            <table id="guild-ships-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Member') ?></th>
                        <th scope="col"><?= __('Stars') ?></th>
                        <th scope="col"><?= __('Level') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($memberShips as $memberShip): ?>
                    <tr>
                        <td><?= $this->Html->link($memberShip->member->name, ['controller' => 'Members', 'action' => 'ships', 'guild' => $guild->slug, 'member' => $memberShip->member->swgoh_name]) ?></td>
                        <td><?= h($memberShip->stars) ?></td>
                        <td><?= h($memberShip->level) ?></td>
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
                    paging: false
                });
            });
        </script>
    <?php $this->end(); ?>
    <?php else: ?>
        <div class="alert alert-warning clearfix">
            <?= $guild->name ?> currently has no members with this ship. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
