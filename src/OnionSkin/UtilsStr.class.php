<?php

namespace OnionSkin
{
	/**
	 * Utilities for strings
	 *
	 */
	class UtilsStr
	{
        /**
         * Determines whether the beginning of this string instance matches the specified string.
         * @param string $needle
         * @param string $haystack
         * @return boolean
         */
        public static function startWith($needle,$haystack)
        {
            return substr($haystack,0,strlen($needle)) === $needle;
        }


        /**
         * Determines whether the ending of this string instance matches the specified string.
         * @param string $needle
         * @param string $haystack
         * @return boolean
         */
        public static function endWith($needle,$haystack)
        {
            return substr($haystack,-strlen($needle)) === $needle;
        }
	}
}