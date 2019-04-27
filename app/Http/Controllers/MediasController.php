<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediasController extends Controller
{
    use MediaUpload;
    private $medias_path;
 
    public function __construct()
    {
        $this->medias_path = public_path('/images');
        
    }

    public function store(Request $request){
        $media = $request->file('file');
        $this->prepare('avatar' ,$media);     
    }
}
