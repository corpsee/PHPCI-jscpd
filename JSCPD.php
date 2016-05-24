<?php

namespace SergiuParaschiv\PHPCI\Plugin;

use PHPCI;
use PHPCI\Builder;
use PHPCI\Model\Build;

class JSCPD implements \PHPCI\Plugin
{
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->build = $build;
        $this->directory = '';
        $this->command = '';
        $this->data_offset = 0;

        if (isset($options['directory'])) {
            $this->directory = $options['directory'];
        }

        if (isset($options['command'])) {
            $this->command = $options['command'];
        }

        if (isset($options['data_offset'])) {
            $this->data_offset = $options['data_offset'];
        }
    }

    public function execute()
    {
        if (empty($this->command)) {
            $this->phpci->logFailure('Configuration command not found.');
            return false;
        }

        if (empty($this->directory)) {
            $this->phpci->logFailure('Configuration directory not found.');
            return false;
        }

        // $this->phpci->logExecOutput(false);

        $cmd = 'cd ' . $this->directory . '; ' . $this->command;
        $this->phpci->executeCommand($cmd);
        $output = $this->phpci->getLastOutput();

        var_dump($output);

        // if($this->data_offset) {
        //     $output = implode("\n", array_slice(explode("\n", $output), $this->data_offset));
        // }

        // list($errors, $warnings) = $this->processReport($output);
        //
        // $this->phpci->logExecOutput(true);
        //
        // if ($this->allowed_warnings != -1 && $warnings > $this->allowed_warnings) {
        //     $success = false;
        // }
        //
        // if ($this->allowed_errors != -1 && $errors > $this->allowed_errors) {
        //     $success = false;
        // }

        return true;
    }

    // protected function processReport($output)
    // {
    //     $data = json_decode(trim($output));
    //
    //     if (!is_array($data)) {
    //         $this->phpci->log($output);
    //         throw new \Exception(Lang::get('could_not_process_report'));
    //     }
    //
    //     $errors = 0;
    //     $warnings = 0;
    //
    //     foreach ($data as $file) {
    //         $fileName = str_replace($this->phpci->buildPath, '', $file->filePath);
    //
    //         $errors += $file->errorCount;
    //         $warnings = $file->warningCount;
    //
    //         foreach ($file->messages as $message) {
    //             $this->build->reportError(
    //                 $this->phpci,
    //                 'phplint_errors',
    //                 'ESLINT: ' . $message->message . "\n" . $message->source,
    //                 $message->severity == 2 ? BuildError::SEVERITY_HIGH : BuildError::SEVERITY_LOW,
    //                 $fileName,
    //                 $message->line
    //             );
    //         }
    //     }
    //
    //     return array($errors, $warnings);
    // }
}
