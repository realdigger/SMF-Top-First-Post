<?php
/**
 * Project: SMF TopFirstPost Mod
 * Version: 2.0.2
 * File: Mod-TopFirstPost.php
 * Author: Loac and simplemachines.ru community
 * License: The BSD 3-Clause License
 */


/**
 *  Sticky a first post
 */
function StickyPost()
{
    global $db_prefix, $modSettings, $topic, $sourcedir, $smcFunc;

    // Make sure the user can sticky it, and they are stickying *something*.
    isAllowedTo('make_sticky');

    // You shouldn't be able to (un)sticky a topic if the setting is disabled.
    if (empty($modSettings['enableStickyTopics'])) {
        fatal_lang_error('cannot_make_sticky', false);
    }

    // You can't sticky a board or something!
    if (empty($topic)) {
        fatal_lang_error('not_a_topic', false);
    }

    checkSession('get');
    $sticky_posts = explode(',', $modSettings['TopFirstPost']);

    if (in_array($topic, $sticky_posts)) {
        $sticky_posts = array_flip($sticky_posts);
        unset($sticky_posts[$topic]);
        $sticky_posts = array_flip($sticky_posts);
    } else {
        $sticky_posts[] = $topic;
    }

    $smcFunc['db_query']('', '
		UPDATE {db_prefix}settings SET value = {string:sticky_posts} WHERE variable ={string:variable}',
        array(
            'sticky_posts' => implode(',', $sticky_posts),
            'variable' => 'TopFirstPost',
        )
    );

    // Cache wipe.
    clean_cache();

    // Take them back to the now stickied topic.
    redirectexit('topic=' . $topic . '.' . $_REQUEST['start']);
}
 