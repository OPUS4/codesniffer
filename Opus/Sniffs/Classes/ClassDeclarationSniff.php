<?php
/**
 * Class Declaration Test.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 *
 * Modified for OPUS 4 project coding standard.
 * - checks that opening bracket of class is on the same line as the declaration
 * - can fix bracket automatically
 *
 * @author    Jens Schwidder <schwidder@zib.de>
 */

/**
 * Class Declaration Test.
 *
 * Checks the declaration of the class is correct.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Opus_Sniffs_Classes_ClassDeclarationSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * The number of spaces code should be indented.
     *
     * @var int
     */
    public $indent = 4;


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_CLASS,
                T_INTERFACE,
                T_TRAIT,
               );

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer              $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens    = $phpcsFile->getTokens();
        $errorData = array(strtolower($tokens[$stackPtr]['content']));

        if (isset($tokens[$stackPtr]['scope_opener']) === false) {
            $error = 'Possible parse error: %s missing opening or closing brace';
            $phpcsFile->addWarning($error, $stackPtr, 'MissingBrace', $errorData);
            return;
        }

        $curlyBrace  = $tokens[$stackPtr]['scope_opener'];
        $lastContent = $phpcsFile->findPrevious(T_WHITESPACE, ($curlyBrace - 1), $stackPtr, true);
        $classLine   = $tokens[$lastContent]['line'];
        $braceLine   = $tokens[$curlyBrace]['line'];

        if ($braceLine === $classLine) {
            $phpcsFile->recordMetric($stackPtr, 'Class opening brace placement', 'same line');
        }
        else {
            $phpcsFile->recordMetric($stackPtr, 'Class opening brace placement', 'new line');

            $error = 'Opening brace of a %s must be on the same line following the %s declaration';
            $data  = array($tokens[$stackPtr]['content'], $tokens[$stackPtr]['content']);

            $fix = $phpcsFile->addFixableError($error, $curlyBrace, 'OpenBraceWrongLine', $data);

            if ($fix === true) {
                $phpcsFile->fixer->beginChangeset();

                for ($i = $curlyBrace - 1; $i > $lastContent; $i--) {
                    $phpcsFile->fixer->replaceToken($i, ' ');
                }

                $phpcsFile->fixer->endChangeset();
            }

            return;
        } // end if

        if ($tokens[($curlyBrace - 1)]['code'] === T_WHITESPACE) {
            $prevContent = $tokens[($curlyBrace - 1)]['content'];

            $blankSpace = substr($prevContent, strpos($prevContent, $phpcsFile->eolChar));
            $spaces = strlen($blankSpace);

            $expected = 1;

            if ($spaces !== $expected) {
                $error = 'Expected %s spaces before opening brace; %s found';
                $data  = array($expected, $spaces);

                $fix = $phpcsFile->addFixableError($error, $curlyBrace, 'SpaceBeforeBrace', $data);
                if ($fix === true) {
                    $indent = str_repeat(' ', $expected);
                    if ($spaces === 0) {
                        $phpcsFile->fixer->addContentBefore($curlyBrace, $indent);
                    }
                    else {
                        $phpcsFile->fixer->replaceToken(($curlyBrace - 1), $indent);
                    }
                }
            }
        }
        else {
            $error = 'Expected 1 space before opening brace; none found';
            $fix = $phpcsFile->addFixableError($error, $curlyBrace, 'SpaceBeforeBrace');
            if ($fix === true) {
                $phpcsFile->fixer->addContentBefore($curlyBrace, ' ');
            }
        }

    } // end process()

} // end class
