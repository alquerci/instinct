<?php

namespace Instinct\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class InstinctUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
