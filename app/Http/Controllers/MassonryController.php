<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MassonryRequest;
use App\Massonry;
use Intervention\Image\Facades\Image;
use File;

class MassonryController extends Controller
{
  public function create(){
    
    return view('massonry.create');
  }
  
  public function adminIndex(){
  
    $massonrys = Massonry::orderBy('weight')->get();
    return view('massonry.admin_index', [
      'massonrys' => $massonrys
    ]);
  }
  
  public function ajax_reorder(Request $request){
    $orderedArray = $this->unserializaOrderString($request->testdata);
    $i = 0;
    foreach($orderedArray as $key=>$parent){
      $i++;
      $massonry = Massonry::findOrFail($key);
      $massonry->weight = $i;
      $massonry->save();
    }
    
    $response = array(
      'status' => 'success',
      'msg' => 'Збережено',
    );
    return \Response::json($response);
  }
  
  public function edit(Massonry $massonry){
    
    return view('massonry.edit', [
      'massonry' => $massonry,
    ]);
  }
  
  public function update(Massonry $massonry, MassonryRequest $request){
    
    if($massonry->user_id == \Auth::user()->id){
      
      $old_image = $massonry->image;
  
      $massonry->fill($request->all());
      if(isset($request->published)) { $massonry->published = $request->published; }
      else { $massonry->published = false; }
  
      $massonry->image = $old_image;
      $massonry->save();
      
      //cover_image
      $file = $request->file('image');
      if(!empty($file)){
        $this->deleteImages($massonry);
        $this->createImage($file, $file->getClientOriginalName(), $massonry->id);
        $massonry->image = $file->getClientOriginalName();
        $massonry->save();
      }
      
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  public function store(MassonryRequest $request){
    
    $massonry = new Massonry($request->all());
    $this->maximizeWeight($massonry);
  
    $massonry->user_id = \Auth::user()->id;
    $massonry->save();
    //cover_image
    $file = $request->file('image');
    if($file){
      $this->createImage($file, $file->getClientOriginalName(), $massonry->id);
      $massonry->image = $file->getClientOriginalName();
      $massonry->save();
    }
    
    return redirect()->back()->with('message', 'Успішно');
  }
  
  public function publish(Massonry $massonry){
    if($massonry->user_id == \Auth::User()->id) {
      $massonry->published = true;
      $massonry->save();
      $msg = trans('Успішно');
    }
    else {
      $msg = trans('Недостатньо прав');
    }
    
    return redirect()->back()->with('message', $msg);
  }
  
  public function unpublish(Massonry $massonry){
    if($massonry->user_id == \Auth::User()->id) {
      $massonry->published = false;
      $massonry->save();
      $msg = trans('Успішно');
    }
    else {
      $msg = trans('Недостатньо прав');
    }
    
    return redirect()->back()->with('message', $msg);
  }
  
  public function delete(Massonry $massonry){
    //TODO todo_security check that current user is author of this content DONE  !!! OR had rights to edit it
    if($massonry->user_id == \Auth::User()->id) {
      $dir = base_path() . "/public/images/massonry/$massonry->id/";
      File::deleteDirectory($dir);
      $massonry->delete();
      $msg = 'Успішно';
    }
    else {
      $msg = 'Ви не маєте на це права';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  private function deleteImages($massonry){
    $old_image = $massonry->image;
    $file1 = base_path() . "/public/images/massonry/$massonry->id/$old_image";
    $file2 = base_path() . "/public/images/massonry/$massonry->id/small_$old_image";
    $file3 = base_path() . "/public/images/massonry/$massonry->id/thumbnail_$old_image";
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
      base_path() . "/public/images/massonry/$nodeId/", $fileName
    );
    
    //4 to 3 proportion
    $two_to_one = Image::make(base_path() . "/public/images/massonry/$nodeId/$fileName");
    $two_to_one->crop($width, $thirdFourHeight);
    $four_to_three_180x135 = $two_to_one;
    $four_to_three_180x135->resize(180, 135);
    $four_to_three_180x135->save(base_path() . "/public/images/massonry/$nodeId/small_$fileName");
    
    
    //1 to 1 proportion
    $one_to_one = Image::make(base_path() . "/public/images/massonry/$nodeId/$fileName");
    $one_to_one->crop($equalWidth, $equalHeight);
    $one_to_one_100x100 = $one_to_one;
    $one_to_one_100x100->resize(100, 100);
    $one_to_one_100x100->save(base_path() . "/public/images/massonry/$nodeId/thumbnail_$fileName");
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
    
    $weight = \DB::table('massonries')
      ->select('weight')
      ->orderBy('weight', 'desc')
      ->limit(1)
      ->get();
    if(isset($weight[0])){
      $link->weight = $weight[0]->weight + 1;
    }
  }
}
