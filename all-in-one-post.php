<?php
/**
 * Plugin Name: All In One Post Decor
 * Description: Provides a suite of features for enhancing posts, including a customizable Table of Contents, author bio with additional information, featured image settings, and customizable excerpts.
 * Version: 1.0
 * Author: Shahid Siddique
 * Website: https://ssiddique.info
 */

// Enqueue styles
function aio_enqueue_admin_styles($hook) {
    if ('settings_page_aio' !== $hook) {
        return;
    }
    wp_enqueue_style('aio_admin_styles', plugin_dir_url(__FILE__) . 'aio-admin-style.css');
}
add_action('admin_enqueue_scripts', 'aio_enqueue_admin_styles');

function aio_enqueue_styles() {
    wp_enqueue_style('aio_styles', plugin_dir_url(__FILE__) . 'aio-style.css');
}
add_action('wp_enqueue_scripts', 'aio_enqueue_styles');

// Add settings menu item
function aio_menu_item() {
    add_options_page('All In One Post Settings', 'AIO Settings', 'manage_options', 'aio', 'aio_settings_page');
}
add_action('admin_menu', 'aio_menu_item');

// Create settings page content
function aio_settings_page() {
    ?>
    <div class="wrap">
    <h1>All In One Post Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('aio-settings');
        do_settings_sections('aio-settings');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Display Featured Image on:</th>
                <td>
                    <input type="checkbox" name="aio_display_home" value="1" <?php checked(1, get_option('aio_display_home'), true); ?> /> Home<br>
                    <input type="checkbox" name="aio_display_archive" value="1" <?php checked(1, get_option('aio_display_archive'), true); ?> /> Archive<br>
                    <input type="checkbox" name="aio_display_single" value="1" <?php checked(1, get_option('aio_display_single'), true); ?> /> Single Posts<br>
                    <input type="checkbox" name="aio_display_page" value="1" <?php checked(1, get_option('aio_display_page'), true); ?> /> Pages
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Number of Paragraphs Before Featured Image:</th>
                <td><input type="number" name="num_paragraphs" value="<?php echo esc_attr(get_option('num_paragraphs')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Number of Paragraphs for Excerpt:</th>
                <td><input type="number" name="aio_excerpt_paragraphs" value="<?php echo esc_attr(get_option('aio_excerpt_paragraphs')); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Display Author Bio on:</th>
                <td>
                    <input type="checkbox" name="aio_author_single_post" value="1" <?php checked(1, get_option('aio_author_single_post'), true); ?> /> Single Posts<br>
                    <input type="checkbox" name="aio_author_page" value="1" <?php checked(1, get_option('aio_author_page'), true); ?> /> Pages<br>
                    <input type="checkbox" name="aio_author_home" value="1" <?php checked(1, get_option('aio_author_home'), true); ?> /> Home<br>
                    <input type="checkbox" name="aio_author_archive" value="1" <?php checked(1, get_option('aio_author_archive'), true); ?> /> Archive
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Enable Table of Contents on:</th>
                <td>
                    <input type="checkbox" name="aio_enable_toc_post" value="1" <?php checked(1, get_option('aio_enable_toc_post'), true); ?> /> Posts<br>
                    <input type="checkbox" name="aio_enable_toc_page" value="1" <?php checked(1, get_option('aio_enable_toc_page'), true); ?> /> Pages
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Table of Contents Default State:</th>
                <td>
                    <select name="aio_toc_default_state">
                        <option value="expanded" <?php selected('expanded', get_option('aio_toc_default_state')); ?>>Expanded</option>
                        <option value="collapsed" <?php selected('collapsed', get_option('aio_toc_default_state')); ?>>Collapsed</option>
                    </select>
                </td>
            </tr>
        </table>

        <!-- Fields for Social Media Icons -->
        <h2>Social Media Icons</h2>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Twitter Icon URL:</th>
                    <td><input type="text" name="aio_icon_twitter" value="<?php echo esc_attr(get_option('aio_icon_twitter')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Facebook Icon URL:</th>
                    <td><input type="text" name="aio_icon_facebook" value="<?php echo esc_attr(get_option('aio_icon_facebook')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Blog Icon URL:</th>
                    <td><input type="text" name="aio_icon_blog" value="<?php echo esc_attr(get_option('aio_icon_blog')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Other Icon URL:</th>
                    <td><input type="text" name="aio_icon_other" value="<?php echo esc_attr(get_option('aio_icon_other')); ?>" /></td>
                </tr>
            </table>
            
        <?php submit_button(); ?>
    </form>
    </div>
    <?php
}

// Register and define the settings
function aio_register_settings() {
    register_setting('aio-settings', 'aio_display_home');
    register_setting('aio-settings', 'aio_display_archive');
    register_setting('aio-settings', 'aio_display_single');
    register_setting('aio-settings', 'aio_display_page');
    register_setting('aio-settings', 'num_paragraphs');
    register_setting('aio-settings', 'aio_author_single_post');
    register_setting('aio-settings', 'aio_author_page');
    register_setting('aio-settings', 'aio_author_home');
    register_setting('aio-settings', 'aio_author_archive');
    register_setting('aio-settings', 'aio_excerpt_paragraphs');
    register_setting('aio-settings', 'aio_enable_toc_post');
    register_setting('aio-settings', 'aio_enable_toc_page');
    register_setting('aio-settings', 'aio_toc_default_state');
    register_setting('aio-settings', 'aio_icon_twitter');
    register_setting('aio-settings', 'aio_icon_facebook');
    register_setting('aio-settings', 'aio_icon_blog');
    register_setting('aio-settings', 'aio_icon_other');
}
add_action('admin_init', 'aio_register_settings');

function aio_generate_and_append_toc($content) {
    // Check if ToC should be displayed
    if ((is_single() && get_option('aio_enable_toc_post')) ||
        (is_page() && get_option('aio_enable_toc_page'))) {
        
        // Generate the Table of Contents
        $toc = aio_generate_toc($content);

        // Append the ToC at the beginning of the content
        $content = $toc . $content;
    }

    return $content;
}
add_filter('the_content', 'aio_generate_and_append_toc');

function aio_insert_featured_image($content) {
    if (has_post_thumbnail()) {
        $image = get_the_post_thumbnail(get_the_ID(), 'large');
        $display_on_home = get_option('aio_display_home', 0);
        $display_on_archive = get_option('aio_display_archive', 0);
        $display_on_single = get_option('aio_display_single', 0);
        $display_on_page = get_option('aio_display_page', 0);

        $should_display_image = (
            (is_home() && $display_on_home) ||
            (is_archive() && $display_on_archive) ||
            (is_single() && $display_on_single) ||
            (is_page() && $display_on_page)
        );

        if ($should_display_image) {
            $num_paragraphs = get_option('num_paragraphs', 3);
            $paragraphs = explode('</p>', $content);

            if (count($paragraphs) > $num_paragraphs) {
                $paragraphs[$num_paragraphs - 1] .= $image;
            }

            $content = implode('</p>', $paragraphs);
        }
    }

    $content .= aio_get_author_bio();

    return $content;
}

function aio_custom_excerpt($content) {
    if (is_home() || is_archive()) {
        $num_paragraphs_for_excerpt = get_option('aio_excerpt_paragraphs', 3);
        $paragraphs = explode('</p>', $content, $num_paragraphs_for_excerpt + 1);

        if (count($paragraphs) > $num_paragraphs_for_excerpt) {
            array_pop($paragraphs);
            $content = implode('</p>', $paragraphs) . '</p>';
            $content .= '... <a href="'. get_permalink(get_the_ID()) . '" class="read-more-link">Read More</a>';
        }
    }

    return $content;
}

function aio_get_author_bio() {
    ob_start();
    if ((is_single() && get_option('aio_author_single_post')) ||
        (is_page() && get_option('aio_author_page')) ||
        (is_home() && get_option('aio_author_home')) ||
        (is_archive() && get_option('aio_author_archive'))) {
        
        $twitter = get_the_author_meta('aio_twitter');
        $facebook = get_the_author_meta('aio_facebook');
        $blog = get_the_author_meta('aio_blog');
        $other = get_the_author_meta('aio_other');

        $icon_twitter = esc_url(get_option('aio_icon_twitter'));
        $icon_facebook = esc_url(get_option('aio_icon_facebook'));
        $icon_blog = esc_url(get_option('aio_icon_blog'));
        $icon_other = esc_url(get_option('aio_icon_other'));

        ?>
        <div id="author-bio">
            <div id="author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 60); ?></div>
            <div id="author-details">
                <h4><?php esc_html_e('Written by', 'text_domain'); ?> <?php the_author_posts_link(); ?></h4>
                <p><?php the_author_meta('description'); ?></p>

                <!-- Social Media Links -->
                <div class="author-social-media">
                    <?php if ($twitter) : ?>
                        <?php  echo '<a href="https://twitter.com/' . esc_attr($twitter) . '"><img src="' . $icon_twitter . '" alt="Twitter"/></a>'; ?>
                    <?php endif; ?>
                    <?php if ($facebook) : ?>
                        <?php echo '<a href="https://facebook.com/' . esc_attr($facebook) . '"><img src="' . $icon_facebook . '" alt="Facebook"/></a>'; ?>
                    <?php endif; ?>
                    <?php if ($blog) : ?>
                        <?php echo '<a href="' . $blog . '"><img src="' . $icon_blog. '" alt="Personal Blog"/></a>'; ?>
                        <!-- <a href="<?php echo esc_url($blog); ?>"><img src="' . $icon_blog . '" alt="Personal Blog"/></a> -->
                    <?php endif; ?>
                    <?php if ($other) : ?>
                        <a href="<?php echo esc_url($other); ?>"><img src="' . $icon_other . '" alt="other"/></a>
                    <?php endif; ?>
                </div>
            </div><!-- #author-details -->
        </div><!-- #author-bio -->
        <?php
    }
    return ob_get_clean();
}

function aio_generate_toc($content) {
    preg_match_all('/<h([2-4]).*?>(.*?)<\/h[2-4]>/i', $content, $matches, PREG_SET_ORDER);
    if (empty($matches)) {
        return ''; // No headings, return empty string
    }

    $default_state = get_option('aio_toc_default_state', 'expanded');
    $toc = '<div class="aio-toc" data-state="' . esc_attr($default_state) . '">';
    $toc .= '<button class="aio-toc-toggle">' . esc_html(($default_state === 'collapsed') ? 'Expand' : 'Collapse') . '</button>';
    $toc .= '<h2>Table of Contents</h2><ul>';
    $prev_level = 2;
    foreach ($matches as $match) {
        $current_level = intval($match[1]);
        $title = strip_tags($match[2]);
        $slug = sanitize_title($title);

        if ($current_level > $prev_level) {
            $toc .= '<ul>';
        } elseif ($current_level < $prev_level) {
            $toc .= str_repeat('</ul></li>', $prev_level - $current_level);
        } else {
            if ($prev_level != 2) {
                $toc .= '</li>';
            }
        }
        $toc .= '<li><a href="#' . $slug . '">' . $title . '</a>';
        // $toc .= '<li><a href="#' . sanitize_title($title) . '">' . $title . '</a>';
        $prev_level = $current_level;
    }

    $toc .= str_repeat('</li></ul>', $prev_level - 2) . '</li></ul></div>';

    return $toc;
}

function aio_add_id_to_headings($content) {
    return preg_replace_callback('/<h([2-4])>(.*?)<\/h[2-4]>/i', function($matches) {
        $slug = sanitize_title(strip_tags($matches[2])); // Create a slug
        return '<h' . $matches[1] . ' id="' . $slug . '">' . $matches[2] . '</h' . $matches[1] . '>';
    }, $content);
}


function aio_add_inline_scripts() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toc = document.querySelector('.aio-toc');
            var toggle = document.querySelector('.aio-toc-toggle');

            if (toc && toggle) {
                var defaultState = toc.getAttribute('data-state');
                toc.classList.add(defaultState);
                toggle.addEventListener('click', function () {
                    var isCollapsed = toc.classList.contains('collapsed');
                    toggle.textContent = isCollapsed ? 'Collapse' : 'Expand';
                    toc.classList.toggle('collapsed');
                    toc.classList.toggle('expanded');
                });
            }
        });
    </script>
    <?php
}

function aio_add_heading_ids_script() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var headings = document.querySelectorAll('.wp-block-heading');
            headings.forEach(function (heading) {
                if (!heading.id) {
                    var slug = heading.textContent.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                    heading.id = slug;
                }
            });
        });
    </script>
    <?php
}

function aio_add_social_media_fields($contactmethods) {
    // Add user contact methods
    $contactmethods['aio_twitter'] = 'Twitter Username';
    $contactmethods['aio_facebook'] = 'Facebook Username';
    $contactmethods['aio_blog'] = 'Personal Blog URL';
    $contactmethods['aio_other'] = 'Other URL';

    return $contactmethods;
}

function aio_social_media_icons_settings_page() {
    ?>
    <input type="text" name="aio_icon_blog" value="<?php echo esc_attr(get_option('aio_icon_blog')); ?>" />
    <input type="text" name="aio_icon_facebook" value="<?php echo esc_attr(get_option('aio_icon_facebook')); ?>" />
    <input type="text" name="aio_icon_twitter" value="<?php echo esc_attr(get_option('aio_icon_twitter')); ?>" />
    <input type="text" name="aio_icon_other" value="<?php echo esc_attr(get_option('aio_icon_other')); ?>" />
    <?php
}

add_action('wp_footer', 'aio_add_inline_scripts');
add_action('wp_footer', 'aio_add_heading_ids_script');
add_filter('user_contactmethods', 'aio_add_social_media_fields', 10, 1);
add_filter('the_content', 'aio_custom_excerpt');
add_filter('the_excerpt', 'aio_custom_excerpt');
add_filter('the_content', 'aio_insert_featured_image');
add_filter('the_content', 'aio_add_id_to_headings', 10);
