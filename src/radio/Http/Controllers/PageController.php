<?php namespace Amelia\Radio\Http\Controllers;

use Amelia\Radio\Repositories\News\PostRepository;
use function Amelia\Radio\theme;

class PageController extends RadioController {

    /**
     * Show the homepage, with news posts.
     *
     * @param \Amelia\Radio\Repositories\News\PostRepository $posts
     */
    public function home(PostRepository $posts) {
        $news = $posts->preview();
        $this->layout->content = theme("radio::home")->with(compact($news));
    }
}
