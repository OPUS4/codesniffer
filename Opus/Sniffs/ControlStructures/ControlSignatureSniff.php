<?php
/**
 * Created by IntelliJ IDEA.
 * User: jens
 * Date: 1/12/15
 * Time: 3:04 PM
 */

class Opus_Sniffs_ControlStructures_ControlSignatureSniff extends PHP_CodeSniffer_Standards_AbstractPatternSniff {

    public $ignoreComments = true;

    protected function getPatterns() {
        return array(
            'do {EOL...} while (...);EOL',
            'while (...) {EOL',
            'for (...) {EOL',
            'if (...) {EOL',
            'foreach (...) {EOL',
            '}EOLelse if (...) {EOL',
            '}EOLelseif (...) {EOL',
            '}EOLelse {EOL',
            'do {EOL',
        );
    }

} 