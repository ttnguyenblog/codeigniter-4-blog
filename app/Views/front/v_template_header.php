<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no">

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Cabin|Herr+Von+Muellerhoff|Source+Sans+Pro" rel="stylesheet">
    <!--Fonts-->

    <!--FontAwesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!--FontAwesome-->

    <link href="<?php echo base_url('home') ?>/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url('admin') ?>/css/styles.css" rel="stylesheet" />
</head>

<body class="stop-scroll">



    <!--Start Dots-->
    <div class="dots">
        <div class="active one" data-x="header"></div>
        <div class="three" data-x=".fixed-image"></div>
    </div>
    <!--End Dots-->

    <!--Start Header-->
    <header>
        <nav>
            <div class="logo">
                <div class="navigation-bar" style="float: left;">
                    <ul>
                        <li><a href="<?php echo site_url() ?>">Ahihi Travel<span class="underline"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="toggle">
                <span class="first"></span>
                <span class="middle"></span>
                <span class="last"></span>
            </div>
            <div class="navigation-bar">
                <ul>
                    <li><a href="<?php echo site_url() ?>">Home<span class="underline"></span></a></li>
                    <li class="blog"><a href="<?php echo site_url('blog') ?>">Blog<span class="underline"></span></a></li>
                    <li class="about"><a href="<?php echo set_post_link('55') ?>">About<span class="underline"></span></a></li>
                    <li class="contact" ><a href="<?php echo site_url('contact') ?>">Contact<span class="underline"></span></a></li>
                </ul>
            </div>
        </nav>

        <svg class="svg-down" width="192" height="61" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 160.7 61.5" enable-background="new 0 0 160.7 61.5" xml:space="preserve">
            <path fill="currentColor" d="M80.3,61.5c0,0,22.1-2.7,43.1-5.4s41-5.4,36.6-5.4c-21.7,0-34.1-12.7-44.9-25.4S95.3,0,80.3,0c-15,0-24.1,12.7-34.9,25.4S22.3,50.8,0.6,50.8c-4.3,0-6.5,0,3.5,1.3S36.2,56.1,80.3,61.5z"></path>
        </svg>
        <div class="arrow-down">
        </div>
    </header>
    <!--End Header-->