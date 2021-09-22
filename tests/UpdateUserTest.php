<?php

namespace Tests;

use App\Controller\UserManageController;
use App\Core\Request;
use App\Model\AppUserRole;
use App\Model\AppUserRoleRepository;
use App\Model\User;
use App\Model\UserRepository;
use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;

class UpdateUserTest extends TestCase
{

    public function setUp(): void
    {
        $this->configureDatabase();
        $this->migrateIdentitiesTable();
    }

    protected function configureDatabase()
    {
        $db = new DB;
        $db->addConnection(array(
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));
        $db->bootEloquent();
        $db->setAsGlobal();
    }

    public function migrateIdentitiesTable()
    {
        DB::schema()->create('users', function($table) {
            $table->increments('id');
            $table->integer('identifier');
            $table->string('lastname');
            $table->string('firstname');
            $table->string('mail2');
            $table->string('phone');
            $table->integer('center_id');
            $table->integer('financial_id');
            $table->string('address');
            $table->string('complementAddress');
            $table->string('zip');
            $table->string('city');
            $table->string('country');
            $table->integer('gender');
        });

        DB::schema()->create('apps__users__roles', function($table) {
            $table->integer('apps');
            $table->integer('user_id');
            $table->integer('roles');
        });

        User::create([
            "id" => 1,
            "identifier" => 156401356,
            "lastname" => "NewLastName",
            "firstname" => "NewFirstName",
            "mail2" => "mail@mail.fr",
            "phone" => 17314053,
            "center_id" => 1,
            "financial_id" => 1,
            "address" => "route du test",
            "complementAddress" => "Bâtiment T",
            "zip" => 56416,
            "city" => "City T",
            "country" => "Country T",
            "gender" => 1,
        ]);
    }

    /**
     * @group User
     * @group Update
     * @dataProvider userUpdateDataProvider
     */
    public function testUpdateUser($updatedAttributes)
    {
        $userManageController = new UserManageController(
            $this->createMock(UserRepository::class),
            $this->createMock(AppUserRoleRepository::class),
            $this->createMock(Request::class),
            $this->createMock(AppUserRole::class)
        );
        $result = $userManageController->updateUser($updatedAttributes);

        $this->assertEquals(User::whereId($updatedAttributes['uid'])->first()->toArray(), $result->toArray());
    }

    public function userUpdateDataProvider(): \Generator
    {
        yield [
            [
                'uid' => 1,
                'beneficiary' => 156401356,
                'lastname' => 'NewLastName',
                'firstname' => 'NewFirstName',
                'email' => 'mail@mail.fr',
                'phone' => 0102030405,
                'center' => 1,
                'financial' => 1,
                'address' => 'route du test',
                'complementAddress' => 'Bâtiment T',
                'zip' => 56416,
                'city' => 'City T',
                'country' => 'Country T',
                'gender' => 1,
            ]
        ];

        yield [
            [
                'uid' => 1,
                'beneficiary' => 98801356,
                'lastname' => 'NewLastName2',
                'firstname' => 'NewFirstName2',
                'email' => 'mail2@mail.fr',
                'phone' => 0102030406,
                'center' => 2,
                'financial' => 2,
                'address' => 'route du test2',
                'complementAddress' => 'Bâtiment T2',
                'zip' => 24416,
                'city' => 'City T2',
                'country' => 'Country T2',
                'gender' => 2,
            ]
        ];
    }
}