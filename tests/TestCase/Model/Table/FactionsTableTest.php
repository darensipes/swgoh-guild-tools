<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FactionsTable Test Case
 */
class FactionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FactionsTable
     */
    public $Factions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.factions',
        'app.characters',
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
        $config = TableRegistry::getTableLocator()->exists('Factions') ? [] : ['className' => FactionsTable::class];
        $this->Factions = TableRegistry::getTableLocator()->get('Factions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Factions);

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
