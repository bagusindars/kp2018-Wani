<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Tag;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $tagss = Tag::get();
        $tagfix = array();
        foreach($tagss as $tag){
            $tagfix[] = $tag->name;
        }
        $tagfixp[] = asort($tagfix);
        View::share('tagfix',$tagfix);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
