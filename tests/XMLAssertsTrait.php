<?php

namespace Taisiya\PropelBundle;

/**
 * @target PHPUnit_Framework_Assert
 */
trait XMLAssertsTrait
{
    public function assertXmlHasProlog(string $xml, $version = '1.0', $encoding = 'UTF-8', $message = ''): void
    {
        $this->assertSame(0, strpos($xml, '<?xml version="'.$version.'" encoding="'.$encoding.'"?>'), $message);
    }
}
