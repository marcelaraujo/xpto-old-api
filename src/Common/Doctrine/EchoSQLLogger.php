<?php

namespace Common\Doctrine;

use Doctrine\DBAL\Logging\SQLLogger;
use Monolog\Logger;

class EchoSQLLogger implements SQLLogger
{

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql The SQL to be executed.
     * @param array|null $params The SQL parameters.
     * @param array|null $types The SQL parameter types.
     *
     * @return void
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        if (!empty($params)) {
            preg_replace_callback('/(\?)/', function ($matches) use (&$sql, &$params) {
                $param = array_shift($params);

                /**
                 * Format objects to string
                 */
                if ($param instanceof \Datetime) {
                    /* @var $param \Datetime */
                    $param = $param->format(\Datetime::W3C);
                } elseif (is_array($param)) {
                    $param = implode(',', $param);
                }

                $sql = preg_replace('/(\?)/', "\"{$param}\"", $sql, 1);
            }, $sql);
        }

        $this->logger->addInfo($sql);
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery()
    {
    }
}
