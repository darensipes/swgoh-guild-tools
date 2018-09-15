<?php
namespace App\Shell;

use App\Model\Entity\Guild;
use App\Model\Entity\Member;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Console\Shell;
use Cake\I18n\Time;
use Cake\Utility\Hash;

include_once(APP . 'Tools' . DS . 'simple_html_dom.php');

/**
 * Sync shell command.
 */
class SyncShell extends Shell
{
    /**
     * Site
     */
    const SITE = 'https://swgoh.gg';

    /**
     * Stars
     */
    const STARS = 7;

    /**
     * Gear Levels
     */
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
     * Init Function
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Guilds');
        $this->loadModel('Members');
        $this->loadModel('Characters');
        $this->loadModel('Ships');
    }

    /**
     * Main Function
     *
     * @return void
     */
    public function main()
    {
        Configure::write('debug', true);
        $guilds = $this->Guilds->find();

        if (!empty($this->params['guildId'])) {
            $guilds->where(['id' => $this->params['guildId']]);
        } else {
            $syncUtcHour = (new Time())->format('H');
            $guilds->where(['sync_utc_hour' => $syncUtcHour]);
        }

        foreach ($guilds as $guild) {
            $this->syncGuild($guild);
            $members = $this->Members
                ->find()
                ->contain([
                    'Guilds'
                ])
                ->where([
                    'Members.guild_id' => $guild->id,
                ]);

            foreach ($members as $member) {
                $this->hr();
                $this->out('Working with Member: ' . $member->name);
                $this->hr();
                $this->syncCharacters($member);
                $this->syncShips($member);
                sleep(1);
            }
        }
    }

    public function base()
    {
        Configure::write('debug', true);
        $this->syncBaseCharacters();
        $this->syncBaseShips();
    }

    private function syncBaseCharacters()
    {
        try {
            $html = file_get_html('https://swgoh.gg/');
        } catch (Exception $e) {
            return [];
        }
        $factions = $this->Characters->Factions->find('list')->toArray();
        foreach ($html->find('li[class="character"]') as $element) {
            $characterName = trim(html_entity_decode($element->getAttribute('data-name-lower'), ENT_QUOTES));
            $tags = $element->getAttribute('data-tags');
            $character = $this->Characters
                ->find()
                ->where(['Characters.name' => $characterName])
                ->first();
            if (!empty($character)) {
                $ids = [];
                foreach ($factions as $factionId => $faction) {
                    if (stripos($tags, $faction) !== false) {
                        $ids[] = $factionId;
                    }
                }

                if (!empty($ids)) {
                    $character = $this->Characters->patchEntity($character, ['factions' => ['_ids' => $ids]]);
                    if (!$this->Characters->save($character)) {
                        $this->out('<error>Unable to save factions for: ' . $characterName . '</error>');
                    }
                }
            } else {
                $this->out('<error>Character Not Found: ' . $characterName . '</error>');
            }
        }
    }

    private function syncBaseShips()
    {
        try {
            $html = file_get_html('https://swgoh.gg/ships/');
        } catch (Exception $e) {
            return [];
        }
        $factions = $this->Ships->Factions->find('list')->toArray();
        foreach ($html->find('li[class="character"]') as $element) {
            $shipName = trim(html_entity_decode($element->getAttribute('data-name-lower'), ENT_QUOTES));
            $tags = $element->getAttribute('data-tags');
            $ship = $this->Ships
                ->find()
                ->where(['Ships.name' => $shipName])
                ->first();
            if (!empty($ship)) {
                $ids = [];
                foreach ($factions as $factionId => $faction) {
                    if (stripos($tags, $faction) !== false) {
                        $ids[] = $factionId;
                    }
                }

                if (!empty($ids)) {
                    $ship = $this->Ships->patchEntity($ship, ['factions' => ['_ids' => $ids]]);
                    if (!$this->Ships->save($ship)) {
                        $this->out('<error>Unable to save factions for: ' . $shipName . '</error>');
                    }
                }
            } else {
                $this->out('<error>Ship Not Found: ' . $shipName . '</error>');
            }
        }
    }

    private function syncGuild(Guild $guild)
    {
        $swgohMembers = $this->getGuildMembersFromSwgoh($guild->url);

        if (!empty($swgohMembers)) {
            $this->pruneMembers($guild->id, array_keys($swgohMembers));
        }

        $this->syncMembers($swgohMembers, $guild->id);
    }

    private function syncMembers(array $swgohMembers, $guildId)
    {
        foreach ($swgohMembers as $swgohNumber => $inGameName) {
            $member = $this->Members
                ->find()
                ->where([
                    'Members.swgoh_number' => $swgohNumber,
                    'Members.guild_id' => $guildId
                ])
                ->first();

            if (empty($member)) {
                $member = $this->Members->newEntity([
                    'name' => $inGameName,
                    'swgoh_number' => $swgohNumber,
                    'guild_id' => $guildId
                ]);
            } else {
                $member = $this->Members->patchEntity($member, [
                    'name' => $inGameName,
                    'swgoh_number' => $swgohNumber,
                    'guild_id' => $guildId
                ]);
            }

            $newRecord = $member->isNew();
            if ($this->Members->save($member)) {
                if ($newRecord) {
                    $this->out('<success>Saving New Member: ' . $inGameName . '</success>');
                } else {
                    $this->out('<success>Updating Existing Member: ' . $inGameName . '</success>');
                }
            } else {
                $this->out('<error>Failed to Save Member!</error>');
            }
        }
    }

    private function getGuildMembersFromSwgoh($url)
    {
        $members = [];
        $html = file_get_html($url);
        foreach ($html->find('table[class="table"] td a') as $element) {
            preg_match("/\/p\/(.*)\//", $element->href, $matches)[1];
            $members[trim(rawurldecode($matches[1]))] = trim($element->plaintext);
        }

        return $members;
    }

    private function pruneMembers($guildId, array $newMembers = [])
    {
        $members = $this->Members
            ->find()
            ->where(['Members.guild_id' => $guildId]);

        foreach ($members as $member) {
            if (!in_array($member->swgoh_number, $newMembers)) {
                if ($this->Members->delete($member)) {
                    $this->out('<warning>Deleting Old Guild Member: ' . $member->name . '</warning>');
                }
            }
        }
    }

    private function syncCharacters(Member $member)
    {
        $swgohCharacters = $this->getCharacters($member->characters_url);
        ksort($swgohCharacters);
        $characters = $this->Characters->find('list', ['keyField' => 'name', 'valueField' => 'id'])->toArray();
        foreach ($swgohCharacters as $swgohCharacterName => $swgohCharacterData) {
            if (!empty($characters[$swgohCharacterName])) {
                $characterId = $characters[$swgohCharacterName];
            } else {
                $character = $this->Characters->newEntity([
                    'name' => $swgohCharacterName,
                    'light_side' => $swgohCharacterData['light_side']
                ]);

                if ($this->Characters->save($character)) {
                    $this->out('<success>Saving New Character: ' . $swgohCharacterName . '</success>');
                    $characterId = $character->id;
                } else {
                    $this->out('<error>Unable to save New Character: ' . $swgohCharacterName . '</error>');
                }
            }

            if (!empty($characterId)) {
                $memberCharacter = $this->Members->MemberCharacters
                    ->find()
                    ->where([
                        'MemberCharacters.member_id' => $member->id,
                        'MemberCharacters.character_id' => $characterId
                    ])
                    ->first();
                if (!empty($memberCharacter)) {
                    $memberCharacter = $this->Members->MemberCharacters->patchEntity($memberCharacter, [
                        'level' => $swgohCharacterData['level'],
                        'stars' => $swgohCharacterData['stars'],
                        'gear' => $swgohCharacterData['gear'],
                        'zetas' => $swgohCharacterData['zetas'],
                    ]);
                } else {
                    $memberCharacter = $this->Members->MemberCharacters->newEntity([
                        'member_id' => $member->id,
                        'character_id' => $characterId,
                        'level' => $swgohCharacterData['level'],
                        'stars' => $swgohCharacterData['stars'],
                        'gear' => $swgohCharacterData['gear'],
                        'zetas' => $swgohCharacterData['zetas'],
                    ]);
                }
                $newRecord = $memberCharacter->isNew();
                if ($this->Members->MemberCharacters->save($memberCharacter)) {
                    if ($newRecord) {
                        $this->out('<success>Saving New Member Character: ' . $swgohCharacterName . '</success>');
                    } else {
                        $this->out('<success>Updating Existing Member Character: ' . $swgohCharacterName . '</success>');
                    }
                } else {
                    $this->out('<error>Failed to Save Member Character: ' . $swgohCharacterName . '</error>');
                }

            } else {
                $this->out('<error>Missing Character ID for Character: ' . $swgohCharacterName . '</error>');
            }
        }
    }

    private function getCharacters($url)
    {
        $characters = [];
        try {
            $html = file_get_html($url);
        } catch (Exception $e) {
            return [];
        }
        foreach ($html->find('div[class="collection-char"]') as $element) {
            $name = !empty($element->find('div[class="collection-char-name"]', 0)->plaintext) ? trim(html_entity_decode($element->find('div[class="collection-char-name"]', 0)->plaintext, ENT_QUOTES)) : null;
            $level = !empty($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) ? trim($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) : 0;

            if (!empty($level)) {
                $inactiveStars = $element->find('div[class="star-inactive"]');
                $characters[$name]['stars'] = self::STARS - count($inactiveStars);
                $characters[$name]['level'] = !empty($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) ? (int) trim($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) : null;
                $characters[$name]['zetas'] = !empty($element->find('div[class="char-portrait-full-zeta"]', 0)->plaintext) ? (int) trim($element->find('div[class="char-portrait-full-zeta"]', 0)->plaintext) : 0;
                $characters[$name]['gear'] = !empty($element->find('div[class="char-portrait-full-gear-level"]', 0)->plaintext) ? self::GEAR_LEVELS[trim($element->find('div[class="char-portrait-full-gear-level"]', 0)->plaintext)] : null;
                $characters[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $powerString = trim($element->find('div[class="collection-char-gp"]', 0)->getAttribute('title'));

                if (stripos($powerString, '/') !== false) {
                    list($power, $maxPower) = explode('/', $powerString);
                    $power = preg_replace('/[^0-9]/', '', $power);
                    $maxPower = preg_replace('/[^0-9]/', '', $maxPower);
                }

                if (!empty($power) && !empty($maxPower)) {
                    $characters[$name]['power'] = $power;
                    $characters[$name]['max_power'] = $maxPower;
                }
            } else {
                $characters[$name]['stars'] = 0;
                $characters[$name]['level'] = 0;
                $characters[$name]['gear'] = 0;
                $characters[$name]['zetas'] = 0;
                $characters[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $characters[$name]['power'] = 0;
                $characters[$name]['max_power'] = 0;
            }
        }

        return $characters;
    }

    private function syncShips(Member $member)
    {
        $swgohShips = $this->getShips($member->ships_url);
        ksort($swgohShips);
        $ships = $this->Ships->find('list', ['keyField' => 'name', 'valueField' => 'id'])->toArray();
        foreach ($swgohShips as $swgohShipName => $swgohShipData) {
            if (!empty($ships[$swgohShipName])) {
                $shipId = $ships[$swgohShipName];
            } else {
                $ship = $this->Ships->newEntity([
                    'name' => $swgohShipName,
                    'light_side' => $swgohShipData['light_side']
                ]);

                if ($this->Ships->save($ship)) {
                    $this->out('<success>Saving New Ship: ' . $swgohShipName . '</success>');
                    $shipId = $ship->id;
                } else {
                    $this->out('<error>Unable to save New Ship: ' . $swgohShipName . '</error>');
                }
            }

            if (!empty($shipId)) {
                $memberShip = $this->Members->MemberShips
                    ->find()
                    ->where([
                        'MemberShips.member_id' => $member->id,
                        'MemberShips.ship_id' => $shipId
                    ])
                    ->first();
                if (!empty($memberShip)) {
                    $memberShip = $this->Members->MemberShips->patchEntity($memberShip, [
                        'level' => $swgohShipData['level'],
                        'stars' => $swgohShipData['stars'],
                    ]);
                } else {
                    $memberShip = $this->Members->MemberShips->newEntity([
                        'member_id' => $member->id,
                        'ship_id' => $shipId,
                        'level' => $swgohShipData['level'],
                        'stars' => $swgohShipData['stars'],
                    ]);
                }
                $newRecord = $memberShip->isNew();
                if ($this->Members->MemberShips->save($memberShip)) {
                    if ($newRecord) {
                        $this->out('<success>Saving New Member Ship: ' . $swgohShipName . '</success>');
                    } else {
                        $this->out('<success>Updating Existing Member Ship: ' . $swgohShipName . '</success>');
                    }
                } else {
                    $this->out('<error>Failed to Save Member Ship: ' . $swgohShipName . '</error>');
                }

            } else {
                $this->out('<error>Missing Ship ID for Ship: ' . $swgohShipName . '</error>');
            }
        }
    }

    private function getShips($url)
    {
        $ships = [];
        try {
            $html = file_get_html($url);
        } catch (\Exception $e) {
            return [];
        }
        foreach ($html->find('div[class="collection-ship"]') as $element) {
            $name = !empty($element->find('div[class="collection-ship-name"]', 0)->plaintext) ? trim(html_entity_decode($element->find('div[class="collection-ship-name"]', 0)->plaintext, ENT_QUOTES)) : null;
            $level = !empty($element->find('div[class="ship-portrait-full-frame-level"]', 0)->plaintext) ? trim($element->find('div[class="ship-portrait-full-frame-level"]', 0)->plaintext) : 0;

            if (!empty($level)) {
                $inactiveStars = $element->find('div[class="ship-portrait-full-star-inactive"]');
                $ships[$name]['stars'] = self::STARS - count($inactiveStars);
                $ships[$name]['level'] = !empty($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) ? (int) trim($element->find('div[class="char-portrait-full-level"]', 0)->plaintext) : null;
                $ships[$name]['light_side'] = stripos($element->getAttribute('class'), 'light-side') !== false;
                $powerString = trim($element->find('div[class="collection-char-gp"]', 0)->getAttribute('title'));

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
        $parser->addSubcommand('base', [
            'help' => 'Will Sync the base data',
        ]);

        $parser->addOption('guildId', [
            'help' => 'Guild ID for the Guild you want to Sync'
        ]);

        return $parser;
    }
}
