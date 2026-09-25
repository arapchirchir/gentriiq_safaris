<?php

namespace App\Actions;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;

class RenderRichText
{
    public function __invoke(?string $content): string
    {
        if ($content === null || $content === '') {
            return '';
        }

        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);

        try {
            $document->loadHTML('<?xml encoding="UTF-8"><body>'.$content.'</body>', LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        $body = $document->getElementsByTagName('body')->item(0);

        return $body ? $this->renderNode($body) : '';
    }

    private function renderNode(DOMNode $node): string
    {
        if ($node instanceof DOMText) {
            return e($node->textContent);
        }

        if (! $node instanceof DOMElement) {
            return '';
        }

        $tag = strtolower($node->tagName);

        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'svg', 'math', 'template'], true)) {
            return '';
        }

        $content = '';

        foreach ($node->childNodes as $child) {
            $content .= $this->renderNode($child);
        }

        // Rebuild supported formatting; never copy source attributes or executable markup.
        if (in_array($tag, ['p', 'h2', 'h3', 'strong', 'b', 'em', 'i', 'ul', 'ol', 'li', 'blockquote', 'code', 'pre', 's', 'u'], true)) {
            return '<'.$tag.'>'.$content.'</'.$tag.'>';
        }

        if (in_array($tag, ['br', 'hr'], true)) {
            return '<'.$tag.'>';
        }

        return $content;
    }
}
