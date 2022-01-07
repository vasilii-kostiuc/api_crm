<?php
/**
 * api_crm.loc - BaseController.php
 *
 * Created by Admin
 * Created on: 26.12.2021 12:31
 */

namespace app\Modules\Admin\Dashboard\Controllers;


use App\Modules\Admin\Menu\Models\Menu as MenuModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Menu;

class BaseDashboardController extends \App\Http\Controllers\Controller {

    protected $template;

    protected $user;

    protected $title;

    protected $content;

    protected $sidebar;

    protected $vars;

    protected $locale;

    public function __construct() {
        $this->middleware('auth');

        $this->template = "Admin::Dashboard.dashboard";

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->locale = App::getLocale();
            return $next($request);
        });
    }

    protected function renderOutput() {
        $this->vars = Arr::add($this->vars, 'content', $this->content);

        $menu = $this->getMenu();
        $this->sidebar = view('Admin::layouts.parts.sidebar')->with([
                'menu' => $menu,
                'user' => Auth::user(),
            ]
        )->render();

        $this->vars = Arr::add($this->vars, 'sidebar', $this->sidebar);

        return view($this->template)->with($this->vars);
    }

    private function getMenu() {

        return Menu::make('menuDashboard', function ($menu) {
            $routes = \Route::getRoutes()->getRoutes();
            foreach (MenuModel::menuByType(MenuModel::MENU_TYPE_BACKENND)->get() as $item) {
                $path = $item->path;
                if ($path && $this->checkRoute($routes, $path)) {
                    $path = route($path);
                }
                if($item->parent == 0){
                    $menu->add($item->title, $path)->id($item->id)->data('permissions', []);
                }else{
                    if($menu->find($item->parent)){
                        $menu->find($item->parent)->add($item->title, $path)->id($item->id)->data('permissions', []);
                    }
                }
            }
        })->filter(function($item){
            // to do
            return true;
        });
    }

    private function checkRoute($routes, $path) {
        foreach ($routes as $route) {
            if($route->getName() == $path){
                return true;
            }
        }
    }
}
