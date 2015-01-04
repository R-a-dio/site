<?php namespace Amelia\Radio\Service\Verifier;

interface VerifierService {

    /**
     * Verify the given file
     *
     * @param string $file
     * @return bool
     */
    public function verify($file);
}
