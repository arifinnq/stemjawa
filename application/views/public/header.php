<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/css/datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/datatable-bootstrap.css">
    <link href="<?=base_url();?>assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/facebox.css">
    <link rel="stylesheet" href="<?=base_url(); ?>assets/js/jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/js/select2/select2.css" />
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/logo-navbar.png"/>
  </head>
  <body>
    <nav class="navbar navbar-default navbar-utama" role="navigation">
      <div class="container">
        
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
          <img src="<?php echo base_url();?>assets/img/logo-navbar.png" class="logo-navbar">
          <strong>Stemming Jawa</strong>
          </a>
        </div>
        
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-left">
            <li class="active"><a href="<?php echo base_url();?>"><i class="fa fa-home"></i>Beranda</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-th-list"></i> Data <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu tipe-kiri dropdown-menu-login2">
                <li><a href="<?php echo base_url(); ?>stemjawa/kata_dasar"><i class="fa fa-tags"></i> Kata Dasar</a></li>
                <li><a href="<?php echo base_url(); ?>stemjawa/kata_stopword"><i class="fa fa-tags"></i> Kata Stopword</a></li>
                <li><a href="<?php echo base_url(); ?>stemjawa/uji_dokumen"><i class="fa fa-tags"></i> Uji Dokumen</a></li>
              </ul>
            </li>
            </ul>
          <!--  
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="<?php echo base_url(); ?>administrasi/logout"><i class="fa fa-sign-out"></i><?php echo $nama ?> (Log Out)</a>
            </li>
          </ul>
        -->
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="tengah">
          <div class="head-depan tengah">
            <div class="row">
              <div class="col-md-1">
                <img class="img-thumbnail img-responsive margin-b10" src="<?php echo base_url();?>assets/img/jawa.jpg" width="100" height="100" alt="Logo" />
              </div>
              <div class="col-md-11">
                  <h1 class="judul-head"><?= $titlesistem?></h1>
                  <p><i class="fa fa-cog fa-fw"></i> Stemming Jawa</p>             
              </div>
            </div>
            <hr class="hr1 margin-b-10" />
          </div>
        </div>
        
      </div>
    </div>
