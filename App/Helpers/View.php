<?php

namespace App\Helpers;

class View {
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
     * Render the view within the layout.
     */
    public function render(): void
    {
        require __DIR__ . '/../../env.php';

        extract($this->data);

        ob_start();
        require $this->path . $this->view . '.php';
        $viewContent = ob_get_clean();

        ob_start();
        require $this->path . 'layouts/' . $this->layout . '.php';
        $layoutContent = ob_get_clean();

        echo str_replace('@content', $viewContent, $layoutContent);
    }
}