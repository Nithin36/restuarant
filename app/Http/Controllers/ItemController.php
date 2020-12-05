<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use App\Itemsale;
use Validator;
use Response;
class ItemController extends Controller
{
    
    public function sendOrder(Request $request){
                
                        $data = $request->all();


        $rules = array
        (

              
             'itemid' => ['required'],
             'itemno' => ['required'],
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {
            $message="Validation error";
            $validation_errors=$validator->messages()->toArray();
            return Response::json(array('error' => true,'message' => $message,'validationerror' => $validation_errors),200);
        }
        else
        {
            $items=new Items();
       
            $idata=$items->getdata($data['itemid']);
          
            if(($idata)&&($idata->available!=0)) {
            $itemno=$idata['available']-$data['itemno'];
                 $itemdata=[
                'available'=>$itemno
                
            ];
           $items->updatedata($data['itemid'], $itemdata);
           $Itemsale=new Itemsale();
           $itemsaledata=[
               'item'     => $data['itemid'],
               'itemno'   => $data['itemno'],
               'itemtime' => time()
           ];
           $Itemsale->insert_data($itemsaledata);
           $message="Sucessfully updated";
            }else{
           $message="Item out of stock";     
            }

        return Response::json(array('error' => false,'message' => $message),200); 
        }
                
       // return view('departmentadd');
    }
    
    public function soldItems(){
        $startdate=strtotime('-2 day');
        $enddate= time();
        $Itemsale=new Itemsale();
        $itemdata=$Itemsale->between_data($startdate,$enddate);
        $message="Data retrieved";
        return Response::json(array('error' => false,'message' => $message,'data'=>$itemdata),200); 
    }
        public function reportItems(){
        $startdate=strtotime('-10 day');
        $enddate= time();
        $Itemsale=new Itemsale();
        $itemdata=$Itemsale->between_data($startdate,$enddate);
        $message="Data retrieved";
        return Response::json(array('error' => false,'message' => $message,'leastsolddata'=>$itemdata,'mostsolddata'=>$itemdata),200); 
    }
}
