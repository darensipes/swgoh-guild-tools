<div class="card">
    <div class="card-header">
        <?= $guild->name ?>: Ships By Stars
    </div>
    <?php if (!empty($memberShips) && !empty($ships)): ?>
    <div class="card-body clearfix">
        <div class="table-responsive">
            <table id="guild-ships-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Member') ?></th>
                        <?php foreach ($ships as $shipId => $ship) : ?>
                            <th scope="col"><?= __($ship) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($memberShips as $memberSwgohName => $shipsByStars) : ?>
                    <tr>
                        <td><?= $this->Html->link($members[$memberSwgohName], ['controller' => 'Members', 'action' => 'ships', 'guild' => $guild->slug, 'member' => $memberSwgohName]) ?></td>
                        <?php foreach ($ships as $shipId => $ship) : ?>
                            <?php $level = isset($shipsByStars[$shipId]) ? $shipsByStars[$shipId] : 0; ?>
                            <?php if ($level >= 85) :?>
                                <td scope="col" class="text-center table-success"><?= $level ?></td>
                            <?php elseif ($level >= 53) : ?>
                                <td scope="col" class="text-center table-warning"><?= $level ?></td>
                            <?php else : ?>
                                <td scope="col" class="text-center table-danger"><?= $level ?></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
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
            <?= $guild->name ?> currently has no ships. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
