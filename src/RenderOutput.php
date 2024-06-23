<?php

namespace Test357;

class RenderOutput {
    /**
     * Outputs data as JSON.
     *
     * @param array $data The data to output.
     * @return void
     */
    public function output(array $data): void {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Outputs an error message as JSON.
     *
     * @param string $message The error message to output.
     * @return void
     */
    public function outputError(string $message): void {
        $this->output(['error' => $message]);
    }
}
