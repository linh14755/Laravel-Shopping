<?php

namespace App\Http\Controllers;

use App\Category;
use App\Compoments\Recusive;
use App\Http\Requests\ProductAddRequest;
use App\Product;
use App\ProductImage;
use App\ProductTag;
use App\Tag;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageStrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Storage;
use DB;

class AdminProductController extends Controller
{
    use StorageImageStrait;
    use DeleteModelTrait;

    private $category;
    private $product;
    private $productImage;
    private $tag;
    private $productTag;
    private $recusive;


    public function __construct(Category $category, Product $product, ProductImage $productImage, Tag $tag, ProductTag $productTag)
    {
        $this->category = $category;
        $this->product = $product;
        $this->productImage = $productImage;
        $this->tag = $tag;
        $this->productTag = $productTag;

        $data = $this->category->all();
        $this->recusive = new Recusive($data);
    }

    public function index()
    {
        $product = $this->product->latest()->paginate(20);
        return view('admin.product.index', compact('product'));
    }

    public function create()
    {
        $htmlOption = $this->getcategory($parent_id = '');
        return view('admin.product.add', compact('htmlOption'));
    }

    public function getcategory($parent_id)
    {
        $htmlOption = $this->recusive->categoryRecusive($parent_id);
        return $htmlOption;
    }

    public function store(ProductAddRequest $request)
    {
        try {

            DB::beginTransaction();
            //Insert data to products
            $dataProductCreate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id
            ];


            $dataUploadfeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');


            if (!empty($dataUploadfeatureImage)) {
                $dataProductCreate['feature_image_name'] = $dataUploadfeatureImage['file_name'];
                $dataProductCreate['feature_image_path'] = $dataUploadfeatureImage['file_path'];
            }
            $product = $this->product->create($dataProductCreate);


            //Insert data to product_images
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMultipe($fileItem, 'product');

                    $product->images()->create([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name']
                    ]);
                }
            }

            //Insert tags for product
            if (!empty($request->tags)) {
                foreach ($request->tags as $tag) {
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tag]);

                    $tagId[] = $tagInstance->id;
                }
                $product->tags()->attach($tagId);
            }
            DB::commit();

            //Sau khi thêm sản phẩm xong quay lại trang danh sách sản phẩm
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();

        }
    }

    public function edit($id)
    {
        $product = $this->product->find($id);
        $htmlOption = $this->recusive->categoryRecusive($parent_id = $product->category_id);
        return view('admin.product.edit', compact('htmlOption', 'product'));
    }

    public function update(ProductAddRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //Update data to products
            $dataProductUpdate = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id
            ];
            $dataUploadfeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

            if (!empty($dataUploadfeatureImage)) {
                $dataProductUpdate['feature_image_name'] = $dataUploadfeatureImage['file_name'];
                $dataProductUpdate['feature_image_path'] = $dataUploadfeatureImage['file_path'];
            }

            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);

            //Update data to product_images
            $this->productImage->where('product_id', $id)->delete();
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMultipe($fileItem, 'product');

                    $product->images()->create([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name']
                    ]);
                }
            }
            //Update tags for product
            if (!empty($request->tags)) {
                foreach ($request->tags as $tag) {
                    $tagInstance = $this->tag->firstOrCreate(['name' => $tag]);
                    $tagId[] = $tagInstance->id;
                }
                $product->tags()->sync($tagId);
            }

            DB::commit();

            //Sau khi thêm sản phẩm xong quay lại trang danh sách sản phẩm
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            Log::error('Message' . $exception->getMessage() . ' ------Line ' . $exception->getLine());
            DB::rollBack();
            return redirect()->route('product.create');
        }
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->product);
    }


    //front-end
    public function addToCart($id)
    {
//        session()->flush('cart'); //xoa session
        $product = $this->product->find($id);
        $cart = session()->get('cart'); // lấy giá trị trong session để thêm quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->feature_image_path
            ];
        }
        // Tạo session với key => value
        session()->put('cart', $cart);

        //Lấy số lượng sản phẩm đã thêm để hiển thị lên thẻ cart
        $cartsNumber = count(session()->get('cart'));

        //sau khi tạo xong session thì return cho ajax thông báo cho người dùng
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'cartNumber' => $cartsNumber
        ], 200);
    }

    public function showCart()
    {
        $categorys = $this->category->where('parent_id', 0)->get();
        $categoryLimits = $this->category->where('parent_id', 0)->take(3)->get();
        $carts = session()->get('cart');
        //Lấy số lượng sản phẩm đã thêm để hiển thị lên thẻ cart
        $cartsNumber = count(session()->get('cart'));

        return view('frontend.product.cart.cart', compact('categorys', 'categoryLimits', 'carts','cartsNumber'));
    }
}
