<?php

namespace Taisiya\PropelBundle\Database;

abstract class Index implements IndexInterface
{
    use IndexTrait;

    /**
     * @param \DOMDocument $dom
     * @param \DOMElement  $table
     */
    public function appendToXmlDocument(\DOMDocument $dom, \DOMElement $table): void
    {
        $index = $dom->createElement('index');
        $index->setAttribute('name', $this::getName());

        /** @var IndexColumn $indexColumn */
        foreach ($this->getColumns() as $indexColumn) {
            $indexColumn->appendToXmlDocument($dom, $index);
        }

        $table->appendChild($index);
    }
}
