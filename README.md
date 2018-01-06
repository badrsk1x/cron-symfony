Cron Bundle

Installation
------------

Installing this bundle can be done through these simple steps:

1. Add the bundle to your project as a composer dependency:
  ```javascript
  // composer.json
  {
      // ...
      require: {
          // ...
          "cron/cron-bundle": "^1.5"
      }
  }
  ```

2. Update your composer installation:
  ```shell
  composer update
  ````

3. Add the bundle to your application kernel:
  ```php
  // app/AppKernel.php
  public function registerBundles()
  {
  	// ...
  	$bundle = array(
  		// ...
          new Cron\CronBundle\CronCronBundle(),
	  );
      // ...
  
      return $bundles;
  }
  ```

4. Update your DB schema
  ```shell
  bin/console doctrine:schema:update
  ```

5. Start using the bundle:
  ```shell
  bin/console cron:list
  bin/console cron:run
  ```

6. To run your cron jobs automatically, add the following line to your crontab:
  ```shell
  * * * * * /path/to/symfony/install/app/console cron:run 1>> /dev/null 2>&1
  ```

Available commands
------------------

### list
```shell
bin/console cron:list
```
Show a list of all jobs. Job names are show with ```[x]``` if they are enabled and ```[ ]``` otherwise.

### create
```shell
bin/console cron:create
```
Create a new job.

### delete
```shell
bin/console cron:delete _jobName_
```
Delete a job. For your own protection, the job must be disabled first.

### enable
```shell
bin/console cron:enable _jobName_
```
Enable a job.

### disable
```shell
bin/console cron:disable _jobName_
```
Disable a job.

### run
```shell
bin/console cron:run [--force] [job]
```

Requirements
------------

PHP 5.3.2 or above
