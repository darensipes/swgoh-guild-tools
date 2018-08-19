<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="character-items" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Characters
            </a>
            <div class="dropdown-menu" aria-labelledby="character-items">
                <?= $this->Html->link('List', ['controller' => 'Guilds', 'action' => 'characters', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link('By Stars', ['controller' => 'MemberCharacters', 'action' => 'stars', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link('By Level', ['controller' => 'MemberCharacters', 'action' => 'level', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link('By Gear', ['controller' => 'MemberCharacters', 'action' => 'gear', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="ship-items" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ships
            </a>
            <div class="dropdown-menu" aria-labelledby="ship-items">
                <?= $this->Html->link('List', ['controller' => 'Guilds', 'action' => 'ships', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link('By Stars', ['controller' => 'MemberShips', 'action' => 'stars', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
                <?= $this->Html->link('By Level', ['controller' => 'MemberShips', 'action' => 'level', 'guild' => $guildSlug], ['class' => 'dropdown-item']) ?>
            </div>
        </li>
        <li class="nav-item">
            <?= $this->Html->link('Members', ['controller' => 'Guilds', 'action' => 'members', 'guild' => $guildSlug], ['class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link('Guilds', ['controller' => 'Guilds', 'action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
    </ul>
</div>
<?= $this->Html->link($guildName, $guildUrl, ['target' => '_blank', 'class' => 'nav-link', 'data-toggle' => 'tooltip', 'title' => 'View Guild on swgoh.gg']) ?>
