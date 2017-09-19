<div class="row">
    <div class="col-12">
        <h3 class="text-primary"><?= $memberId ?></h3>
        <?= $this->Html->link('View Profile on swgoh.gg', 'https://swgoh.gg/u/' . $memberId . '/ships/', ['target' => '_blank']) ?><br>
        <?= $this->Html->link('View Member\'s Toons', ['controller' => 'Roster', 'action' => 'member', $memberId]) ?>
        <table id="member-profile" class="table table-striped table-hover table-bordered table-responsive table-inverse" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Ship</th>
                    <th>Level</th>
                    <th>Stars</th>
                    <th>Side</th>
                    <th>Power</th>
                    <th>Max Power</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($member as $ship) : ?>
                    <tr>
                        <td><?= $ship->ship ?></td>
                        <td><?= $ship->level ?></td>
                        <td><?= $ship->stars ?></td>
                        <td><?= $ship->light_side === true ? 'Light' : 'Dark' ?></td>
                        <td><?= number_format($ship->power) ?></td>
                        <td><?= number_format($ship->max_power) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->start('script'); ?>
    <script>
        $(function(){
            $('#member-profile').DataTable({
                paging: false,
                searching: false,
                info: false
            });
        });
    </script>
<?php $this->end(); ?>
