
@php Theme::set('pageName', __()) @endphp
<div class="section">

    <form action="{{ URL::current() }}" method="GET">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
                        {{-- <div class="col-12">
                            <div class="product_header">
                                @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/sort')
                            </div>
                        </div> --}}
                    </div>
                    <div class="row shop_container grid">

                    @foreach($categories as $category)

                    @if($category->children->count() > 0)
                    <a href="{{route('get.sub.categories',$category->id) }}">
                        <div class="col-md-4 col-6">
                            <div class="product">

                                <div class="product_img">

                                    <img src="{{ RvMedia::getImageUrl($category->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">

                                </div>

                                <div class="product_info">
                                    <h6 class="product_title"><a href="{{route('get.sub.categories',$category->id) }}">{{ $category->name }}</a></h6>
                                    <div class="pr_desc">
                                        {{ $category->children }}

                                    </div>
                                </div>


                            </div>
                        </div>
                    </a>
                    @else
                    <a href="{{ $category->url }}">
                        <div class="col-md-4 col-6">
                            <div class="product">

                                <div class="product_img">

                                    <img src="{{ RvMedia::getImageUrl($category->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">


                                </div>

                                <div class="product_info">
                                    <h6 class="product_title"><a href="{{$category->url}}">{{ $category->name }}</a></h6>
                                    <div class="pr_desc">

                                    </div>
                                </div>


                            </div>
                        </div>
                    </a>
                    @endif


                    @endforeach


                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
