<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MemberCharactersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MemberCharactersTable Test Case
 */
class MemberCharactersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MemberCharactersTable
     */
    public $MemberCharacters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.member_characters',
        'app.members',
        'app.characters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MemberCharacters') ? [] : ['className' => MemberCharactersTable::class];
        $this->MemberCharacters = TableRegistry::getTableLocator()->get('MemberCharacters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MemberCharacters);

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
