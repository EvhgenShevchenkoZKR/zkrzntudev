<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Card;
use App\Http\Requests\cardRequest;

use Intervention\Image\Facades\Image;


class CardController extends Controller
{
    public function index(){

        $cards = Card::all();
//        dd($cards->all());
        return view('card.index', compact('cards', $cards));
    }

    public function show(Card $card){

//        $card = Card::with('notes')->find($card->id);  --dumb way to do that
//        nice way
        $card->load('notes.user');

        return view('card.card', compact ('card', $card));
    }

    public function store(cardRequest $request) {
//        dd($request->file('image')->getClientOriginalName());
        $fileName = $request->file('image')->getClientOriginalName();
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);

        $fileName =
          $withoutExt .
          '_'.rand(111,999).'.' .
          $request->file('image')->getClientOriginalExtension(); // renaming image

        $card = new Card(array(
          'title' => $request->get('title'),
          'body'  => $request->get('body'),
          'image' => $fileName,
        ));


        $card->user_id = 1; // TODO get real userId here
    
//        $card->save();

    
//        $request->file('image')->move(
//          base_path() . "/public/images/cards/$card->id/", $fileName
//        );

//        $tar = base_path() . "/public/images/cards/5.jpg";
//
////        dd($tar);
//        //thumbnail image
//        var_dump($tar);
//        $a = is_file ($tar);
//        dd($a);
        $manipulation = Image::make(base_path() . "/public/images/cards/5.jpg");
        $manipulation->resize(100, 100);
        $manipulation->save(base_path() . "/public/images/cards/100x100_5.jpg");
        
        return \Redirect::back()->with('message', 'Product added!');
    }

    public function filemanager(){

        return 'checking';
    }
}
