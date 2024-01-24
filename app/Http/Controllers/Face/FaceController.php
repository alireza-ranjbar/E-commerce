<?php

namespace App\Http\Controllers\Face;

use App\Models\Banner;
use App\Models\Category;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class FaceController extends Controller
{
    public function index(){
        $sliders = Banner::where('type','slider')->where('is_active',1)->orderBy('priority')->get();
        $topBanners = Banner::where('type','index-top')->where('is_active',1)->get();
        $bottomBanners = Banner::where('type','index-bottom')->where('is_active',1)->get();
        $firstThreeparentCategories = Category::where('parent_id',0)->get()->take(3);
        $categories = Category::where('parent_id','!=',0)->get();
        return view('face.index', compact('sliders','topBanners','bottomBanners','firstThreeparentCategories','categories'));
    }

    public function aboutUs(){
        $bottomBanners = Banner::where('type','index-bottom')->where('is_active',1)->get();
        return view('face.about-us',compact('bottomBanners'));
    }

    public function contactUs(){
        return view('face.contact-us');
    }

    public function contactUsForm(Request $request){
        //dd($request->all());

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|max:20',
            'text' => 'required|max:300',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        ContactUs::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'subject' =>  $request->subject,
            'text' =>  $request->text,
        ]);

        alert()->success('پیام شما با موفقیت ثبت شد','با سپاس');
        return redirect()->back();
    }
}
