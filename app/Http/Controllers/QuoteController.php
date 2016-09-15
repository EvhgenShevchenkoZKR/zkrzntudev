<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Quote;
use App\Http\Requests\QuotesRequest;

class QuoteController extends Controller
{
  public function create(){
    return view('quote.create');
  }

  public function store(QuotesRequest $request){

    $quote = new Quote($request->all());
    $quote->user_id = \Auth::user()->id;
    $quote->save();
    
    return redirect()->back()->with('message', 'Цитату збережено');
  }
  
  public function edit(Quote $quote){

    return view('quote.edit', [
      'quote' => $quote,
    ]);
  }
  
  public function update(Quote $quote, QuotesRequest $request) {

    if($quote->user_id == \Auth::user()->id){

      $quote->fill($request->all())->save();
      $msg = 'Оновлено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    
    return redirect()->back()->with('message', $msg);
  }
  
  public function adminIndex() {
    
    $quotes = Quote::select('id','body', 'author')->paginate(5);
    
    return view('quote.admin_index', ['quotes' => $quotes]);
  }
  
  public function delete(Quote $quote) {
    if($quote->user_id == \Auth::user()->id){
      $quote->delete();
      $msg = 'Цитату видалено';
    }
    else {
      $msg = 'У вас немає на це прав';
    }
    return redirect()->back()->with('message', $msg);
  }
  
}
