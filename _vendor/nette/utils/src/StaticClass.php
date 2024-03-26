<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette;


/**
 * Static class.
 */
trait StaticClass
{
	/**
<<<<<<< HEAD
	 * @return never
	 * @throws \Error
	 */
	final public function __construct()
	{
		throw new \Error('Class ' . static::class . ' is static and cannot be instantiated.');
=======
	 * Class is static and cannot be instantiated.
	 */
	final private function __construct()
	{
>>>>>>> 8545c672bd290d38922760fe75108e83faedae85
	}


	/**
	 * Call to undefined static method.
	 * @throws MemberAccessException
	 */
	public static function __callStatic(string $name, array $args): mixed
	{
		Utils\ObjectHelpers::strictStaticCall(static::class, $name);
	}
}
