<?php namespace Amelia\Radio\Http\Controllers;

use Amelia\Radio\Repositories\LastPlayed\LastPlayedRepository,
    Amelia\Radio\Repositories\News\PostRepository,
    Amelia\Radio\Repositories\Queue\QueueRepository,
    Amelia\Radio\Repositories\Users\UserRepository;
use Illuminate\Http\Request;
use function Amelia\Radio\theme;

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

    /**
     * Show the last played songs
     *
     * @param \Amelia\Radio\Repositories\LastPlayed\LastPlayedRepository $lastPlayed
     * @param \Illuminate\Http\Request                                   $input
     * @get("last-played")
     */
    public function lastPlayed(LastPlayedRepository $lastPlayed, Request $input) {
        $lp = $lastPlayed->paginate($input->get("page", 0));
        $this->layout->content = theme("radio::last-played")->with(compact("lp"));
    }

    /**
     * Show the queue page
     *
     * @param \Amelia\Radio\Repositories\Queue\QueueRepository $queue
     * @get("queue")
     */
    public function queue(QueueRepository $queue) {
        $queue = $queue->get();
        $this->layout->content = theme("radio::last-played")->with(compact("queue"));
    }
}
