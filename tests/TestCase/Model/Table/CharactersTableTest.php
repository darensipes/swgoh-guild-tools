<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CharactersTable Test Case
 */
class CharactersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CharactersTable
     */
    public $Characters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.characters',
        'app.member_characters',
        'app.factions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Characters') ? [] : ['className' => CharactersTable::class];
        $this->Characters = TableRegistry::getTableLocator()->get('Characters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Characters);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
