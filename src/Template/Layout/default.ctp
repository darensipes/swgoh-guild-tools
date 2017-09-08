<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GotW Guild Tools</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
        <?= $this->fetch('meta') ?>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <?= $this->Html->link($this->Html->image('icon.png', ['class' => 'd-inline-block align-top', 'height' => 30, 'width' => 30]) . ' GotW ' . \Cake\Core\Configure::read('Guild.long_name') , ['controller' => 'Roster', 'action' => 'stars'], ['escape' => false, 'class' => 'navbar-brand']) ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" onclick="return false" id="roster-items" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Roster
                        </a>
                        <div class="dropdown-menu" aria-labelledby="roster-items">
                            <?= $this->Html->link('By Stars', ['controller' => 'Roster', 'action' => 'stars'], ['class' => 'dropdown-item']) ?>
                            <?= $this->Html->link('By Gear', ['controller' => 'Roster', 'action' => 'gear'], ['class' => 'dropdown-item']) ?>
                            <?= $this->Html->link('By Level', ['controller' => 'Roster', 'action' => 'level'], ['class' => 'dropdown-item']) ?>
                            <?= $this->Html->link('By Power', ['controller' => 'Roster', 'action' => 'power'], ['class' => 'dropdown-item']) ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Guild Members', ['controller' => 'Roster', 'action' => 'members'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Toons', ['controller' => 'Roster', 'action' => 'toons'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Star Average', ['controller' => 'Roster', 'action' => 'average'], ['class' => 'nav-link']) ?>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
        <?= $this->fetch('script') ?>
    </body>
</html>
