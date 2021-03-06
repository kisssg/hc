<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('css/bootstrap.min.css') }}
        {{ stylesheet_link('css/bootstrap-theme.min.css') }}
        {{ stylesheet_link('css/min.css?6') }}
        {{ stylesheet_link('css/jquery.datetimepicker.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="description" content="QM data">
        <meta name="author" content="Sucre.Xu">
    </head>
    <body>
        {{ content() }}
        {{ javascript_include('js/jquery-1.11.3.min.js') }}
        {{ javascript_include('js/bootstrap.min.js') }}
        {{ javascript_include('js/Chart.bundle.min.js') }}
        {{ javascript_include('js/jquery.datetimepicker.min.js') }}
        {{ javascript_include('js/autoload.js?201922') }}
    </body>
</html>
