<?php

namespace App\Markdown\Hint;

use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Util\ArrayCollection;

class HintParser extends AbstractBlockContinueParser implements BlockContinueParserInterface
{
    /** @psalm-readonly */
    private Hint $block;

    /** @var ArrayCollection<string> */
    private ArrayCollection $strings;

    public function __construct(?string $header)
    {
        $this->block = new Hint;
        $this->block->setHeader($header);
        $this->strings = new ArrayCollection;
    }

    public function getBlock(): Hint
    {
        return $this->block;
    }

    public function isContainer(): bool
    {
        return true;
    }

    public function canContain(AbstractBlock $childBlock): bool
    {
        return true;
    }

    public function canHaveLazyContinuationLines(): bool
    {
        return false;
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        if ($cursor->getLine() === ':::') {
            return BlockContinue::finished();
        }

        return BlockContinue::at($cursor);
    }
}
