<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itemsale extends Model
{
    protected $table ='itemsale';
    protected $fillable = ['id','item','itemno','itemtime'];
    public $timestamps = false;
    
    function insert_data($data){
       $insert_data= $this->create($data);
        return $insert_data;
    }
    function between_data($starttime,$endtime){
       return $this->whereBetween('itemtime', [$starttime, $endtime])->get();
    }
}
