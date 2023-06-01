<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DiaChi;

use App\Page\SearchRoomService;
use Illuminate\Http\Request;

class SearchRoomController extends Controller
{
    public function index(Request $request)
    {
        $data = SearchRoomService::index($request);
        if ($request->thanhpho_id) {
            $districts = DiaChi::where('parent_id', $request->thanhpho_id)->get();
            $data['districts'] = $districts;
        }

        if ($request->quan_id) {
            $wards = DiaChi::where('parent_id', $request->quan_id)->get();
            $data['wards'] = $wards;
        }
        return view('frontend.pages.search_room.index', $data);
    }
}