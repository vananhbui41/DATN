<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Category;
use App\Models\Item;

class CashierController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('cashier.index')->with('categories', $categories);
    }

    public function getTables() {
        $tables = Table::all();

        $html = '';
        foreach ($tables as $table) {
            $html .= '<div class="col-md-2 mb-4">';
            $html .= 
            '<button class="btn btn-primary btn-table" data-id="'.$table->id.'" data-name="'.$table->name.'">
            <img class="img-fluid" src="'.url('/images/table.png').'"/>
            <br>';
            if($table->status == "available"){
                $html .= '<span class="badge badge-success">'.$table->name.'</span>';
            }else{ 
                $html .= '<span class="badge badge-danger">'.$table->name.'</span>';
            }
            $html .='</button>';
            $html .= '</div>';
        }
        return $html;
    }

    public function getItemByCategory($id) {
        $items = Item::where('id', $id)->get();
        $html = '';
        foreach($items as $item){
            $html .= '
            <div class="col-md-3 text-center">
                <a class="btn btn-outline-secondary btn-item" data-id="'.$item->id.'">
                    <img class="img-fluid" src="'.url('/item_images/'.$item->image).'">
                    <br>
                    '.$item->name.'
                    <br>
                    $'.number_format($item->price).'
                </a>
            </div>
            
            ';
        }
        return $html;
    }
}
