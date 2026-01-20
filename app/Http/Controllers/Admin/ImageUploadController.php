<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminBlock;
use App\Models\AdminThumb;
use App\Models\PluginProductsImages;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index(Request $request)
    {
        $table = $request->get('table');
        $id = $request->get('id');

        $cartella = $request->get('cartella');

        if($cartella === null){
            if($table == "plugins_products_images") {
                $images = PluginProductsImages::where("product_id", $id)
                    ->whereRaw("(cartella = 'uploads' OR cartella IS NULL)")
                    ->orderBy("order", "asc")->get();
            }else{
                $images = \DB::table("$table")
                    ->whereRaw("(cartella = 'uploads' OR cartella IS NULL)")
                    ->where("block_id", $id)->get();
            }
        }else{
            if($table == "plugins_products_images") {
                $images = PluginProductsImages::where("product_id", $id)
                    ->where('cartella', 'LIKE', "%/$cartella")
                    ->orderBy("order", "asc")->get();
            }else{
                $images = \DB::table("$table")
                    ->where('cartella', 'LIKE', "%/$cartella")
                    ->where("block_id", $id)->get();
            }
        }


        return view(backpack_view('dropzone'), compact('table','id', 'images'));
    }

    public function fileStore(Request $request)
    {
        // =========================
        // VALIDAZIONE BASE
        // =========================
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'Nessun file ricevuto'], 400);
        }

        $image = $request->file('file');
        $table = $request->get('table');
        $id    = $request->get('id');

        // =========================
        // CARTELLA (OPZIONALE)
        // =========================
        $cartella = $request->get('cartella'); // null se non esiste

        // path base uploads
        $basePath = public_path('uploads');

        // =========================
        // SE CARTELLA È VALORIZZATA
        // =========================
        if (!empty($cartella)) {

            // sanitizzazione
            $cartella = strtolower(trim($cartella));
            $cartella = preg_replace('/[^a-z0-9\-]/', '-', $cartella);
            $cartella = preg_replace('/-+/', '-', $cartella);
            $cartella = trim($cartella, '-');

            $folderPath   = $basePath . DIRECTORY_SEPARATOR . $cartella;
            $dbFolderPath = "uploads/{$cartella}";

            // crea la cartella se non esiste
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

        } else {
            // =========================
            // NESSUNA CARTELLA
            // =========================
            $folderPath   = $basePath;
            $dbFolderPath = "uploads";
        }

        // =========================
        // GENERAZIONE NOME FILE
        // =========================
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = strtolower($image->getClientOriginalExtension());

        $safeName = strtolower($originalName);
        $safeName = preg_replace('/[^a-z0-9\-]/', '-', $safeName);
        $safeName = preg_replace('/-+/', '-', $safeName);
        $safeName = trim($safeName, '-');

        // contatore numerico a 3 cifre
        $counter = 1;
        do {
            $suffix = str_pad($counter, 3, '0', STR_PAD_LEFT);
            $newImageName = "{$safeName}-{$suffix}.{$ext}";
            $counter++;
        } while (File::exists($folderPath . DIRECTORY_SEPARATOR . $newImageName));

        // =========================
        // SALVATAGGIO FILE
        // =========================
        $image->move($folderPath, $newImageName);

        // =========================
        // PATH FILE PER DB
        // =========================
        $dbFilePath = $dbFolderPath . '/' . $newImageName;

        // =========================
        // SALVATAGGIO DATABASE
        // =========================
        if ($table === 'plugins_products_images') {

            $imageUpload = new PluginProductsImages();
            $imageUpload->product_id = $id;
            $imageUpload->image     = $dbFilePath;
            $imageUpload->cartella  = $dbFolderPath;
            $imageUpload->save();

        } else {

            $last = \DB::table($table)->orderBy('lft', 'desc')->first();
            $lft  = $last ? $last->lft + 1 : 0;

            \DB::table($table)->insert([
                'block_id' => $id,
                'title'    => 'Foto',
                'foto'     => $dbFilePath,
                'cartella' => $dbFolderPath,
                'lft'      => $lft,
            ]);

            $basename = basename($dbFilePath);
            $nameFile = explode(".", $basename);
            $disk = config('backpack.base.root_disk_name');
            $destination_path = "public/thumb/blocks_gallerys";

            // nuovo sistema Thumb 2.0 creato il 25/10/2022 KT
            $adminBlock = AdminBlock::where("name_table", "$table")->first();
            $adminThumb = AdminThumb::where("admin_block_id", $adminBlock->id)->get();

            if(count($adminThumb)){
                foreach ($adminThumb as $thumb){
                    $image  = \Image::make(public_path($dbFilePath))->encode('webp', 90);

                    $width = $thumb->width_max != 0 ? $thumb->width_max : null;
                    $height = $thumb->height_max != 0 ? $thumb->height_max : null;
                    $suffix = $thumb->suffix;

                    $image->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });

                    $filename = "$nameFile[0]-{$suffix}.webp";
                    \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                }
            }

        }

        // =========================
        // RESPONSE
        // =========================
        return response()->json([
            'success' => true,
            'file'    => $dbFilePath,
            'folder'  => $dbFolderPath,
        ]);
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
