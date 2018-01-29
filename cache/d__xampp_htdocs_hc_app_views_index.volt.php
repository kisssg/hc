<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?= $this->tag->getTitle() ?>
        <?= $this->tag->stylesheetLink('css/bootstrap.min.css') ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="description" content="Your invoices">
        <meta name="author" content="Phalcon Team">
    </head>
    <body>
        <?= $this->getContent() ?>
        <?= $this->tag->javascriptInclude('js/jquery-1.11.3.min.js') ?>
        <?= $this->tag->javascriptInclude('js/json.js') ?>
        <?= $this->tag->javascriptInclude('js/bootstrap.min.js') ?>
        <?= $this->tag->javascriptInclude('js/Chart.bundle.min.js') ?>        
        <?= $this->tag->javascriptInclude('js/ajax.js') ?>
    </body>
</html>
