<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Region;
use App\Http\Requests\RegionRequest;
use App\Http\Requests\RegionUpdateRequest;
use Intervention\Image\Facades\Image;
use File;

class RegionController extends Controller
{

    private $locale;

    public function __construct()
    {
        $this->locale = \App::getLocale();
    }

    public function adminIndex(){

        $regions = Region::orderBy('weight')->get();
        return view('region.draggable_index', compact('regions', $regions));
//        return view('region.admin_index', compact('regions', $regions));
    }

    public function create(){

        return view('region.create');
    }

    public function edit(Region $region){

        return view('region.edit', ['region' => $region]);
    }

    public function update(RegionUpdateRequest $request, Region $region) {
        if($region->user_id == \Auth::User()->id) {
            if(isset($request->image)){
                $file = $request->file('image');
                if(!empty($file)) {
                    //if file is not empty - we should remove old file from disk
                    $this->dropRegionImage($region);

                    $fileName = $this->updatefilename($file);
                    $region->image = $fileName;
                    $this->createRegionImage($file, $fileName, $region->id);
                }
            }

            if(isset($request->published)){
                $region->published = $request->published;
            }
            else {
                $region->published = false;
            }

            $region->title_en = $request->title_en;
            $region->title_uk = $request->title_uk;
            $region->title_ru = $request->title_ru;

            $region->metatitle_en = $request->metatitle_en;
            $region->metatitle_uk = $request->metatitle_uk;
            $region->metatitle_ru = $request->metatitle_ru;

            $region->metakeywords_en = $request->metakeywords_en;
            $region->metakeywords_uk = $request->metakeywords_uk;
            $region->metakeywords_ru = $request->metakeywords_ru;

            $region->metadescription_en = $request->metadescription_en;
            $region->metadescription_uk = $request->metadescription_uk;
            $region->metadescription_ru = $request->metadescription_ru;

            $region->description_en = $request->description_en;
            $region->description_uk = $request->description_uk;
            $region->description_ru = $request->description_ru;

            $region->latitude = $request->latitude;
            $region->longitude = $request->longitude;

            $region->image_title = $request->image_title;
            $region->image_alt = $request->image_alt;

            $region->save();
            $msg = trans('m.success');
        }
        else {
            $msg = trans('m.no_right');
        }

        return redirect()->back()->with('message', $msg);
    }

    public function publish(Region $region){
        if($region->user_id == \Auth::User()->id) {
            $region->published = true;
            $region->save();
            $msg = trans('m.success');
        }
        else {
            $msg = trans('m.no_right');
        }

        return redirect()->back()->with('message', $msg);
    }

    public function unpublish(Region $region){
        if($region->user_id == \Auth::User()->id) {
            $region->published = false;
            $region->save();
            $msg = trans('m.success');
        }
        else {
            $msg = trans('m.no_right');
        }
        return redirect()->back()->with('message', $msg);
    }

    public function delete(Region $region){
        //TODO todo_security check that current user is author of this content DONE  !!! OR had rights to edit it
        if($region->user_id == \Auth::User()->id) {
            $dir = base_path() . "/public/images/regions/$region->id/";
            File::deleteDirectory($dir);
            $region->delete();
            $msg = trans('m.success');
        }
        else {
            $msg = trans('m.no_right');
        }
        return redirect()->back()->with('message', $msg);
    }

    public function store(RegionRequest $request){

        $region = new Region();

        $this->maximizeRegionWeight($region);

        if(isset($request->published)){
            $region->published = $request->published;
        }
        else {
            $region->published = false;
        }

        $region->title_en = $request->title_en;
        $region->title_uk = $request->title_uk;
        $region->title_ru = $request->title_ru;

        $region->metatitle_en = $request->metatitle_en;
        $region->metatitle_uk = $request->metatitle_uk;
        $region->metatitle_ru = $request->metatitle_ru;

        $region->metakeywords_en = $request->metakeywords_en;
        $region->metakeywords_uk = $request->metakeywords_uk;
        $region->metakeywords_ru = $request->metakeywords_ru;

        $region->metadescription_en = $request->metadescription_en;
        $region->metadescription_uk = $request->metadescription_uk;
        $region->metadescription_ru = $request->metadescription_ru;

        $region->description_en = $request->description_en;
        $region->description_uk = $request->description_uk;
        $region->description_ru = $request->description_ru;


        $region->user_id = \Auth::User()->id;
        $region->latitude = $request->latitude;
        $region->longitude = $request->longitude;
        $region->sluggable();
        $region->save(); // have to save it to get Region id for image store folder
//        creating image
        $file = $request->file('image');
        if(!empty($file)) {
            $fileName = $this->updatefilename($file);
            $region->image = $fileName;
            $region->image_title = $request->image_title;
            $region->image_alt = $request->image_alt;
            $this->createRegionImage($file, $fileName, $region->id);
        }

        $region->save();

        $msg = trans('m.success');

        return redirect()->back()->with('message', $msg);

    }

    public function ajax_reorder(Request $request){
        $orderedArray = $this->unserializaOrderString($request->testdata);
        $i = 0;
        foreach($orderedArray as $key=>$parent){
            $i++;
            $region = Region::findOrFail($key);
            $region->weight = $i;
            $region->save();
        }

        $response = array(
            'status' => 'success',
            'msg' => trans('m.saved'),
        );
        return \Response::json($response);
    }

    /**
     * When we create a new menu item - we check weight of all existing menu items
     * and make new one the last one
     * @param $slider
     */
    private function maximizeRegionWeight($region){

        $weight = \DB::table('regions')
            ->select('weight')
            ->orderBy('weight', 'desc')
            ->limit(1)
            ->get();
        if(isset($weight[0])){
            $region->weight = $weight[0]->weight + 1;
        }
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

    private function dropRegionImage($region){
        //delete all files
        $file1 = base_path() . "/public/images/regions/$region->id/$region->image";
        $file2 = base_path() . "/public/images/regions/$region->id/slide_$region->image";
        $file3 = base_path() . "/public/images/regions/$region->id/thumbnail_$region->image";
        File::delete($file1, $file2, $file3);
    }

    /**
     * Creating and croping images
     * @param $file
     * @param $fileName
     * @param $imageId
     */
    protected function createRegionImage($file, $fileName, $regionId){
        //saving original image
        $file->move(
            base_path() . "/public/images/regions/$regionId/", $fileName
        );

        //crop and saving slide size image
        $manipulation = Image::make(base_path() . "/public/images/regions/$regionId/$fileName");
        $manipulation->resize(800, 600);
        $manipulation->save(base_path() . "/public/images/regions/$regionId/slide_$fileName");

        //crop and saving thumbnail size image
        $manipulation = Image::make(base_path() . "/public/images/regions/$regionId/$fileName");
        $manipulation->resize(100, 100);
        $manipulation->save(base_path() . "/public/images/regions/$regionId/thumbnail_$fileName");
    }

    /**
     * Little method to modify image filename
     * @param $file
     * @return string
     */
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
