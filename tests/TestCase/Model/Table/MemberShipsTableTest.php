<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MemberShipsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MemberShipsTable Test Case
 */
class MemberShipsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MemberShipsTable
     */
    public $MemberShips;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.member_ships',
        'app.members',
        'app.ships'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MemberShips') ? [] : ['className' => MemberShipsTable::class];
        $this->MemberShips = TableRegistry::getTableLocator()->get('MemberShips', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MemberShips);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
