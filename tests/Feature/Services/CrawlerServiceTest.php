<?php
namespace Tests\Feature\Services;

use App\Services\CrawlerService;
use Tests\TestCase;

class CrawlerServiceTest extends TestCase
{
    /** @var  CrawlerService */
    private $crawlerService;


    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->crawlerService = app(CrawlerService::class);
    }

    public function tearDown()
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testGetOriginalData()
    {
        $crawler = $this->crawlerService->getOriginalData('https://ani.gamer.com.tw/');

        $this->assertNotEmpty($crawler->html());
    }

    public function testGetNewAnimationFromBaHa()
    {
        $crawler = $this->crawlerService->getOriginalData('https://ani.gamer.com.tw/');
        $target = $this->crawlerService->getNewAnimationFromBaHa($crawler);

        $this->assertArrayHasKey('directUri', $target[0]);
        $this->assertArrayHasKey('imagePath', $target[0]);
        $this->assertArrayHasKey('label', $target[0]);
    }
}
