<?php namespace Amelia\Radio\Services\Slack;

use Illuminate\Contracts\Config\Repository;

class SlackService {

    /**
     * Username for the slack bot
     *
     * @var string
     */
    protected $username = "R/a/dio";

    /**
     * @var array
     */
    protected $lines = [];

    /**
     * Channel to post to
     *
     * @var string
     */
    protected $channel;

    /**
     * Slack api token
     *
     * @var string
     */
    protected $token;

    /**
     * Pending array to send to slack
     *
     * @var array
     */
    protected $request;

    /**
     * Application config
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->channel = $config->get("radio::slack.channels.default");
        $this->username = $config->get("radio::slack.username");
        $this->token = $config->get("radio::slack.token");
    }

    public function log($text)
    {
        $channel = $this->config->get("radio::slack.channels.logs");
        $this->text($text, $channel);
    }

    public function post($title, $attachments = [])
    {

    }

    public function text($text)
    {
        $this->post($text);
    }
}
