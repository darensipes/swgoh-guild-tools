<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RosterTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RosterTable Test Case
 */
class RosterTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RosterTable
     */
    public $Roster;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.roster'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Roster') ? [] : ['className' => RosterTable::class];
        $this->Roster = TableRegistry::get('Roster', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Roster);

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
