<?php


use App\Core\Request;
use App\Model\Financial;
use App\Model\Formation;
use App\Model\Session;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\Upload;
use PHPUnit\Framework\TestCase;
use App\Controller\UserUploadController;

class FormatDateTest extends TestCase
{

    private $uuc;

    protected function setUp():void {
        $this->uuc = new UserUploadController(
            $this->createMock(Request::class),
            $this->createMock(UserRepository::class),
            $this->createMock(User::class)
        );
    }

    /**
     * @group formatDateTest
     * @dataProvider dateDataProvider
     */
    public function testFormat($unformatted, $expected)
    {
        $formatdateTest = $this->uuc->formatDate($unformatted);
        $this->assertEquals($formatdateTest, $expected);
    }



    public function dateDataProvider()
    {

        return [
            [
                '11/04/1999',
                '1999-04-11'
            ],
            [
                '12/04/1999',
                '1999-04-12'
            ],
            [
                '11/05/1999',
                '1999-05-11'
            ]
        ];
    }
}
