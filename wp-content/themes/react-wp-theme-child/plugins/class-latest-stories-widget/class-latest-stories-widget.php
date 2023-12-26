<?php
/**
 * Plugin Name
 *
 * @package Latest Stories Package
 * @author  Rakesh Ranjan
 *
 * @wordpress-plugin
 * Plugin Name:       Latest Stories plugin
 * Description:       To show latest stories using rest api.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rakesh Ranjan
 * Text Domain:       plugin-latest-stories
 */

/**
 * Function to Section Latest content as per design template.
 */
class Latest_Stories_Widget extends WP_Widget
{

    /**
     * for defining the latest stories function
     */
    public function __construct()
    {
        $widget_ops = array(
        'classname'   => 'latest_stories_widget',
        'description' => 'Displays latest story',
        );
        parent::__construct('latest_stories_widget', 'Latest Post12', $widget_ops);
    }
}

    // displaying widget.
function widget( $args, $instance )
{
    $box_title         = ! empty($instance['post_title']) ? $instance['post_title'] : '';
    $boxwidget_postion = ! empty($instance['position_latest_box']) ? $instance['position_latest_box'] : '';
    $post_per_page     = ! empty($instance['post_per_page']) ? $instance['post_per_page'] : 4;

    $key          = 'latest_stories' . md5($args['widget_id']);
    $group        = 'group_latest_stories_html';
    $cache_name   = sanitize_key($key);
    $cache_group  = sanitize_key($group);
    $latest_story = wp_cache_get($cache_name, $cache_group);
    $end_date     = date('Y-m-d H:i:s', strtotime('+330 minutes'));
    $start_date   = date('Y-m-d H:i:s', strtotime('-5 days'));
    if (! empty($latest_story) ) {
        $latest_query = $latest_story;
    } else {
        $args         = array(
        'post_type'           => 'post',
        'posts_per_page'      => intval($post_per_page),
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'desc',
        'no_found_rows'       => true,
        'ignore_sticky_posts' => true,
        'date_query'          => array(
        array(
        'after'     => $start_date,
        'before'    => $end_date,
        'inclusive' => true,
        ),
        ),
        );
        $latest_query = new WP_Query($args);
		//print_r($latest_query);
        wp_cache_set($cache_name, $latest_query, $cache_group, 300);
    } ?>
    <?php if (! empty($boxwidget_postion) && $boxwidget_postion === 'right' ) { ?>
            <div class="rightcol mt30">
                <div class="gridnewsbox mb30">
                    <div class="h_group">
                        <div class="rightcol-title"><?php echo esc_html($box_title); ?></div>
                    </div>
                    <ul>
        <?php
        while ( $latest_query->have_posts() ) :
            $latest_query->the_post();
            ?>
                        <li>
            <?php
            if (has_post_thumbnail(get_the_ID()) ) {
                $latest_image = wp_get_attachment_image_src(get_post_thumbnail_id(), array( 320, 213 ));
                if (is_array($latest_image) && ! empty($latest_image[0]) ) {
                    ?>
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <figure><?php echo '<img src="' . esc_url($latest_image[0], 320, true) . '" alt="' . esc_attr(get_the_title()) . '">'; ?></figure>
                                    </a>
                    <?php
                }
            }
            ?>
                            <p><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></p>
                        </li>
        <?php endwhile; ?>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
    <?php } elseif (! empty($boxwidget_postion) && $boxwidget_postion === 'left' ) { ?>
                <div class="common-row">
                    <div class="h_group">
                        <div class="rightcol-title"><?php echo esc_html($box_title); ?></div>
                    </div>
        <?php
        $i = 1;
        while ( $latest_query->have_posts() ) :
            $latest_query->the_post();
            if (6 === intval($i) ) {
                break;
            }
            $latest_image = wp_get_attachment_image_src(get_post_thumbnail_id(), array( 320, 213 ));
            if (is_array($latest_image) && ! empty($latest_image[0]) && ( 1 === intval($i) ) ) {
                ?>
                                    <div class="column-left mt20">
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <figure><?php echo '<img src="' . esc_url($latest_image[0], 320, true) . '" alt="' . esc_attr(get_the_title()) . '">'; ?></figure>
                                    </a>
                                    <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                                    </div>
                <?php
            } else {
                if (intval($i) === 2 ) {
                    echo '<div class="column-right mt20">';
                }
                ?>
                                        <div class="newslist ">
                                        <a href="<?php echo esc_url(get_permalink()); ?>">
                
                <?php echo '<img class ="newslistimg" src="' . esc_url($latest_image[0], 320, true) . '" alt="' . esc_attr(get_the_title()) . '">'; ?>
                                        </a>
                                        <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
                                        </div>
                <?php
            }
            ?>
            <?php
            ++$i;
        endwhile;
        ?>
                    </div>
                    <div class="clear"></div>
            </div>
    <?php } ?>
    <?php
}

    // widget form fields.
function form( $instance )
{
 
}

function update( $new_instance, $old_instance )
{

}
function latest_stories_registration()
{
    register_widget('Latest_Stories_Widget');
}
add_action('widgets_init', 'latest_stories_registration');


