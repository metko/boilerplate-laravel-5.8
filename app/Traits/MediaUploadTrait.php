<?php
namespace App\Traits;

use App\Media;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

trait MediaUploadTrait
{
    protected $dir_path;
    protected $model_name;
    protected $media;
    protected $model;
    protected $mediaName;
    protected $sizeResize;

    public function __construct()
    {
        $this->dir_path = public_path('/images');
        $this->asset_path = asset('/images');
    }
    public function setup($media, $model, $mediaName, $size)
    {
        $this->media = $media;
        $this->model = $model;
        $this->mediaName = $mediaName;
        $this->sizeResize = $size;
    }

    public function create_model_path_directory()
    {
        $this->model_name = Str::slug(Str::plural(explode('\\', get_class($this->model))[1]));
        $this->dir_path = $this->dir_path.'/'.$this->model_name;
        $this->asset_path = $this->asset_path.'/'.$this->model_name;
        return $this->dir_path;
       
    }

    public function createDirectory($directory)
    {
        if (!is_dir($directory)) {
            return mkdir($directory, 0777, true);
        }
    }

    public function setFileNames($filename, $extension)
    {
        $rdmStr = Str::random(20);;
        $this->filename = Str::snake($filename).'_'.$rdmStr. '.' . $extension;
        $this->filename_resize = Str::snake($filename).'_'.$this->sizeResize.'_' .$rdmStr. '.' . $extension ;
    }

    public function moveMedia($media){
        Image::make($media)
                    ->resize(250, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->save($this->dir_path . '/' . $this->filename_resize);
            $media->move($this->dir_path, $this->filename);
            return $media;
    }

   protected function uploadMedia($media, $model, $mediaName, $size = 300)
   {
         $this->setup($media, $model, $mediaName, $size);

         if( ! $this->createDirectory($this->create_model_path_directory())) {
             // TODO 
             // THE FILE DIRECTORY CANT BE CREATED FOR SOME REASON
             // SEND A MESSAGE TO THE USER
         }

         if (!is_array($this->media)) {
            $this->media = [$this->media];
         }
    
         foreach($this->media as $media)
         {
            $this->setFileNames($mediaName, $media->getClientOriginalExtension());
            $this->moveMedia($media);
         }
        
        
        $this->saveMedia($this->filename, 'original');
        $this->saveMedia($this->filename_resize, $this->sizeResize);

        return Response::json([
            'message' => 'Image saved Successfully'
        ], 400);
   }

   public function saveMedia($media, $size)
   {
    
        if( count($this->model->medias)){
            foreach($this->model->medias as $d){
                $tod = $this->dir_path.'/'.$d->filename;;
                $d->delete();
                if (@getimagesize($tod)) {
                    unlink($tod);
                }
            } 
        }
        $m = new Media(); 
        $m->filename = $media;
        $m->path = $this->asset_path."/".$media;
        $m->size = $size;
        $this->model->medias()->save($m);
   }
}