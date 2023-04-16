<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
class HomeController extends Controller {
   public function index(){


    $Defaultlanguages=[];

    foreach((new TesseractOCR())->availableLanguages() as $lang) {
        $Defaultlanguages[] = $lang;
    };


       return view('home',compact('Defaultlanguages'));
   }

   public function upload(Request $request){

    $image = $request->file('image');
    $filename= date('YmdHi').$image->getClientOriginalName();
    $image-> move(public_path('images'), $filename);

    $ocr = new TesseractOCR(public_path("images/$filename"));
    $ocr->lang('ara','en');
    $text = $ocr->run();

    return redirect()->back()->with('text',$text);




   }
}

