<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

    <link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/gif">

    <link href="<?= base_url('NewAssets/fontAwesome'); ?>" rel="stylesheet">
    <link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
    <link href="<?= base_url('NewAssets/sweetalertCss') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet">
    
    <script type="text/javascript" src="<?= base_url('assets/js/scriptLoader.js')?>"></script>
    
    <script>loadJs(base_url + 'NewAssets/jquery');</script>
</head>
<body>