<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\orders_list;
class ProductController extends Controller
{
    public function availableProducts()
    {
      $availProdcuts = array();
      $availProdcuts['status'] = "200";
      $availProdcuts['products'][] = array('id'=>'1','name'=>"TV");
      $availProdcuts['products'][] = array('id'=>'2','name'=>"Fridge");
      $availProdcuts['products'][] = array('id'=>'3','name'=>"Bed");
      $availProdcuts['products'][] = array('id'=>'4','name'=>"Sofa");
      $availProdcuts['products'][] = array('id'=>'5','name'=>"Chair");
      $availProdcuts['products'][] = array('id'=>'6','name'=>"Phone");
      $availProdcuts['products'][] = array('id'=>'7','name'=>"Laptop");
      $availProdcuts['products'][] = array('id'=>'8','name'=>"Home Theater");
      $availProdcuts['products'][] = array('id'=>'9','name'=>"Router");
      $availProdcuts['products'][] = array('id'=>'10','name'=>"Car");

      return response()->json($availProdcuts);

    }
    public function getUserEmailValidation($email)
    {
      $apiResponse = array();
      $orders = new orders_list();
      if($ordersList = $orders::where('customer_email',$email)->exists()){
        $apiResponse['status'] = '400';
        $apiResponse['msg'] = array('message' => 'user Exsits');

      }
      else{
        $apiResponse['status'] = '200';
        $apiResponse['msg']['message'] = "User doesn't exsits";
      }
      return response()->json($apiResponse);
    }
    public function createOrder(Request $request){
        $apiResponse = array();
        $data = $request->json()->all();
        $customer_name = $data['customer_name'];
        $customer_email = $data['customer_email'];
        $customer_dob = $data['customer_dob'];
        $products = json_encode($data['products']);

        $orderData = new orders_list();
        $orderData->customer_name = $customer_name;
        $orderData->customer_email = $customer_email;
        $orderData->dob = $customer_dob;
        $orderData->products = $products;
        if($orderData->save()){
          $apiResponse['status'] = "200";
          $apiResponse['success']['message'] = "Order Placed";
        }
        else{
          $apiResponse['status'] = '400';
          $apiResponse['error']['message'] = "Order Creation Failed";
        }
        return response()->json($apiResponse);
    }
}
