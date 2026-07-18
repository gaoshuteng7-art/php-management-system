<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use think\Validate;

class News extends Common
{
    public function initialize(){
        parent::initialize();
        $this->model = new \app\admin\model\News();
    }
    public function add(){
        $this->request->filter([]);
        $id = $this->request->param('id');
        if($id){
            $row = $this->model->find($id);
        }
        $data = $this->request->post();
        if(!empty($data)){
            $result = false;
            try{
                if(isset($data['id']) && intval($data['id']) > 0 && $row){
                    $result = $row->save($data);
                }else{
                    unset($data['id']);
                    // 处理上传图片
                    $file = $this->request->file('file');
                    if(!$file){
                        $this->error('请选择封面图片');
                    }
                    $validate = Validate::rule([
                        'file' => 'fileSize:5242880|fileExt:jpg,jpeg,png,gif,webp|fileMime:image/jpeg,image/png,image/gif,image/webp'
                    ]);
                    if(!$validate->check(['file'=>$file])){
                        $this->error($validate->getError());
                    }
                    $savename = \think\facade\Filesystem::putFile( 'topic', $file);
                    $data['picurl'] = '/storage/'.$savename;

                    $result = $this->model->save($data);
                }
            }catch(Exception|PDOException $e){
                $this->error($e->getMessage());
            }
            if($result){
                $this->success('操作成功');
            }
            $this->error('操作失败');
        }
        $d = array_merge($this->addData(),['row' => $row ?? []]);
        return view('add',$d);
    }
}
?>
