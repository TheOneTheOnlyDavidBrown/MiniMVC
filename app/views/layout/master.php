<?php

$this->view->load('layout/head',$data);
$this->view->load('layout/menu');
$this->view->load($page,$data);
$this->view->load('layout/footer');