<?php

$filename = tempnam(sys_get_temp_dir(), 'file');

$container->setParameter('storage', $filename);
