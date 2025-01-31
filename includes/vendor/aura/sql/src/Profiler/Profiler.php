<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license https://opensource.org/licenses/MIT MIT
 *
 */
namespace Aura\Sql\Profiler;

use Aura\Sql\Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 *
 * Sends query profiles to a logger.
 *
 * @package Aura.Sql
 *
 */
class Profiler implements ProfilerInterface
{
    /**
     *
     * The current profile information.
     *
     * @var array
     *
     */
    protected $context = [];

    /**
     *
     * Log profile data through this interface.
     *
     * @var LoggerInterface
     *
     */
    protected $logger;

    /**
     *
     * Turns profile logging off and on.
     *
     * @var bool
     *
     * @see setActive()
     *
     */
    protected $active = false;

    /**
     *
     * The log level for all messages.
     *
     * @var string
     *
     * @see setLogLevel()
     *
     */
    protected $logLevel = LogLevel::DEBUG;

    /**
     *
     * Sets the format for the log message, with placeholders.
     *
     * @var string
     *
     * @see setLogFormat()
     *
     */
    protected $logFormat = "{function} ({duration} seconds): {statement} {backtrace}";

    /**
     *
     * Constructor.
     *
     * @param LoggerInterface $logger Record profiles through this interface.
     *
     */
    public function __construct(LoggerInterface $logger = null)
    {
        if ($logger === null) {
            $logger = new MemoryLogger();
        }
        $this->logger = $logger;
    }

    /**
     *
     * Enable or disable profiler logging.
     *
     * @param bool $active
     *
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;
    }

    /**
     *
     * Returns true if logging is active.
     *
     * @return bool
     *
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     *
     * Returns the underlying logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     *
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * Returns the level at which to log profile messages.
     *
     * @return string
     *
     */
    public function getLogLevel()
    {
        return $this->logLevel;
    }

    /**
     *
     * Level at which to log profile messages.
     *
     * @param string $logLevel A PSR LogLevel constant.
     *
     * @return null
     *
     */
    public function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;
    }

    /**
     *
     * Returns the log message format string, with placeholders.
     *
     * @return string
     *
     */
    public function getLogFormat()
    {
        return $this->logFormat;
    }

    /**
     *
     * Sets the log message format string, with placeholders.
     *
     * @param string $logFormat
     *
     * @return null
     *
     */
    public function setLogFormat($logFormat)
    {
        $this->logFormat = $logFormat;
    }

    /**
     *
     * Starts a profile entry.
     *
     * @param string $function The function starting the profile entry.
     *
     * @return null
     *
     */
    public function start($function)
    {
        if (! $this->active) {
            return;
        }

        $this->context = [
            'function' => $function,
            'start' => microtime(true),
        ];
    }

    /**
     *
     * Finishes and logs a profile entry.
     *
     * @param string $statement The statement being profiled, if any.
     *
     * @param array $values The values bound to the statement, if any.
     *
     * @return null
     *
     */
    public function finish($statement = null, array $values = [])
    {
        if (! $this->active) {
            return;
        }

        $finish = microtime(true);
        $e = new Exception();

        $this->context['finish'] = $finish;
        $this->context['duration'] = $finish - $this->context['start'];
        $this->context['statement'] = $statement;
        $this->context['values'] = empty($values) ? '' : print_r($values, true);
        $this->context['backtrace'] = $e->getTraceAsString();

        $this->logger->log($this->logLevel, $this->logFormat, $this->context);

        $this->context = [];
    }
}
