<?php namespace Amelia\Radio\Console\Commands\Slack;

use Amelia\Radio\Services\Slack\SlackService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SlackLogCommand extends Command {

    /**
     * Name of the command
     *
     * @var string
     */
    protected $name = "slack:log";

    /**
     * Command Description
     *
     * @var string
     */
    protected $description = "Send a log to slack";

    /**
     * @var \Amelia\Radio\Services\Slack\SlackService
     */
    protected $slack;

    /**
     * Create a new slack command with a slack service.
     *
     * @param \Amelia\Radio\Services\Slack\SlackService $slack
     */
    public function __construct(SlackService $slack) {
        $this->slack = $slack;
        parent::__construct();
    }

    /**
     * Execute the command.
     */
    public function fire()
    {
        $this->slack->log($this->argument("text"));
    }

    /**
     * Get arguments for this command
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            ["text", InputArgument::REQUIRED, "Log message to send", null]
        ];
    }

    /**
     * Get options (--option) for this command
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }
}