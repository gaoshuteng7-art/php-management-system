<?php
namespace app\api\model;

use think\Model;

class User extends Model
{
    public function bumen(){
        return $this->belongsTo(\app\api\model\Bumen::class,'bumenId','id');
    }
}

?>