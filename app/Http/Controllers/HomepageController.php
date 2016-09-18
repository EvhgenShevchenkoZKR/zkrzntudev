<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Slider;
use App\Menu;
use App\News;
use App\Advert;
use App\Massonry;
use App\Link;

class HomepageController extends Controller
{
  public function homepageSlider(){

    $m = new Menu();
    $menus = $m->mainMenu();

    $sliders = Slider::orderBy('weight')->get();

    //prepare 8 element for top news slider at homepage
    $top_news = News::select('id','slug','cover_image', 'cover_alt', 'cover_title', 'title', 'body')
    ->where('published', true)
    ->where('important', true)
    ->orderBy('updated_at', 'desc')
    ->limit(8)
    ->get();

    $freshNews = News::select('id','slug','cover_image', 'cover_alt', 'cover_title', 'title', 'body',
      'created_at', 'author_name')
      ->where('published', true)
      ->where('important', false)
      ->orderBy('updated_at', 'desc')
      ->limit(4)
      ->get();

    $freshAdverts = Advert::select('id','slug','cover_image', 'cover_alt', 'cover_title', 'title', 'body',
      'created_at', 'author')
      ->where('published', true)
      ->orderBy('updated_at', 'desc')
      ->limit(4)
      ->get();
    
    $massonry = Massonry::select('*')
      ->where('published', true)
      ->orderBy('weight', 'asc')
      ->limit(8)
      ->get();

    $links = Link::select('*')
      ->where('published', true)
      ->orderBy('weight', 'asc')
      ->limit(8)
      ->get();

    return view('homepage.slider', [
      'sliders' => $sliders,
      'menus' => $menus,
      'top_news' => $top_news,
      'freshNews' => $freshNews,
      'freshAdverts' => $freshAdverts,
      'massonry' => $massonry,
      'links' => $links,
    ]);
  }
    
}
