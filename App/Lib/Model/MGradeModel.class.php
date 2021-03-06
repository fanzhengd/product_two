<?php

/**
 * 会议等级模型
 */

class MGradeModel extends Model{

    /**
     * @var 查找
     */
    public function getList($where, $firstRow = 0, $listRows = 20,$onlyCount=0,$type){

        //获取用户搜索条件
        $where = $this->_search($where);
        $pre = C("DB_PREFIX");
        //print_r($pre);exit;
        $new_where = array();

       /* if(!empty($where)){
            foreach ($where as $key => $value) {
                $new_where[$pre.'m_student.'.$key] = $value;
            }
        }*/
       /* //学生会议室1 自筹会议室2
        if ($type ==1) {
            $_type = 1;
        }else if ($type == 2){
            $_type =2;
        }
        $new_where['room_type'] = array('eq',$_type); */
       // $this->where($new_where);
        if($onlyCount){
            return $this->count();
        }
        $fields = 'mt_id,g_xuefen,g_id,g_name,g_time';
        $list   = $this->field($fields)
                       ->order('g_id desc')
                       ->limit($firstRow , $listRows)
                       ->select();



       // echo $this->getLastSql();exit;
        return $list;
    }

    /**
     * @var 搜索条件
     *  搜索
     */
    private function _search($post){
        $map = array();

        //学生号
        if($post['s_no']){
            $map['s_no'] = $post['s_no'];
        }

        //学生名称
        if($post['s_name']){
            $map['s_name'] = array('like', '%'.trim($post['s_name']).'%');
        }

        //学生身份证号
        if($post['s_card']){
            $map['s_card'] = array('like', '%'.trim($post['s_card']).'%');
        }
        //导师名字
        if($post['s_teacher']){
            $map['s_teacher'] = array('like', '%'.trim($post['s_teacher']).'%');
        }

        //导入时间开始
        if($post['start_time']){
            $map['s_time'][] = array('egt', strtotime(trim($post['start_time'])));
        }
        //导入时间结束
        if($post['end_time']){
            $_end_time = trim($post['end_time']);
            $map['s_time'][] = array('elt', strtotime($_end_time)+(24*60*60-1));
        }

        return $map;
    }



}