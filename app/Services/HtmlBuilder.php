<?php

namespace App\Services;

use Illuminate\Support\Str;

class HtmlBuilder extends \Collective\Html\HtmlBuilder
{
    /**
     * @param string $uri
     * @param array|null $attributes
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkCreate(string $uri, array $attributes = null)
    {
        if (auth()->user()->can('create ' . $uri)) {
            $html = '<a href="' . route($uri . '.create') . '" class="btn btn-success btn-sm" rel="content" ' . $this->attributes($attributes) . '><i class="fa fa-plus"></i> ' . __('label.create') . '</a>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @param $label
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkUpdate(string $uri, $parameter, $label)
    {
        if (auth()->user()->can('edit ' . $uri)) {
            $html = '<a href="' . route($uri . '.edit', $parameter) . '" class="btn btn-info btn-xs" title="' . __('label.update_message', ['label' => $label]) . '" rel="action"><i class="fa fa-edit"></i></a>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @param $label
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkDelete(string $uri, $parameter, $label)
    {
        if (auth()->user()->can('destroy ' . $uri)) {
            $html = '<a href="' . route($uri . '.destroy', $parameter) . '" class="btn btn-danger btn-xs" title="' . __('label.delete_message', ['label' => $label]) . '" rel="delete"><i class="fa fa-remove"></i></a>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param array|null $actions
     * @param $parameter
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkActions(array $actions = null, $parameter)
    {
        $can = 0;
        $link = '';

        if (is_array($actions)) {
            foreach ($actions as $action) {
                if (Str::contains($action['url'], '.')) {
                    $url = $this->url->route($action['url'], $parameter);
                } elseif (Str::contains($action['url'], '@')) {
                    $url = $this->url->action($action['url'], $parameter);
                } else {
                    $url = $this->url->to($action['url'], $parameter);
                }

                if (isset($action['attributes']['class'])) {
                    $action['attributes']['class'] = $action['attributes']['class'] . ' dropdown-item';
                } else {
                    $action['attributes']['class'] = 'dropdown-item';
                }

                if (auth()->user()->can($action['permission'])) {
                    $link .= '<a href="' . $url . '" ' . $this->attributes($action['attributes']) . '>' . $action['label'] . '</a>';
                    ++$can;
                }
            }
        }

        if ($can > 0) {
            $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';
            $html .= $link;
            $html .= '</div></button>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkResource(string $uri, $parameter)
    {
        if (auth()->user()->can('show ' . $uri) || auth()->user()->can('edit ' . $uri) || auth()->user()->can('destroy ' . $uri)) {
            $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';

            if (auth()->user()->can('show ' . $uri)) {
                $html .= '<a href="' . route($uri . '.show', $parameter['id']) . '" class="dropdown-item" rel="content" title="' . __('label.show_message', ['label' => $parameter['label']]) . '">' . __('label.show_message', ['label' => $parameter['label']]) . '</a>';
            }

            if (auth()->user()->can('edit ' . $uri)) {
                $html .= '<a href="' . route($uri . '.edit', $parameter['id']) . '" class="dropdown-item" rel="action" title="' . __('label.update_message', ['label' => $parameter['label']]) . '">' . __('label.update_message', ['label' => $parameter['label']]) . '</a>';
            }

            if (auth()->user()->can('destroy ' . $uri)) {
                $html .= '<a href="' . route($uri . '.destroy', $parameter['id']) . '" class="dropdown-item" rel="delete" title="' . __('label.delete_message', ['label' => $parameter['label']]) . '">' . __('label.delete_message', ['label' => $parameter['label']]) . '</a>';
            }

            $html .= '</div></button>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkUpdateDelete(string $uri, $parameter)
    {
        if (auth()->user()->can('edit ' . $uri) || auth()->user()->can('destroy ' . $uri)) {
            $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';

            if (auth()->user()->can('edit ' . $uri)) {
                $html .= '<a href="' . route($uri . '.edit', $parameter['id']) . '" class="dropdown-item" rel="action" title="' . __('label.update_message', ['label' => $parameter['label']]) . '">' . __('label.update_message', ['label' => $parameter['label']]) . '</a>';
            }

            if (auth()->user()->can('destroy ' . $uri)) {
                $html .= '<a href="' . route($uri . '.destroy', $parameter['id']) . '" class="dropdown-item" rel="delete" title="' . __('label.delete_message', ['label' => $parameter['label']]) . '">' . __('label.delete_message', ['label' => $parameter['label']]) . '</a>';
            }

            $html .= '</div></button>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkUpdateShow(string $uri, $parameter)
    {
        if (auth()->user()->can('edit ' . $uri) || auth()->user()->can('destroy ' . $uri)) {
            $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';

            if (auth()->user()->can('show ' . $uri)) {
                $html .= '<a href="' . route($uri . '.show', $parameter['id']) . '" class="dropdown-item" rel="content" title="' . __('label.show_message', ['label' => $parameter['label']]) . '">' . __('label.show_message', ['label' => $parameter['label']]) . '</a>';
            }
            
            if (auth()->user()->can('edit ' . $uri)) {
                $html .= '<a href="' . route($uri . '.edit', $parameter['id']) . '" class="dropdown-item" rel="action" title="' . __('label.update_message', ['label' => $parameter['label']]) . '">' . __('label.update_message', ['label' => $parameter['label']]) . '</a>';
            }

            $html .= '</div></button>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkShow(string $uri, $parameter)
    {
        if (auth()->user()->can('show ' . $uri)) {
            $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';

            if (auth()->user()->can('show ' . $uri)) {
                $html .= '<a href="' . route($uri . '.show', $parameter['id']) . '" class="dropdown-item" rel="content" title="' . __('label.show_message', ['label' => $parameter['label']]) . '">' . __('label.show_message', ['label' => $parameter['label']]) . '</a>';
            }

            $html .= '</div></button>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }

    /**
     * @param string $uri
     * @param $parameter
     * @return array|\Illuminate\Contracts\Translation\Translator|\Illuminate\Support\HtmlString|string|\Underscore\Underscore|null
     */
    public function linkShowDelete(string $uri, $parameter)
    {
        if (auth()->user()->can('show ' . $uri)) {
            $html = '<div class="btn-group"><button class="btn btn-default">' . __('label.action') . '</button><button class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown"><span class="sr-only"></span><div class="dropdown-menu" role="menu">';

            if (auth()->user()->can('show ' . $uri)) {
                $html .= '<a href="' . route($uri . '.show', $parameter['id']) . '" class="dropdown-item" rel="content" title="' . __('label.show_message', ['label' => $parameter['label']]) . '">' . __('label.show_message', ['label' => $parameter['label']]) . '</a>';
            }

            if (auth()->user()->can('destroy ' . $uri)) {
                $html .= '<a href="' . route($uri . '.destroy', $parameter['id']) . '" class="dropdown-item" rel="delete" title="' . __('label.delete_message', ['label' => $parameter['label']]) . '">' . __('label.delete_message', ['label' => $parameter['label']]) . '</a>';
            }

            $html .= '</div></button>';

            return $this->toHtmlString($html);
        }

        return __('label.no_action');
    }
}