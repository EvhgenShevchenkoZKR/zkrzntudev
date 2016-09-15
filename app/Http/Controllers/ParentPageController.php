<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use App\ParentPage;
use App\Http\Requests\ParentRequest;

class ParentPageController extends Controller
{
  public function adminIndex() {

    $parents = ParentPage::select('id','title','slug', 'published')->paginate(5);

    return view('parent.admin_index', ['parents' => $parents]);
  }

    public function create(){
      $tags = Tag::pluck('title', 'id');
      return view('parent.create',[
        'tags' => $tags,
      ]);
    }
  
  public function store(ParentRequest $request) {
    $parent = new ParentPage($request->all());
    $parent->sluggable();

    if(isset($request->published)) { $parent->published = $request->published; }
    else { $parent->published = false; }
    $user = \Auth::user();
    $parent->user_id = $user->id;
    $parent->save();

    if(isset($request->tags)){
      foreach($request->tags as $tag){
        $parent->tag()->attach($tag);
      }
    }

    $parent->save();

    return redirect()->back()->with('message', 'Сторінку збережено');
  }
  
  public function edit(ParentPage $parent){
  
    //all tags
    $tags = Tag::pluck('title', 'id');
  
    //getting selected tags
    $pageTags = $parent->tag;
    $selected_tags = [];
    foreach ($pageTags as $pageTag) {
      $selected_tags[] = $pageTag->id;
    }
    
    return view('parent.edit', [
      'parent' => $parent,
      'tags' => $tags,
      'selected_tags' => $selected_tags
    ]);
  }

  public function update(ParentPage $parent, ParentRequest $request){

    if($parent->user_id == \Auth::user()->id) {
      $parent->fill($request->all());

      if (isset($request->published)) {
        $parent->published = $request->published;
      } else {
        $parent->published = false;
      }

      if($request->tags){
        $parent->tag()->sync($request->tags);
      }
      else {
        $parent->tag()->sync([]);
      }
      $parent->save();

      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
  public function delete(ParentPage $parent) {
    if($parent->user_id == \Auth::user()->id){
      $parent->delete();
      $msg = 'Новину видалено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }

  public function publish (ParentPage $parent) {
    if($parent->user_id == \Auth::user()->id){
      $parent->published = true;
      $parent->save();
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }

  public function unpublish (ParentPage $parent) {
    if($parent->user_id == \Auth::user()->id){
      $parent->published = false;
      $parent->save();
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
}
