<div class="row">
    <div class="col-12">
        <h3 class="text-primary"><?= $toonId ?></h3>
        <table id="toon-profile" class="table table-striped table-hover table-bordered table-responsive table-inverse" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Gear</th>
                    <th>Level</th>
                    <th>Stars</th>
                    <th>Power</th>
                    <th>Max Power</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($toon as $member) : ?>
                    <tr>
                        <td><?= $member->member ?></td>
                        <td><?= $member->gear ?></td>
                        <td><?= $member->level ?></td>
                        <td><?= $member->stars ?></td>
                        <td><?= number_format($member->power) ?></td>
                        <td><?= number_format($member->max_power) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->start('script'); ?>
    <script>
        $(function(){
            $('#toon-profile').DataTable({
                paging: false,
                searching: false,
                info: false
            });
        });
    </script>
<?php $this->end(); ?>
