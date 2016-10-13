<?php

namespace Taisiya\PropelBundle\Database;

interface IndexInterface
{
    /**
     * The index name.
     * @return string
     */
    public static function getName(): string;

    /**
     * @param \DOMDocument $dom
     * @param \DOMElement $table
     */
    public function appendToXmlDocument(\DOMDocument $dom, \DOMElement $table): void;
}
