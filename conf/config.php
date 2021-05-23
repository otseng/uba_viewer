<?php
$PW['default']['site_db'] = 'uba';

$PW['db']['map']['pw'] = 'pw_core';
$PW['db']['map']['pwm'] = 'pw_core';
$PW['default']['inst_id'] = 0;

$PW['dir']['log'] = "log";

$PW['db']['datasource']['platform'] = 'mysqli';  // mysqli, postgres
$PW['db']['datasource']['database'] = 'uba_viewer';
$PW['db']['datasource']['user']     = 'uba_viewer';
$PW['db']['datasource']['password'] = 'uba_viewer';
$PW['db']['datasource']['server']   = '127.0.0.1';

$PW['db']['datasource']['pw_core'] = array( 
                        'name' => 'pw core',
                        'comments' => 'local mysql database',
                        'dsn' => $PW['db']['datasource']['platform'].
                            '://'.$PW['db']['datasource']['user'].':'.
							$PW['db']['datasource']['password'].'@'.
							$PW['db']['datasource']['server'].'/'.
							$PW['db']['datasource']['database'],
                        'id_generator' => 'adodb',
                        'prefix' => '',
                    );

$PW['dir']['adodb'] = "./lib/adodb-5.21.0";
include_once($PW['dir']['adodb'] . '/adodb.inc.php');
include_once($PW['dir']['adodb'] . '/adodb-exceptions.inc.php');
                    
?>