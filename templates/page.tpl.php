<?php

/**
 * @file
 */
?>
<header id="navbar" role="banner">
  <div class="container">
      <div class="navbar-inner">
         <div id="main-navs">
           <div class="container">
             <div class="navbar-header">
              <?php if (!empty($logo)): ?>
                <a class="logo" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
                  <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                </a>
              <?php endif; ?>

              <?php if (!empty($site_name)): ?>
                <h1 id="site-name">
                  <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" class="brand"><?php print $site_name; ?></a>
                </h1>
              <?php endif; ?>
              <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
             </div>
             <div id="header" class="header">
               <div>
                <?php print render($page['header']); ?>
                <?php if (!empty($primary_nav) || !empty($page['navigation'])): ?>
                  <div id="main-nav" class="<?php print $collapse; ?>">
                    <nav role="navigation">
                      <?php if (!empty($primary_nav)): ?>
                        <?php print render($primary_nav); ?>
                      <?php endif; ?>
                      <?php if (!empty($page['navigation'])): ?>
                        <?php print render($page['navigation']); ?>
                      <?php endif; ?>
                    </nav>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</header>

<?php if (!empty($page['slider'])): ?>
  <section id="slider">
       <div class="container">
         <?php print render($page['slider']); ?>
       </div>
  </section>
<?php endif; ?>

<section class="main-container">
 <div class="container">

  <div class="grid"> 

    <?php if (!empty($page['preface'])): ?>
      <div id="preface">
        <?php print render($page['preface']); ?>
      </div>  <!-- /#preface -->
    <?php endif; ?>  

    <?php if (!empty($page['sidebar_first'])): ?>
      <aside class="column <?php print $sidebar_first_width; ?>">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>  

    <section class="column <?php print $content_width; ?>">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>
      <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
      
      <a id="main-content"></a>
      <?php if ($print_content): ?>
        <?php print render($title_prefix); ?>
        <?php if (!empty($title)): ?>
          <h1 class="page-header"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php print render($title_suffix); ?>
      <?php endif; ?>
      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <div class="well"><?php print render($page['help']); ?></div>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      
      <?php if (!empty($page['content_top'])): ?>
      <div id="page-top">
        <?php print render($page['content_top']); ?>
      </div>  <!-- /#sidebar-second -->
      <?php endif; ?>
      
      <?php if ($print_content): ?>
        <div id="content-inner">
          <?php print render($page['content']); ?>
        </div>
      <?php else: ?>
        <?php
          render($pagemetatag);
        ?>
      <?php endif; ?>
      
      <?php if (!empty($page['content_bottom'])): ?>
      <div id="page-bottom">
        <?php print render($page['content_bottom']); ?>
      </div>  <!-- /#sidebar-second -->
      <?php endif; ?>
      
    </section>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="column <?php print $sidebar_second_width; ?>">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>

  </div>

    <?php if (!empty($page['postcript_top'])): ?>
      <div id="postcript_top" class="clearfix row">
        <div class="content">
        <?php print render($page['postcript_top']); ?>
        </div>
      </div>  <!-- /#postcript_top -->
    <?php endif; ?>

    <?php if (!empty($page['postcript_bottom'])): ?>
      <div id="postcript_bottom" class="clearfix row">
        <div class="content">
        <?php print render($page['postcript_bottom']); ?>
        </div>
      </div>  <!-- /#postcript_bottom -->
    <?php endif; ?>
 </div>
</section>


<footer class="footer" >
    <div id="footer-inner" class="container">
    <?php print render($page['footer']); ?>
    </div>
</footer>
<section id="development">
   <div class="container"> <?php print render($page['footer_development']); ?></div>
</section>
