<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = 'menus';

  protected $fillable = [
    'title',
    'url',
    'weight',
    'published',
    'parent',
  ];
  
  /**
   * Building main menu
   * @return array
   */
  public function mainMenu(){
    $parent_menus = $this::where('parent', '=', 0)
      ->where('published', true)
      ->orderBy('weight')
      ->get();
    $menus = [];
    foreach($parent_menus as $key=>$menu){
      $menus[$key] = $menu;
      $submenus = $this::where('parent', '=', $menu->id)
        ->where('published', true)
        ->orderBy('weight')
        ->get();
      if(!empty($submenus)){
        $menus[$key]['submenus'] = $submenus;
      }
    }
    return $menus;
  }
  
}
