<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ParentPage;
use App\ChildPage;
use App\Http\Requests\ChildPageRequest;
use Intervention\Image\Facades\Image;
use File;

class ChildPageController extends Controller
{
  public function adminIndex(){
    
    $childs = ChildPage::all();

    return view('child.admin_index', [
      'childs' => $childs
    ]);
  }
  
  public function create(){
    $parents = ParentPage::pluck('title', 'id');
    return view('child.create',[
      'parents' => $parents,
    ]);
  }
  
  public function store(ChildPageRequest $request) {
  
    $child = new ChildPage($request->all());
    $child->sluggable();

    if(isset($request->published)) { $child->published = $request->published; }
    else { $child->published = false; }
    $user = \Auth::user();
    $child->user_id = $user->id;
    $child->save();

    $file = $request->file('cover_image');
    if($file){
      $this->createImage($file, $file->getClientOriginalName(), $child->id);
      $child->cover_image = $file->getClientOriginalName();
      $child->save();
    }
  
    $child->save();
  
    return redirect()->back()->with('message', 'Матеріал збережено');
  }
  
  public function edit(ChildPage $child){
  
    $parents = ParentPage::pluck('title', 'id');
    
    return view('child.edit',[
      'child' => $child,
      'parents' => $parents,
    ]);
  }
  
  public function update(ChildPage $child, ChildPageRequest $request) {
    
    if($child->user_id == \Auth::user()->id){

      $old_image = $child->cover_image;

      $child->fill($request->all());
      if(isset($request->published)) { $child->published = $request->published; }
      else { $child->published = false; }
      if(isset($request->cover_show)) { $child->cover_show = $request->cover_show; }
      else { $child->cover_show = false; }

      $child->cover_image = $old_image;
      $child->save();

      //cover_image
      $file = $request->file('cover_image');
      if(!empty($file)){
        $this->deleteImages($child);
        $this->createImage($file, $file->getClientOriginalName(), $child->id);
        $child->cover_image = $file->getClientOriginalName();
        $child->save();
      }
      
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    
    return redirect()->back()->with('message', $msg);
  }

  public function publish(ChildPage $child){
    if($child->user_id == \Auth::User()->id) {
      $child->published = true;
      $child->save();
      $msg = trans('Успішно');
    }
    else {
      $msg = trans('Недостатньо прав');
    }

    return redirect()->back()->with('message', $msg);
  }

  public function unpublish(ChildPage $child){
    if($child->user_id == \Auth::User()->id) {
      $child->published = false;
      $child->save();
      $msg = trans('Успішно');
    }
    else {
      $msg = trans('Недостатньо прав');
    }

    return redirect()->back()->with('message', $msg);
  }

  public function delete(ChildPage $child){
    //TODO todo_security check that current user is author of this content DONE  !!! OR had rights to edit it
    if($child->user_id == \Auth::User()->id) {
      $dir = base_path() . "/public/images/child/$child->id/";
      File::deleteDirectory($dir);
      $child->delete();
      $msg = 'Успішно';
    }
    else {
      $msg = 'Ви не маєте на це права';
    }
    return redirect()->back()->with('message', $msg);
  }

  private function deleteImages($child){
    $old_image = $child->cover_image;
    $file1 = base_path() . "/public/images/child/$child->id/$old_image";
    $file2 = base_path() . "/public/images/child/$child->id/small_$old_image";
    $file3 = base_path() . "/public/images/child/$child->id/thumbnail_$old_image";
    File::delete($file1, $file2,$file3);
  }

//  todo create update etc

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
      base_path() . "/public/images/child/$nodeId/", $fileName
    );

    //4 to 3 proportion
    $two_to_one = Image::make(base_path() . "/public/images/child/$nodeId/$fileName");
    $two_to_one->crop($width, $thirdFourHeight);
    $four_to_three_800x600 = $two_to_one;
    $four_to_three_800x600->resize(800, 600);
    $four_to_three_800x600->save(base_path() . "/public/images/child/$nodeId/small_$fileName");


    //1 to 1 proportion
    $one_to_one = Image::make(base_path() . "/public/images/child/$nodeId/$fileName");
    $one_to_one->crop($equalWidth, $equalHeight);
    $one_to_one_100x100 = $one_to_one;
    $one_to_one_100x100->resize(100, 100);
    $one_to_one_100x100->save(base_path() . "/public/images/child/$nodeId/thumbnail_$fileName");
  }
}
