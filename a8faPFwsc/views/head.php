<!DOCTYPE HTML>
<html>
<head>
<?php echo $meta; ?>
<?php echo $css; ?>
<?php echo $js; ?>
<style>
.highlight {
        background: #e0f1df;
		opacity: 0.9;
        filter: Alpha(opacity=90); /* IE8 and earlier */
    }
.tip_schlay1 {
        position: relative;
        z-index: 99;
        border: 1px solid #c0c0c0;
        background: #fff;
    }
    .tip_schlay1 ul {
        width: 100%;
        overflow: hidden;
    }
    .tip_schlay1 li {
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid #ececec;
    }
    
    .tip_schlay1 li a {
        display: block;
        height: 32px;
        overflow: hidden;
        padding: 0 10px;
        line-height: 32px;
        color: #323232;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>
<link rel="stylesheet" href="<?= base_url().'css/validate.css'?>" />
<script src="<?= base_url().'js/jquery.validate.min.js'?>"></script>

