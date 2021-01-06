<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class Navbar
{
    /**
     * @var array
     */
    protected $navbar = [];

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $uri_exceptions = ['home', 'login', 'logout'];

    /**
     * @var string
     */
    protected $nav_format = '<i class="nav-icon %s"></i> %s';

    /**
     * @var string
     */
    protected $item_format = '<li class="nav-item %s">%s</li>';

    /**
     * @var string
     */
    protected $anchor_format = '<a href="%s" class="nav-link %s" %s>%s</a>';

    /**
     * @var string
     */
    protected $child_format = '<ul class="nav nav-treeview" style="margin-left:5px;">%s</ul>';

    /**
     * Navbar constructor.
     */
    public function __construct()
    {
        $this->setAvailableRoutes();
        $this->setUserNavbar();
    }

    /**
     * @param array|null $navbar
     * @param int $level
     * @return string
     */
    public function render(array $navbar = null): string
    {
        $navbar = !is_null($navbar) ? $navbar : $this->navbar;
        $html = '';
        $currentnav = request()->segment(1);

        foreach ($navbar as $nav) {
            $child_html = '';
            $has_childs = count($nav['childs']);
            $uri = Str::contains($nav['uri'], 'index') ? route($nav['uri']) :
                (Str::contains($nav['uri'], 'javascript') ? $nav['uri'] : url('/' . $nav['uri']));
            $title = sprintf(
                $this->nav_format,
                (!is_null($nav['icon']) ? $nav['icon'] : 'fas fa-circle-o'),
                '<p>' . $nav['label'] . ($has_childs ? '<i class="right fas fa-angle-left"></i>' : '') . '</p>'
            );

            if ($has_childs) {
                $child_html = sprintf($this->child_format, $this->render($nav['childs']));
            }

            $anchor = sprintf(
                $this->anchor_format,
                $uri,
                ($uri === url('/' . $currentnav) || $this->isChildActive($currentnav, $nav['id']) ? 'active' : ''),
                (!Str::contains($uri, '#') ? 'rel="page-content"' : ''),
                $title
            ) . $child_html;
            $html .= sprintf(
                $this->item_format,
                ($has_childs ? 'has-treeview ' . ($this->isChildActive($currentnav, $nav['id']) ? 'menu-open' : '') : ''),
                $anchor
            );
        }

        return $html;
    }

    /**
     *
     */
    protected function setAvailableRoutes()
    {
        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri();

            if ($route->methods()[0] === 'GET' && !in_array($uri, $this->uri_exceptions) && !Str::startsWith($uri, '/')) {
                $this->routes[$uri] = !empty($route->getName()) ? $route->getName() : $uri;
            }
        }
    }

    /**
     *
     */
    protected function setUserNavbar()
    {
        foreach (\Modules\HakAkses\Entities\Role::findByName(auth()->user()->roles->first()->name)->modules->where('visible', 1) as $access) {
//        foreach (\App\Entities\Module::where('visible', 1)->orderBy('sequence')->get() as $access) {
            if (isset($this->routes[$access->uri]) || Str::contains($access->uri, '#')) {
                $structure = [
                    'id' => $access->id, 'label' => $access->label,
                    'icon' => $access->icon, 'parent_module' => $access->parent_module,
                    'childs' => []
                ];
                $structure['uri'] = isset($this->routes[$access->uri]) ? $this->routes[$access->uri] : $access->uri;

                if (!is_null($access->parent_module)) {
                    $childs = \Illuminate\Support\Arr::where($this->navbar, function ($value, $key) use ($access) {
                        if ($value['id'] === $access->parent_module) {
                            return $value;
                        }
                    });

                    if (!empty($childs)) {
                        array_push($this->navbar[key($childs)]['childs'], $structure);
                    }
                } else {
                    $this->navbar[] = $structure;
                }
            }
        }
    }

    /**
     * @return string
     */
    protected function isChildActive($current, $parentId)
    {
        $access = \Modules\HakAkses\Entities\Role::findByName(auth()->user()->roles->first()->name)->modules->where('visible', 1);
//        $access = \App\Entities\Module::where('visible', 1)->orderBy('sequence')->get();
        $mappedNav = $access->mapToGroups(function ($item, $key) {
            return [
                [
                    'id' => $item['id'],
                    'uri' => Str::contains($item['uri'], 'index') ? str_replace('.index', '', $item['uri']) : $item['uri'],
                    'parent_module' => $item['parent_module'],
                ]
            ];
        })[0]->firstWhere('uri', $current);
        $mappedParentId = isset($mappedNav['parent_module']) ? $mappedNav['parent_module'] : null;

        return !is_null($mappedParentId) && $mappedParentId === $parentId ? ' active' : '';
    }
}
