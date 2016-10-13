<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AdvertRequest;
use App\Http\Requests\AdvertRequestUpdate;
use App\Advert;
use Intervention\Image\Facades\Image;
use File;


class AdvertController extends Controller
{
  public function create(){ 
    return view('advert.create');
  }
  
  public function store(AdvertRequest $request){ 
    
    $advert = new Advert($request->all());
    $advert->user_id = \Auth::user()->id;
    $advert->sluggable();
    $advert->save();
    //cover_image
    $file = $request->file('cover_image');
    if($file){
      $this->createImage($file, $file->getClientOriginalName(), $advert->id);
      $advert->cover_image = $file->getClientOriginalName();
      $advert->save();
    }
    
    return redirect()->back()->with('message', 'Об’яву збережено');
  }
  
  public function edit(Advert $advert){ 
    
    return view('advert.edit', [
      'advert' => $advert,
    ]);
  }
  
  public function update(Advert $advert, AdvertRequestUpdate $request) {
    
    if($advert->user_id == \Auth::user()->id){

      $old_image = $advert->cover_image;

      $advert->fill($request->all());
      if(isset($request->published)) { $advert->published = $request->published; }
      else { $advert->published = false; }

      $advert->cover_image = $old_image;
      $advert->save();
  
      //cover_image
      $file = $request->file('cover_image');
      if(!empty($file)){
        $this->deleteImages($advert);
        $this->createImage($file, $file->getClientOriginalName(), $advert->id);
        $advert->cover_image = $file->getClientOriginalName();
        $advert->save();
      }
      
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    
    return redirect()->back()->with('message', $msg);
  }

  public function search(Request $request){
    if(!empty($request->search)){
      return $this->adminIndex($request->search);
    }
    else {
      return redirect('adm/objavas')->with('message', 'Введiть щось');
    }
  }
  
  public function adminIndex($search = null) {

    if(!empty($search) ) {
      $adverts = Advert::select('*')
          ->orderBy('created_at', 'desc')
          ->Where('title', 'like', '%' . $search . '%')
          ->get();
    }
    else {
      $adverts = Advert::select('*')
          ->orderBy('created_at', 'desc')
          ->paginate(25);
    }
    
    return view('advert.admin_index', [
        'adverts' => $adverts,
        'search' => $search
    ]);
  }

  public function delete(Advert $advert) {
    if($advert->user_id == \Auth::user()->id){
      $this->deleteDirectory($advert);
      $advert->delete();
      $msg = 'Новину видалено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }

  public function publish (Advert $advert) {
    if($advert->user_id == \Auth::user()->id){
      $advert->published = true;
      $advert->save();
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }

  public function unpublish (Advert $advert) {
    if($advert->user_id == \Auth::user()->id){
      $advert->published = false;
      $advert->save();
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }

  /**
   * Deleting whole news images folder by id with all images in it
   */
  private function deleteDirectory($advert){
    $dir = base_path() . "/public/images/objavas/$advert->id/";
    File::deleteDirectory($dir);
  }
  
  private function deleteImages($advert){ 
    $old_image = $advert->cover_image;
    $file1 = base_path() . "/public/images/objavas/$advert->id/$old_image";
    $file2 = base_path() . "/public/images/objavas/$advert->id/big_$old_image";
    $file3 = base_path() . "/public/images/objavas/$advert->id/small_$old_image";
    $file4 = base_path() . "/public/images/objavas/$advert->id/thumbnail_$old_image";
    File::delete($file1, $file2, $file3, $file4);
    
  }

  protected function createImage($file, $fileName, $nodeId){ 
    $image = getimagesize($file);
    $baseWidth = $image[0];
    $baseHeight = $image[1];
    if($baseWidth >= $baseHeight) {
    //classic crop
      $width = $baseWidth;
      $thirdFourHeight = round($baseHeight * 0.75);
      $equalWidth = $baseHeight;
      $equalHeight = $baseHeight;
    }
    else {
      //vertical crop
      $width = $baseWidth;
      $thirdFourHeight = round($baseWidth * 0.75);
      $equalWidth = $baseWidth;
      $equalHeight = $baseWidth;
    }
    //saving original image
    $file->move(
      base_path() . "/public/images/objavas/$nodeId/", $fileName
    );

    //4 to 3 proportion
    $two_to_one = Image::make(base_path() . "/public/images/objavas/$nodeId/$fileName");
    $two_to_one->crop($width, $thirdFourHeight);

    $four_to_three_1200x900 = $two_to_one;
    $four_to_three_1200x900->resize(1200, 900);
    $four_to_three_1200x900->save(base_path() . "/public/images/objavas/$nodeId/big_$fileName");

    $four_to_three_180x135 = $two_to_one;
    $four_to_three_180x135->resize(180, 135);
    $four_to_three_180x135->save(base_path() . "/public/images/objavas/$nodeId/small_$fileName");


    //1 to 1 proportion
    $one_to_one = Image::make(base_path() . "/public/images/objavas/$nodeId/$fileName");
    $one_to_one->crop($equalWidth, $equalHeight);
    $one_to_one_100x100 = $one_to_one;
    $one_to_one_100x100->resize(100, 100);
    $one_to_one_100x100->save(base_path() . "/public/images/objavas/$nodeId/thumbnail_$fileName");
  }
}
