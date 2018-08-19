<?php
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Home Route
    $routes->connect('/', ['controller' => 'guilds', 'action' => 'index']);

    // Member Route
    $routes->connect(':guild/members/*', ['controller' => 'Guilds', 'action' => 'members'])->setPass(['guild']);

    // Character Routes
    $routes->connect(':guild/characters', ['controller' => 'Guilds', 'action' => 'characters'])->setPass(['guild']);
    $routes->connect(':guild/characters/:action', ['controller' => 'MemberCharacters'])->setPass(['guild']);
    $routes->connect(':guild/:member/characters/*', ['controller' => 'Members', 'action' => 'characters'])->setPass(['guild', 'member']);
    $routes->connect(':guild/character/:character_id-:slug', ['controller' => 'MemberCharacters', 'action' => 'character'])->setPass(['character_id', 'guild', 'slug'])->setPatterns(['character_id' => '[0-9]+']);
    $routes->connect(':guild/characters/:action', ['controller' => 'MemberCharacters'])->setPass(['guild']);

    // Ship Routes
    $routes->connect(':guild/ships', ['controller' => 'Guilds', 'action' => 'ships'])->setPass(['guild']);
    $routes->connect(':guild/ships/:action', ['controller' => 'MemberShips'])->setPass(['guild']);
    $routes->connect(':guild/:member/ships/*', ['controller' => 'Members', 'action' => 'ships'])->setPass(['guild', 'member']);
    $routes->connect(':guild/ship/:ship_id-:slug', ['controller' => 'MemberShips', 'action' => 'ship'])->setPass(['ship_id', 'guild', 'slug'])->setPatterns(['ship_id' => '[0-9]+']);
    $routes->connect(':guild/ships/:action', ['controller' => 'MemberShips'])->setPass(['guild']);

    // Default Pages Route
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->fallbacks(DashedRoute::class);
});
