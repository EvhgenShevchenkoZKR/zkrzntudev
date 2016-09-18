<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Menu;
use App\Quote;
use App\Tag;
use App\Employee;
use App\Advert;
use App\ParentPage;
use App\ChildPage;
use App\Http\Requests;

class IndexController extends Controller
{
  private $menu;
  private $paginationItem = 5;
  private $sidebarLimit = 10;
  private $horizontalLimit = 15;

  public function __construct()
  {
    $m = new Menu();
    $this->menu = $m->mainMenu();
  }

  /**
   * Get top and published news with different limits
   */
  private function getTopNews($limit) {
    $topNews = News::select('*')
    ->where('cover_show', true)
    ->Where('published', true)
    ->orderBy('created_at', 'desc')
    ->limit($limit)
    ->get();

    return $topNews;
  }
  
  public function administrationPage(){

    $topNews = $this->getTopNews($this->sidebarLimit);

    $quote = Quote::inRandomOrder()
      ->limit(1)
      ->get();

    $materials = Employee::where('administration', true)
      ->orderBy('weight', 'asc')
      ->get();
    
    $breadcrumbs = $this->parentPageBreadcrumbs();

    return view('index.administration', [
      'menus' => $this->menu,
      'breadcrumbs' => $breadcrumbs,
      'materials' => $materials,
      'topNews' => $topNews,
      'quote' => $quote,
    ]);
  }
  
  public function showObjavas(){
    $materials = Advert::select('*')
      ->where('published', true)
      ->orderBy('created_at', 'desc')
      ->paginate($this->paginationItem);

    $folder = 'objavas';
    $sinlge_link = 'objava';
    $page_title = 'Оголошення';
    $image_prefix = 'big'; //news

    return $this->materialsPage($materials,$folder,$sinlge_link,$page_title,$image_prefix);
  }
  
  public function showNews(){
    $materials = News::select('*')
      ->where('published', true)
      ->orderBy('created_at', 'desc')
      ->paginate($this->paginationItem);
    
    $folder = 'news';
    $sinlge_link = 'news';
    $page_title = 'Новини';
    $image_prefix = 'news'; //news

    return $this->materialsPage($materials,$folder,$sinlge_link,$page_title,$image_prefix);
  }
  
  public function showTag($slug){

    $tag = Tag::where('slug', $slug)->first();
    $materials = $tag->news()
      ->where('published', true)
      ->orderBy('created_at', 'desc')
      ->paginate($this->paginationItem);
    if($materials) {
      $folder = 'news';
      $sinlge_link = 'news';
      $page_title = 'Новини з тегом ' . $tag->title;
      $image_prefix = 'news'; //news

      return $this->materialsPage($materials, $folder, $sinlge_link, $page_title, $image_prefix);
    }
    else {
      return view('404');
    }
  }

  public function showSingleNews($slug){
    $segments = \Request::segments();
    if($segments[0] == 'tvorchist'){
      $material = News::where('slug', $slug)
          ->where('author_name', 'Життя коледжу')
          ->first();
    }
    else {
      $material = News::where('slug', $slug)->first();
    }
    if($material){
      $relatedNews = $material->getRelatedNews();
      $material_folder = 'news';
      $material_sinlge_link = 'news';
      $material_image_prefix = 'news';
      $folder = 'news';
      $sinlge_link = 'news';
      $image_prefix = 'news';

      return $this->materialPage(
          $material,$relatedNews,$folder,$sinlge_link,$image_prefix,$material_folder,
          $material_image_prefix,$material_sinlge_link);
    }
    else {
      return view('404');
    }
  }
  
  public function showSingleChild($slug){
    
    $material = ChildPage::where('slug', $slug)->first();
    if($material) {
      $relatedNews = $material->getRelatedNews();
      $material_folder = 'child';
      $material_sinlge_link = 'child';
      $material_image_prefix = 'small';
      $folder = 'news';
      $sinlge_link = 'news';
      $image_prefix = 'news';

      return $this->materialPage(
          $material, $relatedNews, $folder, $sinlge_link, $image_prefix, $material_folder,
          $material_image_prefix, $material_sinlge_link);
    }
    else {
      return view('404');
    }
  }

  public function showSingleObjava($slug){

    $material = Advert::where('slug', $slug)->first();
    if($material) {
      $relatedNews = $material->getRelatedNews();
      $material_folder = 'objavas';
      $material_sinlge_link = 'objava';
      $material_image_prefix = 'small';
      $folder = 'objavas';
      $sinlge_link = 'objava';
      $image_prefix = 'small';

      return $this->materialPage(
          $material, $relatedNews, $folder, $sinlge_link, $image_prefix, $material_folder,
          $material_image_prefix, $material_sinlge_link);
    }
    else {
      return view('404');
    }
  }

  private function materialPageBreadcrumbs($material,$folder){

    $segments = \Request::segments();
    $first = Menu::where('url', $segments[0])->first();
    $second = $material;
    if($first){
      $first['breadcrumb_url'] = '/' . $segments[0];
    }
    elseif($segments[0] == 'tvorchist'){
      $first = Menu::where('url', 'news')->first();
      $first['breadcrumb_url'] = '/news';
    }
    else {
      $first = ParentPage::where('id', $material->parent_id)->first();
      $first['breadcrumb_url'] = '/' . $first->slug;
    }
    $second['breadcrumb_url'] = '/' . $folder . '/' . $segments[1];
    $breadcrumbs = [$first, $second];

    return $breadcrumbs;
  }

  public function showParentPage($slug){
    $material = ParentPage::where('slug', $slug)->first();
    if($material){

      $relatedNews = $material->getRelatedNews();
      $material_sinlge_link = 'child';
      $folder = 'news';
      $sinlge_link = 'news';
      $image_prefix = 'news';

      $totalRelated = count($relatedNews);
      $relatedNews = array_slice($relatedNews, 0, 2);
      $relatedLeft = $totalRelated - 2;

      $topNews = $this->getTopNews($this->sidebarLimit);

      $quote = Quote::inRandomOrder()
        ->limit(1)
        ->get();

      $breadcrumbs = $this->parentPageBreadcrumbs($material);
      
      return view('index.parent_page', [
        'material' => $material,
        'breadcrumbs' => $breadcrumbs,
        'menus' => $this->menu,
        'topNews' => $topNews,
        'quote' => $quote,
        'folder' => $folder,
        'sinlge_link' => $sinlge_link,
        'image_prefix' => $image_prefix,
        'relatedNews' => $relatedNews,
        'relatedLeft' => $relatedLeft,
        'material_sinlge_link' => $material_sinlge_link,
      ]);
    }
    else {
      return view('404');
    }
  }
  
  public function parentPageBreadcrumbs($material = null){
  
    $segments = \Request::segments();

    $first = Menu::where('url', $segments[0])->first();
    if(!$first){
      $first = $material;
    }

    $first['breadcrumb_url'] = '/' . $segments[0];

    $breadcrumbs = [$first];

    return $breadcrumbs;
  }

  public function materialPage(
    $material,$relatedNews,$folder,$sinlge_link,$image_prefix,$material_folder,
    $material_image_prefix,$material_sinlge_link){

    $totalRelated = count($relatedNews);
    $relatedNews = array_slice($relatedNews, 0, 2);
    $relatedLeft = $totalRelated - 2;

    $topNews = $this->getTopNews($this->sidebarLimit);

    $quote = Quote::inRandomOrder()
      ->limit(1)
      ->get();
  
    $breadcrumbs = $this->materialPageBreadcrumbs($material,$material_sinlge_link);
    
    return view('index.material', [
      'material' => $material,
      'breadcrumbs' => $breadcrumbs,
      'menus' => $this->menu,
      'topNews' => $topNews,
      'quote' => $quote,
      'folder' => $folder,
      'sinlge_link' => $sinlge_link,
      'image_prefix' => $image_prefix,
      'relatedNews' => $relatedNews,
      'relatedLeft' => $relatedLeft,
      'material_folder' => $material_folder,
      'material_sinlge_link' => $material_sinlge_link,
      'material_image_prefix' => $material_image_prefix,
    ]);

  }

  public function materialsPage($materials,$folder,$sinlge_link,$page_title,$image_prefix){

    $topNews = $this->getTopNews($this->horizontalLimit);

    $quote = Quote::inRandomOrder()
      ->limit(1)
      ->get();

    $breadcrumbs = $this->materialsBreadcrumbs($page_title);

    return view('index.materials', [
      'materials' => $materials,
      'menus' => $this->menu,
      'topNews' => $topNews,
      'quote' => $quote,
      'folder' => $folder,
      'sinlge_link' => $sinlge_link,
      'page_title' => $page_title,
      'image_prefix' => $image_prefix,
      'breadcrumbs' => $breadcrumbs,
    ]);
  }

  public function materialsBreadcrumbs($page_title){

    $segments = \Request::segments();

    $first = Menu::where('url', $segments[0])->first();
    if(!$first){
      $first = new News();
      $first->title = $page_title;
    }

    $first['breadcrumb_url'] = '/' . $segments[0];

    $breadcrumbs = [$first];

    return $breadcrumbs;
  }


  /**
   * This is ugly but i don`t know any better way for now
   */
  private function buildMoreHtml($request, $relatedNews){

    $totalRelated = count($relatedNews); //6
    $startPoint = $totalRelated - $request->relatedLeft; //6 - 4 = 2
    $relatedNews = array_slice($relatedNews, $startPoint, 2);

    $sinlge_link = $request->relatedSingleLink;
    $folder = $request->relatedFolder;
    $image_prefix = $request->relatedImagePrefix;

    $html = [];
    foreach ($relatedNews as $related){
      $published = $related->created_at->format('H:i m.d.Y');
      $body = str_limit(strip_tags($related->body, '<p><b><em><ol><ul><li>'), $limit = 550, $end = '...');
      $tagg = '';
      if(method_exists($related,'tag')) {
        if (count($related->tag())) {
          $tagg = '<span>Теги: </span>';
          foreach ($related->tag as $k => $tag) {
            if ($k != 0) {
              $tagg .= '<span class="coma">,</span>';
            }
            $tagg .= "<span><a href='/tag/$tag->slug'>$tag->title</a></span>";
          }
        }
      }
      $html[] = "<div class='news-wrapper clearfix'>
                <div class='n-image col-md-3'>
                    <a href='/$sinlge_link/$related->slug'>
                        <img src='/images/$folder/$related->id/$image_prefix" . '_' . "$related->cover_image'
                             alt='$related->cover_alt'
                             title='$related->cover_title'
                             width='250px' height='180px'
                        />
                    </a>
                </div>
                <div class='n-text col-md-9'>
                    <h4>
                        <a href='/$sinlge_link/$related->slug'>
                            $related->title
                        </a>
                    </h4>
                    <div class='n-tags'>
                    $tagg
                    </div>
                    <div class='n-published'>
                        <span>Опубліковано:</span>
                        <span class='n-time'>$published</span>
                    </div>
                    <div class='nbody'>
                        $body
                        <span class='read-more'><a href='/$sinlge_link/$related->slug'>читати далі</a></span>
                    </div>
                    <div class='n-author'>$related->author_name</div>
                </div>
            </div>
        <hr class='divider'>";
    }

    return $html;
  }

  /**
   * method for ajax Load more functionality only for parent pages
   */
  public function ajax_more_parent(Request $request)
  {
    $material = ParentPage::find($request->relatedId);
    $relatedNews = $material->getRelatedNews();

    $left = $request->relatedLeft - 2;
    $html = $this->buildMoreHtml($request, $relatedNews);

    $response = array(
      'status' => 'success',
      'html' => $html,
      'left' => $left
    );
    return \Response::json($response);
  }

  /**
   * universal method for ajax Load more functionality
   */
  public function ajax_more(Request $request){

    if($request->relatedType == 'news'){
      $material = News::find($request->relatedId);
      $relatedNews = $material->getRelatedNews();
    }
    elseif($request->relatedType == 'child'){
      $material = ChildPage::find($request->relatedId);
      $relatedNews = $material->getRelatedNews();
    }
    elseif($request->relatedType == 'objava'){
      $material = Advert::find($request->relatedId);
      $relatedNews = $material->getRelatedNews();
    }
  
    $left = $request->relatedLeft - 2;
    $html = $this->buildMoreHtml($request, $relatedNews);
    
    $response = array(
      'status' => 'success',
      'html' => $html,
      'left' => $left
    );
    return \Response::json($response);
  }
}
