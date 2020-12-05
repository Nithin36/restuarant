<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table ='items';
    protected $fillable = ['id','dish','available','price'];
    public $timestamps = false;
    
    public  function updatedata($id,$arr){
            
     $this->where('id', '=', $id)->update($arr);
    return  TRUE;
    }
    
    function getdata($id){
      $get_data=  $this->where('id',$id)->first();
      return $get_data;
    }
}
