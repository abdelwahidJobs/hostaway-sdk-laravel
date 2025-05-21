<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace Tests;

use Carbon\Carbon;
use Orchestra\Testbench\TestCase;
use Backend\HostawaySdkLaravel\Dto\Listing;
use Backend\HostawaySdkLaravel\Dto\Webhook;
use Backend\HostawaySdkLaravel\Dto\Calendar;
use Backend\HostawaySdkLaravel\Dto\AccessToken;
use Backend\HostawaySdkLaravel\Dto\CustomField;
use Backend\HostawaySdkLaravel\Dto\Reservation;
use Backend\HostawaySdkLaravel\HostAwayService;
use Backend\HostawaySdkLaravel\Dto\ConversationMessage;
use Backend\HostawaySdkLaravel\HostawayServiceProvider;
use Backend\HostawaySdkLaravel\Dto\FinanceStandardField;
use Backend\HostawaySdkLaravel\Exceptions\HostAwayException;

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

    /**
     * @test
     * @vcr hostaway/access_token_invalid_response
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_not_get_access_token()
    {
        $this->expectException(HostAwayException::class);

        $this->service->withClientCredentials(
            '11111',
            'random-string'
        )->getAccessToken();
    }

    /**
     * @test
     * @vcr hostaway/access_token_invalid_response
     * @group vcr
     */
    public function is_return_non_valid_client_credentials()
    {
        $this->assertFalse($this->service->isClientCredentialsValid('11111', 'random-string'));
    }


    /**
     * @test
     * @vcr hostaway/access_token_valid_response
     * @group vcr
     */
    public function is_return_valid_client_credentials()
    {
        $this->assertTrue($this->service->isClientCredentialsValid('37187', 'd8e4ba38234d12f7ffc74889ec738c804a35624aa183b7953d1b687236faa16c'));
    }


    /**
     * @test
     */
    public function it_show_throw_credentials_exception()
    {
        $this->expectException(HostAwayException::class);
        $this->service->getAccessToken();
    }


    /**
     * @test
     * @vcr hostaway/get_listings.yml
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_listings()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $listings = $this->service->withAccessToken(
            $access_token,
        )->getListings();

        $this->assertSame(95503, collect($listings)->first()->id);
    }


    /**
     * @test
     * @vcr hostaway/get_listings_valid_response_with_offset
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_listings_with_offset()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1MjA1NCIsImp0aSI6IjEyNDE3ZDI5NTJjYmNiZTJiZDMwNjdiN2I3NGNiNmMxMjE5NDBhZGMxNzZjYWYyNDIyZTU5MmExMTAyYjY1MjhkNGYwMzU0ZWIxNjg1ZThiIiwiaWF0IjoxNzE2MTE0NzExLjQ5OTg3MiwibmJmIjoxNzE2MTE0NzExLjQ5OTg3MywiZXhwIjoyMDMxNjQ3NTExLjQ5OTg3Niwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjMyNzA4fQ.qbAYK7SHrbN4DWweZHe66Csk0Rz4RUCyoNs1zrOnZKjoA7KzOakoyM8QTogPoHFTexe4AMYeD1iamVlFTyUuhFNYV_L4VxlGWFUrMspPhoi3-F0TRNcxt0WnK6lYPXfiXtlYubPOQW22L7iNaylX_eaqHeu8u7diXnIvnQUuD_M';
        $listings = $this->service->withAccessToken(
            $access_token,
        )->getListings(['offset' => 101]);

        $this->assertSame(181626, collect($listings)->first()->id);
    }


    /**
     * @test
     * @vcr hostaway/get_listings_valid_response
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_listings_count()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $count = $this->service->withAccessToken(
            $access_token,
        )->getListingsCount();

        $this->assertSame(12, $count);
    }


    /**
     * @test
     * @vcr hostaway/get_listing_valid_response
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_listing()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $listing = $this->service->withAccessToken(
            $access_token,
        )->getListing(95503);

        $this->assertInstanceOf(Listing::class, $listing);

        $this->assertSame(95503, $listing->id);
    }


    /**
     * @test
     * @vcr hostaway/get_listing_invalid_response
     * @group vcr
     * @throws HostAwayException
     */
    public function it_show_throw_listing_not_found_exception()
    {
        $this->expectException(HostAwayException::class);

        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $this->service->withAccessToken(
            $access_token,
        )->getListing(1);
    }


    /**
     * @test
     * @vcr hostaway/get_listing_list_fee_settings_valid_response
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_list_fee_settings()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $fee_settings = $this->service->withAccessToken(
            $access_token,
        )->getListingListFeeSettings(95503);

        $this->assertSame([
            'id' => 6366,
            'accountId' => 37187,
            'listingMapId' => 95503,
            'feeType' => 'parkingFee',
            'feeTitle' => "",
            'feeAppliedPer' => 'night',
            'amount' => 10,
            'amountType' => 'flat',
            'isMandatory' => 0,
            'isQuantitySelectable' => 0,
            'insertedOn' => '2022-03-21 17:03:56',
            'updatedOn' => '2022-03-21 17:03:56',
        ], collect($fee_settings)->first()->toArray());
    }


    /**
     * @test
     * @vcr hostaway/get_listing_units_valid_response
     * @group vcr
     * @throws HostAwayException
     */
    public function it_can_get_unit_listings()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $fee_settings = $this->service->withAccessToken(
            $access_token,
        )->getUnitListing(95503);

        $this->assertSame([], collect($fee_settings)->toArray());
    }

    /**
     * @test
     * @vcr hostaway/get_all_reservations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_all_reservations()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';

        $reservations = $this->service->withAccessToken(
            $access_token,
        )->getReservations([]);

        $this->assertSame(14188731, collect($reservations)->first()->id);
        $this->assertSame('37187-95503-2000-1140840743', collect($reservations)->first()->reservationId);
        $this->assertSame(18740395, collect($reservations)->last()->id);
        $this->assertSame('37187-188393-2020-7576270109', collect($reservations)->last()->reservationId);
    }

    /**
     * @test
     * @vcr hostaway/get_listing_reservations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_listing_reservations()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';

        $reservations = $this->service->withAccessToken(
            $access_token,
        )->getReservations(['listingId' => 95503]);

        $this->assertSame(14188731, collect($reservations)->first()->id);
        $this->assertSame('37187-95503-2000-1140840743', collect($reservations)->first()->reservationId);
        $this->assertSame(11812168, collect($reservations)->last()->id);
        $this->assertSame('37187-95503-2000-3351497381', collect($reservations)->last()->reservationId);
    }


    /**
     * @test
     * @vcr hostaway/get_listings_valid_response
     * @group vcr
     */
    public function itCanFetchNewListings()
    {

        // Arrange
        $existingIds = [1838648, 2460213];
        // Act
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $listings = $this->service->withAccessToken(
            $access_token,
        )->getNewListings($existingIds);

        // Assert
        $this->assertCount(12, $listings);
    }

    /**
     * @test
     * @vcr hostaway/get_listings_valid_response
     * @group vcr
     */
    public function itIgnoreOldListings()
    {
        // Arrange
        $existingIds = [95503];
        // Act
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $listings = $this->service->withAccessToken(
            $access_token,
        )->getNewListings($existingIds);

        // Assert
        $this->assertCount(11, $listings);
    }

    /** @test */


    /**
     * @test
     */
    public function shouldReturnExpiredAccessToken()
    {
        $expired_at = now()
            ->subSeconds(30)
            ->toDateTimeString();

        $this->assertTrue($this->service->hasExpiredAccessToken($expired_at));

    }

    /**
     * @test
     */
    public function shouldReturnHasNotExpiredAccessToken()
    {
        $expired_at = now()
            ->addSeconds(2)
            ->toDateTimeString();

        $this->assertFalse($this->service->hasExpiredAccessToken($expired_at));

    }

    /** @test */
    public function testMatchesListings()
    {
        $matches = $this->service->matchListings($this->hostaway_listings, $this->user_listings);

        $this->assertEquals([
            'property_1' => [
                '1838648',
            ]
        ], $matches);
    }

    /** @test */
    public function itCanMatchListingsWithNameInBothLanguages()
    {
        // Arrange
        $hostaway_listing = new Listing([
            'id' => 1838648,
            'name' => 'Montreal DREAMLOFT on the PLATEAU',
            'externalListingName' => 'Montreal DREAMLOFT on the PLATEAU',
            'address' => 'Canada',
            'guestsIncluded' => 6,
            'currencyCode' => 'CAD'
        ]);

        $user_listing = [
            'id' => 'property_1',
            'name_default' => null,
            'name_fr' => 'Montreal DREAMLOFT on the PLATEAU',
            'name_en' => null,
        ];

        // Act
        $matches = $this->service->matchListings([$hostaway_listing], [$user_listing]);

        // Assert
        $this->assertEquals([
            'property_1' => [
                '1838648',
            ],
        ], $matches);

        $user_listing = [
            'id' => 'property_1',
            'name_default' => null,
            'name_fr' => null,
            'name_en' => 'Montreal DREAMLOFT on the PLATEAU',
        ];

//        // Act
        $matches = $this->service->matchListings([$hostaway_listing], [$user_listing]);

        // Assert
        $this->assertEquals([
            'property_1' => [
                '1838648',
            ],
        ], $matches);
    }


    /** @test */
    public function itCanMatchListingsWithDefaultName()
    {
        // Arrange
        $hostaway_listing = new Listing([
            'id' => 1838648,
            'name' => 'Montreal DREAMLOFT on the PLATEAU',
            'externalListingName' => 'Montreal DREAMLOFT on the PLATEAU',
            'address' => 'Canada',
            'guestsIncluded' => 6,
            'currencyCode' => 'CAD'
        ]);

        $user_listing = [
            'id' => 'property_1',
            'name_default' => 'Montreal DREAMLOFT on the PLATEAU',
            'name_fr' => null,
            'name_en' => null,
        ];

        // Act
        $matches = $this->service->matchListings([$hostaway_listing], [$user_listing]);

        // Assert
        $this->assertEquals([
            'property_1' => [
                '1838648',
            ],
        ], $matches);
    }

    /**
     * @test
     * @vcr hostaway/get_webhook_reservations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_webhook_reservations()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $webhooks = $this->service->withAccessToken(
            $access_token,
        )->getWebhookReservations([]);
        $this->assertSame([
            "id" => 4680,
            "accountId" => 37187,
            "listingMapId" => 95503,
            "channelId" => null,
            "isEnabled" => 1,
            "url" => "https://api.wechalet.dev/webhooks/e97c4cc0-81f9-4100-9128-d9fe1bc4a365/v1lLJxmkdFi8EJAZDnSV6fOTDaBtPuai",
            "type" => "manual",
            "insertedOn" => "2023-03-13 22:35:33",
            "updatedOn" => "2023-03-13 22:35:33",
            "listingName" => "test",
            "login" => null,
            "password" => null
        ], collect($webhooks)->first()->toArray());
    }

    /**
     * @test
     * @throws HostAwayException
     * @vcr hostaway/get_webhook_reservation
     * @group vcr
     */
    public function it_can_fetch_reservation_webhook()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $webhook = $this->service->withAccessToken(
            $access_token,
        )->getWebhookReservation(4680);
        $this->assertSame([
            "id" => 4680,
            "accountId" => 37187,
            "listingMapId" => 95503,
            "channelId" => null,
            "isEnabled" => 1,
            "url" => "https://api.wechalet.dev/webhooks/e97c4cc0-81f9-4100-9128-d9fe1bc4a365/v1lLJxmkdFi8EJAZDnSV6fOTDaBtPuai",
            "type" => "manual",
            "insertedOn" => "2023-03-13 22:35:33",
            "updatedOn" => "2023-03-13 22:35:33",
            "listingName" => null,
            "login" => null,
            "password" => null
        ], $webhook->toArray());

    }


    /**
     * @test
     * @vcr hostaway/create_webhook_reservations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_create_webhook_reservations()
    {
        $webhook = new Webhook([
            'listingMapId' => null,
            'channelId' => null,
            'isEnabled' => 1,
            'url' => 'https://webhook.site/c148c551-ad70-4e51-be22-9d556b5013f9',
            'type' => 'manual',
        ]);

        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $webhook = $this->service->withAccessToken(
            $access_token,
        )->createWebhookReservations($webhook);

        $this->assertSame([
            "id" => 6635,
            "accountId" => 37187,
            "listingMapId" => null,
            "channelId" => null,
            "isEnabled" => 1,
            "url" => "https://webhook.site/c148c551-ad70-4e51-be22-9d556b5013f9",
            "type" => "manual",
            "insertedOn" => "2023-10-29 15:32:26",
            "updatedOn" => "2023-10-29 15:32:26",
            "listingName" => null,
            "login" => null,
            "password" => null
        ], $webhook->toArray());
    }


    /**
     * @test
     * @vcr hostaway/update_webhook_reservations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_update_webhook_reservations()
    {
        $webhook = new Webhook([
            'listingMapId' => null,
            'channelId' => null,
            'isEnabled' => 0,
            'url' => 'https://webhook.site/c148c551-ad70-4e51-be22-9d556b5013f9',
            'type' => 'manual',
            'login' => 'wechalet-dev',
            'password' => 'wechalet-dev',
        ]);

        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $webhook = $this->service->withAccessToken(
            $access_token,
        )->updateWebhookReservations(6635, $webhook);

        $this->assertSame([
            'id' => 6635,
            'accountId' => 37187,
            'listingMapId' => null,
            'channelId' => null,
            'isEnabled' => 0,
            'url' => "https://webhook.site/c148c551-ad70-4e51-be22-9d556b5013f9",
            'type' => "manual",
            'insertedOn' => "2023-10-29 15:32:26",
            'updatedOn' => "2023-10-29 15:34:32",
            'listingName' => null,
            'login' => "wechalet-dev",
            'password' => "wechalet-dev"
        ], $webhook->toArray());

    }


    /**
     * @test
     * @vcr hostaway/delete_webhook_reservations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_remove_webhook_reservations()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $result = $this->service->withAccessToken(
            $access_token,
        )->removeWebhookReservations(6635);

        $this->assertSame('success', $result);

    }

    /**
     * @test
     * @vcr hostaway/create_reservation
     * @group vcr
     * @throws HostAwayException
     */
    public function it_create_reservation()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $reservation = $this->service->withAccessToken(
            $access_token,
        )->createReservation($this->reservation());

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertSame(20611920, $reservation->id);
    }

    /**
     * @test
     * @throws GuzzleException
     * @vcr hostaway/update_reservation
     * @group vcr
     */
    public function it_update_reservation()
    {

        $reservation = $this->reservation();
        $reservation->id = 20611920;
        $reservation->arrivalDate = '2023-12-25';
        $reservation->departureDate = '2023-12-30';
        $reservation->status = 'new';
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';

        $reservation = $this->service->withAccessToken(
            $access_token,
        )->updateReservation($reservation);

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertSame(20611920, $reservation->id);
        $this->assertSame('2023-12-25', $reservation->arrivalDate);
        $this->assertSame('2023-12-30', $reservation->departureDate);
        $this->assertSame('modified', $reservation->status);
    }

    /**
     * @test
     * @vcr hostaway/cancel_reservation
     * @group vcr
     */
    public function it_cancel_reservation()
    {

        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $reservation = $this->service->withAccessToken(
            $access_token,
        )->cancelReservation(20611920, 'guest');

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertSame(20611920, $reservation->id);
        // Assert new status of the reservation
        $this->assertSame('cancelled', $reservation->status);

    }


    /**
     * @test
     * @vcr hostaway/get_conversations
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_conversations_without_reservation()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $conversations = $this->service->withAccessToken(
            $access_token,
        )->getConversations([
            'limit' => 20,
            'reservationId' => 12618923,
            'includeResources' => 0,
        ]);
        $this->assertSame(4587450, collect($conversations)->first()->id);
    }

    /**
     * @test
     * @vcr hostaway/get_conversations_with_reservation
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_conversations_with_reservation()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $conversations = $this->service->withAccessToken(
            $access_token,
        )->getConversations([
            'limit' => 20,
            'reservationId' => 12618923,
            'includeResources' => 1,
        ]);
        $this->assertSame(4587450, collect($conversations)->first()->id);
        // its contain reservation
        $reservation = collect($conversations)->first()->Reservation;
        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertSame(12618923, $reservation->id);
        $this->assertSame('37187-95503-2000-3560796049', $reservation->reservationId);
        // its contains conversationMessages
        $conversationMessages = collect($conversations)->first()->conversationMessages;
        $this->assertSame(1, collect($conversationMessages)->count());
    }


    /**
     * @test
     * @vcr hostaway/get_conversation_messages
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_conversation_messages()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $messages = $this->service->withAccessToken(
            $access_token,
        )->getConversationMessages(4587450);

        $expected = collect($messages)->take(2)->map(function ($item) {
            return [
                'id' => $item->id,
                'accountId' => $item->accountId,
                'listingMapId' => $item->listingMapId,
                'reservationId' => $item->reservationId,
                'conversationId' => $item->conversationId,
                'body' => $item->body,
                'status' => $item->status,
                'isIncoming' => $item->isIncoming,
                'sentUsingHostaway' => $item->sentUsingHostaway

            ];
        });

        $this->assertSame([
            0 => [
                "id" => 93125973,
                "accountId" => 37187,
                "listingMapId" => 95503,
                "reservationId" => 12618923,
                "conversationId" => 4587450,
                "body" => "hello first message from the guest updated",
                "status" => "sent",
                "isIncoming" => 0,
                "sentUsingHostaway" => 0
            ],
            1 => [
                "id" => 67235833,
                "accountId" => 37187,
                "listingMapId" => 95503,
                "reservationId" => 12618923,
                "conversationId" => 4587450,
                "body" => "hello first message from the guest updated",
                "status" => "sent",
                "isIncoming" => 0,
                "sentUsingHostaway" => 0
            ]
        ], $expected->toArray());
    }


    /**
     * @test
     * @vcr hostaway/create_conversation_message
     * @group vcr
     * @throws HostAwayException
     */
    public function it_create_conversation_messages()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';

        $body = new ConversationMessage([

            'conversationId' => 4587450,
            'body' => 'Welcome'
        ]);

        $message = $this->service->withAccessToken(
            $access_token,
        )->createConversationMessage(4587450, $body);

        $this->assertInstanceOf(ConversationMessage::class, $message);

        $this->assertSame(93130783, $message->id);
        $this->assertSame('Welcome', $message->body);
        $this->assertSame('sent', $message->status);
    }

    /**
     * @test
     * @vcr hostaway/get_finance_standard_field
     * @group vcr
     * @throws HostAwayException
     */
    public function it_fetch_finance_standard_field()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $finance_standard = $this->service->withAccessToken(
            $access_token,
        )->getFinanceStandardField(11812168);

        $this->assertInstanceOf(FinanceStandardField::class, $finance_standard);
        $this->assertNull($finance_standard->id);
    }

    /**
     *
     * @vcr hostaway/get_listing_calendar
     * @group vcr
     * @test
     * @throws HostAwayException
     */
    public function it_fetch_listing_calendar()
    {
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $calendars = $this->service->withAccessToken(
            $access_token,
        )->getListingCalendar(95503, [
            'startDate' => '2023-02-05',
            'endDate' => '2023-02-10',
            'includeResources' => 0
        ]);

        $expected = collect($calendars)->map(function ($item) {
            return [
                'date' => $item->date,
                'isAvailable' => $item->isAvailable,
                'price' => $item->price,
                'minimumStay' => $item->minimumStay,
                'maximumStay' => $item->maximumStay,
            ];
        });


        $this->assertSame([
            0 => [
                "date" => "2023-02-05",
                "isAvailable" => 1,
                "price" => 100,
                "minimumStay" => 1,
                "maximumStay" => 365
            ],
            1 => [
                "date" => "2023-02-06",
                "isAvailable" => 1,
                "price" => 100,
                "minimumStay" => 1,
                "maximumStay" => 365
            ],
            2 => [
                "date" => "2023-02-07",
                "isAvailable" => 1,
                "price" => 100,
                "minimumStay" => 1,
                "maximumStay" => 365
            ],
            3 => [
                "date" => "2023-02-08",
                "isAvailable" => 1,
                "price" => 100,
                "minimumStay" => 1,
                "maximumStay" => 365
            ],
            4 => [
                "date" => "2023-02-09",
                "isAvailable" => 1,
                "price" => 100,
                "minimumStay" => 1,
                "maximumStay" => 365
            ],
            5 => [
                "date" => "2023-02-10",
                "isAvailable" => 1,
                "price" => 100,
                "minimumStay" => 1,
                "maximumStay" => 365
            ]
        ], $expected->toArray());
    }


    /**
     *
     * @vcr hostaway/update_listing_calendar
     * @group vcr
     * @test
     * @throws HostAwayException
     */
    public function it_update_listing_calendar()
    {
        $calendar = new Calendar([
            'startDate' => '2023-12-05',
            'endDate' => '2023-12-10',
            'date' => '2023-12-05',
            'isAvailable' => 0,
        ]);
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $calendars = $this->service->withAccessToken(
            $access_token,
        )->updateCalendar(95503, $calendar);

        $expected = collect($calendars)->map(function ($item) {
            return [
                'date' => $item->date,
                'isAvailable' => $item->isAvailable,
            ];
        });

        $this->assertSame([
            0 => [
                'date' => '2023-12-05',
                'isAvailable' => 0,
            ],
            1 => [
                'date' => '2023-12-06',
                'isAvailable' => 0,
            ],
            2 => [
                'date' => '2023-12-07',
                'isAvailable' => 0,
            ],
            3 => [
                'date' => '2023-12-08',
                'isAvailable' => 0,
            ],
            4 => [
                'date' => '2023-12-09',
                'isAvailable' => 0,
            ],
            5 => [
                'date' => '2023-12-10',
                'isAvailable' => 0,
            ],
        ], $expected->toArray());
    }


    /**
     *
     * @vcr hostaway/update_batch_listing_calendar
     * @group vcr
     * @test
     * @throws HostAwayException
     */
    public function it_update_listing_batch_calendar()
    {
        Carbon::setTestNow('2023-08-16');

        $calendars = [
            new Calendar([
                'startDate' => '2023-11-01',
                'endDate' => '2023-11-01',
                'isAvailable' => 1,
                'date' => '2023-11-01',
                "price" => 250,
                "note" => null
            ]),
            new Calendar([
                'startDate' => '2023-11-02',
                'endDate' => '2023-11-02',
                'isAvailable' => 1,
                'date' => '2023-11-02',
                "price" => 250,
                "note" => 'holidays'
            ]),
        ];
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $calendars = $this->service->withAccessToken(
            $access_token,
        )->batchUpdateCalendar(95503, $calendars);
        $this->assertSame([], $calendars);
    }


    /**
     * @test
     * @vcr hostaway/create_webhook_conversation
     * @group vcr
     * @throws HostAwayException
     */
    public function it_create_webhook_conversation()
    {
        $webhook = new Webhook([
            'listingMapId' => null,
            'channelId' => null,
            'isEnabled' => 1,
            'url' => 'https://webhook.site/c148c551-ad70-4e51-be22-9d556b5013f9',
        ]);

        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';
        $webhook = $this->service->withAccessToken(
            $access_token,
        )->createWebhookConversation($webhook);

        $this->assertSame([
            "id" => 628,
            "accountId" => 37187,
            "listingMapId" => null,
            "channelId" => null,
            "isEnabled" => 1,
            "url" => "https://webhook.site/c148c551-ad70-4e51-be22-9d556b5013f9",
            "type" => null,
            "insertedOn" => "2023-10-29 15:50:14",
            "updatedOn" => "2023-10-29 15:50:14",
            "listingName" => null,
            "login" => null,
            "password" => null,
        ], $webhook->toArray());
    }


    /**
     * @test
     */
    public function it_test_key_stays_by_dates()
    {
        /**
         * periods are
         * [ 2023-10-01 => 2023-10-03] => 3
         * [ 2023-10-05 => 2023-10-06] => 2
         * [ 2023-10-08 => 2023-10-08] => 1
         */
        $events = [
            new Calendar([
                'date' => '2023-10-01',
                'minimumStay' => 3
            ]),
            new Calendar([
                'date' => '2023-10-02',
                'minimumStay' => 3
            ]),
            new Calendar([
                'date' => '2023-10-03',
                'minimumStay' => 3
            ]),
            new Calendar([
                'date' => '2023-10-04',
            ]),
            new Calendar([
                'date' => '2023-10-05',
                'minimumStay' => 2
            ]),
            new Calendar([
                'date' => '2023-10-06',
                'minimumStay' => 2
            ]),
            new Calendar([
                'date' => '2023-10-08',
                'minimumStay' => 1
            ]),
        ];

        $result = $this->service->keyStaysByDates($events)->toArray();
        $this->assertSame([
            0 => [
                "start_date" => "2023-10-01",
                "end_date" => "2023-10-03",
                "min_stay_count" => 3,
                "min_stay_type" => "nights",
                "checkin_day" => "any_day"
            ],
            1 => [
                "start_date" => "2023-10-05",
                "end_date" => "2023-10-06",
                "min_stay_count" => 2,
                "min_stay_type" => "nights",
                "checkin_day" => "any_day"
            ],
            2 => [
                "start_date" => "2023-10-08",
                "end_date" => "2023-10-08",
                "min_stay_count" => 1,
                "min_stay_type" => "nights",
                "checkin_day" => "any_day"
            ]
        ], $result);

    }


    /**
     * @test
     * @vcr hostaway/update_listing
     * @group vcr
     */
    public function it_update_listing()
    {

        $listing = new Listing([
            'id' => 201858,
            'address' => '303 Av. Morgan, Rawdon, QC J0K 1S0, Canada',
            'name' => 'Wechalet listing updated',
            'description' => 'Wechalet listing updated',
            'internalListingName' => 'wechalet internal name',
            'externalListingName' => 'wechalet internal name',
            'bathroomsNumber' => 4,
            'personCapacity' => 20,
            'price' => 178,
            'instantBookable' => 1,
            'minNights' => 3,
            'maxNights' => 60,
            'houseRules' => 'Wechalet house rules',
            'keyPickup' => '1993',
            'specialInstruction' => 'close the door behind you',
            'weeklyDiscount' => 12,
            'monthlyDiscount' => 30,
            'refundableDamageDeposit' => 7000,
            'guestsIncluded' => 2,
            'cleaningFee' => 60,
            'priceForExtraPerson' => 70,
            'wifiUsername' => 'Wechalet',
            'wifiPassword' => 'Wechalet2024',
            'propertyLicenseNumber' => '979727',
            'propertyLicenseExpirationDate' => '2025-10-10',
            'currencyCode' => 'CAD'
        ]);
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6ImM0ZDdhNjRlZDFhYWZlNTI0OTNiODI4YjAzYWQzYjRmZTI4MmJhODI0MTk0ZGYzZDQ3MTdjNWEzYWM5OWJhN2Y2ZTI3ZWQ5ZmVhYTU3MDNjIiwiaWF0IjoxNjQ3ODYwMzcxLCJuYmYiOjE2NDc4NjAzNzEsImV4cCI6MTcxMTAxODc3MSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.jOLlCBn4uTWlnXeQSLU3UVzDRJmdmGlogjrwLAD8_SOIY1ER4wn56GJ_e5aWaUvpkXhrYovyEXNvHnmnMSvNBq-5t0HgLyQmaLaRhlA-o7YHo4IdO8ySFlCpKqFQX934F4OVGgDTNQVqm2e-OHTYM_qULebLkllZBkWAeiYqaFI';

        $listing = $this->service->withAccessToken(
            $access_token,
        )->updateListing($listing);

        $this->assertInstanceOf(Listing::class, $listing);
        $this->assertSame(201858, $listing->id);
    }

    /**
     * @test
     * @vcr hostaway/create_custom_field
     * @group vcr
     */
    public function it_create_custom_field()
    {

        $customField = new CustomField([
            "name" => "Wechalet reservation id",
            "varName" => "reservation",
            "possibleValues" => null,
            "type" => "text",
            "objectType" => "reservation",
            "isPublic" => 1,
            "sortOrder" => null
        ]);

        $access_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzNzE4NyIsImp0aSI6IjE1OTk0NDk4MDg4YTI3YzI3ZDc2ZmVmNjlhYTE2OTFlY2I0NjJhMjYzZjQ3MzQ1YTJkZjdmOTIwNWI0NDYxNjFhYmI4ODRjODJiYWUzNTY2IiwiaWF0IjoxNzI1OTY1NTgzLjMyNDQ0MSwibmJmIjoxNzI1OTY1NTgzLjMyNDQ0MiwiZXhwIjoyMDQxNDk4MzgzLjMyNDQ0NSwic3ViIjoiIiwic2NvcGVzIjpbImdlbmVyYWwiXSwic2VjcmV0SWQiOjUwOTR9.czSAJt06ruwyzqKv-r_AHLn8EMInpM8RtvOSUrdZrb4PWYk__LR9db3vpX3MwkhKJs1o2c4xLs9tH75j9BxdLzMS7KzW6jsnDGfOnsla_966ZdALzXj9kg2aV3p2qy0X3qfYJy1wPCVj30o4BLGKOJ6Ud1cZbEJ8AM4vhW9GiOg";

        $result = $this->service->withAccessToken(
            $access_token,
        )->createCustomField($customField);

        $this->assertInstanceOf(CustomField::class, $result);
        $this->assertSame(66090, $result->id);
        $this->assertSame(37187, $result->accountId);
        $this->assertSame('reservation_wechalet_reservation_id', $result->varName);
    }


}