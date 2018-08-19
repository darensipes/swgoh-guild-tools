<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GuildsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GuildsTable Test Case
 */
class GuildsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GuildsTable
     */
    public $Guilds;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.guilds',
        'app.members'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Guilds') ? [] : ['className' => GuildsTable::class];
        $this->Guilds = TableRegistry::getTableLocator()->get('Guilds', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Guilds);

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
