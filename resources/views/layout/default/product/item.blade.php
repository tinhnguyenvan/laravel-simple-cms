<div class="product-item">
    <div class="pro-image">
        <a href="{{ $item->link($item) }}">
            @if($item->image_url)
                <img src="{{ asset('storage'.$item->image_url) }}" alt="{{ $item->title }}" title="{{ $item->title }}"
                     class="img-responsive"/>
            @else
                <img src="{{ asset('layout/product1/img/empty_box.png') }}" alt="{{ $item->title }}"
                     class="img-responsive">
            @endif
        </a>
    </div>
    <div class="pro-content">
        <h4 class="pro-name">
            <a href="{{ $item->link($item) }}"> {{ $item->title }} </a>
        </h4>
        <div class="pro-price">
            @if($item->price_promotion > 0)
                <p class="price-new">{{ $item->price_promotion > 0  ? number_format($item->price_promotion) : 'Vui lòng gọi'}}</p>
                <p class="price-old">
                    <del>{{number_format($item->price)}}</del>
                </p>
            @else
                <p class="price-new">{{ $item->price > 0  ? number_format($item->price) : 'Vui lòng gọi'}}</p>
            @endif

        </div>
        <div class="link-detail">
            <span><a href="{{ $item->link($item) }}">Chi tiết</a></span>
        </div>
    </div>
</div>