<div class="row">
    <div class="col-12">
        <h3 class="text-primary">Team Roster by Gear Level</h3>
        <div class="btn-group" role="group">
            <?= $this->Html->link('All', ['?' => ['side' => 'all']], ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('Light Side', ['?' => ['side' => 'light']], ['class' => 'btn btn-success']) ?>
            <?= $this->Html->link('Dark Side', ['?' => ['side' => 'dark']], ['class' => 'btn btn-danger']) ?>
        </div>
        <table id="roster-by-gear-level" class="table table-striped table-hover table-bordered table-responsive table-inverse" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Member</th>
                    <?php foreach ($toons as $toon): ?>
                        <th><?= $toon ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roster as $member => $inventory): ?>
                    <tr>
                        <td><?= $this->Html->link($member, 'https://swgoh.gg/u/' . $member . '/collection/', ['target' => '_blank']) ?></td>
                        <?php foreach ($toons as $toon): ?>
                            <?php $gear = isset($inventory[$toon]) ? $inventory[$toon] : 0; ?>
                            <?php
                                $class = '';
                                if ($gear <= 6) {
                                    $class = ' class="bg-danger"';
                                } elseif ($gear <= 9) {
                                    $class = ' class="bg-warning"';
                                } elseif ($gear <= 11) {
                                    $class = ' class="bg-success"';
                                } elseif ($gear <= 12) {
                                    $class = ' class="bg-primary"';
                                }
                            ?>
                            <td<?= $class ?>><?= isset($inventory[$toon]) ? $inventory[$toon] : null ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->start('script'); ?>
    <script>
        $(function(){
            $('#roster-by-gear-level').DataTable({
                paging: false,
                searching: false,
                info: false
            });
        });
    </script>
<?php $this->end(); ?>
