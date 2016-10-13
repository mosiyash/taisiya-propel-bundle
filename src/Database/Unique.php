<?php

namespace Taisiya\PropelBundle\Database;

abstract class Unique extends Index
{
    /**
     * @param \DOMDocument $dom
     * @param \DOMElement $table
     */
    public function appendToXmlDocument(\DOMDocument $dom, \DOMElement $table): void
    {
        $uniqueIndex = $dom->createElement('unique');
        $uniqueIndex->setAttribute('name', $this::getName());

        /** @var IndexColumn $indexColumn */
        foreach ($this->getColumns() as $indexColumn) {
            $indexColumn->appendToXmlDocument($dom, $uniqueIndex);
        }

        $table->appendChild($uniqueIndex);
    }
}
