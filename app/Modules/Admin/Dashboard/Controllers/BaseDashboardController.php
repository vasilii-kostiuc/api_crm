<?php
/**
 * api_crm.loc - BaseController.php
 *
 * Created by Admin
 * Created on: 26.12.2021 12:31
 */

namespace app\Modules\Admin\Dashboard\Controllers;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Lavary\Menu\Menu;

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

        return Menu::make('menuRenderer', function (){

        });
    }

}
