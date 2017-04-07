<?php
/**
 * Plugin Name: WordPress Gzip Compression
 * Plugin URI: http://tribulant.com
 * Description: Enables gzip-compression if the visitor's browser can handle it. This will speed up your WordPress website drastically and reduces bandwidth usage as well. Uses the PHP ob_gzhandler() callback.
 * Version: 1.0
 * Author: James Socol
 * Author URI: http://jamessocol.com/
 */

/*

Copyright (c) 2009  James Socol  (email : me@jamessocol.com)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

add_action('init','ezgz_buffer');

function ezgz_buffer ()
{
	ob_start('ob_gzhandler');
}
