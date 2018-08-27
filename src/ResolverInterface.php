<?php

namespace Resque;

use \Exception;

/**
 * ResolverInterface
 *
 * Implement this to use a custom class class loader; that is, dynamically
 * load job class given it's enqueued class name.
 */
interface ResolverInterface
{
	/**
	 * @param string $class
	 * @return Class
	 */
	public function resolveClass($class);
}
