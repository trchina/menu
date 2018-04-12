
### 文件迁移
```
php artisan vendor:publish --provider="Keling\Menu\MenuServiceProvider"
```

### 数据库迁移
```
php artisan migrate
```

### 更新composer
```
composer dump-autoload
```

### 数据添加
```
php artisan db:seed --class=MenusTableSeeder
```

### 使用方法
```
use Keling\Menu\Repositories\MenuRepository;

class TestController extends Controller
{
    public $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function test(){
        // 显示全部 参数一 $kile 参数二  $is 1 返回一维菜单 其余返回递归菜单
        $data = $this->menuRepository->all();
//         添加
//        $data = $this->menuRepository->create('菜单', '1', '1');
//        查询
//        $data = $this->menuRepository->show(1);
//        删除
//        $data = $this->menuRepository->destroy(1);
//        修改
//        $data = $this->menuRepository->store(['id' => 1], ['name' => '修改']);
        dd($data);
    }
}
```

### 配置
```
'Redis' => true // true 开始redis缓存  false 开启
```