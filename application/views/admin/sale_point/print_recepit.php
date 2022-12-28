<!doctype html>
<html>

<head>
    <title>Receipt</title>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />

    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


    <style>
        body {
            background: rgb(204, 204, 204);
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 8cm;
            height: auto;
            font-weight: bold !important;
            font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            font-size: 12px !important;
        }


        @media print {

            body,
            page {
                margin: 0 auto;
                box-shadow: 0;
                color: black;
            }
    </style>

</head>

<body>
    <page size='A4' style="padding: 5px !important;">
        <?php $this->load->view(ADMIN_DIR . "sale_point/recepit");  ?>
    </page>
</body>

</html>