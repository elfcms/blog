<?php

namespace Elfcms\Blog\View\Components;

use Elfcms\Blog\Models\Blog as Blog;
use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class Posts extends Component
{
    public $blog, $theme, $params;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($blog, $theme='default', $params = [])
    {
        if (is_numeric($blog)) {
            $blog = intval($blog);
            $blog = Blog::with('posts')->find($blog);
        }
        elseif (gettype($blog) == 'string') {
            $blog = Blog::where('slug',$blog)->with('posts')->first();
        }
        $this->blog = $blog;
        $this->theme = $theme;
        $this->params = $params;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (View::exists('components.blog.' . $this->theme)) {
            return view('components.blog.' . $this->theme);
        }
        if (View::exists('blog.components.blog.' . $this->theme)) {
            return view('blog.components.blog.' . $this->theme);
        }
        if (View::exists('blog::components.blog.' . $this->theme)) {
            return view('blog::components.blog.' . $this->theme);
        }
        if (View::exists('elfcms.components.blog.' . $this->theme)) {
            return view('elfcms.components.blog.' . $this->theme);
        }
        if (View::exists('elfcms.blog.components.blog.' . $this->theme)) {
            return view('elfcms.blog.components.blog.' . $this->theme);
        }
        if (View::exists('elfcms.modules.blog.components.blog.' . $this->theme)) {
            return view('elfcms.modules.blog.components.blog.' . $this->theme);
        }
        if (View::exists('elfcms::blog.components.blog.' . $this->theme)) {
            return view('elfcms::blog.components.blog.' . $this->theme);
        }
        if (View::exists($this->theme)) {
            return view($this->theme);
        }
        return null;
    }
}
