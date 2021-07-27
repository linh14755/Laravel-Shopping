<div class="category-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            @foreach($categorys as $indexcategory=> $category)
                <li class="{{$indexcategory ==0 ?'active':''}}"><a href="#category_tab_{{$category->id}}"
                                                                   data-toggle="tab">{{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="tab-content">
        @foreach($categorys as $indexcategoryproduct=> $categoryproduct)
            <div class="tab-pane fade {{($indexcategoryproduct == 0)?'active in':''}}" id="category_tab_{{$categoryproduct->id}}">
                @foreach($categoryproduct->products as $product)
                    <div class="col-sm-3">
                        <div class="product-image-wrapper" style="width: 180px;height: 280px">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{config('app.base_url').$product->feature_image_path}}" style="height: 100px;width: 100px"/>
                                    <h2>{{number_format($product->price)}}</h2>
                                    <p>{{$product->name}}</p>
                                    <a href="#" class="btn btn-default add-to-cart"><i
                                            class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
