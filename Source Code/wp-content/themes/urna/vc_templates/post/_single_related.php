<div class="post">
    <?php
    if (has_post_thumbnail()) {
        ?>
        <div class="entry-thumb">
             <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(array(100, 100)); ?>
            </a>
        </div>
        <?php
    }
    ?>
    <div class="entry-content">
        <?php
        if (get_the_title()) { ?>
              <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h4>
        <?php } ?>
          <ul class="entry-meta-list">
            <li class="entry-date"><i class="linear-icon-calendar-31"></i><?php echo urna_time_link(); ?></li>
            <li class="comments-link"><i class="linear-icon-bubbles"></i> <?php comments_popup_link('0', '1', '%'); ?></li>
          </ul>
    </div>
</div>      
