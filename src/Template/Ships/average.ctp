<div class="row">
    <div class="col-12">
        <h3 class="text-primary">Star Average Per Ship</h3>
        <div class="btn-group" role="group">
            <?= $this->Html->link('All', ['?' => ['side' => 'all']], ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link('Light Side', ['?' => ['side' => 'light']], ['class' => 'btn btn-success']) ?>
            <?= $this->Html->link('Dark Side', ['?' => ['side' => 'dark']], ['class' => 'btn btn-danger']) ?>
        </div>
        <table id="weak-ships" class="table table-striped table-hover table-bordered table-responsive table-inverse" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Ship</th>
                    <th>Star Average</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ships as $ship) : ?>
                    <tr>
                        <td><?= $this->Html->link($ship->ship, ['controller' => 'Roster', 'action' => 'ship', $ship->ship]) ?></td>
                        <td><?= $ship->star_avg ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->start('script'); ?>
    <script>
        $(function(){
            $('#weak-ships').DataTable({
                paging: false,
                searching: false,
                ordering: false,
                info: false
            });
        });
    </script>
<?php $this->end(); ?>
