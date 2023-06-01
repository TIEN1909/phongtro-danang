<section class="top-location container">

    <div class="top-location__body">
        <h2 class="body-title">
            Khu vực nổi bật
        </h2>
        <div class="location-list">
            @foreach($locationsHot ?? [] as $item)
            @php
            $route = 'get.room.by_location';
            if ($item->loai == 2)
            $route = 'get.room.by_district';
            @endphp
            <a class="location-item city-1" href="{{ route($route,['id' => $item->id, 'slug' => $item->slug]) }}" title="Cho thuê phòng trọ {{ $item->ten }}">
                <img src="{{ pare_url_file($item->anhdaidien) }}" alt="">
                <div class="location-cat">
                    <span>
                        <span class="location-name">
                            {{ $item->ten }}
                        </span>
                        <span>
                            ({{ $item->rooms_count ?? 0  }})
                        </span>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
<script>

</script>