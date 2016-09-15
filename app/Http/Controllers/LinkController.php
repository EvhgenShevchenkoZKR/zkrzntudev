<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\LinkRequest;
use App\Link;
use Intervention\Image\Facades\Image;
use File;

class LinkController extends Controller
{
  public function create(){
    
    return view('link.create');
  }
  
  public function adminIndex(){

    $links = Link::orderBy('weight')->get();
    return view('link.admin_index', [
      'links' => $links
    ]);
  }
  
  public function ajax_reorder(Request $request){
    $orderedArray = $this->unserializaOrderString($request->testdata);
    $i = 0;
    foreach($orderedArray as $key=>$parent){
      $i++;
      $link = Link::findOrFail($key);
      $link->weight = $i;
      $link->save();
    }
    
    $response = array(
      'status' => 'success',
      'msg' => 'Збережено',
    );
    return \Response::json($response);
  }
  
  public function edit(Link $link){
    
    return view('link.edit', [
      'link' => $link,
    ]);
  }
  
  public function update(Link $link, LinkRequest $request){
    
    if($link->user_id == \Auth::user()->id){
      
      $old_image = $link->image;

      $link->fill($request->all());
      if(isset($request->published)) { $link->published = $request->published; }
      else { $link->published = false; }

      $link->image = $old_image;
      $link->save();
      
      //cover_image
      $file = $request->file('image');
      if(!empty($file)){
        $this->deleteImages($link);
        $this->createImage($file, $file->getClientOriginalName(), $link->id);
        $link->image = $file->getClientOriginalName();
        $link->save();
      }
      
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  public function store(LinkRequest $request){
    
    $link = new Link($request->all());
    $this->maximizeWeight($link);
  
    $link->user_id = \Auth::user()->id;
    $link->save();
    //cover_image
    $file = $request->file('image');
    if($file){
      $this->createImage($file, $file->getClientOriginalName(), $link->id);
      $link->image = $file->getClientOriginalName();
      $link->save();
    }
    
    return redirect()->back()->with('message', 'Успішно');
  }

  public function publish(Link $link){
    if($link->user_id == \Auth::User()->id) {
      $link->published = true;
      $link->save();
      $msg = trans('Успішно');
    }
    else {
      $msg = trans('Недостатньо прав');
    }

    return redirect()->back()->with('message', $msg);
  }

  public function unpublish(Link $link){
    if($link->user_id == \Auth::User()->id) {
      $link->published = false;
      $link->save();
      $msg = trans('Успішно');
    }
    else {
      $msg = trans('Недостатньо прав');
    }

    return redirect()->back()->with('message', $msg);
  }
  
  public function delete(Link $link){
    //TODO todo_security check that current user is author of this content DONE  !!! OR had rights to edit it
    if($link->user_id == \Auth::User()->id) {
      $dir = base_path() . "/public/images/links/$link->id/";
      File::deleteDirectory($dir);
      $link->delete();
      $msg = 'Успішно';
    }
    else {
      $msg = 'Ви не маєте на це права';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  private function deleteImages($link){
    $old_image = $link->image;
    $file1 = base_path() . "/public/images/links/$link->id/$old_image";
    $file2 = base_path() . "/public/images/links/$link->id/small_$old_image";
    $file3 = base_path() . "/public/images/links/$link->id/thumbnail_$old_image";
    File::delete($file1, $file2,$file3);
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
      base_path() . "/public/images/links/$nodeId/", $fileName
    );

    //4 to 3 proportion
    $two_to_one = Image::make(base_path() . "/public/images/links/$nodeId/$fileName");
    $two_to_one->crop($width, $thirdFourHeight);
    $four_to_three_180x135 = $two_to_one;
    $four_to_three_180x135->resize(180, 135);
    $four_to_three_180x135->save(base_path() . "/public/images/links/$nodeId/small_$fileName");


    //1 to 1 proportion
    $one_to_one = Image::make(base_path() . "/public/images/links/$nodeId/$fileName");
    $one_to_one->crop($equalWidth, $equalHeight);
    $one_to_one_100x100 = $one_to_one;
    $one_to_one_100x100->resize(100, 100);
    $one_to_one_100x100->save(base_path() . "/public/images/links/$nodeId/thumbnail_$fileName");
  }
  
  /**
   * nestedSortable serialize info about reordering in a little strange way
   * so i have to deserilize it by myself
   * @param $string
   * @return array
   */
  private function unserializaOrderString($string){
    $pieces = explode("&", $string);
    $result = array();
    foreach ($pieces as $peace){
      $pic = explode('=',$peace);
      $pic[0] = str_replace('list[', '', $pic[0]);
      $pic[0] = str_replace(']', '', $pic[0]);
      if(is_numeric($pic[0])){
        $result[$pic[0]] = $pic[1];
      }
    }
    return $result;
  }
  
  /**
   * When we create a new menu item - we check weight of all existing menu items
   * and make new one the last one
   * @param $slider
   */
  private function maximizeWeight($link){
    
    $weight = \DB::table('links')
      ->select('weight')
      ->orderBy('weight', 'desc')
      ->limit(1)
      ->get();
    if(isset($weight[0])){
      $link->weight = $weight[0]->weight + 1;
    }
  }
}
