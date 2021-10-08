<?php

namespace Theme\Shopwise\Http\Controllers;

use DB;
use Cart;
use Theme;
use EcommerceHelper;
use Illuminate\Http\Request;
use Botble\Ecommerce\Models\Brand;
use Botble\Ecommerce\Models\Product;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Models\ProductAttribute;
use Theme\Shopwise\Http\Resources\PostResource;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Models\ProductAttributeSet;
use Theme\Shopwise\Http\Resources\BrandResource;
use Theme\Shopwise\Http\Resources\ReviewResource;
use Botble\Theme\Http\Controllers\PublicController;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Theme\Shopwise\Http\Resources\TestimonialResource;
use Theme\Shopwise\Http\Resources\ProductCategoryResource;
use Botble\Ecommerce\Repositories\Interfaces\ReviewInterface;
use Botble\Ecommerce\Repositories\Interfaces\FlashSaleInterface;
use Botble\Testimonial\Repositories\Interfaces\TestimonialInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;

class ShopwiseController extends PublicController
{
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_products_by_collections([
            'collections' => [
                'by'       => 'id',
                'value_in' => [$request->input('collection_id')],
            ],
            'take'        => 10,
            'with'        => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
                'promotions',
                'latestFlashSales',
            ],
            'withCount'   => $withCount,
        ]);

        $data = [];
        foreach ($products as $product) {
            $data[] = Theme::partial('product-item', compact('product'));
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getFeaturedProductCategories(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $categories = get_featured_product_categories();

        return $response->setData(ProductCategoryResource::collection($categories));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetTrendingProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_trending_products([
            'take'      => 10,
            'with'      => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
                'promotions',
                'latestFlashSales',
            ],
            'withCount' => $withCount,
        ]);

        $data = [];
        foreach ($products as $product) {
            $data[] = Theme::partial('product-item', compact('product'));
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetFeaturedBrands(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $brands = get_featured_brands();

        return $response->setData(BrandResource::collection($brands));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetFeaturedProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $data = [];

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_featured_products([
            'take'      => 10,
            'with'      => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
                'promotions',
                'latestFlashSales',
            ],
            'withCount' => $withCount,
        ]);

        foreach ($products->chunk(3) as $chunk) {
            $item = '';
            foreach ($chunk as $product) {
                $item .= Theme::partial('product-item', compact('product'));
            }
            $data[] = $item;
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetTopRatedProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_top_rated_products(10, [
            'slugable',
            'variations',
            'productLabels',
            'variationAttributeSwatchesForProductList',
            'promotions',
            'latestFlashSales',
        ], $withCount);

        $data = [];
        foreach ($products->chunk(3) as $chunk) {
            $item = '';
            foreach ($chunk as $product) {
                $item .= Theme::partial('product-item', compact('product'));
            }
            $data[] = $item;
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxGetOnSaleProducts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $products = get_products_on_sale([
            'take'      => 10,
            'with'      => [
                'slugable',
                'variations',
                'productLabels',
                'variationAttributeSwatchesForProductList',
                'promotions',
                'latestFlashSales',
            ],
            'withCount' => $withCount,
        ]);

        $data = [];
        foreach ($products->chunk(3) as $chunk) {
            $item = '';
            foreach ($chunk as $product) {
                $item .= Theme::partial('product-item', compact('product'));
            }
            $data[] = $item;
        }

        return $response->setData($data);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxCart(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        return $response->setData([
            'count' => Cart::instance('cart')->count(),
            'html'  => Theme::partial('cart'),
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return mixed
     */
    public function getQuickView(Request $request, $id, BaseHttpResponse $response)
    {
        if (!$request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        $withCount = [];
        if (EcommerceHelper::isReviewEnabled()) {
            $withCount = [
                'reviews',
                'reviews as reviews_avg' => function ($query) {
                    $query->select(DB::raw('avg(star)'));
                },
            ];
        }

        $product = get_products([
            'condition' => [
                'ec_products.id'     => $id,
                'ec_products.status' => BaseStatusEnum::PUBLISHED,
            ],
            'take'      => 1,
            'with'      => [
                'defaultProductAttributes',
                'slugable',
                'tags',
                'tags.slugable',
            ],
            'withCount' => $withCount,
        ]);

        if (!$product) {
            return $response->setNextUrl(route('public.index'));
        }

        $productImages = $product->images;
        if ($product->is_variation) {
            $product = $product->original_product;
            $selectedAttrs = app(ProductVariationInterface::class)->getAttributeIdsOfChildrenProduct($product->id);
            if (count($productImages) == 0) {
                $productImages = $product->images;
            }
        } else {
            $selectedAttrs = $product->defaultVariation->productAttributes;
        }

        return Theme::partial('quick-view', compact('product', 'selectedAttrs', 'productImages'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function ajaxGetFeaturedPosts(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $posts = app(PostInterface::class)->getFeatured(3);

        return $response
            ->setData(PostResource::collection($posts))
            ->toApiResponse();
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param TestimonialInterface $testimonialRepository
     * @return BaseHttpResponse
     */
    public function ajaxGetTestimonials(
        Request $request,
        BaseHttpResponse $response,
        TestimonialInterface $testimonialRepository
    ) {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $testimonials = $testimonialRepository->allBy(['status' => BaseStatusEnum::PUBLISHED]);

        return $response->setData(TestimonialResource::collection($testimonials));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param ReviewInterface $reviewRepository
     * @return BaseHttpResponse
     */
    public function ajaxGetProductReviews(
        $id,
        Request $request,
        BaseHttpResponse $response,
        ReviewInterface $reviewRepository
    ) {
        if (!$request->ajax() || !$request->wantsJson()) {
            return $response->setNextUrl(route('public.index'));
        }

        $reviews = $reviewRepository->advancedGet([
            'condition' => [
                'status'     => BaseStatusEnum::PUBLISHED,
                'product_id' => $id,
            ],
            'order_by'  => ['created_at' => 'desc'],
            'paginate'  => [
                'per_page'      => (int)$request->input('per_page', 10),
                'current_paged' => (int)$request->input('page', 1),
            ],
        ]);

        return $response->setData(ReviewResource::collection($reviews))->toApiResponse();
    }

    public function ajaxFindBlade(Request $request, BaseHttpResponse $response){

          $brand = $request->brand;
          $attributes = array();
          $attributes['model'] = $request->model;
          $attributes['bladesizeinche'] = $request->bladesizeinche;
          $attributes['bladesizefrac'] = $request->bladesizefrac;
          $attributes['bladelengthwidth'] = $request->bladelengthwidth;
          $attributes['bladelengthick'] = $request->bladelengthick;
          $attributes['cross'] = $request->cross;
          $attributes['material'] = $request->material;
          $attributes['dimension'] = $request->dimension;

          $products = "";
          if(!empty($request->all())){
            $products = Product::with('productAttributes')->with('brand')
            ->WhereHas('productAttributes', function ($query) use ($attributes) {

                $query->where('attribute_id', $attributes['bladesizeinche'])
                  ->orwhere('attribute_id', $attributes['bladesizefrac'])
                  ->orwhere('attribute_id', $attributes['bladelengthwidth'])
                  ->orwhere('attribute_id',$attributes['bladelengthick'])
                  ->orwhere('attribute_id', $attributes['cross'])
                  ->orwhere('attribute_id',$attributes['material'])
                  ->orwhere('attribute_id',$attributes['dimension']);
            })
            ->orwhere('brand_id',$brand)
            ->orderBy('id')
            ->get();

          }else{
            $products = Product::with('productAttributes')->with('brand')->get();

          }




          $view = [
              'products' => $products,
               'n' =>"botble",
              'name' => 'bladeresult',
          ];




$theme = Theme::uses('shopwise')->layout('default');
return $theme->scope('bladeresult', $view)->render();






    }
    public function ajaxGetFinder(BaseHttpResponse $response){


        $brands = Brand::all();
        $attribute_model_id = ProductAttributeSet::where('title','Model')->pluck('id')->first();
        $attribute_bladelengthinches_id = ProductAttributeSet::where('title','Blade Length(inches)')->pluck('id')->first();
        $attribute_bladelengthfrac_id = ProductAttributeSet::where('title','Blade Length(fraction)')->pluck('id')->first();
        $attribute_crosssection_id = ProductAttributeSet::where('title','CROSS SECTION')->pluck('id')->first();
        $attribute_bladesize_width_id = ProductAttributeSet::where('title','Blade Size(width)')->pluck('id')->first();
        $attribute_blade_size_thick_id = ProductAttributeSet::where('title','Blade Size(thickness)')->pluck('id')->first();
        $attribute_material_id = ProductAttributeSet::where('title','Material')->pluck('id')->first();
        $attribute_materialwidth_id = ProductAttributeSet::where('title','Material Width')->pluck('id')->first();
        $attribute_length_feet_id = ProductAttributeSet::where('title','Blade Length(Feet)')->pluck('id')->first();
        $attribute_length_inch_id = ProductAttributeSet::where('title','Blade Length(Inch)')->pluck('id')->first();

        $models = ProductAttribute::where('attribute_set_id',$attribute_model_id)->get();
        $bladelengthinches = ProductAttribute::where('attribute_set_id',$attribute_bladelengthinches_id )->get();
        $bladelengthfractions = ProductAttribute::where('attribute_set_id',$attribute_bladelengthfrac_id)->get();
        $crossSections = ProductAttribute::where('attribute_set_id',$attribute_crosssection_id)->get();
        $bladesizewidth = ProductAttribute::where('attribute_set_id',$attribute_bladesize_width_id)->get();
        $bladesizethicks = ProductAttribute::where('attribute_set_id',$attribute_blade_size_thick_id)->get();
        $materials = ProductAttribute::where('attribute_set_id',$attribute_material_id)->get();
        $lengthFeets = ProductAttribute::where('attribute_set_id',$attribute_length_feet_id)->get();
        $lengthInches = ProductAttribute::where('attribute_set_id',$attribute_length_inch_id)->get();
        $materialwidths = ProductAttribute::where('attribute_set_id',$attribute_materialwidth_id)->get();


        $theme = Theme::uses('shopwise')->layout('default');

        $view = [
            'name' => 'finder',
            'brands' => $brands,
            'models' => $models,
            'bladelengthinches' => $bladelengthinches,
            'bladelengthfractions' =>$bladelengthfractions,
            'crossSections' => $crossSections,
            'bladesizewidths' => $bladesizewidth,
            'bladesizethicks' => $bladesizethicks,
            'materials' => $materials,
            'lengthFeets' => $lengthFeets,
            'lengthInches' => $lengthInches,
            'materialwidths' => $materialwidths
        ];


        // home.index will look up the path 'platform/themes/your-theme/views/home/index.blade.php'
        return $theme->scope('finder', $view)->render();

    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @param FlashSaleInterface $flashSaleRepository
     * @return BaseHttpResponse
     */
    public function ajaxGetFlashSales(
        Request $request,
        BaseHttpResponse $response,
        FlashSaleInterface $flashSaleRepository
    ) {
        if (!$request->ajax()) {
            return $response->setNextUrl(route('public.index'));
        }

        $flashSales = $flashSaleRepository->getModel()
            ->notExpired()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with([
                'products' => function ($query) {
                    $withCount = [];
                    if (EcommerceHelper::isReviewEnabled()) {
                        $withCount = [
                            'reviews',
                            'reviews as reviews_avg' => function ($query) {
                                $query->select(DB::raw('avg(star)'));
                            },
                        ];
                    }

                    return $query->where('status', BaseStatusEnum::PUBLISHED)->withCount($withCount);
                },
            ])
            ->get();

        if (!$flashSales->count()) {
            return $response->setData([]);
        }

        $data = [];
        foreach ($flashSales as $flashSale) {
            foreach ($flashSale->products as $product) {
                $data[] = Theme::partial('flash-sale-product', compact('product', 'flashSale'));
            }
        }

        return $response->setData($data);
    }
}
