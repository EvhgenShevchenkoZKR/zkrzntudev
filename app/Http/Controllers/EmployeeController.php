<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EmployeeRequest;
use App\Employee;
use Intervention\Image\Facades\Image;
use File;


class EmployeeController extends Controller
{
  public function create(){

    return view('employee.create');
  }
  
  public function adminIndex(){
    
    $employees = Employee::orderBy('weight')->get();
    return view('employee.admin_index', ['employees' => $employees]);
  }

  public function ajax_reorder(Request $request){
    $orderedArray = $this->unserializaOrderString($request->testdata);
    $i = 0;
    foreach($orderedArray as $key=>$parent){
      $i++;
      $employee = Employee::findOrFail($key);
      $employee->weight = $i;
      $employee->save();
    }

    $response = array(
      'status' => 'success',
      'msg' => 'Збережено',
    );
    return \Response::json($response);
  }
  
  public function edit(Employee $employee){

    return view('employee.edit', [
      'employee' => $employee,
    ]);
  }

  public function update(Employee $employee, EmployeeRequest $request){

    if($employee->user_id == \Auth::user()->id){

      $old_image = $employee->photo;

      $employee->fill($request->all());
      if(isset($request->administration)) { $employee->administration = $request->administration; }
      else { $employee->administration = false; }

      $employee->photo = $old_image;
      $employee->save();

      //cover_image
      $file = $request->file('photo');
      if(!empty($file)){
        $this->deleteImages($employee);
        $this->createImage($file, $file->getClientOriginalName(), $employee->id);
        $employee->photo = $file->getClientOriginalName();
        $employee->save();
      }

      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }

  public function store(EmployeeRequest $request){

    $employee = new Employee($request->all());
    $this->maximizeWeight($employee);

    $employee->user_id = \Auth::user()->id;
    $employee->save();
    //cover_image
    $file = $request->file('photo');
    if($file){
      $this->createImage($file, $file->getClientOriginalName(), $employee->id);
      $employee->photo = $file->getClientOriginalName();
      $employee->save();
    }

    return redirect()->back()->with('message', 'Успішно');
  }

  public function delete(Employee $employee){
    //TODO todo_security check that current user is author of this content DONE  !!! OR had rights to edit it
    if($employee->user_id == \Auth::User()->id) {
      $dir = base_path() . "/public/images/employees/$employee->id/";
      File::deleteDirectory($dir);
      $employee->delete();
      $msg = 'Успішно';
    }
    else {
      $msg = 'Ви не маєте на це права';
    }
    return redirect()->back()->with('message', $msg);
  }

  private function deleteImages($employee){
    $old_image = $employee->photo;
    $file1 = base_path() . "/public/images/employees/$employee->id/$old_image";
    $file2 = base_path() . "/public/images/employees/$employee->id/photo_$old_image";
    File::delete($file1, $file2);
  }

  protected function createImage($file, $fileName, $nodeId){
    $image = getimagesize($file);
    $baseWidth = $image[0];
    $baseHeight = $image[1];
    if($baseWidth >= $baseHeight) {
      //classic crop
      $height = $baseHeight;
      $width = round($baseHeight * 0.75);
    }
    else {
      //vertical crop
      $thirdFourWidth = round($baseHeight * 0.75);
      if($thirdFourWidth > $baseWidth) {
        $width = $baseWidth;
        $height = round(($baseWidth * 4) / 3);
      }
      else {
        $width = $thirdFourWidth;
        $height = $baseHeight;
      }
    }
    //saving original image
    $file->move(
      base_path() . "/public/images/employees/$nodeId/", $fileName
    );

    //3 to 4 proportion
    $three_to_four = Image::make(base_path() . "/public/images/employees/$nodeId/$fileName");
    $three_to_four->crop($width, $height);
    $three_to_four->resize(600, 800);
    $three_to_four->save(base_path() . "/public/images/employees/$nodeId/photo_$fileName");
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
  private function maximizeWeight($employee){

    $weight = \DB::table('employees')
      ->select('weight')
      ->orderBy('weight', 'desc')
      ->limit(1)
      ->get();
    if(isset($weight[0])){
      $employee->weight = $weight[0]->weight + 1;
    }
  }

}
