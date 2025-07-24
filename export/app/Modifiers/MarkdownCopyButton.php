<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class MarkdownCopyButton extends Modifier
{
    /**
     * Modify a value.
     *
     * @param  mixed  $value  The value to be modified
     * @param  array  $params  Any parameters used in the modifier
     * @param  array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {

        $buttonHtml = trim(view('docs.partials.copy_code')->render());

        // Match <pre> that contains <code> anywhere inside (non-greedy)
        // and inject button before the closing </pre>
        return preg_replace_callback('/(<pre\b[^>]*>.*?<code\b[^>]*>.*?<\/code>.*?)(<\/pre>)/is', function ($matches) use ($buttonHtml) {
            return $matches[1].$buttonHtml.$matches[2];
        }, $value);
    }
}
