<header>
    <div class="bg-header-wrapper header-01">    

        <div class="cosmos-header header-page <?php echo esc_attr($class_header_full_1920); ?>">
        
            <div class="<?php echo esc_attr($class_fixed_menu); ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="commont-menu not-fixed navi-type-<?php echo esc_attr($menu_style); ?>">
                                <div id="nav-toggle" class="not-fixed" title="menu"><span></span></div>                     
                                <div class="header-left">
                                    <a class="logo-company" href="<?php echo esc_url(site_url()); ?>">
                                        <?php echo wp_kses_post($header_logo_data); ?>
                                    </a>
                                </div>
                                <div class="header-right">
                                    <nav class="menu-head-page menu">
                                        <?php cosmos_show_main_menu(); ?>
                                        <?php cosmos_show_main_menu_mobile(); ?>
                                    </nav>
                                    <?php 
                                    if( (has_action('wpml_add_language_selector') && $show_laguage_switcher == '1' )) {
                                        echo '<ul class="topbar pull-right list-unstyled list-inline">';
                                            if( has_action('wpml_add_language_selector') ) {                                    
                                                if( $show_laguage_switcher == '1' ) {
                                                    echo '<li><div class="wpml-language item">';
                                                        do_action('wpml_add_language_selector');
                                                    echo '</div></li>';
                                                }                                   
                                            }
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>

        </div>

    </div>
    
    <div class="clearfix"></div>
</header>