<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env('APP_NAME', 'Application Name')}}</title>

        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bower_components/jstree/dist/themes/default/style.min.css">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}?t=<?=filemtime(public_path().'/css/app.css')?>">
        <link id="template-tuner" rel="stylesheet" type="text/css" href="bower_components/bootswatch/flatly/bootstrap.min.css">
    </head>
    <body>
@yield('content')
        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="js/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="js/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="js/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>

        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" charset="utf8" src="bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="bower_components/jstree/dist/jstree.min.js"></script>

        <script src="bower_components/chart.js/dist/Chart.bundle.js"></script>
        <script src="bower_components/chart.js/samples/utils.js"></script>
        <script type="text/javascript" charset="utf8">
            (function ( $ ) {
                $.fn.slider = function(viewId) {
                    if ( typeof viewId === 'undefined') {
                        this.children().slideUp();
                        this.children('.active').slideDown();
                    } else {
                        this.children('.active').slideUp();
                        $(this.children()[viewId]).slideDown();
                        $(this.children()[viewId]).addClass('active');
                    }
                };
            }( jQuery ));
            window.PathItem=function(base, self) {
                this.goto = function(){
                    self.goto(this.item, this);
                }
                for (var a in base) {
                    this[a] = base[a];
                }
            }
        </script>
    </body>
</html>