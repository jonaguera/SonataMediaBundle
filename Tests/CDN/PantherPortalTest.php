<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\MediaBundle\Tests\CDN;

use Sonata\MediaBundle\CDN\PantherPortal;
use Sonata\MediaBundle\Tests\Helpers\PHPUnit_Framework_TestCase;

class PantherPortalTest extends PHPUnit_Framework_TestCase
{
    public function testPortal()
    {
        $client = $this->createMock(
            'Sonata\MediaBundle\Tests\CDN\ClientSpy',
            array('flush'),
            array(),
            '',
            false
        );
        $client->expects($this->exactly(3))->method('flush')->will($this->returnValue('Flush successfully submitted.'));

        $panther = new PantherPortal('/foo', 'login', 'pass', 42);
        $panther->setClient($client);

        $this->assertSame('/foo/bar.jpg', $panther->getPath('bar.jpg', true));

        $path = '/mypath/file.jpg';

        $panther->flushByString($path);
        $panther->flush($path);
        $panther->flushPaths(array($path));
    }

    public function testException()
    {
        $this->setExpectedException('\RuntimeException', 'Unable to flush : Failed!!');

        $client = $this->createMock(
            'Sonata\MediaBundle\Tests\CDN\ClientSpy',
            array('flush'),
            array(),
            '',
            false
        );
        $client->expects($this->exactly(1))->method('flush')->will($this->returnValue('Failed!!'));

        $panther = new PantherPortal('/foo', 'login', 'pass', 42);
        $panther->setClient($client);

        $panther->flushPaths(array('boom'));
    }
}

class ClientSpy
{
    public function flush()
    {
    }
}
