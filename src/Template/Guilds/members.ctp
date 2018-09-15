<div class="card">
    <div class="card-header">
        <?= $guild->name ?>: Members
    </div>
    <?php if (!empty($guild->members)): ?>
    <div class="card-body">
        <div class="table-responsive">
            <table id="guild-members-table" class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th scope="col"><?= __('Name') ?></th>
                        <th scope="col"><?= __('Swgoh Number') ?></th>
                        <th scope="col" class="text-center" style="width:10rem"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($guild->members as $member): ?>
                    <tr>
                        <td><?= h($member->name) ?></td>
                        <td><?= $this->Html->link($member->swgoh_number, $member->url, ['title' => 'View Profile on swgoh.gg', 'target' => '_blank', 'data-toggle' => 'tooltip']) ?></td>
                        <td class="text-center">
                            <?= $this->Html->link(__('Characters'), ['controller' => 'Members', 'action' => 'characters', 'guild' => $guild->slug, 'member' => $member->swgoh_number], ['class' => 'btn btn-outline-primary btn-xs']) ?>
                            <?= $this->Html->link(__('Ships'), ['controller' => 'Members', 'action' => 'ships', 'guild' => $guild->slug, 'member' => $member->swgoh_number], ['class' => 'btn btn-outline-info btn-xs']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php $this->append('script'); ?>
        <script>
            $(function(){
                $('#guild-members-table').DataTable({
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
            <?= $guild->name ?> currently has no members. Please check back later...
        </div>
    <?php endif; ?>
</div>
<?php $this->assign('navbar', $this->element('navbar', ['guildName' => $guild->name, 'guildSlug' => $guild->slug, 'guildUrl' => $guild->url])); ?>
