<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Email bericht</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,900,300,100,100italic,300italic,700italic,900italic&subset=latin,latin-ext'
          rel='stylesheet' type='text/css'>
    <style>

        /* -------------------------------------
            GLOBAL
        ------------------------------------- */
        * {

            color: #444444;
            font-family: 'Lato', sans-serif;
            font-size: 16px;
            font-weight: normal;
            font-size: 100%;
            line-height: 1.6em;
            margin: 0;
            padding: 0;
        }

        img {
            max-width: 680px;
            height: auto;
        }

        body {
            -webkit-font-smoothing: antialiased;
            height: 100%;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            font-family: 'Lato', sans-serif;
        }

        /* -------------------------------------
            ELEMENTS
        ------------------------------------- */
        a {
            color: #348eda;
            font-family: 'Lato', sans-serif;
        }

        .btn-primary {
            Margin-bottom: 10px;
            width: auto !important;
        }

        .btn-primary td {
            background-color: #348eda;
            border-radius: 25px;
            font-family: 'Lato', sans-serif;
            font-size: 14px;
            text-align: center;
            vertical-align: top;
        }

        .btn-primary td a {
            background-color: #348eda;
            border: solid 1px #348eda;
            border-radius: 25px;
            border-width: 10px 20px;
            display: inline-block;
            color: #ffffff;
            cursor: pointer;
            font-weight: bold;
            line-height: 2;
            text-decoration: none;
            font-family: 'Lato', sans-serif;
        }

        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .padding {
            padding: 10px 0;
        }

        /* -------------------------------------
            BODY
        ------------------------------------- */
        table.body-wrap {
            padding: 20px;
            width: 100%;
            font-family: 'Lato', sans-serif;
        }

        table.body-wrap .container {
            border: 1px solid #f0f0f0;
            font-family: 'Lato', sans-serif;
        }

        /* -------------------------------------
            FOOTER
        ------------------------------------- */
        table.footer-wrap {
            clear: both !important;
            width: 100%;
            font-family: 'Lato', sans-serif;
        }

        .footer-wrap .container p {
            color: #666666;
            font-size: 12px;
            font-family: 'Lato', sans-serif;
        }

        table.footer-wrap a {
            color: #999999;
            font-family: 'Lato', sans-serif;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1,
        h2,
        h3 {
            color: #111111;
            font-family: 'Lato', sans-serif;
            font-weight: 200;
            line-height: 1.2em;
            margin: 40px 0 10px;
        }

        h1 {
            font-size: 36px;
            font-family: 'Lato', sans-serif;
        }

        h2 {
            font-size: 28px;
            font-family: 'Lato', sans-serif;
        }

        h3 {
            font-size: 22px;
            font-family: 'Lato', sans-serif;
        }

        p,
        ul,
        ol {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 10px;
            font-family: 'Lato', sans-serif;
        }

        ul li,
        ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* ---------------------------------------------------
            RESPONSIVENESS
        ------------------------------------------------------ */

        /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
        .container {
            clear: both !important;
            display: block !important;
            Margin: 0 auto !important;
            max-width: 600px !important;
            font-family: 'Lato', sans-serif;
        }

        /* Set the padding on the td rather than the div for Outlook compatibility */
        .body-wrap .container {
            padding: 20px;
        }

        /* This should also be a block element, so that it will fill 100% of the .container */
        .content {
            display: block;
            margin: 0 auto;
            max-width: 600px;
        }

        /* Let's make sure tables in the content area are 100% wide */
        .content table {
            width: 100%;
        }

    </style>
</head>

<body bgcolor="#f6f6f6">

<!-- body -->
<table class="body-wrap" bgcolor="#f6f6f6">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>

                        <td><h1 style="text-align: right;"><img src="<?= base_url(); ?>/assets/img/elapsus2.0.png"
                                                                alt="Elapsus 2.0" width="90" class="img-responsive"/>
                            </h1>
                            <p>Beste <?= $fullname; ?></p>
                            <p>De gegevens om toegang te krijgen tot het verslagsysteem zijn aangemaakt.<br/>
                                Uw inloggegevens zijn:<br/> <br/>
                            <table border="0" cellpadding="1">
                                <tr>
                                    <td> Gebruiker: <?= $email; ?></td>
                                </tr>
                                <tr>
                                    <td>Wachtwoord: <?= $password; ?></td>
                                </tr>
                            </table>
                            <br/>
                            Om in te loggen ga naar <a href="<?= base_url(); ?>"><?= base_url(); ?></a><br/>
                            </p>
                            <h3>Gemak - Snel - Overzichtelijk</h3>
                            <p>Het verslagsysteem is gemakkelijk, snel en overzichtelijk. Naast de vele opties zijn er
                                ook mogelijkheden dit pakket voor u uit te breiden.</p>

                            <!-- button -->
                            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td>
                                        <a href="<?= base_url(); ?>">Direct Inloggen</a>
                                    </td>
                                </tr>
                            </table>
                            <!-- /button -->
                            <h3><strong>Vragen?</strong></h3>
                            <p>Heeft u vragen over dit bericht of in het algemeen over uw product? Neem dan gerust
                                contact met ons op. Dit kan via telefoonnummer 0703608091 of stuur een email naar
                                hallo@zobijzonder.com</p>
                            <p>
                                Met vriendelijke groet,<br/>
                                <br/>
                                <img src="<?= base_url(); ?>assets/img/signature_elapsus.jpg" width="130"/>
                                <br/>
                                Email Disclaimer:<br/>
                                Dit bericht kan informatie bevatten die niet voor u is bestemd. Indien u niet de
                                geadresseerde bent of dit bericht abusievelijk aan u is gezonden, wordt u verzocht dat
                                aan de afzender te melden en het bericht te verwijderen.
                                Zo Bijzonder aanvaardt geen aansprakelijkheid voor schade, van welke aard ook, die
                                verband houdt met risico's verbonden aan het elektronisch verzenden van berichten.
                                This message may contain information that is not intended for you. If you are not the
                                addressee or if this message was sent to you by mistake, you are requested to inform the
                                sender and delete the message.
                                Zo Bijzonder accepts no liability for damage of any kind resulting from the risks
                                inherent in the electronic transmission of messages.
                                <br/>
                                Software Proclaimer:<br/>
                                Elapsus is een volledig autonoom en zelfsturend crm systeem. Emails en financiele
                                transacties worden gemonitored en bijgehouden. Toch is het mogelijk dat er fouten kunnen
                                optreden.
                                Wij verzoeken u, bij constatering van een dergelijke, direct een melding te doen aan
                                beheer@zobijzonder.com
                                Elapsus is a full selfsustaining CRM system. Emails and financial transactions are
                                always monitored and logged. Though thoroughly tested there is a possibilty that an
                                error could occur.
                                We kindly request you, in case of such failure, to report to us immediately. This can be
                                done by sending an email to support@zobijzonder.com
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->

        </td>
        <td></td>
    </tr>
</table>
<!-- /body -->

<!-- footer -->
<table class="footer-wrap">
    <tr>
        <td></td>
        <td class="container">

            <!-- content -->
            <div class="content">
                <table>
                    <tr>
                        <td align="center">
                            <p>Elapsus is een product van Zo Bijzonder.
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /content -->

        </td>
        <td></td>
    </tr>
</table>
<!-- /footer -->

</body>
</html>
