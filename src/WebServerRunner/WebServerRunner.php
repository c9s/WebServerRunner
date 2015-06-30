<?php
namespace WebServerRunner;

class WebServerRunner {

    public $host;

    public $port;

    public $docroot;

    public $pid;

    protected $useShutdownFunction = false;

    protected $verbose = false;

    public function __construct($host = 'localhost', $port = '3343', $docroot)
    {
        $this->host = $host;
        $this->port = $port;
        $this->docroot = $docroot;
    }

    public function setVerbose($verbose)
    {
        $this->verbose = $verbose;
    }

    public function buildCommand() 
    {
        $command = sprintf(
            'php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
            $this->host,
            $this->port,
            $this->docroot
        );
        return $command;
    }

    public function execute() 
    {
        $command = $this->buildCommand();
        $output = array(); 
        exec($command, $output);
        $this->pid = intval($output[0]);
        if ($this->verbose) {
            echo $this->info(), PHP_EOL;
        }
        return $this->pid;
    }

    public function info() 
    {
        return sprintf(
            '%s - Web server started on %s:%d with PID %d', 
            date('r'),
            $this->host, 
            $this->port, 
            $this->pid
        );
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function stop() 
    {
        if ($this->verbose) {
            echo sprintf('%s - Killing process with ID %d', date('r'), $this->pid) . PHP_EOL;
        }
        exec(sprintf('kill %d', $this->pid));
    }

    public function stopOnShutdown() {
        $self = $this;
        $this->useShutdownFunction = true;
        register_shutdown_function(function() use ($self) {
            $self->stop();
        });
    }

    public function __destruct() 
    {
        if (!$this->useShutdownFunction) {
            $this->stop();
        }
    }
}


/*
// PHP server runner
 
// Execute the command and store the process ID
 
echo sprintf(
    '%s - Web server started on %s:%d with PID %d', 
    date('r'),
    WEB_SERVER_HOST, 
    WEB_SERVER_PORT, 
    $pid
) . PHP_EOL;
 
// Kill the web server when the process ends
register_shutdown_function(function() use ($pid) {
    echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
    exec('kill ' . $pid);
});
 */
