<?php
/**
 * This file is part of OPUS. The software OPUS has been originally developed
 * at the University of Stuttgart with funding from the German Research Net,
 * the Federal Department of Higher Education and Research and the Ministry
 * of Science, Research and the Arts of the State of Baden-Wuerttemberg.
 *
 * OPUS 4 is a complete rewrite of the original OPUS software and was developed
 * by the Stuttgart University Library, the Library Service Center
 * Baden-Wuerttemberg, the Cooperative Library Network Berlin-Brandenburg,
 * the Saarland University and State Library, the Saxon State Library -
 * Dresden State and University Library, the Bielefeld University Library and
 * the University Library of Hamburg University of Technology with funding from
 * the German Research Foundation and the European Regional Development Fund.
 *
 * LICENCE
 * OPUS is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the Licence, or any later version.
 * OPUS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details. You should have received a copy of the GNU General Public License
 * along with OPUS; if not, write to the Free Software Foundation, Inc., 51
 * Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * @category    CodingStandard
 * @author      Ralf Claussnitzer <ralf.claussnitzer@slub-dresden.de>
 * @copyright   Copyright (c) 2008, OPUS 4 development team
 * @license     http://www.gnu.org/licenses/gpl.html General Public License
 * @version     $Id$
 */

if (class_exists('PHP_CodeSniffer_Standards_CodingStandard', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_CodingStandard not found');
}


/**
 * Defines the coding standard.
 *
 * @category    CodingStandard
 * @package     Opus
 */
class PHP_CodeSniffer_Standards_Opus_OpusCodingStandard extends PHP_CodeSniffer_Standards_CodingStandard
{
    /**
     * Return a list of external sniffs to include with the Opus Framework standard
     *
     * @return array    List of external code sniffs. This list only includes the
     *                  Zend Conding Standard.
     */
    public function getIncludedSniffs() {
        return array(
            'Zend'
            );
    }

    /**
     * Return a list of external sniffs to exclude from this standard.
     *
     * @return array List of code sniffs to exclude.
     */
    public function getExcludedSniffs() {
        return array(
            'Zend/Sniffs/Commenting/FileCommentSniff.php',
            'Zend/Sniffs/Commenting/ClassCommentSniff.php',
            'Zend/Sniffs/Commenting/FunctionCommentSniff.php',
            'Zend/Sniffs/Commenting/InlineCommentSniff.php',
            'Zend/Sniffs/Commenting/VariableCommentSniff.php',

            'Zend/Sniffs/Formatting',
            'Zend/Sniffs/WhiteSpace',
            'Zend/Sniffs/Classes',
            'Zend/Sniffs/NamingConventions',
            'Zend/Sniffs/Functions/FunctionCallArgumentSpacingSniff.php',
            'Zend/Sniffs/Files/LineLengthSniff.php',

            'Generic/Sniffs/Files/LineEndingsSniff.php',
            'Generic/Sniffs/WhiteSpace',
            'Generic/Sniffs/Functions/OpeningFunctionBraceBsdAllmanSniff.php',
            'Generic/Sniffs/NamingConventions/UpperCaseConstantNameSniff.php',

            'Squiz/Sniffs/WhiteSpace',
            'Squiz/Sniffs/Functions/FunctionDeclarationSniff.php',
            'Squiz/Sniffs/Objects/ObjectInstantiationSniff.php',
            'Squiz/Sniffs/NamingConventions/ConstantCaseSniff.php'
            );
    }

}
