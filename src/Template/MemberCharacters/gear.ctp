<div class="card">
    <div class="card-header">
        <?= $guild->name ?>: Characters By Stars
    </div>
    <?php if (!empty($memberCharacters) && !empty($characters)): ?>
    <div class="card-body clearfix">
        <div class="table-responsive">
            <table id="guild-characters-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Member') ?></th>
                        <?php foreach ($characters as $characterId => $character) : ?>
                            <th scope="col"><?= __($character) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($memberCharacters as $memberSwgohName => $charactersByStars) : ?>
                    <tr>
                        <td><?= $this->Html->link($members[$memberSwgohName], ['controller' => 'Members', 'action' => 'characters', 'guild' => $guild->slug, 'member' => $memberSwgohName]) ?></td>
                        <?php foreach ($characters as $characterId => $character) : ?>
                            <?php $gear = isset($charactersByStars[$characterId]) ? $charactersByStars[$characterId] : 0; ?>
                            <?php if ($gear >= 12) :?>
                                <td scope="col" class="text-center bg-gear-gold"><?= $gear ?></td>
                            <?php elseif ($gear >= 7) : ?>
                                <td scope="col" class="text-center bg-gear-purple"><?= $gear ?></td>
                            <?php elseif ($gear >= 4) : ?>
                                <td scope="col" class="text-center bg-gear-blue"><?= $gear ?></td>
                            <?php elseif ($gear >= 2) : ?>
                                <td scope="col" class="text-center bg-gear-green"><?= $gear ?></td>
                            <?php else : ?>
                                <td scope="col" class="text-center bg-gear-grey"><?= $gear ?></td>
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
                $('#guild-characters-table').DataTable({
                    paging: false
                });
            });
        </script>
    <?php $this->end(); ?>
    <?php else: ?>
        <div class="alert alert-warning clearfix">
            <?= $guild->name ?> currently has no characters. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
