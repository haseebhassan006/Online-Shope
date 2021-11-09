<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Poppins')) }}:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <style>
            :root {
                --color-1st: {{ theme_option('primary_color', '#FF324D') }};
                --color-2nd: {{ theme_option('secondary_color', '#1D2224') }};
                --primary-font: '{{ theme_option('primary_font', 'Poppins') }}', sans-serif;
            }
/* nav {
  width: 70%;
  margin: 0 auto;
  list-style: none;
  display: flex;
  justify-content: space-around;
  align-items: center;
  height: 50px;
  opacity: 1;
} */

nav .dropdown button{
  width: max-content;
  padding: 10px 20px;
  text-align: center;
  font-weight: bold;
  background: none;
  outline: none;
  border: none;
  color:#fff;
  background-color: #f30707;
height: 66px;
}
nav .dropdown button span {
  font-size: 1.25rem;
  display: none;
}

nav .dropdown button:hover{
  color: #fff;
  text-decoration: none;
  border-bottom: solid 3p;
  padding-bottom: 7px;
  cursor: pointer;
}

.content-nav {
  display: none;
  position: absolute;
  left: -817px;
  width: 100vw;
  margin: 0;
  padding-top: 20px;
  background: #1d2224;
  border-top: 15px transparent solid;

}
.dropdown:hover .content-nav {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  flex-direction: column;
}

.row-nav {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 25px;

}
h2{
  background: rgba(220,220,220);
  color:#fff;
  text-align: center;
  width: 100%;
  padding: 25px 0;
  margin-top: -35px;
  font-size: 2rem;
}

nav .dropdown:hover .content-nav h3{
    color:#f30303;

}
h3{
    font-size: 1rem;
  font-weight: bold;
  margin-bottom: 15px;
}

.row-nav :not(last-child){
  margin-right: 35px;
}

.column {
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.column a {
  color:#fff;
  text-decoration: none;
  font-size: .9rem;
}
.column a:not(last-child){
  margin-bottom: 10px;
}
.column a:hover {
  color:#fff;
  text-decoration: underline;
}
@media (max-width: 800px){

/* nav {
    width: 50%;
    flex-direction: column;
    height: 100%;
    padding: unset;
    margin: unset;
    text-align: left;
    align-items: flex-start;
    justify-content: flex-start;
    display: none;
  } */

  nav .dropdown button {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #eee;
  }
  nav .dropdown button span {
    display: inline;
  }
  nav .dropdown button:hover{
    color: black;
    text-decoration: none;
    border-bottom-color: #eee;
    cursor: unset;
  }
  nav .dropdown:hover .content-nav {
    display: none;
  }

  .content-nav h2 {
    display: none;
  }
  .row-nav {
    flex-direction: column;
    padding: 0;
    margin: 0;
  }
  .column {
    padding: 0 20px;
    margin: 0 0 10px 0;
  }

}
.
 @media (max-width: 600px){
  /* nav {
    width: 100%;
  } */
}



/* Animation for hamburger menu */
.animInfo {
  animation-duration: .5s;
  animation-fill-mode: forwards;
  animation-timing-fucntion: ease;
}
@keyframes bar1Anim {
  0%{transform: rotate(0deg) translate(0px);}
  100%{transform: rotate(45deg) translate(6px, 10px);}
}
@keyframes bar2Anim {
  0%{opacity: 1;}
  100%{opacity: 0;}
}
@keyframes bar3Anim {
  0%{transform: rotate(0deg) translate(0px);}
  100%{transform: rotate(-45deg) translate(6px, -10px);}
}

@keyframes bar1AnimReverse {
  0%{transform: rotate(45deg) translate(6px, 10px);}
  100%{transform: rotate(0deg) translate(0px);}
}
@keyframes bar2AnimReverse {
  0%{opacity: 0;}
  100%{opacity: 1;}
}
@keyframes bar3AnimReverse {
  0%{transform: rotate(-45deg) translate(6px, -10px);}
  100%{transform: rotate(0deg) translate(0px);}
}

/* Animation for navigation appearing */
@keyframes navAnim {
  0%{opacity: 0;}
  100%{opacity: 1;}
}
@keyframes navAnimReverse {
  0%{opacity: 1;}
  100%{opacity: 0;}
}
@media (min-width: 801px){
  nav {
    opacity: 1 !important;
  }
}
        </style>

        {!! Theme::header() !!}
    </head>
    <body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>
    @if (theme_option('preloader_enabled', 'no') == 'yes')
        <!-- LOADER -->
        <div class="preloader">
            <div class="lds-ellipsis">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- END LOADER -->
    @endif

    <div id="alert-container"></div>

    @if (is_plugin_active('newsletter') && theme_option('enable_newsletter_popup', 'yes') === 'yes')
        <div data-session-domain="{{ config('session.domain') ?? request()->getHost() }}"></div>

    @endif

    @php
        if (is_plugin_active('ecommerce')) {
            $categories = get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable', 'children', 'children.slugable', 'icon'], [], true);
        } else {
            $categories = [];
        }

    @endphp


    <!-- START HEADER -->
    <header class="header_wrap @if (theme_option('enable_sticky_header', 'yes') == 'yes') fixed-top header_with_topbar @endif">
        <div class="top-header d-none d-md-block">
            <div class="container">
                <div class="row align-items-center">
                    @if (theme_option('hotline'))
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                <ul class="contact_detail text-center text-lg-left">
                                    <li><i class="ti-mobile"></i><span>{{ theme_option('hotline') }}</span></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                            @if (is_plugin_active('ecommerce'))
                                @php $currencies = get_all_currencies(); @endphp
                                @if (count($currencies) > 1)
                                    <div class="mr-3 choose-currency">
                                        <span>{{ __('Currency') }}: </span>
                                        @foreach ($currencies as $currency)
                                            <a href="{{ route('public.change-currency', $currency->title) }}" @if (get_application_currency_id() == $currency->id) class="active" @endif><span>{{ $currency->title }}</span></a>&nbsp;
                                        @endforeach
                                    </div>
                                @endif
                                <ul class="header_list">
                                    <li><a href="{{ route('public.compare') }}"><i class="ti-control-shuffle"></i><span>{{ __('Compare') }}</span></a></li>
                                    @if (!auth('customer')->check())
                                        <li><a href="{{ route('customer.login') }}"><i class="ti-user"></i><span>{{ __('Login') }}</span></a></li>
                                    @else
                                        <li><a href="{{ route('customer.overview') }}"><i class="ti-user"></i><span>{{ auth('customer')->user()->name }}</span></a></li>
                                        <li><a href="{{ route('customer.logout') }}"><i class="ti-lock"></i><span>{{ __('Logout') }}</span></a></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <div class="middle-header dark_skin">
            <div class="container">
                <div class="nav_block">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="logo_dark" src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" />
                    </a>
                    @if (theme_option('hotline'))
                        <div class="contact_phone order-md-last">
                            <i class="linearicons-phone-wave"></i>
                            <span>{{ theme_option('hotline') }}</span>
                        </div>
                    @endif
                    @if (is_plugin_active('ecommerce'))
                        <div class="product_search_form">
                            <form action="{{ route('public.products') }}" method="GET">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="custom_select">
                                            <select name="categories[]" class="first_null">
                                                <option value="">{{ __('All') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @if (in_array($category->id, request()->input('categories', []))) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input class="form-control" name="q" value="{{ request()->input('q') }}" placeholder="{{ __('Search Product') }}..." required  type="text" style="height:50px;">
                                    <button type="submit" class="search_btn"><i class="linearicons-magnifier"></i></button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="bottom_header light_skin main_menu_uppercase bg_dark @if (url()->current() === url('')) mb-4 @endif" style="height:66px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-4">
                        @if (theme_option('enable_sticky_header', 'yes') == 'yes')
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ RvMedia::getImageUrl(theme_option('logo_footer') ? theme_option('logo_footer') : theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" />
                            </a>
                        @endif
                    </div>
                    <div class="container w-auto">
       <nav class="navbar navbar-expand-lg">
         <div class='dropdown'>
          <button>Product Menu<span class="fa fa-caret-right"></span></button>
           <div class="content-nav">
              <div class="row-nav">

            @foreach($categories as $category)

                    <div class="column">
                        @if($category->children->count() > 0)
                        <h4 style="color:#f30707">{{ $category->name }}</h4>
                        @endif
                          @foreach ($category->children as $key=>$childCategory)
                        <div class="column">
                         <a href="{{ route('get.sub.categories',$childCategory->id) }}"> {{ $childCategory->name }}</a>
                        </div>
                        @if ($loop->iteration % 3 == 0)
                    </div>
                    <div class="column">
                        @endif


            @endforeach

                </div>

          @endforeach
        </div>



      </div>
    </div>
    <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
        {!! Menu::renderMenuLocation('main-menu', ['view' => 'menu', 'options' => ['class' => 'navbar-nav']]) !!}
    </div>
    @if (is_plugin_active('ecommerce'))
        <ul class="navbar-nav attr-nav align-items-center">
            <li><a href="@if (!auth('customer')->check()) {{ route('customer.overview') }} @else {{ route('customer.login') }} @endif" class="nav-link"><i class="linearicons-user"></i></a></li>
            <li><a href="{{ route('public.wishlist') }}" class="nav-link btn-wishlist"><i class="linearicons-heart"></i><span class="wishlist_count">{{ !auth('customer')->check() ? Cart::instance('wishlist')->count() : auth('customer')->user()->wishlist()->count() }}</span></a></li>
            @if (EcommerceHelper::isCartEnabled())
                <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger btn-shopping-cart" href="#" data-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count">{{ Cart::instance('cart')->count() }}</span></a>
                    <div class="cart_box dropdown-menu dropdown-menu-right">
                        {!! Theme::partial('cart') !!}
                    </div>
                </li>
            @endif
        </ul>
    @endif
    <div class="pr_search_icon">
        <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
    </div>
  </nav>
        </div>
                </div>
            </div>
        </div>
</header>

