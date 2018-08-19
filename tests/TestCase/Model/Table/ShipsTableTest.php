<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShipsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShipsTable Test Case
 */
class ShipsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ShipsTable
     */
    public $Ships;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ships',
        'app.member_ships',
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
        $config = TableRegistry::getTableLocator()->exists('Ships') ? [] : ['className' => ShipsTable::class];
        $this->Ships = TableRegistry::getTableLocator()->get('Ships', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ships);

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
