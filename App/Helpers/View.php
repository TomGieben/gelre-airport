<?php

namespace App\Helpers;

class View
{
    private string $path = __DIR__ . '/../../views/';
    private string $view;
    private array $data;
    private string $layout;

    /**
     * Create a new View instance.
     *
     * @param string $view The view file to render.
     * @param array $data The data to pass to the view.
     */
    public function __construct(string $view, array $data = [], string $layout = 'app')
    {
        $this->view = $view;
        $this->data = $data;
        $this->layout = $layout;

        $this->checkIfExists($this->view);
        $this->checkIfExists($this->layout, true);
        $this->render();
    }

    /**
     * Check if the view file exists.
     */
    private function checkIfExists(string $file, bool $isLayout = false): void
    {
        $filePath = $isLayout ? $this->path . 'layouts/' . $file . '.php' : $this->path . $file . '.php';

        if (!file_exists($filePath)) {
            throw new \Exception(($isLayout ? "Layout" : "View") . " {$file} not found.");
        }
    }

    /**
     * Make the parameters safe to use in the view.
     * 
     * @param array $data The data to make safe.
     * @return array The safe data.
     */
    private function safeParameters(array $data): array
    {
        $safeData = [];

        foreach ($data as $key => $value) {
            if (!is_string($value)) {
                $safeData[$key] = $value;
                continue;
            }

            $safeData[$key] = htmlspecialchars($value);
        }

        return $safeData;
    }

    /**
     * Render the view within the layout.
     */
    public function render(): void
    {
        extract($this->safeParameters($this->data));

        ob_start();
        require $this->path . $this->view . '.php';
        $viewContent = ob_get_clean();

        ob_start();
        require $this->path . 'layouts/' . $this->layout . '.php';
        $layoutContent = ob_get_clean();

        echo str_replace('@content', $viewContent, $layoutContent);
    }
}
