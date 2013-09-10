<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if(isset($this->titulo)) echo $this->titulo;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
        <link href="<?php echo $_layoutParams['ruta_css']; ?>estilo.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo BASE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>public/js/jquery.validate.js" type="text/javascript"></script>
        
        <?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
            
        <?php for($i = 0; $i < count($_layoutParams['js']); $i++):?>
                <script src="<?php echo $_layoutParams['js'][$i]?>" type="text/javascript"></script>
        <?php endfor;?>
        <?php endif;?>
        
    </head>
    <body>
        <body>
            <div id="main">
                <div id="header">
                    <div id="logo">
                        <h1><?php echo APP_NAME; ?></h1>
                    </div>

                    <div id="menu">
                        <div id="top_menu">
                            <ul>
                            <?php if(isset($_layoutParams['menu'])): ?>
                            <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                            <?php 

                            if($item && $_layoutParams['menu'][$i]['id'] == $item ){ 
                            $_item_style = 'current'; 
                            } else {
                            $_item_style = '';
                            }

                            ?>

                            <li><a class="<?php echo $_item_style; ?>" href="<?php echo $_layoutParams['menu'][$i]['enlace']; ?>"><?php  echo $_layoutParams['menu'][$i]['titulo']; ?></a></li>

                            <?php endfor; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="content">
                    <div id="error"><?php if(isset($this->_error)) echo $this->_error ?></div>