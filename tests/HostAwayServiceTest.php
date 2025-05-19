<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests;

use Backend\HostawaySdkLaravel\Dto\AccessToken;
use Backend\HostawaySdkLaravel\Exceptions\HostAwayException;
use Backend\HostawaySdkLaravel\HostAwayService;
use Backend\HostawaySdkLaravel\HostawayServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * @group vcr
 */
class HostAwayServiceTest extends TestCase
{
    /**
     * @test
     * @vcr access_token_valid_response.yml
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_access_token()
    {

        $token = $this->service->withClientCredentials(
            '37187',
            'd8e4ba38234d12f7ffc74889ec738c804a35624aa183b7953d1b687236faa16c'
        )->getAccessToken();
        $this->assertInstanceOf(AccessToken::class, $token);
        $this->assertSame('Bearer', $token->token_type);
        $this->assertSame(63072000, $token->expires_in);
    }

    protected HostAwayService $service;

    protected function getPackageProviders($app): array
    {
        return [HostawayServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(HostAwayService::class);
    }
public function testExample()
{
    $this->assertTrue(true);
}
}