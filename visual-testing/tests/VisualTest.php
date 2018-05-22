<?php declare(strict_types=1);

namespace My;

use Applitools\BatchInfo;
use Applitools\MatchLevel;
use Applitools\Selenium\Eyes;
use Lmc\Steward\Test\AbstractTestCase;

class VisualTest extends AbstractTestCase
{
    /** @var Eyes */
    protected $eyes;
    /** @var BatchInfo */
    protected static $batchId;

    public static function setUpBeforeClass()
    {
        self::$batchId = new BatchInfo(date('Y-m-d H:i:s'));
    }

    protected function setUp(): void
    {
        $this->eyes = new Eyes();
        $this->eyes->setApiKey(getenv('API_KEY'));
        $this->eyes->setBatch(self::$batchId);
        $this->eyes->setForceFullPageScreenshot(true);

        $this->eyes->open($this->wd, 'Dashboard demo', __CLASS__ . '::' . $this->getName());
    }

    protected function tearDown(): void
    {
        $this->eyes->close();
    }

    public function testLoginAndShowDashboard(): void
    {
        $this->wd->get('https://demo.vlastovka.eu/dashboard/pages/login.html');
        //$this->wd->get('https://demo.vlastovka.eu/dashboard/pages/login.html?break');

        $this->assertSame('Admin Dashboard Login', $this->wd->getTitle());
        $this->eyes->checkWindow('Login page');

        $this->findByName('email')
            ->sendKeys('foo@email.cz');

        $this->findByName('password')
            ->sendKeys('password');

        $this->findByCss('[type=submit]')
            ->click();

        $this->waitForCss('#morris-area-chart', true);

        $this->assertSame('Admin Dashboard Main Page', $this->wd->getTitle());
        $this->eyes->checkWindow('Dashboard');
    }

    public function testDynamicDashboard(): void
    {
        $this->eyes->setMatchLevel(MatchLevel::LAYOUT);

        $this->wd->get('https://demo.vlastovka.eu/dashboard/pages/dynamic.php');
        //$this->wd->get('https://demo.vlastovka.eu/dashboard/pages/dynamic.php?break[]=panel');

        $this->waitForCss('#morris-area-chart', true);

        $this->eyes->checkWindow('Dynamic Dashboard');
    }
}
