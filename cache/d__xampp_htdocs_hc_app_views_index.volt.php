<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?= $this->tag->getTitle() ?>
        <?= $this->tag->stylesheetLink('css/bootstrap.min.css') ?>
        <?= $this->tag->stylesheetLink('css/bootstrap-theme.min.css') ?>
        <?= $this->tag->stylesheetLink('css/min.css?6') ?>
        <?= $this->tag->stylesheetLink('css/jquery.datetimepicker.css') ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="description" content="QM data">
        <meta name="author" content="Sucre.Xu">
    </head>
    <body>
        <?= $this->getContent() ?>
        <?= $this->tag->javascriptInclude('js/jquery-1.11.3.min.js') ?>
        <?= $this->tag->javascriptInclude('js/bootstrap.min.js') ?>
        <?= $this->tag->javascriptInclude('js/Chart.bundle.min.js') ?>
        <?= $this->tag->javascriptInclude('js/jquery.datetimepicker.min.js') ?>
        <?= $this->tag->javascriptInclude('js/autoload.js?201922') ?>
    </body>
</html>
