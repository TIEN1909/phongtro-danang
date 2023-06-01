<?php

namespace App\Providers;


use App\Models\BaiViet;

use App\Models\DanhMuc;
use App\Models\DiaChi;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try{
            $categoriesGlobalSidebar = DanhMuc::select('id','ten','slug')->get();
            $categoriesGlobal = DanhMuc::select('id','ten','slug')->get();
            $articlesNew = BaiViet::orderByDesc('id')->limit(5)->get();
            $locationsCity = DiaChi::where('parent_id', 0)->select('id','ten')->get();
        }catch (\Exception $exception){

        }
        
        View::share('categoriesGlobal', $categoriesGlobal ?? []);
        View::share('categoriesGlobalSidebar', $categoriesGlobalSidebar ?? []);
        View::share('articlesNew', $articlesNew ?? []);
        View::share('locationsCity', $locationsCity ?? []);
        // dd($categoriesGlobalSidebar);
    }
}
