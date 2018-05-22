<?php declare(strict_types=1);

namespace My;

use Lmc\Steward\Test\AbstractTestCase;

/**
 * @group ignore
 */
class NotVisualTest extends AbstractTestCase
{
    public function testLoginAndShowDashboard(): void
    {
        $this->wd->get('https://demo.vlastovka.eu/dashboard/pages/login.html');

        $this->assertSame('Admin Dashboard Login', $this->wd->getTitle());

        $this->findByName('email')
            ->sendKeys('foo@email.cz');

        $this->findByName('password')
            ->sendKeys('password');

        $this->findByCss('[type=submit]')
            ->click();

        $this->assertSame('Admin Dashboard Main Page', $this->wd->getTitle());

        $this->waitForCss('#morris-area-chart', true);
    }
}
