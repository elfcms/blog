<?php

namespace Elfcms\Blog\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Elfcms\Elfcms\Models\Form;
use Elfcms\Blog\Models\Blog;
use Elfcms\Blog\Models\BlogCategory;
use Elfcms\Blog\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Update positions for form groups.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function lineOrder(Request $request, string $type)
    {
        $types = ['blog', 'category', 'post'];

        $type = strtolower($type);

        if (!in_array($type, $types)) return false;

        if (!$request->ajax()) abort(403);

        $result = [
            'result' => 'error',
            'message' => '',
        ];

        $data = $request->all();

        if ($type == 'blog') {
            foreach ($data['lines'] as $id => $line) {
                if (empty($line['position'])) continue;
                $ib = Blog::find($id);
                if (!empty($ib)) {
                    $ib->position = $line['position'];
                    $ib->save();
                }
            }
        } elseif ($type == 'category') {
            foreach ($data['lines'] as $id => $line) {
                if (empty($line['position'])) continue;
                $cat = BlogCategory::find($id);
                if (!empty($cat)) {
                    $cat->position = $line['position'];
                    $cat->save();
                }
            }
        } elseif ($type == 'post') {
            foreach ($data['lines'] as $id => $line) {
                if (empty($line['position'])) continue;
                $post = BlogPost::find($id);
                if (!empty($post)) {
                    $post->position = $line['position'];
                    $post->save();
                }
            }
            return $data;
        }

        $result['message'] = __('elfcms::default.changes_saved');
        $result['result'] = 'success';
        return $result;
    }
}
