<?php
/**
 * This file contains a Sniff definition used by CodeSniffer to ensure upper
 * case constant names. There is only one exception for PHPUnit test classes
 * where a contant PHPUnit_MAIN_METHOD is allowed to exist for compatability
 * reasons.
 *
 * This file is part of OPUS. The software OPUS has been developed at the
 * University of Stuttgart with funding from the German Research Net
 * (Deutsches Forschungsnetz), the Federal Department of Higher Education and
 * Research (Bundesministerium fuer Bildung und Forschung) and The Ministry of
 * Science, Research and the Arts of the State of Baden-Wuerttemberg
 * (Ministerium fuer Wissenschaft, Forschung und Kunst des Landes
 * Baden-Wuerttemberg).
 *
 * PHP version 5
 *
 * OPUS is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * OPUS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPUS; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * @category    Opus
 * @package     Opus_Coding_Standard
 * @author      Ralf Claussnitzer <ralf.claussnitzer@slub-dresden.de>
 * @copyright   Universitaetsbibliothek Stuttgart, 1998-2008
 * @license     http://www.gnu.org/licenses/gpl.html
 * @version     $Id: UpperCaseConstantNamePhpUnitExceptionSniff.php 286 2008-07-17 06:23:38Z claussni $
 */

/**
 * Ensures that constant names are all uppercase.  There is only one exception
 * for PHPUnit test classes where a contant PHPUnit_MAIN_METHOD is allowed to
 * exist for compatability reasons.
 *
 * @category    Opus
 * @package     Opus_Coding_Standard
 * @subpackage  Opus_Sniffs_NamingConventions
 */
class Opus_Sniffs_NamingConventions_UpperCaseConstantNamePhpUnitExceptionSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_STRING);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens    = $phpcsFile->getTokens();
        $constName = $tokens[$stackPtr]['content'];

        // If this token is in a heredoc, ignore it.
        if ($phpcsFile->hasCondition($stackPtr, T_START_HEREDOC) === true) {
            return;
        }

        if ($constName === 'PHPUnit_MAIN_METHOD') {
            return;
        }

        // If the next non-whitespace token after this token
        // is not an opening parenthesis then it is not a function call.
        $openBracket = $phpcsFile->findNext(array(T_WHITESPACE), ($stackPtr + 1), null, true);
        if ($tokens[$openBracket]['code'] !== T_OPEN_PARENTHESIS) {
            $functionKeyword = $phpcsFile->findPrevious(array(T_WHITESPACE, T_COMMA, T_COMMENT, T_STRING), ($stackPtr - 1), null, true);

            $declarations = array(
            T_FUNCTION,
            T_CLASS,
            T_INTERFACE,
            T_IMPLEMENTS,
            T_EXTENDS,
            T_INSTANCEOF,
            T_NEW,
            );
            if (in_array($tokens[$functionKeyword]['code'], $declarations) === true) {
                // This is just a declaration; no constants here.
                return;
            }

            if ($tokens[$functionKeyword]['code'] === T_CONST) {
                // This is a class constant.
                if (strtoupper($constName) !== $constName) {
                    $error = 'Class constants must be uppercase; expected '.strtoupper($constName)." but found $constName";
                    $phpcsFile->addError($error, $stackPtr);
                }

                return;
            }

            // Is this a class name?
            $nextPtr = $phpcsFile->findNext(array(T_WHITESPACE), ($stackPtr + 1), null, true);
            if ($tokens[$nextPtr]['code'] === T_DOUBLE_COLON) {
                return;
            }

            // Is this a type hint?
            if ($tokens[$nextPtr]['code'] === T_VARIABLE) {
                return;
            } else if ($phpcsFile->isReference($nextPtr) === true) {
                return;
            }

            // Is this a member var name?
            $prevPtr = $phpcsFile->findPrevious(array(T_WHITESPACE), ($stackPtr - 1), null, true);
            if ($tokens[$prevPtr]['code'] === T_OBJECT_OPERATOR) {
                return;
            }

            // Is this an instance of declare()
            $prevPtr = $phpcsFile->findPrevious(array(T_WHITESPACE, T_OPEN_PARENTHESIS), ($stackPtr - 1), null, true);
            if ($tokens[$prevPtr]['code'] === T_DECLARE) {
                return;
            }

            // This is a real constant but not the PHPUnit constant PHPUnit_MAIN_METHOD.
            if (strtoupper($constName) !== $constName) {
                $error = 'Constants must be uppercase; expected '.strtoupper($constName)." but found $constName";
                $phpcsFile->addError($error, $stackPtr);
            }

        } else if (strtolower($constName) === 'define' || strtolower($constName) === 'constant') {

            /*
             This may be a "define" or "constant" function call.
             */

            // The next non-whitespace token must be the constant name.
            $constPtr = $phpcsFile->findNext(array(T_WHITESPACE), ($openBracket + 1), null, true);
            if ($tokens[$constPtr]['code'] !== T_CONSTANT_ENCAPSED_STRING) {
                return;
            }

            $constName = $tokens[$constPtr]['content'];

            if ($constName == '\'PHPUnit_MAIN_METHOD\'') {
                return;
            }

            if (strtoupper($constName) !== $constName) {
                $error = 'Constants must be uppercase; expected '.strtoupper($constName)." but found $constName";
                $phpcsFile->addError($error, $stackPtr);
            }
        }//end if

    }//end process()


}//end class
