<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TagRequest;
use App\Tag;

class TagController extends Controller
{
  public function index(){ 

    $tags = Tag::all();

    return view('tag.index', compact('tags', $tags));
  }

  public function create(){ 

    return view('tag.create');
  }

  public function store(TagRequest $request) { 

    $tag = new Tag($request->all());
    $tag->sluggable();
    $tag->save();

    $msg = 'Тег створено';
    return redirect()->back()->with('message', $msg);
  }

  public function edit(Tag $tag){ 

    return view('tag.edit', ['tag' => $tag]);
  }

  public function update(Tag $tag, TagRequest $request){ 

    $tag->title = $request->title;
    $tag->meta_title = $request->meta_title;
    $tag->meta_keywords = $request->meta_keywords;
    $tag->meta_description = $request->meta_description;
    $tag->save();
    
    $msg = 'Оновлено';
    return redirect()->back()->with('message', $msg);
  }
  
  public function adminIndex() {
    $tags = Tag::all();
    
    return view('tag.admin_index', ['tags' => $tags]);
  }

  public function delete(Tag $tag) {
    $tag->delete();
    $msg = 'Таг видалено';
    return redirect()->back()->with('message', $msg);
  }
}
