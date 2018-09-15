<div class="card">
    <div class="card-header">
        Character: <?= $character->name ?> <?= !empty($character->light_side) ? '<i class="fab fa-rebel text-primary"></i>' : '<i class="fab fa-empire text-danger"></i>' ?>
        <em class="card-text float-right"><small><?= $character->faction_list ?></small></em>
    </div>
    <?php if (!empty($memberCharacters)): ?>
    <div class="card-body clearfix">
        <div class="table-responsive">
            <table id="guild-characters-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Member') ?></th>
                        <th scope="col"><?= __('Stars') ?></th>
                        <th scope="col"><?= __('Gear') ?></th>
                        <th scope="col"><?= __('Level') ?></th>
                        <th scope="col"><?= __('Zetas') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($memberCharacters as $memberCharacter): ?>
                    <tr>
                        <td><?= $this->Html->link($memberCharacter->member->name, ['controller' => 'Members', 'action' => 'characters', 'guild' => $guild->slug, 'member' => $memberCharacter->member->swgoh_number]) ?></td>
                        <td><?= h($memberCharacter->stars) ?></td>
                        <td><?= h($memberCharacter->gear) ?></td>
                        <td><?= h($memberCharacter->level) ?></td>
                        <td><?= h($memberCharacter->zetas) ?></td>
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
                    paging: false
                });
            });
        </script>
    <?php $this->end(); ?>
    <?php else: ?>
        <div class="alert alert-warning clearfix">
            <?= $guild->name ?> currently has no members with this character. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
