<?php

namespace App\Markdown\Hint;

use Illuminate\Support\Facades\File;
use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Node\StringContainerInterface;

class Hint extends AbstractBlock implements StringContainerInterface
{
    private ?string $header = '';

    protected string $literal;

    public function getTitle(): ?string
    {
        $words = $this->getHeaderWords();
        $type = $this->getType();

        if (count($words) > 1) {
            array_shift($words);

            return implode(' ', $words);
        }

        if ($type == 'caution') {
            return __('hints.caution');
        }

        if ($type == 'important') {
            return __('hints.important');
        }

        if ($type == 'note') {
            return __('hints.note');
        }

        if ($type == 'tip') {
            return __('hints.tip');
        }

        if ($type == 'warning') {
            return __('hints.warning');
        }

        return null;
    }

    public function getType(): ?string
    {
        $words = $this->getHeaderWords();

        if (count($words) > 0) {
            return $words[0];
        }

        return null;
    }

    public function getIcon(): ?string
    {
        $type = $this->getType();

        if ($type == 'caution') {
            return $this->getSvgHtml('hint/hint-caution');
        }

        if ($type == 'important') {
            return $this->getSvgHtml('hint/hint-important');
        }

        if ($type == 'note') {
            return $this->getSvgHtml('hint/hint-note');
        }

        if ($type == 'tip') {
            return $this->getSvgHtml('hint/hint-tip');
        }

        if ($type == 'warning') {
            return $this->getSvgHtml('hint/hint-warning');
        }

        return null;
    }

    public function getSvgHtml(string $path): ?string
    {
        return File::exists(resource_path("svg/{$path}.svg")) ? File::get(resource_path("svg/{$path}.svg")) : '';
    }

    public function getHeaderWords(): array
    {
        return \preg_split('/\s+/', $this->header ?? '') ?: [];
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function setLiteral(string $literal): void
    {
        $this->literal = $literal;
    }

    public function getLiteral(): string
    {
        return $this->literal;
    }
}
