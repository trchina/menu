<?php
/**
 * Created by PhpStorm.
 * User: xhkj
 * Date: 2018/4/12
 * Time: 下午7:31
 */

namespace Keling\Menu\Repositories;


class Tree
{

    /**
     * 返回树状结构
     *
     * @author Eric
     * @param $arr 数组
     * @param string $primaryKey 主键下标
     * @param string $parentKey 父组件下标
     * @param string $collection 子分类下标
     * @param int $topvalue 父id
     * @return array
     */
    public function make($arr, $primaryKey = 'id', $parentKey = 'parent_id', $collection = 'collection', $topvalue = 0 ){

        $fu_arr = [];

        $tem = [];

        foreach ($arr as $k => $v)
        {
            if ($v[$parentKey] == $topvalue)
            {
                $tem = $this->make($arr,$primaryKey, $parentKey, $collection, $v[$primaryKey]);
                // 判断是否存在子数组
                $tem && $v[$collection] = $tem;

                $fu_arr[] = $v;
            }
        }

        return $fu_arr;
    }

}