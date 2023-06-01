<?php

namespace App\Page;

use App\Models\DiaChi;
use App\Service\RoomService;
use Illuminate\Http\Request;

class PageLocationService
{
    public static function index($id, Request $request)
    {
        $location = DiaChi::find($id);
        $params = $request->all();
        $params['location_city_id'] = $id;

        $rooms    = RoomService::getListsRoom($request, $params);
        $districts = DiaChi::withCount('roomDistricts')->where('parent_id', $id)
            ->limit(24)->get();

        // dd($districts);
        return [
            'location'  => $location,
            'rooms'     => $rooms,
            'districts' => $districts,
            'query'     => $request->query()
        ];
    }

    public static function indexByDistrict($id, Request $request)
    {
        $location = DiaChi::find($id);
        $rooms    = RoomService::getListsRoom($request, $params = [
            'location_district_id' => $id
        ]);

        return [
            'location'  => $location,
            'rooms'     => $rooms,
            'query'     => $request->query()
        ];
    }

    public static function indexByWards($id, Request $request)
    {
        $location = DiaChi::find($id);
        $rooms    = RoomService::getListsRoom($request, $params = [
            'huyen_id' => $id
        ]);

        return [
            'location'  => $location,
            'rooms'     => $rooms,
            'query'     => $request->query()
        ];
    }
}
