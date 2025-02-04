<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
   public function upload(Request $request):string {
    $pictures = $request->file('pictures');
    $pictures->storePubliclyAs("pictures", $pictures->getClientOriginalName(), "public");

    return "OK : " . $pictures->getClientOriginalName();
   }
}