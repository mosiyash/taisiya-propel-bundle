<?php

namespace Taisiya\PropelBundle;

/**
 * @target \PHPUnit_Framework_Assert
 */
trait XMLAssertsTrait
{
    /**
     * @param string|\DOMDocument $xml
     * @param string              $version
     * @param string              $encoding
     * @param string              $message
     */
    public function assertXmlHasProlog($xml, $version = '1.0', $encoding = 'UTF-8', string $message = ''): void
    {
        $this->assertSame(0, strpos($xml, '<?xml version="'.$version.'" encoding="'.$encoding.'"?>'), $message);
    }

    /**
     * @param string|\DOMDocument $xml
     * @param string              $query
     * @param int|null            $count
     * @param string              $message
     */
    public function assertXmlHasElements($xml, string $query, int $count = null, string $message = '')
    {
        if ($message === '') {
            $message = 'XML has elements (XPath query is \''.$query.'\')';
        }

        $xpath = $this->toXPath($xml);
        $list  = $xpath->query($query);

        if ($count === null) {
            $this->assertGreaterThan(0, $list->length, $message);
        } else {
            $this->assertSame($count, $list->length, $message);
        }
    }

    /**
     * @param string|\DOMDocument $xml
     *
     * @throws \InvalidArgumentException
     *
     * @return \DOMXPath
     */
    private function toXPath($xml): \DOMXPath
    {
        if ($xml instanceof \DOMDocument) {
            $dom = $xml;
        } elseif (is_string($xml)) {
            $dom = new \DOMDocument('1.0', 'UTF-8');
            if (!$dom->loadXML($xml)) {
                throw new \InvalidArgumentException('Couldn\'t load XML string to DOM object');
            }
        } else {
            throw new \InvalidArgumentException('XML must be a string or DOMDocument');
        }

        return new \DOMXPath($dom);
    }
}
