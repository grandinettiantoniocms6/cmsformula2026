<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PluginProductsImages;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index(Request $request)
    {
        $table = $request->get('table');
        $id = $request->get('id');

        if($table == "plugins_products_images") {
            $images = PluginProductsImages::where("product_id", $id)->orderBy("order", "asc")->get();
        }else{
            $images = \DB::table("$table")->where("block_id", $id)->get();
        }

        return view('vendor.backpack.base.dropzone', compact('table','id', 'images'));
    }

    public function fileStore(Request $request)
    {
        $image = $request->file('file');
        $table = $request->get('table');
        $id = $request->get('id');

        $imageName = $image->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();

        $imageName = str_replace(".", "-", $imageName);
        $now = Carbon::now()->timestamp;
        $newImageName = "{$imageName}-{$now}.$ext";

        // $newImageName = \Str::slug($imageName);
        //$newImageName = $imageName;

        if($table == "plugins_products_images"){
            $image->move(public_path('uploads/products'),$newImageName);
            $imageUpload = new PluginProductsImages();
            $imageUpload->product_id = $id;
            $imageUpload->image = $newImageName;
            $imageUpload->save();
        }else{

            $image->move(public_path('uploads'),$newImageName);

            $ordine = \DB::table("$table")->orderBy("lft", "desc")->first();
            if(!$ordine){
                $ord = 0;
            }else{
                $ord = $ordine->lft + 1;
            }

            \DB::table("$table")->insert([
                "block_id" => $id,
                "title" => "Foto",
                "foto" => "uploads/$newImageName",
                "lft" => $ord
             ]);
        }

        return response()->json(['success'=>$newImageName]);
    }

    public function fileDestroy(Request $request)
    {

        $filename =  $request->get('filename');
        if($request->has('id')){
            $id = $request->get('id');
            PluginProductsImages::where("id", $id)->delete();
        }else{
            PluginProductsImages::where("image", $filename)->delete();
        }

        $path=public_path().'/uploads/products/'.$filename;
        if (file_exists($path)) {
          //  unlink($path);
        }
        return $filename;
    }

    public function reorder(Request $request, PluginProductsImages $productImage)
    {
        if ($request->order) {
            foreach ($request->order as $position => $id) {
                PluginProductsImages::where("id", $id)->update(['order' => $position]);
            }
        }
    }
}
