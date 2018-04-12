<?php
/**
 * Created by PhpStorm.
 * User: xhkj
 * Date: 2018/4/11
 * Time: 下午8:02
 */

namespace Keling\Menu\Repositories;

use Keling\Menu\Models\Menu;
use Illuminate\Support\Facades\Redis;

class MenuRedis
{
    protected $REDIS_KEY = 'keling:menu';

    public $MenuData = [];

    public function __construct()
    {
        if (Redis::exists($this->REDIS_KEY))
        {
            $this->MenuData = Redis::get($this->REDIS_KEY);
        }
        else
        {
            $query = Menu::query();

            $query->orderBy('sort');

            $MenuData = $query->get();

            Redis::set($this->REDIS_KEY, $MenuData);
        }
    }

    /**
     *
     * 更新缓存
     * @author Eric
     */
    public function update()
    {
        $query = Menu::query();

        $query->orderBy('sort');

        $MenuData = $query->get();

        Redis::set($this->REDIS_KEY, $MenuData);
    }
}