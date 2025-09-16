<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SystemSetting;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Attribute;
use App\Models\ProductVariationValue;
use App\Http\Resources\ProductIndexResourceCollection;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductFilterResource;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\ProductsFilter\AttributesFilter;




class ProductsController extends Controller
{

    public function __construct()
    {	  
	  $this->settings =  SystemSetting::first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function  index(Request $request, Category $category)
    {
        
        //Get color image
        if ($request->color && $request->product_id) {
            return $this->getColorImage($request);
        }

        $page_title = $category->title;
        $meta_tag_keywords = $category->keywords;
        $page_meta_description = $category->meta_description;
        $category_attributes = $category->attribute_parents()
                            ->has('children')
                            ->with(['children' => function ($q) {
                                $q->whereHas('attribute', function ($q2) {
                                    $q2->whereNotNull('name')->where('name', '!=', '');
                                })->with(['attribute' => function ($q2) {
                                    $q2->whereNotNull('name')->where('name', '!=', '');
                                }]);
                            }])
                            ->get();

                            


        $products = ProductVariation::whereNotNull('name')
            ->where('allow', true)->paginate(4);

        $products = ProductVariation::whereNotNull('name')
            ->where('allow', true)
            ->where('quantity', '>=', 1)
            ->whereHas('categories', function (Builder $builder) use ($category) {
                $builder->where('categories.name', $category->name);
            })
            ->filter($request, $this->getFilters($category_attributes))
            ->latest()
            ->with(['product:id']) // 👈 only these fields
            ->paginate($this->settings->products_items_per_page);

        $all = false;
        $colors = [];

        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'category_attributes' => $category_attributes->load('attribute'),
                'd' => true,
            ]);
        }

        $breadcrumb = $category->name;
        //$products =  $category->product_variants()->orderBy('created_at','desc')->paginate($this->settings->products_items_per_page);
        return  view('products.index', compact(
            'category',
            'page_title',
            'category_attributes',
            'breadcrumb',
            'products',
            'meta_tag_keywords',
            'meta_tag_keywords',
            'all'
        ));
    }


      public function getFilters($category_attributes)
    {
        $filters = [];
        foreach ($category_attributes as $category_attribute) {
            $filters[$category_attribute->attribute->slug] = AttributesFilter::class;
        }
        return $filters;
    }


    protected function search(Request $request)  {  
		$filtered_array = $request->only(['q', 'field']);
		if (empty( $filtered_array['q'] ) )  { 
			return redirect('/errors');
		}

		if($request->has('q')){
			$filtered_array = array_filter($filtered_array);
			$query = Product::select('products.*')->
						with('categories')->
						join('category_product', function($join) { 
							$join->on('category_product.product_id','=','products.id');
						})->
						join('categories', function($join) { 
							$join->on('category_product.category_id','=','categories.id');
						})
						->where(function ($query) use ($filtered_array) {
							$query->where('categories.name','like','%' .$filtered_array['q'] . '%')
								->orWhere('products.product_name', 'like', '%' .$filtered_array['q'] . '%')
								->orWhere('products.sku', 'like', '%' .$filtered_array['q'] . '%');
						});
			if($request->has('sort_by')){
				$sort = explode(',',$request->sort_by);
				$products =  $query->groupBy('products.id')->orderBy($sort[0],$sort[1])->paginate($this->settings->products_items_per_page);
			} 
			
			$products = $query->groupBy('products.id')->paginate($this->settings->products_items_per_page);
			$q = 'search?q='.$filtered_array['q'];
			$url['url'] = '/search?q='.$filtered_array['q']; 
            $url = collect($url);
			return  ProductIndexResourceCollection::collection(
                $products
            )->additional(['has_filters' => false]);   
		}
	     
   }



    // public function filters(Category $category){

    //     return  ProductFilterResource::collection(
    //             $category->parent_attributes
    //     )->additional(['sub_categories' => $category->children]);
    // }



    public function filters(Category $category){
        return  new ProductFilterResource(
            $category
        );
    }



    public function searchFilters(Request $request){

        $products = Product::whereHas('categories',function(Builder  $builder) use ($category){
            $builder->where('categories.category_name',$category->category_name);
        })->filter($request)->latest()->paginate(5);

        return response()->json([
            'products' => $products->toArray(),
            'category' => $category->category_name
        ]);
        
    }


   


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Category $category,Product $product) 
    {   
        return  (new ProductResource(
            $product
        ))->additional([
            'category' => [
               'name' => $category->name,
            ]
        ]);
    }
    



}
