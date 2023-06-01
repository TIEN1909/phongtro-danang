<?php

namespace App\Service;

use App\Models\Phong;
use App\Models\Room;
use Illuminate\Support\Arr;

class RoomService
{
    protected $column = ['id', 'anhdaidien', 'ten', 'mota', 'chitietdiachi', 'gia', 'updated_at', 'khuvuc', 'slug', 'dichvu_hot'];

    public static function getRoomsHot($limit = 8)
    {
        $self = new self();
        return Phong::where('hot', 1)
            ->whereIn('trangthai', [Phong::STATUS_ACTIVE, Phong::STATUS_EXPIRED])
            ->limit($limit)->select($self->column)->get();
    }

    public static function getRoomsNew($limit = 10)
    {
        $self = new self();
        return Phong::whereIn('trangthai', [Phong::STATUS_ACTIVE, Phong::STATUS_EXPIRED])
            ->limit($limit)
            ->select($self->column)
            ->orderByDesc('id')
            ->get();
    }

    public static function getListsRoomVip($limit = 10, $params = [])
    {
        $self = new self();
        $room =  Phong::whereIn('trangthai', [Phong::STATUS_ACTIVE, Phong::STATUS_EXPIRED]);

        if ($dichvu_hot =  Arr::get($params, 'dichvu_hot'))
            $room->where('dichvu_hot', $dichvu_hot);

        return $room
            ->limit($limit)
            ->select($self->column)
            ->orderByDesc('id')
            ->get();
    }

    public static function getRoomsNewVip($limit = 10, $params = [])
    {
        $self = new self();
        $room =  Phong::whereIn('trangthai', [Phong::STATUS_ACTIVE, Phong::STATUS_EXPIRED]);
        $room->whereBetween('dichvu_hot', [2, 4]);

        return $room
            ->select($self->column)
            ->orderByDesc('dichvu_hot')
            ->paginate($limit);
    }

    public static function getListsRoom($request, $params = [])
    {
        $self = new self();
        $rooms = Phong::whereIn('trangthai', [Phong::STATUS_ACTIVE, Phong::STATUS_EXPIRED]);

        if ($categoryId = Arr::get($params, 'danhmuc_id'))
            $rooms->where('danhmuc_id', $categoryId);

        if ($cityId = Arr::get($params, 'location_city_id'))
            $rooms->where('thanhpho_id', $cityId);

        if ($quan_id = Arr::get($params, 'location_district_id'))
            $rooms->where('quan_id', $quan_id);

        if ($huyen_id = Arr::get($params, 'huyen_id'))
            $rooms->where('huyen_id', $huyen_id);

        if ($khoanggia = Arr::get($params, 'price'))
            $rooms->where('khoanggia', $khoanggia);

        if ($khoangkhuvuc = Arr::get($params, 'area'))
            $rooms->where('khoangkhuvuc', $khoangkhuvuc);

        $rooms = $rooms->select($self->column)->orderByDesc('id')->paginate(10);

        return $rooms;
    }
}
