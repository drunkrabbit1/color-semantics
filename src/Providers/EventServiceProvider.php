<?php

namespace Drabbit\ColorSemantics\Providers;

use Drabbit\ColorSemantics\Models\Algorithm\Algorithm;
use Drabbit\ColorSemantics\Models\Color;
use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Models\Results\Result;
use Drabbit\ColorSemantics\Models\Results\ResultColorPivot;
use Drabbit\ColorSemantics\Models\Results\ResultConceptPivot;
use Drabbit\ColorSemantics\Models\Tests\Test;
use Drabbit\ColorSemantics\Models\Tests\TestConceptPivot;
use Drabbit\ColorSemantics\Observers\ResultColorPivotObserver;
use Drabbit\ColorSemantics\Observers\SlugObserver;
use Drabbit\ColorSemantics\Observers\UuidGenerateObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
//        Concept::observe(UuidGenerateObserver::class);

//        Color::observe([UuidGenerateObserver::class]);

        Test::observe([
//            UuidGenerateObserver::class,
            SlugObserver::class
        ]);
//        TestConceptPivot::observe([UuidGenerateObserver::class]);

//        AlgorithmTest::observe(UuidGenerateObserver::class);
//        AlgorithmConcept::observe([UuidGenerateObserver::class]);

//        Result::observe([UuidGenerateObserver::class]);
//        ResultConceptPivot::observe([UuidGenerateObserver::class]);
        ResultColorPivot::observe([
//            UuidGenerateObserver::class,
            ResultColorPivotObserver::class
        ]);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
