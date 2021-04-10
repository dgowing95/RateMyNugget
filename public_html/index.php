<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate My Nugget - The Best Place to Rate Chicken Nuggets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>
    <link rel="icon" type="image/png" href="/images/favicon.png"/>

    <meta name="title" content="Rate My Nugget - The Best Place to Rate Chicken Nuggets">
    <meta name="description" content="We show you pictures of chicken nuggets (mostly), you rate them out of 5. You'll probably get a little hungry too.">

    <meta property="og:title" content="Rate My Nugget - The Best Place to Rate Chicken Nuggets">
    <meta property="og:description" content="We show you pictures of chicken nuggets (mostly), you rate them out of 5. You'll probably get a little hungry too.">
    <meta property="og:image" content="/images/social.png">
    <meta property="og:url" content="https://www.ratemynugget.com">

    <meta name="twitter:title" content="Rate My Nugget - The Best Place to Rate Chicken Nuggets">
    <meta name="twitter:description" content="We show you pictures of chicken nuggets (mostly), you rate them out of 5. You'll probably get a little hungry too. ">
    <meta name="twitter:image" content="/images/social.png">
    <meta name="twitter:card" content="/images/social.png">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0JJZ73G6R5"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-0JJZ73G6R5');
    </script>

    <style>
        ul {
            list-style: none;
        }
        .nug {
            cursor:pointer;
            width:64px;
            height:64px;
        }
        .nug-empty {
            background-image: url('/images/nug-hollow.png');
        }
        .nug-filled {
            background-image: url('/images/nug-fill.png')!important;
        }
        .nug-border {
            background-image: url('/images/nug-border.png');
        }
    </style>
</head>
<body>
    <div class="container pt-3">
        <h1 class='text-center'>
            RateMyNugget.com
        </h1>
        <div class="row mt-5 nugget-stage">
            <div class="col-12 text-center">
                <img class='nugget-image' src="" alt="">
            </div>
            <div class="col-12 text-center mt-2">
                <h3>What do you think of this nugget? </h3>
                <div class='nug-rating d-flex justify-content-center'>
                    <div class='nug nug-empty' alt="" srcset=""></div>
                    <div class='nug nug-empty' alt="" srcset=""></div>
                    <div class='nug nug-empty' alt="" srcset=""></div>
                    <div class='nug nug-empty' alt="" srcset=""></div>
                    <div class='nug nug-empty' alt="" srcset=""></div>
                </div>
                <div> or </div>
                <div class='btn btn-danger not-nug-button'>This isn't a nugget </div>
                <p class='mt-2'>
                    This nugget is currently rated at <span class='nug-current-rating'></span> nuggets by <span class='nug-total-rates'></span> people
                </p>
            </div>
        </div>
        <div class='row mt-5 nug-warning d-none'>
            <div class="col-12 text-center">
                <p>Sorry, you've rated all the nuggets we've got.</p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="/nugget.js?v=1"></script>
</body>
</html>