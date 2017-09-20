<?php
namespace App\Shell;

use Cake\Core\Configure;
use Cake\Console\Shell;
use Exception;

include_once(APP . 'Tools' . DS . 'simple_html_dom.php');

/**
 * Sync shell command.
 */
class SyncShell extends Shell
{

    const SITE = 'https://swgoh.gg';

    const STARS = 7;

    const GEAR_LEVELS = [
        'I' => 1,
        'II' => 2,
        'III' => 3,
        'IV' => 4,
        'V' => 5,
        'VI' => 6,
        'VII' => 7,
        'VIII' => 8,
        'IX' => 9,
        'X' => 10,
        'XI' => 11,
        'XII' => 12
    ];

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        Configure::write('debug', true);
        $this->loadModel('Roster');
        $this->loadModel('Ships');
        $members = $this->getGuildMembers(Configure::read('Guild.number'), Configure::read('Guild.name'));
        $this->pruneOldMembers($members);
        $count = 0;
        $limit = 50;
        foreach ($members as $member) {
            if ($count++ <= $limit) {
                $toons = $this->getToons($member);
                foreach ($toons as $toon => $data) {
                    $roster = $this->Roster
                         ->find()
                         ->where([
                            'Roster.member' => $member,
                            'Roster.toon' => $toon,
                        ])
                        ->first();

                    if (empty($roster)) {
                        $roster = $this->Roster->newEntity([
                            'member' => $member,
                            'toon' => $toon,
                            'level' => $data['level'],
                            'stars' => $data['stars'],
                            'gear' => $data['gear'],
                            'power' => $data['power'],
                            'max_power' => $data['max_power'],
                            'light_side' => $data['light_side']
                        ]);
                    } else {
                        $roster->level = $data['level'];
                        $roster->stars = $data['stars'];
                        $roster->gear = $data['gear'];
                        $roster->power = $data['power'];
                        $roster->max_power = $data['max_power'];
                        $roster->light_side = $data['light_side'];
                    }

                    if ($this->Roster->save($roster)) {
                        $this->out('Saving: [' . $roster->member . '][' . $roster->toon . '] ' . 'Level: ' . $roster->level . ' Gear: ' . $roster->gear . ' Stars:' . $roster->stars);
                    } else {
                        $this->out('<error>Not Saving: [' . $roster->member . '][' . $roster->toon . '] ' . 'Level: ' . $roster->level . ' Gear: ' . $roster->gear . ' Stars:' . $roster->stars . '</error>');
                    }
                }

                $ships = $this->getShips($member);
                foreach ($ships as $ship => $data) {
                    $roster = $this->Ships
                         ->find()
                         ->where([
                            'Ships.member' => $member,
                            'Ships.ship' => $ship,
                        ])
                        ->first();

                    if (empty($roster)) {
                        $roster = $this->Ships->newEntity([
                            'member' => $member,
                            'ship' => $ship,
                            'level' => $data['level'],
                            'stars' => $data['stars'],
                            'power' => $data['power'],
                            'max_power' => $data['max_power'],
                            'light_side' => $data['light_side']
                        ]);
                    } else {
                        $roster->level = $data['level'];
                        $roster->stars = $data['stars'];
                        $roster->power = $data['power'];
                        $roster->max_power = $data['max_power'];
                        $roster->light_side = $data['light_side'];
                    }

                    if ($this->Ships->save($roster)) {
                        $this->out('Saving: [' . $roster->member . '][' . $roster->ship . '] ' . 'Level: ' . $roster->level . ' Stars:' . $roster->stars);
                    } else {
                        $this->out('<error>Not Saving: [' . $roster->member . '][' . $roster->toon . '] ' . 'Level: ' . $roster->level . ' Stars:' . $roster->stars . '</error>');
                    }
                }
            }
        }
    }

    private function pruneOldMembers($currentMembers = [])
    {
        if (!empty($currentMembers)) {
            $this->Roster->deleteAll(['Roster.member NOT IN' => $currentMembers]);
        }
    }

    private function getGuildMembers($guildId, $guildShortName)
    {
        $members = [];
        $html = file_get_html(sprintf("%s/g/%d/%s/", self::SITE, $guildId, $guildShortName));
        foreach ($html->find('table[class="table"] td a') as $element) {
            preg_match("/\/u\/(.*)\//", $element->href, $matches)[1];
            $members[] = $matches[1];
        }

        return $members;
    }

    private function getToons($username)
    {
        Configure::write('debug', true);
        $toons = [];
        $html = file_get_html(sprintf("%s/u/%s/collection/", self::SITE, $username));
        foreach ($html->find('div[class="collection-char"]') as $element) {
            $name = !empty($element->find('div[class="collection-char-name"]', 0)->plaintext) ? html_entity_decode($element->find('div[class="collection-char-name"]', 0)->plaintext, ENT_QUOTES) : null;
            $level = !empty($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) ? $element->find('div[class="char-portrait-full-level"]', 0)->plaintext : 0;

            if (!empty($level)) {
                $inactiveStars = $element->find('div[class="star-inactive"]');
                $toons[$name]['stars'] = self::STARS - count($inactiveStars);
                $toons[$name]['level'] = !empty($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) ? (int) $element->find('div[class="char-portrait-full-level"]', 0)->plaintext : null;
                $toons[$name]['gear'] = !empty($element->find('div[class="char-portrait-full-gear-level"]', 0)->plaintext) ? self::GEAR_LEVELS[$element->find('div[class="char-portrait-full-gear-level"]', 0)->plaintext] : null;
                $toons[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $powerString = $element->find('div[class="collection-char-gp"]', 0)->getAttribute('title');

                if (stripos($powerString, '/') !== false) {
                    list($power, $maxPower) = explode('/', $powerString);
                    $power = preg_replace('/[^0-9]/', '', $power);
                    $maxPower = preg_replace('/[^0-9]/', '', $maxPower);
                }

                if (!empty($power) && !empty($maxPower)) {
                    $toons[$name]['power'] = $power;
                    $toons[$name]['max_power'] = $maxPower;
                }
            } else {
                $toons[$name]['stars'] = 0;
                $toons[$name]['level'] = 0;
                $toons[$name]['gear'] = 0;
                $toons[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $toons[$name]['power'] = 0;
                $toons[$name]['max_power'] = 0;
            }
        }

        return $toons;
    }

    private function getShips($username)
    {
        Configure::write('debug', true);
        $ships = [];
        $html = file_get_html(sprintf("%s/u/%s/ships/", self::SITE, $username));
        foreach ($html->find('div[class="collection-ship"]') as $element) {
            $name = !empty($element->find('div[class="collection-ship-name"]', 0)->plaintext) ? html_entity_decode($element->find('div[class="collection-ship-name"]', 0)->plaintext, ENT_QUOTES) : null;
            $level = !empty($element->find('div[class="ship-portrait-full-frame-level"]', 0)->plaintext) ? $element->find('div[class="ship-portrait-full-frame-level"]', 0)->plaintext : 0;

            if (!empty($level)) {
                $inactiveStars = $element->find('div[class="ship-portrait-full-star-inactive"]');
                $ships[$name]['stars'] = self::STARS - count($inactiveStars);
                $ships[$name]['level'] = !empty($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) ? (int) $element->find('div[class="char-portrait-full-level"]', 0)->plaintext : null;
                $ships[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $powerString = $element->find('div[class="collection-char-gp"]', 0)->getAttribute('title');

                if (stripos($powerString, '/') !== false) {
                    list($power, $maxPower) = explode('/', $powerString);
                    $power = preg_replace('/[^0-9]/', '', $power);
                    $maxPower = preg_replace('/[^0-9]/', '', $maxPower);
                }

                if (!empty($power) && !empty($maxPower)) {
                    $ships[$name]['power'] = $power;
                    $ships[$name]['max_power'] = $maxPower;
                }
            } else {
                $ships[$name]['stars'] = 0;
                $ships[$name]['level'] = 0;
                $ships[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $ships[$name]['power'] = 0;
                $ships[$name]['max_power'] = 0;
            }
        }

        return $ships;
    }
}
