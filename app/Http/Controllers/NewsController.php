<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NewsRequest;
use App\News;
use App\Menu;
use App\Quote;
use App\Tag;
use Intervention\Image\Facades\Image;
use File;

class NewsController extends Controller
{


  public function __construct() {
  }

  public function create(){ 
    $tags = Tag::pluck('title', 'id');
    return view('news.create', compact('tags', $tags));
  }
  

  public function show($slug) {
    
    $news = News::where('slug', $slug)->first();
    
    return view('news.show', [
      'news' => $news,
      'menus' => $this->menu,
    ]);
  }
  
  public function store(NewsRequest $request){ 

    $news = new News();

    $news->title = $request->title;
    $news->body = $request->body;
    $news->sluggable();
    
    $news->author_name = $request->author_name;
    $news->cover_alt = $request->cover_alt;
    $news->cover_title = $request->cover_title;
    $news->meta_title = $request->meta_title;
    $news->meta_keywords = $request->meta_keywords;
    $news->meta_description = $request->meta_description;

    if(isset($request->published)) { $news->published = $request->published; }
    else { $news->published = false; }

    if(isset($request->important)) { $news->important = $request->important; }
    else { $news->important = false; }

    if(isset($request->cover_show)) { $news->cover_show = $request->cover_show; }
    else { $news->cover_show = false; }
    
    $user = \Auth::user();
    $news->author_id = $user->id;
    $news->save();
    if(isset($request->tags)){
      foreach($request->tags as $tag){
        $news->tag()->attach($tag);
      }
    }
    //cover_image
    $file = $request->file('cover_image');
    $fileName = $this->updatefilename($file);
    $this->createImage($file, $fileName, $news->id);
    $news->cover_image = $fileName;
    $news->save();

    return redirect()->back()->with('message', 'Новину збережено');
  }
  
  public function edit(News $news){

    //all tags
    $tags = Tag::pluck('title', 'id');

    //getting selected tags
    $newsTags = $news->tag;
    $selected_tags = [];
    foreach ($newsTags as $newsTag) {
      $selected_tags[] = $newsTag->id;
    }


    return view('news.edit', [
      'news' => $news,
      'tags' => $tags,
      'selected_tags' => $selected_tags
    ]);
  }

  public function update(News $news, NewsRequest $request) { 

    if($news->author_id == \Auth::user()->id){
      $news->title = $request->title;
      $news->body = $request->body;
      $news->author_name = $request->author_name;

      if(isset($request->published)) { $news->published = $request->published; }
      else { $news->published = false; }

      if(isset($request->important)) { $news->important = $request->important; }
      else { $news->important = false; }

      if(isset($request->cover_show)) { $news->cover_show = $request->cover_show; }
      else { $news->cover_show = false; }

      $news->cover_alt = $request->cover_alt;
      $news->cover_title = $request->cover_title;
      $news->meta_title = $request->meta_title;
      $news->meta_keywords = $request->meta_keywords;
      $news->meta_description = $request->meta_description;
      
      $news->save();
      
//     THIS is why i love laravel - we just update tags with this
      if($request->tags){
        $news->tag()->sync($request->tags);
      }
      else {
        $news->tag()->sync([]);
      }
      

      //cover_image
      $file = $request->file('cover_image');
      if(!empty($file)){
        $this->deleteNewsImages($news);

        $fileName = $this->updatefilename($file);
        $this->createImage($file, $fileName, $news->id);
        $news->cover_image = $fileName;
        $news->save();
      }
      
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }

    return redirect()->back()->with('message', $msg);
  }
  
  public function adminIndex() {
    
    $news = News::select('*')
    ->orderBy('created_at', 'desc')
    ->paginate(25);
    
    return view('news.admin_index', ['news' => $news]);
  }
  
  public function delete(News $news) {
    if($news->author_id == \Auth::user()->id){
      $this->deleteNewsDirectory($news);
      $news->delete();
      $msg = 'Новину видалено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  public function publish (News $news) {
    if($news->author_id == \Auth::user()->id){
      $news->published = true;
      $news->save();
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  public function unpublish (News $news) {
    if($news->author_id == \Auth::user()->id){
      $news->published = false;
      $news->save();
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
  private function deleteNewsDirectory($news){
    $dir = base_path() . "/public/images/news/$news->id/";
    File::deleteDirectory($dir);
  }
  
  private function deleteNewsImages($news){ 
    $old_image = $news->cover_image;
    $file1 = base_path() . "/public/images/news/$news->id/$old_image";
    $file2 = base_path() . "/public/images/news/$news->id/news_$old_image";
    $file3 = base_path() . "/public/images/news/$news->id/thumbnail_$old_image";
    File::delete($file1, $file2, $file3);
  }

  protected function updatefilename($file) {
    $fileName = $file->getClientOriginalName();
    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);//cutting of file extension

    // renaming image
    $fileName = $withoutExt . '_' .rand(111,999).'.' . $file->getClientOriginalExtension();

    return $fileName;
  }

  protected function createImage($file, $fileName, $nodeId){
    $image = getimagesize($file);
    $baseWidth = $image[0];
    $baseHeight = $image[1];
    if($baseWidth >= $baseHeight){
      $equalWidth = $baseHeight;
      $equalHeight = $baseHeight;
    }
    else {
      $equalWidth = $baseWidth;
      $equalHeight = $baseWidth;
    }
    //saving original image
    $file->move(
      base_path() . "/public/images/news/$nodeId/", $fileName
    );

    //crop and saving slide size image
    $manipulation = Image::make(base_path() . "/public/images/news/$nodeId/$fileName");
    $manipulation->resize(800, 600);
    $manipulation->save(base_path() . "/public/images/news/$nodeId/news_$fileName");

    //crop and saving thumbnail size image
    $manipulation = Image::make(base_path() . "/public/images/news/$nodeId/$fileName");
    $manipulation->crop($equalWidth,$equalHeight);
    $manipulation->resize(100, 100);
    $manipulation->save(base_path() . "/public/images/news/$nodeId/thumbnail_$fileName");
  }
}
