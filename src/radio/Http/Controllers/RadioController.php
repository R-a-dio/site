<?php namespace Amelia\Radio\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request,
    Illuminate\Routing\Controller;
use function Amelia\Radio\theme;

class RadioController extends Controller {
    use ValidatesRequests;

    /**
     * @var string
     */
    protected $layout;

    /**
     * Set up our layout before anything else.
     *
     * @return void
     */
    public function setupLayout() {
        if ( ! is_null($this->layout)) {
            if ($this->checkForAjax())
                $this->layout = view("radio::ajax");

            $this->layout = view($this->layout);


        }
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters) {
        $this->setupLayout();

        $response = call_user_func_array($method, $parameters);

        if (is_null($response) and ! is_null($this->layout))
            $response = $this->layout;

        return $response;
    }

    /**
     * Check if we're being accessed by an AJAX view,
     * and if so return a Jsonable AJAX view.
     *
     * @return bool
     */
    protected function checkForAjax() {
        $request = app("request");
        return ($request->ajax() or $request->wantsJson());
    }
}