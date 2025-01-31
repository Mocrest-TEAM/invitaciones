<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license https://opensource.org/licenses/MIT MIT
 *
 */
namespace Aura\Sql\Parser;

/**
 *
 * Parsing/rebuilding functionality for the sqlite driver.
 *
 * @package Aura.Sql
 *
 */
class SqliteParser extends AbstractParser
{
    /**
     * {@inheritDoc}
     */
    protected $split = [
        // single-quoted string
        "'(?:[^'\\\\]|\\\\'?)*'",
        // double-quoted string
        '"(?:[^"\\\\]|\\\\"?)*"',
        // backticked column names
        '`(?:[^`\\\\]|\\\\`?)*`', 
    ];
  
    /**
     * {@inheritDoc}
     */
    protected $skip = '/^(\'|"|`|\:[^a-zA-Z_])/um';
}
