<?php


namespace App\Http\Controllers;


use App\Http\Requests\PluginProductsRequest;
use App\Models\AdminBlock;
use App\Models\AdminLanguage;
use App\Models\BlockContact;
use App\Models\BlockNews;
use App\Models\Page;
use App\Models\PageBlock;
use App\Models\PluginForms;
use App\Models\PluginFormsRequests;
use App\Models\PluginProducts;
use App\Models\PluginProductsAttachments;
use App\Models\PluginProductsCategories;
use App\Models\PluginProductsContacts;
use App\Models\PluginProductsImages;
use App\Models\PluginProductsLabels;
use App\Models\PluginProductsOptions;
use App\Models\PluginProductsRelated;
use App\Models\PluginProductsRequests;
use App\Models\PluginProductsSettings;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PluginFormsController extends Controller
{
    public function contact_form_send(Request $request){
        if(env('LOCAL') != 1){
           /* $this->validate($request, [
                'g-recaptcha-response' => 'required|captcha',
            ]);*/
        }

        $form_id = $request->get('form_id');
        $item = PluginForms::find($form_id);

        if(!$item){
            return redirect()->back();
        }

        $data = $request->except(['_token', 'form_id']);

        if($request->has('file')){
            $extension = ["image/jpeg", "image/png", "application/pdf"];

            $file = $request->file('file');

            //Display File Name
            /*echo 'File Name: '.$file->getClientOriginalName();
            echo '<br>';

            //Display File Extension
            echo 'File Extension: '.$file->getClientOriginalExtension();
            echo '<br>';

            //Display File Real Path
            echo 'File Real Path: '.$file->getRealPath();
            echo '<br>';

            //Display File Size
            echo 'File Size: '.$file->getSize();
            echo '<br>';

            //Display File Mime Type
            echo 'File Mime Type: '.$file->getMimeType();*/

            if(!in_array($file->getMimeType(), $extension)){
                return redirect()->back()->withErrors(['Tipo file non accettato']);;
            }

            if($file->getSize() > 4000000){ //4 MB
                return redirect()->back()->withErrors(['Dimensione file non accettata.']);;
            }

            //Move Uploaded File
            $destinationPath = 'uploads/plugins_forms';

            $now = Carbon::now()->toDateTimeString();
            $now = str_replace(" ", "-", $now);
            $now = str_replace(":", "-", $now);
            $file->move($destinationPath,"$now-".$file->getClientOriginalName());

            $domain = env('APP_URL');
            $data['file'] = "$domain/uploads/plugins_forms/"."$now-".$file->getClientOriginalName();
        }

        $vet_email = ["request" => $data];
        $dst_email = $item->email;

        try{
            \Mail::send("common.emails.contact_plugin_form", ['data' => $vet_email], function ($m) use ($dst_email, $item, $data) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $m->replyTo($data['email']);
                $m->to($dst_email);
                if($item->cc){
                    $cc_email = explode(",", $item->cc);
                    if(count($cc_email)){
                        foreach ($cc_email as $k=>$c_email){
                            $cc_email[$k] = trim($c_email);
                        }
                    }

                    $m->cc($cc_email);
                }

                if($item->ccn){
                    $ccn_email = explode(",", $item->ccn);
                    if(count($ccn_email)){
                        foreach ($ccn_email as $k=>$c_email){
                            $ccn_email[$k] = trim($c_email);
                        }
                    }
                    $m->bcc($ccn_email);
                }

                if($item->object_form){
                    $m->subject($item->object_form);
                }else{
                    $m->subject("Richiesta informazioni");
                }
            });

            PluginFormsRequests::create([
                "email" => $data['email'],
                "form_id" => $item->id,
                "object" => $item->object_form,
                "content" => json_encode($data)
            ]);
        }catch (\Throwable $e) {
            //dd($e->getMessage());
            return redirect()->back()->withErrors(['Messaggio non inviato']);
        }

        return redirect()->back()->with('message', $item->message_ringraziamento);
    }

}
