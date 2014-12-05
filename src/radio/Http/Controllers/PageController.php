<?php namespace Amelia\Radio\Http\Controllers;

use Amelia\Radio\Repositories\News\PostRepository;
use Amelia\Radio\Repositories\Users\UserRepository;
use function Amelia\Radio\theme;
use Illuminate\Http\Request;

class PageController extends RadioController {

    /**
     * Show the homepage, with news posts.
     *
     * @param \Amelia\Radio\Repositories\News\PostRepository $posts
     */
    public function home(PostRepository $posts) {
        $news = $posts->preview();
        $this->layout->content = theme("radio::home")->with(compact("news"));
    }

    /**
     * Show the staff page
     *
     * @param \Amelia\Radio\Repositories\Users\UserRepository $users
     * @get("staff")
     */
    public function staff(UserRepository $users) {
        $staff = $users->staff();
        $this->layout->content = theme("radio::staff")->with(compact("staff"));
    }

    /**
     * Show the IRC page
     *
     * @get("irc")
     */
    public function irc() {
        $this->layout->content = theme("radio::irc");
    }


    public function lastPlayed(LastPlayedRepository $lastPlayed, Request $input) {
        $lp = $lastPlayed->paginate($input->get("page"));
        $this->layout->content = theme("radio::last-played")->with(compact("lp"));
    }
}
