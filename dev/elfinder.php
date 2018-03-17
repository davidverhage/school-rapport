<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Administratie Beheer & Overzicht</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- jQuery and jQuery UI (REQUIRED) -->
    <link rel="stylesheet" type="text/css"
          href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" href="css/theme.css">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/theme-set.css"/>
    <!-- elFinder JS (REQUIRED) -->
    <script src="js/elfinder.min.js"></script>


    <!-- elFinder translation (OPTIONAL) -->
    <script src="js/i18n/elfinder.nl.js"></script>

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        // Documentation for client options:
        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
        $(document).ready(function () {
            $('#elfinder').elfinder({
                url: 'php/connector.minimal.php'  // connector URL (REQUIRED)
                , lang: 'nl'                    // language (OPTIONAL)
            });
        });
    </script>
    <style>body {
            background: #f2f2f2 !important;
        }</style>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- preloader -->
<div id="preloader"></div>

<!-- Begin page content -->
<div class="container-fluid">

    <header class="topbar navbar navbar-default navbar-fixed-top" id="mainnav" role="navigation">
        <div class="navbar-header"><a class="navbar-brand" href="/" style="min-width:305px;">Elapsus | Verslagen</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="/">Home</a></li>


                <li><a href="/dashboard">Dashboard</a></li>

                <li><a href="/dashboard/buildusers">Gebruiker Aanmaken</a></li>
                <li><a href="/dashboard/profile">Profiel</a></li>
                <li><a href="/logout">Uitloggen</a></li>

            </ul>

        </div>
    </header>
</div>
<!--/.nav-collapse -->
<!-- Element where elFinder will be created (REQUIRED) -->

<div class="container" style="margin-top:65px; padding-bottom:15px;">
    <div id="elfinder"></div>
</div>
</body>
</html>
