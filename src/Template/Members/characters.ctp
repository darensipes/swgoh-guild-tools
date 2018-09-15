<div class="card">
    <div class="card-header">
        <?= $member->name ?>: Characters
    </div>
    <?php if (!empty($member->member_characters)): ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="member-characters-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Stars') ?></th>
                        <th scope="col"><?= __('Zetas') ?></th>
                        <th scope="col"><?= __('Gear') ?></th>
                        <th scope="col"><?= __('Level') ?></th>
                        <th scope="col"><?= __('Side') ?></th>
                        <th scope="col"><?= __('Factions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($member->member_characters as $memberCharacter): ?>
                    <tr>
                        <td><?= $this->Html->link($memberCharacter->character->name, ['controller' => 'MemberCharacters', 'action' => 'character', 'character_id' => $memberCharacter->character->id, 'guild' => $member->guild->slug, 'slug' => $memberCharacter->character->slug]) ?></td>
                        <td><?= h($memberCharacter->stars) ?></td>
                        <td><?= h($memberCharacter->zetas) ?></td>
                        <td><?= h($memberCharacter->gear) ?></td>
                        <td><?= h($memberCharacter->level) ?></td>
                        <td><?= !empty($memberCharacter->character->light_side) ? '<i class="fab fa-rebel text-primary"></i><span style="display:none">Light</span>' : '<i class="fab fa-empire text-danger"></i><span style="display:none">Dark</span>' ?></td>
                        <td><?= h($memberCharacter->character->faction_list) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php $this->append('script'); ?>
        <script>
            $(function(){
                $('#member-characters-table').DataTable({
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
            <?= $member->name ?> currently has no characters. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $member->guild->name, 'guildSlug' => $member->guild->slug, 'guildUrl' => $member->guild->url])); ?>
