<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 * @since 0.2
 */

namespace modules\wiki\helpers;

use modules\wiki\models\History;

/**
 * Page differences helper.
 *
 * @author skoro
 */
class DiffHelper
{
    
    /**
     * 
     * @param History $history
     * @param array $diffOptions
     * @return string
     */
    public static function diff(History $history, $diffOptions = [])
    {
        if (!($current = $history->wiki->historyLatest)) {
            return '';
        }
        $original = explode("\n", $current->content);
        $content = explode("\n", $history->content);
        $diff = new \Diff($original, $content, $diffOptions);
        $renderer = new \modules\wiki\DiffRendererHtmlInline();
        return $diff->render($renderer);
    }
}
