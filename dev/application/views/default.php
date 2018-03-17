<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$teacher = array();
$select = "SELECT name FROM `users` WHERE `klas` != ''";
$results = $this->db->query($select);
if ($results->num_rows() > 0) {
    foreach ($results->result_array() as $result) {
        $teacher[] = $result['name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <base href="<?= base_url(); ?>">
    <title>IO::School-rapport</title>
    <base href="<?= base_url(); ?>"/>
    <!-- Bootstrap core CSS -->
    <!-- in the <head> .. -->
    <?php foreach ($stylesheets as $stylesheet): ?>
        <?= css_asset($stylesheet) . PHP_EOL; ?>
    <?php endforeach; ?>
    <link href='//fonts.googleapis.com/css?family=Titillium+Web:200,400,300,600|Open+Sans:300,400,600,700'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/js/ui/jquery-ui.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://use.fontawesome.com/9bfadb7786.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/datatables/datatables.min.css"/>
    <script>document.createElement("section");</script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= base_url(); ?>assets/css/ie10wa.css" rel="stylesheet">
    <style>
        .btn span.glyphicon {
            opacity: 0;
        }

        .btn.active span.glyphicon {
            opacity: 1;
        }

        ul li {
            list-style: none;
        }

        td ul li {
            list-style: disc;
        }

        .cke_dialog_ui_vbox_child #cke_193_uiElement, img#cke_230_uiElement, img#cke_204_uiElement {
            display: none !important;
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?= base_url(); ?>assets/css/theme-set.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--[if IE]>
    <script type="text/javascript">
        var console = {
            log: function () {
            }
        };
    </script>
    <![endif]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!-- /**https://elapsus.nl/dashboard/filemanager/verslagbeheer**/ -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?= base_url(); ?>css/elfinder.min.css">
    <!-- Mac OS X Finder style for jQuery UI smoothness theme (OPTIONAL) -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?= base_url(); ?>css/theme.css">
    <style type="text/css">
        #ui-datepicker-div {
            background-color: rgb(255, 255, 255);
            border: 1px solid #efefef;
            -webkit-box-shadow: 2px 2px 5px 0px rgba(168, 165, 168, 1);
            -moz-box-shadow: 2px 2px 5px 0px rgba(168, 165, 168, 1);
            box-shadow: 2px 2px 5px 0px rgba(168, 165, 168, 1);
            padding: 8px;
        }

        .ui-datepicker-month {
            font-family: inherit;
            background-color: transparent;
            width: 100%;
            padding: 4px 0;
            font-size: 16px;
            color: rgba(0, 0, 0, 0.26);
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        }

        .ui-datepicker-year {
            font-family: inherit;
            background-color: transparent;
            width: 100%;
            padding: 4px 0;
            font-size: 16px;
            color: rgba(0, 0, 0, 0.26);
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        }

        button.ui-state-default {

        }
    </style>
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<!-- preloader -->
<div id="preloader"></div>

<!-- Begin page content -->
<div class="container-fluid">
    <header class="topbar navbar navbar-default navbar-fixed-top" id="mainnav" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/" style="min-width:305px;">School Rapport
                    Beheer <?php if ($this->user->validate_session()) { ?> | <?php /* This sets the $time variable to the current hour in the 24 hour clock format */
                        $time = date("H");
                        /* Set the $timezone variable to become the current timezone */
                        $timezone = date("e");
                        /* If the time is less than 1200 hours, show good morning */
                        if ($time < "12") {
                            echo "Goedemorgen";
                        } else /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */ {
                            if ($time >= "12" && $time < "17") {
                                echo "Goedemiddag";
                            } else /* Should the time be between or equal to 1700 and 1900 hours, show good evening */ {
                                if ($time >= "17" && $time < "19") {
                                    echo "Goedenavond";
                                } else /* Finally, show good night if the time is greater than or equal to 1900 hours */ {
                                    if ($time >= "19") {
                                        echo "Goedenavond";
                                    }
                                }
                            }
                        }
                    } ?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right"><?php if (!$this->user->validate_session()) { ?>
                        <li class="active"><a href="/">Home</a></li>
                    <?php } ?>
                    <?php if ($this->user->validate_session()) { ?>
                        <li><a href="/dashboard">Dashboard</a></li>
                        <?php if ($this->user->has_permission('admin') || $this->user->has_permission('administratie')) { ?>
                            <li><a href="/dashboard/buildusers">Gebruiker Aanmaken</a></li>
                        <?php } ?>
                        <li><a href="/dashboard/profile">Profiel</a></li>
                        <li><a href="/logout">Uitloggen</a></li>
                    <?php } ?>

                </ul>

            </div>
            <!--/.nav-collapse -->
        </div>
    </header>
    <div class="container-fluid" style="margin-top:65px; padding-bottom:15px;">
        <?php echo $content; ?>
    </div>
</div>
<a href="#" id="back-to-top" class="btn btn-warning btn-sm">
    <span class="glyphicon glyphicon-arrow-up"></span>
</a>
<!-- a href="#"  class="btn btn-warning btn-lg" title="Back to top"><span class="glyphicon glyphicon-arrow-up"></span> Up</a -->

<footer class="footer" <?php if ($this->uri->segment(1) == '' || $this->uri->segment(0)) {
} else {
    echo 'style="margin-top:30px; position: relative !important;"';
} ?>>
    <div class="container">
        <p class="pull-right" style="color: white">
            <a id="popoverData" class="btn btn-warning" href="#"
               data-content="Problemen met aanmelden? Neem dan contact op met uw administratie of bel de supportdesk +3170 3608091"
               rel="popover" data-placement="top" data-original-title="Problemen met aanmelden?" data-trigger="hover"
               style="margin-right:30px;">
                <i style="color: orangered !important;" class="fa fa-question-circle-o" aria-hidden="true"></i>
            </a>
            Elapsus &copy; <?= date('Y'); ?> | SWSS van <a href="http://zo-bijzonder.nl" target="_blank">Zo
                Bijzonder</a></p>
    </div>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/ui/jquery-ui.css"/>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript"
        src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript" src="assets/js/datepicker-nl.js"></script>
<script src="https://use.fontawesome.com/6b57e79788.js"></script>
<script src="<?= base_url('assets/js/elapsus.control.js'); ?>"></script>
<script type="text/javascript">
    if (!Modernizr.svg) {
        var imgs = document.getElementsByTagName('img');
        var endsWithDotSvg = /.*\.svg$/
        var i = 0;
        var l = imgs.length;
        for (; i != l; ++i) {
            if (imgs[i].src.match(endsWithDotSvg)) {
                imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
            }
        }
    }
</script>
<?php foreach ($javascripts as $javascript): ?>
    <?= js_asset($javascript) . PHP_EOL; ?>
<?php endforeach; ?>

<?php if ($this->user->validate_session()) { ?>

    <script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
    <script src="<?= base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/elfinder.min.js"></script>
    <script type="text/javascript" src="js/i18n/elfinder.nl.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var elf = $('#elfinder').elfinder({
                lang: 'nl',             // language (OPTIONAL)
                url: '<?=base_url();?>dashboard/filemanager/verslagbeheer'  // connector URL (REQUIRED)
            }).elfinder('instance');
        });

        CKEDITOR.replaceAll();
        $(document).ready(function () {

            $('ul.nav > li').click(function (e) {
                $('ul.nav > li').removeClass('active');
                $(this).addClass('active');
            });
        });


        $(document).ready(function () {

            var table =
                $('#example').DataTable({
                    'columnDefs': [{
                        'targets': 0,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center'
                    }],
                    'order': [[1, 'asc']],
                    'oLanguage': {
                        "sProcessing": "Bezig...",
                        "sLengthMenu": "_MENU_ resultaten weergeven",
                        "sZeroRecords": "Geen resultaten gevonden",
                        "sInfo": "_START_ tot _END_ van _TOTAL_ resultaten",
                        "sInfoEmpty": "Geen resultaten om weer te geven",
                        "sInfoFiltered": " (gefilterd uit _MAX_ resultaten)",
                        "sInfoPostFix": "",
                        "sSearch": "Zoeken:",
                        "sEmptyTable": "Geen resultaten aanwezig in de tabel",
                        "sInfoThousands": ".",
                        "sLoadingRecords": "Een moment geduld aub - bezig met laden...",
                        "oPaginate": {
                            "sFirst": "Eerste",
                            "sLast": "Laatste",
                            "sNext": "Volgende",
                            "sPrevious": "Vorige"
                        }
                    }
                });

            $('#t2').DataTable({
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center'
                }],
                'order': [[1, 'asc']],
                'oLanguage': {
                    "sProcessing": "Bezig...",
                    "sLengthMenu": "_MENU_ resultaten weergeven",
                    "sZeroRecords": "Geen resultaten gevonden",
                    "sInfo": "_START_ tot _END_ van _TOTAL_ resultaten",
                    "sInfoEmpty": "Geen resultaten om weer te geven",
                    "sInfoFiltered": " (gefilterd uit _MAX_ resultaten)",
                    "sInfoPostFix": "",
                    "sSearch": "Zoeken:",
                    "sEmptyTable": "Geen resultaten aanwezig in de tabel",
                    "sInfoThousands": ".",
                    "sLoadingRecords": "Een moment geduld aub - bezig met laden...",
                    "oPaginate": {
                        "sFirst": "Eerste",
                        "sLast": "Laatste",
                        "sNext": "Volgende",
                        "sPrevious": "Vorige"
                    }
                }
            });

            $('#example-select-all').on('click', function () {
                var rows = table.rows({'search': 'applied'}).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
            $('#example tbody').on('change', 'input[type="checkbox"]', function () {
                if (!this.checked) {
                    var el = $('#example-select-all').get(0);
                    if (el && el.checked && ('indeterminate' in el)) {
                        el.indeterminate = true;
                    }
                }
            });
            $('#frm-example').on('submit', function (e) {
                var form = this;
                table.$('input[type="checkbox"]').each(function () {
                    if (!$.contains(document, this)) {
                        if (this.checked) {
                            $(form).append(
                                $('<input>')
                                    .attr('type', 'hidden')
                                    .attr('name', this.name)
                                    .val(this.value)
                            );
                        }
                    }
                });
            });
        });


        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(function () {

            var availableTags = <?php echo json_encode($teacher);?>

                function split(val) {
                    return val.split(/,\s*/);
                }

            function extractLast(term) {
                return split(term).pop();
            }

            $("#tags")
                .bind("keydown", function (event) {
                    if (event.keyCode === $.ui.keyCode.TAB &&
                        $(this).autocomplete("instance").menu.active) {
                        event.preventDefault();
                    }
                })

                .autocomplete({
                    minLength: 0,
                    source: function (request, response) {
                        response($.ui.autocomplete.filter(
                            availableTags, extractLast(request.term)));
                    },
                    focus: function () {
                        return false;
                    },
                    select: function (event, ui) {
                        var terms = split(this.value);
                        terms.pop();
                        terms.push(ui.item.value);
                        terms.push("");
                        this.value = terms.join(" ");
                        return false;
                    }


                });
        });


        $(document).ready(function () {
            $('#rights').bind('change', function (e) {
                if ($('#rights').val() == 2) {
                    $('#class-selection').show();
                }
                else {
                    $('#class-selection').hide();
                }
            });
        });

        $("#publish").click(function (event) {

            $.ajax({
                url: "/dashboard/newuser",
                type: "post",
                data: $("form").serialize(),
                success: function (response) {
                    if (response) {
                        window.location.replace("<?=base_url('/dashboard/buildusers');?>");
                        location.reload(true);
                    }
                    else {
                        alert('geen resultaat ontvangen van db');
                        console.log('no result received from db');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            event.preventDefault();
        });

        $(function () {
            $.datepicker.setDefaults(
                $.datepicker.regional["nl"]
            );

            $('.date-picker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                prevText: '←',
                nextText: '→',
                currentText: 'Vandaag',
                monthNames: ['januari', 'februari', 'maart', 'april', 'mei', 'juni',
                    'juli', 'augustus', 'september', 'oktober', 'november', 'december'],
                monthNamesShort: ['jan', 'feb', 'mrt', 'apr', 'mei', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec'],
                dayNames: ['zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'],
                dayNamesShort: ['zon', 'maa', 'din', 'woe', 'don', 'vri', 'zat'],
                dayNamesMin: ['zo', 'ma', 'di', 'wo', 'do', 'vr', 'za'],
                weekHeader: 'Wk',
                closeText: 'Selecteer',
                dateFormat: 'MM yy',
                onClose: function (dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            });

            $.datepicker.setDefaults(
                $.extend(
                    {'dateFormat': 'MM-yy'},
                    $.datepicker.regional['nl']
                )
            );
        });

        $('#zipbuilder').submit(function () {
            var checked_boxes = $(":checkbox:checked").length;
            if (checked_boxes < 1) {
                alert("Please Select Files");
                return false;

            } else if ($('#file_name').val() == '') {
                alert("Please Enter Name");
                return false;
            }
        });
        $(':input:checked').parent('.btn').addClass('active').siblings().removeClass("ac??tive");

        $(document).ready(function () {
            $("#checkAll").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });
        });

    </script>
    <script>
        $("#undoButtons").click(function () {
            var currentResetRequest = $(this).attr('data-target');
            $(".btn-group button").removeClass("active");
            $(currentResetRequest).parent().removeClass("active");
            console.log('reset is gedrukt');
        });
    </script>
<?php } ?>
<script src="<?= base_url(); ?>assets/js/ie10wa.js"></script>
<script>
    $(window).load(function () {
        $('#preloader').fadeOut('slow', function () {
            $(this).remove();
        });
    });
    if (!window.console) console = {
        log: function () {
        }
    };

    $('#popoverData').popover();
    $('#popoverOption').popover({trigger: "hover"});

    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }

    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);
</script>
<script type="text/javascript">
    $(".previewer").on("click", function () {
        // href="/dashboard/preview/<?= $student->tbl_student_id; ?>/<?= $student->lhg; ?>/<?= $student->id; ?>"
        $.post('/dashboard/store', $('form').serialize(), function (response) {
            /* do something with returned data from server*/
            if (response != null) {
                console.log(response);
                window.location.href = "/dashboard/voorbeeld/" + studentid + "/" + studentgroup + "/" + student_db_id;
            }
        });
        return false;
        /* prevent browser submitting form*/
    });

    $(document).ready(function () {
        $('input#login').keyup(function () {
            //console.log('check input form for spaces');
            $(this).val($(this).val().replace(/ +?/g, ''));
            var value = $.trim($(this).val());
            $(this).val(value);
        });
        $('input#login').blur(function () {
            var value = $.trim($(this).val());
            $(this).val(value);
        });
    });
</script>
<?php if ($this->uri->segment(1) === 'edexreader'): ?>
    <script>
        $.ajax({
            type: 'GET',
            url: '/edexreader/getJSONEDEX',
            dataType: 'json',
            success: function (data) {
                var i = 0;
                $.each(data, function (index, element) {
                    $('#datalist').append('<li class="list-group-item">' + element.SCHOOLJAAR + '</li>');
                });
            }
        });
    </script>
<?php endif; ?>
</body>
</html>
