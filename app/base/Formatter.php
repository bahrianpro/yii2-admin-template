<?php
/**
 * @author Skorobogatko Alexei <skorobogatko.oleksii@gmail.com>
 * @copyright 2016
 * @version $Id$
 */

namespace app\base;

use app\widgets\ProgressBar;

/**
 * Formatter
 *
 * @author skoro
 */
class Formatter extends \yii\i18n\Formatter
{
    
    /**
     * Markdown parsers.
     * @see Formatter::asMarkdown()
     */
    const MARKDOWN_PARSER_TRADITIONAL = '\cebe\markdown\Markdown';
    const MARKDOWN_PARSER_GITHUB = '\cebe\markdown\GithubMarkdown';
    const MARKDOWN_PARSER_EXTRA = '\cebe\markdown\MarkdownExtra';

    /**
     * Format value as progress bar widget.
     * @param integer $value progress value
     * @param array $options widget options
     * @return string
     */
    public function asProgressBar($value, $options = [])
    {
        $options['value'] = $value;
        return ProgressBar::widget($options);
    }
    
    /**
     * Converts Markdown to html.
     * @param string $text markdown source.
     * @param string $parserClass markdown parser class.
     * @return string
     */
    public function asMarkdown($text, $parserClass = self::MARKDOWN_PARSER_EXTRA)
    {
        $parser = new $parserClass();
        return $parser->parse($text);
    }
}
