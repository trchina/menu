<?php

namespace Keling\Menu\Repositories;

use Betterde\Tree\Generator;
use Keling\Menu\Models\Menu;

use Betterde\Tree\Exceptions\TreeException;

class MenuRepository
{

    /**
     * 菜单缓存实例化
     * @var MenuRedis
     */
    protected $MenuRedis;

    /**
     * 菜单缓存数据
     * @var array|mixed
     */
    protected $MenuRedisData = [];

    /**
     * 菜单缓存是否开启
     * @var bool|\Illuminate\Config\Repository|mixed
     */
    protected $MenuRedisBool = true;

    public function __construct()
    {
        $this->MenuRedisBool = config('menu.Redis');

        if ($this->MenuRedisBool)
        {
            $this->MenuRedis = new MenuRedis();
            $this->MenuRedisData = json_decode($this->MenuRedis->MenuData, true);
        }

    }

    /**
     *
     *
     * @author Eric
     * @param string $like 模糊查询菜单名称
     * @param string $is 1 返回一维菜单 其余返回递归菜单
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
	public function all($like = '', $is = '')
    {
        $query = Menu::query();
        $min = 0;

        if ($like)
        {
            $query->where('name', 'like', '%'.$like.'%');
            $query->orderBy('sort');
            $MenuData = $query->get();
            $min = $query->min('parent_id');
        }
        else
        {
            if ($this->MenuRedisBool)
            {
                $MenuData = $this->MenuRedisData;
            }
            else
            {
                $query->orderBy('sort');
                $MenuData = $query->get();
            }
        }

        if ($is != 1)
        {
            $generator = new Generator();
            $data = $generator->make($MenuData, 'id', 'parent_id', 'children', $min);
        }
        else
        {
            $data = $MenuData;
        }

        return $data;
	}

    public function create($name, $sort, $parent_id = 0)
    {
        $Menu = new Menu();
        $Menu->name = $name;
        $Menu->parent_id = $parent_id;
        $Menu->sort = $sort;
        $is = $Menu->save();

        if ($this->MenuRedisBool)
        {
            // 更新缓存
            $this->MenuRedis->update();
        }
        return $is;
    }

    /**
     *
     * 修改数据
     * @author Eric
     * @param $where 修改条件
     * @param $update 修改数据
     * @return bool
     * @throws TreeException
     */
    public function store($where, $update)
    {

        if (count($update) > 0)
        {
            $Menu = new Menu();

            $MenuQ = $Menu;

            // where
            if (count($where))
            {
                foreach ($where as $k => $v)
                {
                    $MenuQ = $Menu->where($k, $v);
                }
            }


            $is = $MenuQ->update($update);

            if ($this->MenuRedisBool)
            {
                // 更新缓存
                $this->MenuRedis->update();
            }
            return $is;

        }
        else
        {
            throw new TreeException('请传入修改的数据');
        }

    }

    /**
     *
     * 查询菜单
     * @author Eric
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $data = [];
        $MenuData = $this->MenuRedisData;
        if ($this->MenuRedisBool && count($MenuData) > 0)
        {
            foreach ($MenuData as $v)
            {
                if ($v['id'] == $id)
                {
                    $data = $v;
                }
            }
        }
        else
        {
            $Menu = new Menu();

            $data = $Menu->find($id);
        }

        return $data;
    }

    /**
     *
     * 删除菜单
     * @author Eric
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $Menu = new Menu();
        $is = $Menu->where('id', $id)->delete();

        if ($this->MenuRedisBool)
        {
            // 更新缓存
            $this->MenuRedis->update();
        }

        return $is;
    }

}

?>