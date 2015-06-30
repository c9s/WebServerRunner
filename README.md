WebServerRunner
==================

This is a simple runner wrapper of the php built-in web server.


## Usaage

```php
$runner = new WebServerRunner('localhost', '3343', './');
$runner->setVerbose();
$runner->execute();
$info = $runner->info();
$pid = $runner->getPid();
$runner->stopOnShutdown();
```

