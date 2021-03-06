<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\MediaBundle\Tests\Form\Type;

use Sonata\MediaBundle\Form\Type\ApiMediaType;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class ApiMediaTypeTest extends AbstractTypeTest
{
    public function testBuildForm()
    {
        parent::testBuildForm();
        $provider = $this->getMock('Sonata\MediaBundle\Provider\MediaProviderInterface');

        $mediaPool = $this->getMockBuilder('Sonata\MediaBundle\Provider\Pool')->disableOriginalConstructor()->getMock();
        $mediaPool->expects($this->once())->method('getProvider')->will($this->returnValue($provider));

        $type = new ApiMediaType($mediaPool, 'testclass');

        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $builder->expects($this->once())->method('addModelTransformer');

        $type->buildForm($builder, array('provider_name' => 'sonata.media.provider.image'));
    }

    protected function getTestedInstance()
    {
        return new ApiMediaType($this->mediaPool, 'testclass');
    }
}
