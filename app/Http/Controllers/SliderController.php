<?php

namespace App\Http\Controllers;

use DB;
use File;
use Storage; //SHEVA comment for you - File works as Storage, even better because it can delete dir`s
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Slider;
use Intervention\Image\Facades\Image;
use App\Slide;
use App\Http\Requests\SliderSaveRequest;
use App\Http\Requests\StoreUpdatedSliderRequest;

class SliderController extends Controller
{
  public function __construct() {
    //TODO provide isAdmin middleware check here
  }

  //todo make slides deleting with files removing DONE

  //todo make page to reorder sliders DONE

  //TODO show some image at sliders page DONE

  //TODO make delete link at sliders page also delete all records and files of slides (just record and folder) DONE
  
  //todo make some pages to create sliders - at first place DONE

  //todo make last slider with bigger weight DONE

  //todo add edit link`s to sliders page DONE

  //todo make sliders page look pretty

  //todo fix bug when there is slider without slides
  
  /**
   * This is dummy function to watch how is slider working
   */
  public function show(){

    $serializedDummy = 'list[1]=null&list[7]=1&list[10]=1&list[9]=null&list[8]=9&list[2]=null';

    $pieces = explode("&", $serializedDummy);
    $result = array();
    foreach ($pieces as $peace){
      $pic = explode('=',$peace);
      $pic[0] = str_replace('list[', '', $pic[0]);
      $pic[0] = str_replace(']', '', $pic[0]);
      if(is_numeric($pic[0])){
        $result[$pic[0]] = $pic[1];
      }
    }
    foreach($result as $key=>$parent){
      
    }
//    $serializedDummy = json_decode($serializedDummy, true);

    $sliders = Slider::orderBy('weight')->get();

    
    return view('slider.owl', compact('sliders', $sliders));
  }

  public function index(){

    $sliders = Slider::orderBy('weight')->get();
    
    return view('slider.sliders', compact('sliders', $sliders));
  }
  
  public function reindex(Request $request){
    if($request->get('delete_slider')){
      $slider = Slider::findOrFail($request->get('delete_slider'));
      $this->removeSlider($slider);
      return redirect('sliders')->with('message', 'Слайдер видалено');
    }
    else {
      $r = $request->all();
      $array = [];
      foreach($r as $key=>$req){
        if (strpos($key, 'weight') !== false) {
          $array[$key] = $req;
        }
      }
      $total = count($array);

      $array = array_values($array);

      for($i=0;$i<$total;$i++){

        $slider = Slider::findOrFail($array[$i]);
        $slider->weight = $i;
        $slider->save();
      }
    }

    return redirect('sliders')->with('message', 'Хай славиться новий порядок');
  }

  public function createSlider(){
    
    return view('slider.create');
  }
  
  /**
   * here we removing sliders entity with whole folder
   * @param Slider $slider
   * @throws \Exception
   */
  private function removeSlider(Slider $slider){

    //delete folder with all files
    $directory = base_path() . "/public/images/slider/$slider->id";
    File::deleteDirectory($directory);
    // and slide itself
    $slider->delete();
  }

  private function removeSlide(Slide $slide){

    //delete all files
    $file1 = base_path() . "/public/images/slider/$slide->slider_id/$slide->image";
    $file2 = base_path() . "/public/images/slider/$slide->slider_id/slide_$slide->image";
    $file3 = base_path() . "/public/images/slider/$slide->slider_id/thumbnail_$slide->image";
    File::delete($file1, $file2, $file3);
    // and slide itself
    $slide->delete();
  }
  
  public function storeSlider(SliderSaveRequest $request) {

    $slider = new Slider();

    $this->maximizeSliderWeight($slider);

    //fill in slider object with values ad save it
    $this->fillSliderValues($slider, $request);

    //creating new slides object and making thumbnail images
    $this->createNewSlides($slider, $request);

    //or
//    session()->flash('message', 'Slide saved!');
    return redirect("edit-slider/$slider->id")->with('message', 'Слайдер створено');
  }

  public function editSlider(Slider $slider){
    
    return view('slider.edit', compact('slider', $slider));
  }

  public function storeUpdatedSlider(Slider $slider, StoreUpdatedSliderRequest $request){

//  if we press delete slide - then we go here
    if($request->get('delete_slide')){
      $slide = Slide::findOrFail($request->get('delete_slide'));
      $this->removeSlide($slide);
      return redirect("edit-slider/$slider->id")->with('message', 'Slide deleted!');
    }

    $slider = Slider::find($slider->id);

    $this->fillSliderValues($slider, $request);

    $this->createNewSlides($slider, $request);

    $this->updateSlides($request);

    return view('slider.edit', compact('slider', $slider));
  }

  /**
   * When we create a new slide - we check weight of all existing sliders
   * and make new one the last one
   * @param $slider
   */
  private function maximizeSliderWeight($slider){

    $weight = \DB::table('sliders')
      ->select('weight')
      ->orderBy('weight', 'desc')
      ->limit(1)
      ->get();
    if(isset($weight[0])){
      $slider->weight = $weight[0]->weight + 1;
    }
  }

  private function updateSlides(StoreUpdatedSliderRequest $request){

    for($i = 1; $i <= $request->slides_count; $i++){
      $alt_label = 'alt_' . $i;
      $title_label = 'slide_title_' . $i;
      $slide_id_label = 'slide_id_' . $i;
      $slide = Slide::findOrFail($request->$slide_id_label);
      $slide->alt = $request->$alt_label;
      $slide->title = $request->$title_label;
      $slide->save();
    }
  }

  private function fillSliderValues($slider, $request){

    if($request->get('published') !== NULL){
      $pub = 1;
    }
    else {
      $pub = 0;
    }

    $slider->title = $request->get('title');
    $slider->url  = $request->get('url');
    $slider->published  = $pub;
    $slider->save();
  }

  /**
   * Creates new slides binded to slider entity
   * also creates image files with different size
   *
   * @param $slider
   * @param $request
   */
  private function createNewSlides($slider, $request) {
    //getting all files
    $files = $request->file('image');

    if(isset($files[0])){
      foreach ($files as $file){
        $fileName = $this->updatefilename($file);

        $slide = new Slide(array(
          'title' =>  $request->get('slide_title'),
          'alt' => $request->get('alt'),
          'image' => $fileName,
          'slider_id' => $slider->id,
        ));

        $slide->save();
        $this->createSlideImage($file, $fileName, $slider->id);
      }
    }
  }
  
  protected function createSlideImage($file, $fileName, $sliderId){
    //saving original image
    $file->move(
      base_path() . "/public/images/slider/$sliderId/", $fileName
    );
  
    //crop and saving slide size image
    $manipulation = Image::make(base_path() . "/public/images/slider/$sliderId/$fileName");
    $manipulation->resize(800, 600);
    $manipulation->save(base_path() . "/public/images/slider/$sliderId/slide_$fileName");
  
    //crop and saving thumbnail size image
    $manipulation = Image::make(base_path() . "/public/images/slider/$sliderId/$fileName");
    $manipulation->resize(100, 100);
    $manipulation->save(base_path() . "/public/images/slider/$sliderId/thumbnail_$fileName");
  }

  protected function updatefilename($file) {
    $fileName = $file->getClientOriginalName();
    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);//cutting of file extension

    $fileName =
      $withoutExt .
      '_'.rand(111,999).'.' .
      $file->getClientOriginalExtension(); // renaming image

    return $fileName;
  }
  
}
