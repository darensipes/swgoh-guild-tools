<div class="row">
    <div class="col-12">
        <h3 class="text-primary">Team Roster by Star Count</h3>
        <div class="btn-group" role="group">
            <?= $this->Html->link('All', ['?' => ['side' => 'all']], ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('Light Side', ['?' => ['side' => 'light']], ['class' => 'btn btn-success']) ?>
            <?= $this->Html->link('Dark Side', ['?' => ['side' => 'dark']], ['class' => 'btn btn-danger']) ?>
        </div>
        <table id="roster-by-star-count" class="table table-striped table-hover table-bordered table-responsive table-inverse" cellspacing="0" width="100%">
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
                            <?php $stars = isset($inventory[$toon]) ? $inventory[$toon] : 0; ?>
                            <?php
                                $class = '';
                                if ($stars <= 3) {
                                    $class = ' class="bg-danger"';
                                } elseif ($stars <= 6) {
                                    $class = ' class="bg-warning"';
                                } elseif ($stars >= 7) {
                                    $class = ' class="bg-success"';
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
            $('#roster-by-star-count').DataTable({
                paging: false,
                searching: false,
                info: false
            });
        });
    </script>
<?php $this->end(); ?>
