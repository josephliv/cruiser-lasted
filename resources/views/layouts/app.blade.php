<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com) & Updivision (https://www.updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim & Updivision

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>{{ $title }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" /> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mallanna&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
    <!-- CSS Files -->
    <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet"/>
    <!-- CSS mostly for custom changes such as the dropdown menu -->

    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
<div class="wrapper @if (!auth()->check() ||
    request()->route()->getName() == '') wrapper-full-page @endif">

    @if (auth()->check() &&    request()->route()->getName() != '')
        @if (auth()->check() && !\Auth::user()->is_admin)
            @include('layouts.navbars.sidebaragent')

        @else
            @include('layouts.navbars.sidebar')
        @endif

    @endif

    <div class="@if (auth()->check() &&    request()->route()->getName() != '') main-panel @endif">

        @include('layouts.navbars.navbar')

        @yield('content')
        @include('layouts.footer.nav')
    </div>

</div>

</body>
<!--   Core JS Files   -->
<script src="{{ asset('light-bootstrap/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script>
<!-- script src="{{ asset('light-bootstrap/js/plugins/chartist.min.js') }}"></script -->
<script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script>

@stack('js')
<script>
    //Chris didn't request this and doesn't like it! :/

    $(document).ready(function () {
        $('#lead-table0').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 100,
            "stateSave": true,
            "stateDuration": -1,
            // fixedColumns: true

        });
        $('#lead-table1').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 100,
            "stateSave": true,
            "stateDuration": -1,
            // fixedColumns: true
        });
        $('#lead-table2').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 100,
            "stateSave": true,
            "stateDuration": -1,
            // fixedColumns: true
        });
        $('#lead-table3').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 100,
            "stateSave": true,
            "stateDuration": -1,
            // fixedColumns: true
        });
        $('#lead-table4').DataTable({
            "order": [
                [0, "desc"]
            ],
            "pageLength": 100,
            "stateSave": true,
            "stateDuration": -1,

            "columnDefs": [
                { "width": "10%"},
                { "width": "10%"},
                { "width": "20%"},
                { "width": "20%"},
                { "width": "10%"},
                { "width": "10%"},
                { "width": "20%"},
            ],
            // columnDefs: [
            //     null,
            //     null,
            //     null,
            //     null,
            //     null,
            //     null,
            //     null,
            // ],
            // fixedColumns: true

        });
    });
</script>
<script>
    $(document).ready(function () {

        $('#detailedReportBtn').on('click', function (e) {
            e.stopPropagation();
            $('#detailedReportTable').find('tbody').html(
                '<tr><td colspan="5">Processing...</td><td></td><td></td><td></td><td></td></tr>');
            $.ajax({
                url: "/leads/" + $('#from-date').val() + "/" + $('#to-date').val() + "/report/",
                success: function (result) {
                    res = result;
                    console.log(res);
                    $('#detailedReportTable').find('tbody').empty();
                    $('#detailedReportTable').find('tfoot').empty();
                    leadsTotal = rejectedTotal = reassignedTotal = 0;
                    for (r in res) {
                        date = new Date(res[r].last_lead);
                        formattedDate = date.toLocaleDateString('en-US') + ' ' + date
                            .toLocaleTimeString('en-US');

                        leadsTotal += parseInt(res[r].leads_count);
                        rejectedTotal += parseInt(res[r].leads_rejected);
                        reassignedTotal += parseInt(res[r].leads_reassigned);

                        if (res[r].agent_id == 0) { // This is for unassigned leads
                            $('#detailedReportTable').find('tbody').append(
                                '<tr><td><span id="agent-name">' + res[r].agent_name +
                                '</span></td><td  class="text-left"><span id="time-sent">' +
                                formattedDate +
                                '</span> </td><td  class="text-left"><span id="leads-sent">' +
                                res[r].leads_count +
                                '</span></td><td  class="text-left"><span id="leads-sent">' +
                                res[r].leads_reassigned +
                                '</span></td><td  class="text-left"><span id="leads-rejected">' +
                                res[r].leads_rejected + '</span></td></tr>');
                        } else {
                            $('#detailedReportTable').find('tbody').append(
                                '<tr><td><span id="agent-name">' + res[r].agent_name +
                                '</span></td><td class="text-left"><span id="time-sent">' +
                                formattedDate +
                                '</span> </td><td class="text-left"><span id="leads-sent">' +
                                res[r].leads_count +
                                '</span></td><td class="text-left"><span id="leads-sent">' +
                                res[r].leads_reassigned +
                                '</span></td><td class="text-left"><span id="leads-rejected">' +
                                res[r].leads_rejected + '</span></td></tr>');
                        }
                    }
                    $('#detailedReportTable').find('tfoot').append(
                        '<tr><th colspan="2">TOTAL</th><th class="text-left">' +
                        leadsTotal + '</th><th class="text-left">' + reassignedTotal +
                        '</th><th class="text-left">' + rejectedTotal + '</th></tr>');
                },
                error: function (a, b, c) {
                    alert('Something Went Wrong!');
                    console.log(a, b, c);
                }
            });
        });

        $('#detailedEmailBtn').on('click', function (e) {
            e.stopPropagation();
            $.ajax({
                url: "/leads/" + $('#from-date').val() + "/" + $('#to-date').val() + "/email/",
                success: function (result) {
                    res = JSON.parse(result);
                    console.log(res);
                    alert(res.message);
                },
                error: function (a, b, c) {
                    alert('Something Went Wrong!');
                    console.log(a, b, c);
                }
            });
        });

        $('.removeLead').on('click', function (e) {
            e.stopPropagation();
            confirm('You really want to delete this lead?');
        });

        $('.getbody').on('click', function (e) {
            id = $(this).data('id');
            type = $(this).data('type');

            $('#leadsModalBody').html('Processing');

            if (type == 'body') {
                $.ajax({
                    url: "/leads/" + id + "/body",
                    success: function (result) {
                        res = JSON.parse(result);
                        //console.log(atob(res.body));
                        $('#leadsModalBody').html(atob(res.body))
                    },
                    error: function (a, b, c) {
                        alert('Something Went Wrong!');
                        console.log(a, b, c);
                    }
                });
            }

            if (type == 'reassigned') {
                $.ajax({
                    url: "/leads/" + id + "/reassigned",
                    success: function (result) {
                        res = JSON.parse(result);
                        //console.log(atob(res.body));
                        $('#leadsModalBody').html(atob(res.body))
                    },
                    error: function (a, b, c) {
                        alert('Something Went Wrong!');
                        console.log(a, b, c);
                    }
                });
            }

            if (type == 'rejected') {
                $.ajax({
                    url: "/leads/" + id + "/rejected",
                    success: function (result) {
                        res = JSON.parse(result);
                        //console.log(atob(res.body));
                        $('#leadsModalBody').html(atob(res.body))
                    },
                    error: function (a, b, c) {
                        alert('Something Went Wrong!');
                        console.log(a, b, c);
                    }
                });
            }

        });

        $('.direct-send-lead').on('click', function (e) {
            $('#transferLeadId').val($(this).data('id'));
            $('#transferLeadOriginalAgent').val($(this).data('original-user'));
        })

        $('.direct-send-lead-button').on('click', function (e) {
            var transferLeadId = $('#transferLeadId').val();
            var transferLeadOriginalAgent = $('#transferLeadOriginalAgent').val();
            var transferLeadNewAgent = $('#transferLeadNewAgent').val();

            if (transferLeadOriginalAgent != transferLeadNewAgent) {
                $.ajax({
                    url: "/leads/transfer/" + transferLeadId + "/" + transferLeadNewAgent,
                    success: function (result) {
                        res = JSON.parse(result);
                        console.log(res);
                        alert(res.success);
                        location.reload();
                    },
                    error: function (a, b, c) {
                        alert('Something Went Wrong!');
                        console.log(a, b, c);
                    }
                });
            } else {
                alert('This lead has already being sent to this user');
            }
        })

        $('#facebook').sharrre({
            share: {
                facebook: true
            },
            enableHover: false,
            enableTracking: false,
            enableCounter: false,
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('facebook');
            },
            template: '<i class="fab fa-facebook-f"></i> Facebook',
            url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
        });

        $('#google').sharrre({
            share: {
                googlePlus: true
            },
            enableCounter: false,
            enableHover: false,
            enableTracking: true,
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('googlePlus');
            },
            template: '<i class="fab fa-google-plus"></i> Google',
            url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
        });

        $('#twitter').sharrre({
            share: {
                twitter: true
            },
            enableHover: false,
            enableTracking: false,
            enableCounter: false,
            buttons: {
                twitter: {
                    via: 'CreativeTim'
                }
            },
            click: function (api, options) {
                api.simulateClick();
                api.openPopup('twitter');
            },
            template: '<i class="fab fa-twitter"></i> Twitter',
            url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
        });
    });
</script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js') }}"></script>
<script src="{{ asset('light-bootstrap/js/demo.js') }}"></script>

</html>
