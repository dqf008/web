<?php !defined('IN_LOT')&&die('Access Denied'); ?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6 ie" > <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 ie" > <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 ie" > <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js">
<!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title><?php echo $LOT['title']; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="static/styles/<?php echo $LOT['skin']; ?>.css?v=20161011">
        <!--[if IE 6]>
        <script src="static/scripts/DD_belatedPNG_0.0.8a.js?v=20161011"></script>
        <script>
            /* EXAMPLE */
            DD_belatedPNG.fix('.icon');
            /* string argument can be any CSS selector */
            /* .png_bg example is unnecessary */
            /* change it to what suits you! */
        </script>
        <![endif]-->
        <script>
            var ry_lottery_config = {
                assets: 'static/{0}?v=20161011',
                currency: '¥',
                locale: 'zh_cn'
            };
        </script>
        <script src="static/scripts/requirejs.js"></script>
    </head>
    <body>
