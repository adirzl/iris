<?php

namespace Modules\Sinkronisasi\Services;

use Illuminate\Support\Facades\Log;

class Socket
{
    /**
     */
    protected $socket;

    /**
     * @var integer
     */
    protected $endMessage;

    /**
     * @var integer
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $response = '';

    /**
     * @param integer $endMessage
     * @param integer $timeout
     */
    public function __construct($endMessage=-1, $timeout=30)
    {
        $this->endMessage = chr($endMessage);
        $this->timeout = $timeout;
    }

    /**
     * @param integer $endMessage
     * @return $this
     */
    public function setEndMessage(int $endMessage)
    {
        $this->endMessage = $endMessage;

        return $this;
    }

    /**
     * @param integer $timeout
     * @return $this
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param string $host
     * @param integer $port
     * @return $this
     */
    public function connect(string $host, int $port)
    {
        $this->socket = fsockopen($host, $port, $errnum, $errstr, $this->timeout);

        return $this;
    }

    /**
     * @param array $mpi
     * @return string
     */
    public function setMPI(array $mpi, array $data)
    {
        $mpi['DT'] = now()->format('YmdHis');
        $mpi['ST'] = $this->stan();
        $mpi['MPI'] = $data;
        $incoming = json_encode($mpi);

        Log::channel('socket')->info('[REQ] ' . $incoming);

        return $incoming;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function write(string $message)
    {
        if ($this->socket) {
            fwrite($this->socket, $message);
            fwrite($this->socket, $this->endMessage);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function send()
    {
        while (!feof($this->socket) && ($byte = fread($this->socket, 1)) != $this->endMessage) {
            if ($byte !== '') {
                $this->response .= $byte;
            }
        }

        Log::channel('socket')->info('[RES] ' . $this->response);

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function writeThenSend(string $message)
    {
        $this->write($message);

        if ($this->socket) {
            while (!feof($this->socket) && ($byte = fread($this->socket, 1)) != $this->endMessage) {
                if ($byte !== '') {
                    $this->response .= $byte;
                }
            }

            Log::channel('socket')->info('[RES] ' . $this->response);
        }

        // $this->response = '{"CC":"0002","DT":"20200515202612","PCC":"2","ST":"00000001","MC":"010001","MT":"2110","MPI":{"BRANCH":"0001","GROUP":"STAF","OTODB":"1000000001","IB":"N","OTOCR":"1000000001","USER":"H990"},"MPO":{"BRANCH":"0001","GROUP":"STAF","ERRMSG":"","OTODB":"000001000000001","IB":"N","OTOCR":"000001000000001","USER":"H990","FLAG":"R"}}';

        return $this;
    }

    /**
     * @return array
     */
    public function getMPO()
    {
        return json_decode($this->response, true);
    }

    /**
     * @return void
     */
    public function disconnect()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    /**
     * @return integer
     */
    protected function stan()
    {
        list($usec, $sec) = explode(' ', microtime());
        mt_srand((100000000 * (float) $usec) ^ (float) $sec);

        return mt_rand();
    }
}
