<?php
namespace app\admin\model;

use think\Model;
use app\admin\model\Role;

class Admin extends Model
{
    protected $type = [
        'login_time'    => 'integer'
    ];
    public function setPasswordAttr($value,$data){
        if($value){
            return password_hash($value, PASSWORD_DEFAULT);
        }
        if(isset($data['id'])){
            $old = $this->find($data['id']);
            return $old['password'];
        }
        return '';
    }

    public function role(){
        return $this->belongsTo(Role::class, 'role_id','id');
    }
}

?>
