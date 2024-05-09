<?php

namespace App\Providers;

use App\Events\CompanyConfigured;
use App\Events\CompanyDefaultEvent;
use App\Events\CompanyDefaultUpdated;
use App\Events\CompanyGenerated;
use App\Events\CurrencyRateChanged;
use App\Events\DefaultCurrencyChanged;
use App\Events\PlaidSuccess;
use App\Events\StartTransactionImport;
use App\Listeners\ConfigureChartOfAccounts;
use App\Listeners\ConfigureCompanyDefault;
use App\Listeners\CreateCompanyDefaults;
use App\Listeners\CreateConnectedAccount;
use App\Listeners\HandleTransactionImport;
use App\Listeners\SyncAssociatedModels;
use App\Listeners\SyncWithCompanyDefaults;
use App\Listeners\UpdateAccountBalances;
use App\Listeners\UpdateCurrencyRates;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CompanyDefaultEvent::class => [
            SyncWithCompanyDefaults::class,
        ],
        CompanyDefaultUpdated::class => [
            SyncAssociatedModels::class,
        ],
        CompanyConfigured::class => [
            ConfigureCompanyDefault::class,
        ],
        CompanyGenerated::class => [
            CreateCompanyDefaults::class,
            ConfigureChartOfAccounts::class,
        ],
        DefaultCurrencyChanged::class => [
            UpdateCurrencyRates::class,
        ],
        CurrencyRateChanged::class => [
            UpdateAccountBalances::class,
        ],
        PlaidSuccess::class => [
            CreateConnectedAccount::class,
        ],
        StartTransactionImport::class => [
            HandleTransactionImport::class,
        ],
    ];

    /**
     * The model observers to register.
     *
     * @var array<string, string|object|array<int, string|object>>
     */
    protected $observers = [
        // Currency::class => [CurrencyObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
