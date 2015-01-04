<?php namespace Amelia\Radio\Service\Verifier;

use Illuminate\Contracts\Config\Repository;

class ExternalVerifierService implements VerifierService {

    /**
     * The name of the process to call when verifying.
     *
     * @var string
     */
    protected $process;

    /**
     * Inject dependencies
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config) {
        $this->process = $config->get("radio::verifier.process");
    }

    /**
     * Verify the given file
     *
     * @param string $file
     * @return bool
     */
    public function verify($file) {
        $result = $this->call($file);

        return $this->parse($result);
    }

    /**
     * Call the verifier via CLI
     *
     * e.g. /path/to/file/bin/verifier.py /path/to/filename.mp3
     *
     * @param string $file
     * @return string
     */
    protected function call($file) {
        return exec("{$this->process} " . escapeshellarg($file));
    }

    /**
     * Check the output from the script
     *
     * @param $result
     * @return bool
     */
    protected function parse($result) {
        $result = json_decode($result);

        return (bool) $result->ok;
    }
}
