<?php

namespace App\Providers;

use App\Contracts\AccountHandler;
use App\Services\AccountService;
use BezhanSalleh\PanelSwitch\PanelSwitch;
use Filament\Notifications\Livewire\Notifications;
use Filament\Support\Assets\Js;
use Filament\Support\Enums\Alignment;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     */
    public array $bindings = [
        AccountHandler::class => AccountService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Notifications::alignment(Alignment::Center);

        $this->configurePanelSwitch();

        FilamentAsset::register([
            Js::make('TopNavigation', __DIR__ . '/../../resources/js/TopNavigation.js'),
        ]);
    }

    /**
     * Configure the panel switch.
     */
    protected function configurePanelSwitch(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->modalHeading('Switch Panel')
                ->modalWidth('md')
                ->slideOver()
                ->excludes(['admin'])
                ->iconSize(16)
                ->icons(function () {
                    if (auth()->user()?->belongsToCompany(auth()->user()?->currentCompany)) {
                        return [
                            'user' => 'heroicon-o-user',
                            'company' => 'heroicon-o-building-office',
                        ];
                    }

                    return [
                        'user' => 'heroicon-o-user',
                        'company' => 'icon-building-add',
                    ];
                });
        });
    }
}
