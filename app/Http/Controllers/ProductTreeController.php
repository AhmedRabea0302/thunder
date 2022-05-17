<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use App\Models\ProductTree;
use App\Models\TreeProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProductTreeController extends Controller
{
    public function index() {
        $product_trees = ProductTree::OrderBy('created_at', 'DESC')->paginate(10);
        return view('pages.product-tree.index', ['product_trees' => $product_trees]);
    }

    public function getAddProductTree() {
        $products = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'تام')->get();
        $treeProducts = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'خامات')->get();
        return view('pages.product-tree.add-product-tree', ['products' => $products, 'treeProducts' => $treeProducts]);
    }

    public function getProduct(Request $request) {
        $product = Product::find($request->id);
        $productHasStandardTree = $this->checkIfProductHasStandardProductTree($product->getProductTrees);
        if($product) {
            return response()->json([
                'product' => $product,
                'productHasStTree' => $productHasStandardTree,
            ]);
        }
    }

    public function addProductTree(Request $request) {

        DB::transaction(function ($transaction) use ($request) {

            // Product Tree Attributes
            $product_id = $request->product_tree_id;
            $product_tree_code = $request->product_tree_code;
            $product_tree_type = $request->product_tree_type;
            $quantity = (double)$request->quantity;
            $total_budget = (double)$request->total_budget;
            $date = date('Y-m-d H:i:s');
            // Create Product Tree
            $product_tree_id = DB::table('product_trees')->insertGetId([
                'product_id' => $product_id,
                'product_tree_code' => $product_tree_code,
                'product_tree_type' => $product_tree_type,
                'quantity' => $quantity,
                'total_budget' => $total_budget,
                'created_at' => $date ,
                'updated_at' => $date
            ]);

            // Create Tree Products
            $tree_prouducts_number = count($request->product_id);
             for($i = 0; $i < $tree_prouducts_number; $i++) {
                DB::table('tree_products')->insert([
                    'product_tree_id' => $product_tree_id,
                    'product_id' => (double)$request->product_id[$i],
                    'quantity' => (double)$request->product_quantity[$i],
                    'wasted_quantity' => (double)$request->wasted_quantity[$i],
                    'total_quantity' => (double)$request->total_quantity[$i],
                    'created_at' => $date ,
                    'updated_at' => $date
                ]);
            }

            DB::table('products')->where('id', $request->product_tree_id)
            ->update(['unit_value' => $total_budget]);

        });
        Session::flash('message', 'تم إضافة شجرة المُنتج بنجاح!');

        return redirect()->route('product-tree');
    }

    public function getProductTreeDetails($id) {

        $products = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'تام')->get();
        $treeProducts = Product::where('product_type', '=', 'نصف مُصنع')->orWhere('product_type', '=', 'خامات')->get();
        $product_tree = ProductTree::find($id);
        $productsInthisTree = TreeProduct::where('product_tree_id', '=', $id)->get();
        return view('pages.product-tree.product-tree-details', [
            'product_tree' => $product_tree,
            'products' => $products,
            'treeProducts' => $treeProducts,
            'productsInthisTree' => $productsInthisTree
        ]);
    }

    public function updateProductTree(Request $request, $id) {
        DB::transaction(function () use ($request, $id) {
            $product_tree = ProductTree::find($id);

            $product_tree->update([
                'quantity' => $request->quantity,
                'total_budget' => $request->total_budget,
                'product_tree_type' => $request->product_tree_type
            ]);

            // Create Tree Products
            $tree_prouducts_number = count($request->product_id);
            // dd($request->all());
            for($i = 0; $i < $tree_prouducts_number; $i++) {
                TreeProduct::updateOrCreate(
                    [
                        'id'   => $request->ids[$i],
                    ],
                    [
                        'product_tree_id'     => $id,
                        'product_id' => $request->product_id[$i],
                        'quantity'    => $request->product_quantity[$i],
                        'wasted_quantity'   => $request->wasted_quantity[$i],
                        'total_quantity'       => $request->total_quantity[$i],
                    ]
                );
            }
        });

        Session::flash('message', 'تم تعديل شجرة المُنتج بنجاح!');

        return redirect()->back();
    }

    public function deleteProductFromTree($id) {
        $product = TreeProduct::find($id);
        if($product) {
            $product->delete();
        }
    }

    public function deleteProductTree($id) {
        $product_tree = ProductTree::find($id);
        $product_tree->delete();

        Session::flash('message', 'تم حذف شجرة المُنتج بنجاح!');

        return redirect()->back();
    }

    // Check if the product has a standard Product Tree
    public function checkIfProductHasStandardProductTree($productTrees) {
        $threshold = false;
        foreach($productTrees as $productTree) {
            if($productTree->product_tree_type == '0') {
                $threshold = true;
                break;
            }
        }
        return $threshold;

    }

}
