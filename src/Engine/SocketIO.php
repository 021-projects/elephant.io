<?php
/**
 * This file is part of the Elephant.io package
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright Wisembly
 * @license   http://www.opensource.org/licenses/MIT-License MIT License
 */

namespace ElephantIO\Engine;

use Psr\Log\LoggerInterface;

use ElephantIO\EngineInterface,
    ElephantIO\Exception\UnsupportedActionException;

abstract class SocketIO implements EngineInterface
{
    const CONNECT      = 0;
    const DISCONNECT   = 1;
    const EVENT        = 2;
    const ACK          = 3;
    const ERROR        = 4;
    const BINARY_EVENT = 5;
    const BINARY_ACK   = 6;

    const TRANSPORT_POLLING   = 'polling';
    const TRANSPORT_WEBSOCKET = 'websocket';

    /** @var string[] Parse url result */
    protected $url;

    /** @var LoggerInterface */
    protected $logger = null;

    /** @var string[] Session information */
    protected $sessions;

    /** {@inheritDoc} */
    public function read()
    {
        throw new UnsupportedActionException;
    }

    /** {@inheritDoc} */
    public function keepAlive()
    {
        throw new UnsupportedActionException;
    }

    /** {@inheritDoc} */
    public function connect()
    {
        throw new UnsupportedActionException;
    }

    /** {@inheritDoc} */
    public function close()
    {
        throw new UnsupportedActionException;
    }

    /** {@inheritDoc} */
    public function send()
    {
        throw new UnsupportedActionException;
    }

    /**
     * Get the server information from the parsed URL
     *
     * @return string[] information on the given URL
     */
    protected function getServerInformations()
    {
        $server = array_replace($this->url, ['scheme'    => 'http',
                                             'host'      => 'localhost',
                                             'path'      => 'socket.io',
                                             'transport' => static::TRANSPORT_POLLING]);

        if (!isset($server['port'])) {
            $server['port'] = 'https' === $server['scheme'] ? 443 : 80;
        }

        if ('https' === $server['scheme']) {
            $server['scheme'] = 'ssl';
        }

        return $server;
    }

    /**
     * Get the defaults options
     *
     * @return array mixed[] Defaults options for this engine
     */
    protected function getDefaultOptions()
    {
        return [['check_ssl' => false,
                 'debug'     => false]];
    }

    /**
     * Build the URL to establish a connection
     *
     * @return string URL built
     */
    abstract protected function buildUrl();
}

