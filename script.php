<?php

set_time_limit(0);

const SOCKET_ADDRESS = '127.0.0.1';
const SOCKET_PORT = 10293;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($sock === false)
	exit(0);

$sock_bind = socket_bind($sock, SOCKET_ADDRESS, 10293);
if ($sock_bind === false)
	exit(0);

$sock_listen = socket_listen($sock, 1);
if ($sock_listen < 0)
	exit(0);

$sock_client = socket_accept($sock);

while (true) {
	$buf = socket_read($sock_client, 2048, PHP_NORMAL_READ);
	if ($buf === false) {
		echo "socket_read() failed \n";
		exit(0);
	}

	$json = json_decode($buf);
	var_dump($json);
	echo '\n';
}



?>