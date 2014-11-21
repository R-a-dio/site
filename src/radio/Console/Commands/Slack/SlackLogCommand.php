<?php namespace Amelia\Radio\Console\Commands\Slack;

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
     * @var
     */
    protected $slack;

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