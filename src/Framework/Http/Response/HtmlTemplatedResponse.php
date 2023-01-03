<?php
/** @noinspection PhpUnusedPrivateMethodInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace Ddd\Framework\Http\Response;

use Ddd\Framework\Exception\FrameworkException;

final class HtmlTemplatedResponse implements Response
{
    public function __construct(private readonly string $templateName, private readonly array $params  = [])
    {
    }

    public function render()
    {
        $path = $this->path($this->templateName);

        ob_start();

        try {
            extract(($params = $this->params));
            include $path;
        } catch (\Throwable $throwable) {
            ob_end_clean();
            throw $throwable;
        }

        $renderedResult = ob_get_clean();
        echo $renderedResult;
    }

    private function path(string $templateName): string
    {
        $path = __DIR__ . '/../../../../templates/' . $templateName;

        if (!file_exists($path)) {
            throw new FrameworkException("Template $templateName do not exist!");
        }

        return $path;
    }
}