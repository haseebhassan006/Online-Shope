@php Theme::set('pageName', __()) @endphp
<div class="section">
    <form action="{{ URL::current() }}" method="GET">
       <div class="container">
          <div class="row">
            <div class="container">
                <div class="row">
                    @foreach($categories as $category)
                    <div class="col-12 ">
                       <div class="row">

                            <h3>{{ $category->name }}</h3>
                        </div>
                    </div>
                      @if($category->children->count() > 0)
                        @foreach($category->children as $child)
                        <a href="{{route('get.sub.categories',$child->id) }}">
                     <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                      <div class="card">

                        <img class="card-img" src="{{ RvMedia::getImageUrl($child->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">

                         <div class="card-img-overlay d-flex justify-content-end">

                          </div>
                           <div class="card-body">

                             <h4 class="card-title">
                              <a href="{{route('get.sub.categories',$child->id) }}">
                               {{ $child->name }}
                             </a>
                              </h4>

                        <h6 class="card-subtitle mb-2 text-muted"></h6>
                        <p class="card-text">
                          {{ $child->description }}            </p>
                          <div class="options d-flex flex-fill">
                          </div>
                           <div class="buy d-flex justify-content-between align-items-center">
                        </div>
                      </div>
                      </div>
                      </div>
                    </a>
                      @endforeach
                      @else
                      <a href="{{ $category->url }}">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                            <div class="card">
                                <img class="card-img" src="{{ RvMedia::getImageUrl($category->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}">
                                <div class="card-body">
                                    <h4 class="card-title">
                                    {{ $category->name }}
                                    </h4>
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
