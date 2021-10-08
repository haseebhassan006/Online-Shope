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
        <!-- Home Popup Section -->

        <!-- End Screen Load Popup Section -->
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
                        <div class="categories_wrap">
                            <button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn">
                                <i class="linearicons-menu"></i><span>{{ __('All Categories') }} </span>
                            </button>
                            <div id="navCatContent" class="@if (url()->current() === url('') && theme_option('collapsing_product_categories_on_homepage', 'no') == 'no') nav_cat @endif navbar collapse">
                                <ul>
                                    @foreach($categories as $category)
                                        @if ($loop->index < 10)
                                            <li @if ($category->children->count() > 0) class="dropdown dropdown-mega-menu" @endif>
                                                <a class="dropdown-item nav-link @if ($category->children->count() > 0) dropdown-toggler @endif" href="{{ $category->url }}" @if ($category->children->count() > 0) data-toggle="dropdown" @endif>
                                                    @if ($category->icon && count($category->icon->meta_value) > 0)
                                                        <i class="{{ $category->icon->meta_value[0] }}"></i>
                                                    @endif
                                                    <span>{{ $category->name }}</span></a>
                                                @if ($category->children->count() > 0)
                                                    <div class="dropdown-menu">
                                                        <ul class="mega-menu d-lg-flex">
                                                            <li class="mega-menu-col">
                                                                <ul>
                                                                    @foreach($category->children as $childCategory)
                                                                        <li><a class="dropdown-item nav-link nav_item" href="{{ $childCategory->url }}">{{ $childCategory->name }}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </li>
                                        @else
                                        @if ($loop->index == 10)
                                            <li>
                                                <ul class="more_slide_open" style="display: none;">
                                            @endif
                                                <li @if ($category->children->count() > 0) class="dropdown dropdown-mega-menu" @endif>
                                                    <a class="dropdown-item nav-link nav_item @if ($category->children->count() > 0) dropdown-toggler @endif" href="{{ $category->url }}" @if ($category->children->count() > 0) data-toggle="dropdown" @endif>
                                                        @if (count($category->icon->meta_value) > 0)
                                                            <i class="{{ $category->icon->meta_value[0] }}"></i>
                                                        @endif
                                                    <span>{{ $category->name }}</span></a>
                                                    @if ($category->children->count() > 0)
                                                        <div class="dropdown-menu">
                                                            <ul class="mega-menu d-lg-flex">
                                                                <li class="mega-menu-col">
                                                                    <ul>
                                                                        @foreach($category->children as $childCategory)
                                                                            <li><a class="dropdown-item nav-link nav_item" href="{{ $childCategory->url }}">{{ $childCategory->name }}</a></li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </li>
                                            @if ($loop->last)
                                                </ul>
                                            </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                                @if (count($categories) > 10)
                                <div class="more_categories">{{ __('More Categories') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-6 col-8">
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false">
                                <span class="ion-android-menu"></span>
                            </button>
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

