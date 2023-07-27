<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Category;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Auth;

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
            $html .= '<div class="col-md-2 mb-3">';
            if($table->status == "available"){
                $html .= 
                '<button class="btn btn-success btn-lg btn-table" style="width: -webkit-fill-available" data-id="'.$table->id.'" data-name="'.$table->name.'">';
            } else { 
                $html .= 
                '<button class="btn btn-danger btn-lg btn-table" style="width: -webkit-fill-available" data-id="'.$table->id.'" data-name="'.$table->name.'">';
            }
            $html .= '<span>'.$table->name.'</span>';
            $html .='</button>';
            $html .= '</div>';
        }
        return $html;
    }

    public function getItemByCategory($category_id) {
        $items = Item::where('category_id', $category_id)->get();
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

    public function orderFood(Request $request) {
        $item = Item::find($request->item_id);
        $table_id = $request->table_id;
        $table_name = $request->table_name;
        $sale = Sale::where('table_id', $table_id)->where('sale_status','unpaid')->first();

        if(!$sale) {
            $user = Auth::user();
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();
            $sale_id = $sale->id;
            // update table status
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        } else { // if there is a sale on the selected table
            $sale_id = $sale->id;
        }

        // add ordered item to the sale_details table
        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->item_id = $item->id;
        $saleDetail->item_name = $item->name;
        $saleDetail->item_price = $item->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();
        //update total price in the sales table
        $sale->total_price = $sale->total_price + ($request->quantity * $item->price);
        $sale->save();

        $html = $this->getSaleDetails($sale_id);

        return $html;
    }

    public function getSaleDetailsByTable($table_id){
        $sale = Sale::where('table_id', $table_id)->where('sale_status','unpaid')->first();
        $html = '';
        if($sale){
            $sale_id = $sale->id;
            $html .= $this->getSaleDetails($sale_id);
        }else{
            $html .= "Bàn trống";
        }
        return $html;       
    }

    private function getSaleDetails($sale_id){
        // list all saledetail
        $html = '<p>Sale ID: '.$sale_id.'</p>';
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->get();
        $html .= '<div class="table-responsive md" style="overflow-y:scroll; height: 300px; border: 1px solid #343A40">
        <table class="table table-stripped table-dark">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Món</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Đơn Giá</th>
                <th scope="col"Tổng</th>
                <th scope="col">Trạng Thái</th>
            </tr>
        </thead>
        <tbody>';
        $showBtnPayment = true;
        foreach($saleDetails as $saleDetail){
          
            $html .= '
            <tr>
                <td>'.$saleDetail->id.'</td>
                <td>'.$saleDetail->item_name.'</td>
                <td>'.$saleDetail->quantity.'</td>
                <td>'.$saleDetail->item_price.'</td>
                <td>'.($saleDetail->item_price * $saleDetail->quantity).'</td>';
                if($saleDetail->status == "noConfirm"){
                    $showBtnPayment = false;
                    $html .= '<td><a data-id="'.$saleDetail->id.'" class="btn btn-danger btn-delete-saledetail"><i class="far fa-trash-alt"></a></td>';
                }else{ // status == "confirm"
                    $html .= '<td><i class="fas fa-check-circle"></i></td>';
                }
            $html .= '</tr>';
        }
        $html .='</tbody></table></div>';

        $sale = Sale::find($sale_id);
        $html .= '<hr>';
        $html .= '<h3>Tổng: '.number_format($sale->total_price).' VNĐ</h3>';

        if($showBtnPayment){
            $html .= '<button data-id="'.$sale_id.'" data-totalAmount="'.$sale->total_price.'" class="btn btn-success btn-payment" data-bs-toggle="modal" data-bs-target="#exampleModal" style="width: -webkit-fill-available">Thanh Toán</button>';

        }else{
            $html .= '<button data-id="'.$sale_id.'" class="btn btn-warning btn-confirm-order" style="width: -webkit-fill-available">
                Xác Nhận Order
            </button>';
        }
      

        return $html;
    }

    public function confirmOrderStatus(Request $request){
        $sale_id = $request->sale_id;
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->update(['status'=>'confirm']);
        $html = $this->getSaleDetails($sale_id);
        return $html;

    }

    public function deleteSaleDetail(Request $request){
        $saleDetail_id = $request->saleDetail_id;
        $saleDetail = SaleDetail::find($saleDetail_id);
        $sale_id = $saleDetail->sale_id;
        $menu_price = ($saleDetail->menu_price * $saleDetail->quantity);
        $saleDetail->delete();
        //update total price
        $sale = Sale::find($sale_id);
        $sale->total_price = $sale->total_price - $menu_price;
        $sale->save();
        // check if there any saledetail having the sale id 
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->first();
        if($saleDetail){
            $html = $this->getSaleDetails($sale_id);
        }else{
            $html = "Không tồn tại Order";
        }
        return $html;
    }

    public function savePayment(Request $request){
        $saleID = $request->saleID;
        $recievedAmount = $request->recievedAmount;
        $paymentType = $request->paymentType;
        // update sale information in the sales table by using sale model
        $sale = Sale::find($saleID);
        $sale->total_recieved = $recievedAmount;
        $sale->change = $recievedAmount - $sale->total_price;
        $sale->payment_type = $paymentType;
        $sale->sale_status = "paid";
        $sale->save();
        //update table to be available
        $table = Table::find($sale->table_id);
        $table->status = "available";
        $table->save();
        return "/cashier/showReceipt/".$saleID;
    }

    public function showReceipt($saleID){
        $sale = Sale::find($saleID);
        $saleDetails = SaleDetail::where('sale_id', $saleID)->get();
        return view('cashier.showReceipt')->with('sale', $sale)->with('saleDetails', $saleDetails);
    }
}
