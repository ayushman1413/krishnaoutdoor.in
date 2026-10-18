<?php
/**
 * Plugin Name: Krishna Outdoor blog SEO
 * Description: Removes the default "Hello world!" post, keeps the blog noindex,follow until real posts are published, and sets the blog home title, description and canonical.
 */

if (!defined('ABSPATH')) {
    exit;
}

const KO_BLOG_TITLE = 'OOH Advertising Guides & Insights | Krishna Outdoor';
const KO_BLOG_DESCRIPTION = 'Guides on hoarding, bus and train advertising in Ahmedabad and Mumbai: costs, planning tips and campaign ideas from the Krishna Outdoor team.';

/**
 * One-time: move WordPress's default "Hello world!" post to the trash
 * (recoverable from Posts > Trash). Only touches the untouched default post.
 */
add_action('init', function () {
    if (get_option('ko_default_post_removed')) {
        return;
    }

    $post = get_page_by_path('hello-world', OBJECT, 'post');
    if ($post && $post->post_title === 'Hello world!' && $post->post_status !== 'trash') {
        wp_trash_post($post->ID);
    }

    update_option('ko_default_post_removed', 1, false);
});

function ko_blog_has_real_posts(): bool
{
    $counts = wp_count_posts('post');
    return isset($counts->publish) && (int) $counts->publish > 0;
}

/**
 * noindex,follow on every blog URL until at least one post is published.
 */
add_filter('wp_robots', function (array $robots) {
    if (!ko_blog_has_real_posts()) {
        unset($robots['index'], $robots['max-image-preview']);
        $robots['noindex'] = true;
        $robots['follow'] = true;
    }
    return $robots;
});

/**
 * Blog home: title, meta description and canonical. Single posts already
 * get a canonical from WordPress core.
 */
add_filter('pre_get_document_title', function ($title) {
    return (is_home() || is_front_page()) ? KO_BLOG_TITLE : $title;
});

add_action('wp_head', function () {
    if (!(is_home() || is_front_page())) {
        return;
    }
    echo '<meta name="description" content="' . esc_attr(KO_BLOG_DESCRIPTION) . "\">\n";
    $canonical = is_paged() ? get_pagenum_link(get_query_var('paged')) : home_url('/');
    echo '<link rel="canonical" href="' . esc_url($canonical) . "\">\n";
}, 1);
