<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MenuRequest;
use App\Menu;

class MenuController extends Controller
{
  //DONE - todo make form to create new menus
  //DONE - todo create all new menus with max weight
  //todo make some sublevel reordering
  // at first build some multidimensional array for this
  //todo make Request to validate reordering menus for emptiness

  public function menusList(){

    //todo - select only parent menu, and make some sublevel var for this variable
    $menus = Menu::orderBy('weight')->where('parent', '=', 0)->get();
    foreach($menus as $menu) {
      $Submenu = Menu::orderBy('weight')->where('parent', '=', $menu->id)->get();
      if(isset($Submenu[0])){
        $menu['submenu'] = $Submenu;
      }
    }

    //todo make some validation request class for creation and updating menu
    
    return view('menus.list', compact('menus', $menus));
  }

  /**
   * Function to store new menu item, also gives it new maximum weight
   * @param MenuRequest $request
   * @return mixed
   */
  public function store(MenuRequest $request){

    $Menu = new Menu();
    $this->maximizeMenuWeight($Menu);

    $Menu->title = $request->title;
    $Menu->url = $request->url;
    if($request->published == true){
      $Menu->published = $request->published;
    }
    else {
      $Menu->published = false;
    }
    $Menu->save();

    $message = 'Новий пункт меню створено';

    return redirect('menus-list')->with('message', $message);

  }

  public function reindex(Request $request){
    if($request->get('delete_menu')){
      //TODO when we delete menu - we lose all submenus of it!!! that`s BAD SET some didfferent parent for this
      //get all childs of this menu and set their parent to 0
      \DB::table('menus')
        ->where('parent', $request->get('delete_menu'))
        ->update(['parent' => 0]);

      $menu = Menu::findOrFail($request->get('delete_menu'));
      $menu->delete();
      $message = 'Меню видалено';
    }
    elseif($request->get('update_menu')){

      $menuId = $request->get('update_menu');

      if(!empty($request->get('menu_title_' . $menuId)) &&
        !empty($request->get('menu_url_' . $menuId))){
        $menu = Menu::findOrFail($menuId);

        $menu->title = $request->get('menu_title_' . $menuId);
        $menu->url = $request->get('menu_url_' . $menuId);
        $menu->published  = $request->get('published_' . $menuId);

        $menu->save();

        $message = 'Меню оновлено';
      }
      else {
        $message = 'Поля мають бути заповнені';
      }
    }
    else {
      $message = 'Щось не так';
    }
    return redirect('menus-list')->with('message', $message);
  }
  
  public function reorder_ajax(Request $request){

    $orderedArray = $this->unserializaOrderString($request->testdata);
    $i = 0;
    foreach($orderedArray as $key=>$parent){
      $i++;
      $menu = Menu::findOrFail($key);
      $menu->weight = $i;
      $menu->parent = $parent;
      $menu->save();
    }

    $response = array(
      'status' => 'success',
      'msg' => 'Новий порядок збережено',
    );
    return \Response::json($response);
  }

  /**
   * When we create a new menu item - we check weight of all existing menu items
   * and make new one the last one
   * @param $slider
   */
  private function maximizeMenuWeight($Menu){

    $weight = \DB::table('menus')
      ->select('weight')
      ->orderBy('weight', 'desc')
      ->limit(1)
      ->get();
    if(isset($weight[0])){
      $Menu->weight = $weight[0]->weight + 1;
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

}
