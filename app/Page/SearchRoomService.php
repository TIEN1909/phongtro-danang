<?php

namespace App\Page;

use App\Service\RoomService;
use Illuminate\Http\Request;

class SearchRoomService
{
    public static function index(Request $request)
    {
        $params = $request->all();
        if (isset($params['thanhpho_id'])) $params["location_city_id"] = $params['thanhpho_id'];
        if (isset($params['quan_id'])) $params["location_district_id"] = $params['quan_id'];

        $rooms    = RoomService::getListsRoom($request, $params);
        return [
            'rooms'    => $rooms,
            'query'    => $request->query()
        ];
    }
}